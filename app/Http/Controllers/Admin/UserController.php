<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15);

        if ($request->ajax()) {
            return view('management.portal.admin.users.partials.users-table', compact('users'))->render();
        }

        return view('management.portal.admin.users.index', compact('users'));
    }

    private function getUserWidgets()
    {
        $widgets = [];
        $admin = auth('admin')->user();
        $stats = $this->getUserStats();
        
        if ($admin->can('view-users-widget')) {
            $widgets[] = [
                'title' => 'Total Users',
                'value' => $stats['total_users'],
                'icon' => 'users',
                'color' => 'blue',
                'growth' => $stats['user_growth'],
                'chartId' => 'totalUsersChart',
                'chartData' => $stats['total_growth_data'],
                'chartColor' => '#3B82F6'
            ];
        }

        if ($admin->can('view-active-users-widget')) {
            $widgets[] = [
                'title' => 'Active Users',
                'value' => $stats['active_users'],
                'icon' => 'user-check',
                'color' => 'green',
                'growth' => $stats['active_growth'],
                'chartId' => 'activeUsersChart',
                'chartData' => $stats['active_growth_data'],
                'chartColor' => '#10B981'
            ];
        }

        if ($admin->can('view-new-users-widget')) {
            $widgets[] = [
                'title' => 'New Today',
                'value' => $stats['new_users_today'],
                'icon' => 'user-plus',
                'color' => 'yellow',
                'subtitle' => 'Registered today',
                'chartId' => 'newUsersChart',
                'chartData' => $stats['new_users_growth_data'],
                'chartColor' => '#F59E0B'
            ];
        }

        return $widgets;
    }

    public function create()
    {
        return view('management.portal.admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'status' => ['required', 'in:pending,active,warning,hold,suspended,blocked'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'email_verified_at' => $request->status === 'active' ? now() : null,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('management.portal.admin.users.view', compact('user'));
    }
    
    public function view(User $user)
    {
        return view('management.portal.admin.users.view', compact('user'));
    }

    public function edit(User $user)
    {
        return view('management.portal.admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'status' => ['required', 'in:pending,active,warning,hold,suspended,blocked'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->status === 'active' && !$user->email_verified_at) {
            $data['email_verified_at'] = now();
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function loginAsUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        // Generate a secure token for impersonation
        $token = bin2hex(random_bytes(32));
        
        // Store impersonation data in cache (expires in 5 minutes)
        cache()->put("impersonate_{$token}", [
            'admin_id' => auth('admin')->id(),
            'user_id' => $user->id,
            'created_at' => now()
        ], now()->addMinutes(5));
        
        // Return JSON response with redirect URL
        return response()->json([
            'success' => true,
            'message' => 'Login token generated successfully',
            'redirect_url' => route('admin.impersonate.login', ['token' => $token])
        ]);
    }
    
    public function executeImpersonation($token)
    {
        // Retrieve impersonation data from cache
        $data = cache()->get("impersonate_{$token}");
        
        if (!$data) {
            return redirect()->route('admin.login')->with('error', 'Invalid or expired impersonation token.');
        }
        
        // Remove token from cache (single use)
        cache()->forget("impersonate_{$token}");
        
        // Find the user
        $user = User::find($data['user_id']);
        
        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'User not found.');
        }
        
        // Store admin session data before switching
        session(['impersonating_admin_id' => $data['admin_id']]);
        
        // Login as user
        Auth::login($user);
        
        return redirect()->route('dashboard')->with('success', 'Impersonating ' . $user->name . '. <a href="' . route('admin.stop-impersonation') . '" class="underline">Return to Admin</a>');
    }
    
    public function stopImpersonation()
    {
        $adminId = session('impersonating_admin_id');
        
        if (!$adminId) {
            return redirect()->route('admin.login')->with('error', 'No active impersonation found.');
        }
        
        $admin = \App\Models\Admin::find($adminId);
        
        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Admin not found.');
        }
        
        // Clear impersonation session
        session()->forget('impersonating_admin_id');
        
        // Logout user and login admin
        Auth::logout();
        Auth::guard('admin')->login($admin);
        
        return redirect()->route('admin.dashboard')->with('success', 'Stopped impersonating. Welcome back!');
    }

    public function stats()
    {
        return response()->json($this->getUserStats());
    }

    public function getWidgetsData()
    {
        $widgets = $this->getUserWidgets();
        return response()->json($widgets);
    }

    private function getUserStats()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $newToday = User::whereDate('created_at', today())->count();
        $verified = User::whereNotNull('email_verified_at')->count();

        // Calculate growth percentages (last 7 days vs previous 7 days)
        $lastWeekTotal = User::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $thisWeekTotal = User::whereBetween('created_at', [now()->subDays(7), now()])->count();
        $userGrowth = $lastWeekTotal > 0 ? (($thisWeekTotal - $lastWeekTotal) / $lastWeekTotal) * 100 : 0;

        $lastWeekActive = User::where('status', 'active')->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $thisWeekActive = User::where('status', 'active')->whereBetween('created_at', [now()->subDays(7), now()])->count();
        $activeGrowth = $lastWeekActive > 0 ? (($thisWeekActive - $lastWeekActive) / $lastWeekActive) * 100 : 0;

        // Generate growth data for charts (last 7 days)
        $totalGrowthData = [];
        $activeGrowthData = [];
        $newUsersGrowthData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $totalGrowthData[] = User::whereDate('created_at', '<=', $date)->count();
            $activeGrowthData[] = User::where('status', 'active')->whereDate('created_at', '<=', $date)->count();
            $newUsersGrowthData[] = User::whereDate('created_at', $date)->count();
        }

        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'new_users_today' => $newToday,
            'verified_users' => $verified,
            'total' => $totalUsers,
            'active' => $activeUsers,
            'new_today' => $newToday,
            'verified' => $verified,
            'user_growth' => round($userGrowth, 1),
            'active_growth' => round($activeGrowth, 1),
            'total_growth_data' => $totalGrowthData,
            'active_growth_data' => $activeGrowthData,
            'new_users_growth_data' => $newUsersGrowthData,
        ];
    }
}