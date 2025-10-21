<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerificationBadge;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationBadgeController extends Controller
{
    public function index()
    {
        $badges = VerificationBadge::with(['user', 'verifiedBy'])->latest()->paginate(15);
        return view('management.portal.admin.verification-badges.index', compact('badges'));
    }

    public function show(VerificationBadge $verificationBadge)
    {
        $verificationBadge->load(['user', 'verifiedBy']);
        return view('management.portal.admin.verification-badges.view', compact('verificationBadge'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('verificationBadges')->orderBy('name')->get();
        return view('management.portal.admin.verification-badges.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'badge_type' => 'required|in:identity,business,creator,celebrity',
            'verification_reason' => 'nullable|string',
            'expires_at' => 'nullable|date|after:today'
        ]);

        VerificationBadge::create([
            'user_id' => $request->user_id,
            'badge_type' => $request->badge_type,
            'verified_at' => now(),
            'verified_by' => auth()->id(),
            'expires_at' => $request->expires_at,
            'verification_reason' => $request->verification_reason,
            'is_active' => true
        ]);

        return redirect()->route('admin.verification-badges.index')->with('success', 'Verification badge created successfully.');
    }

    public function edit(VerificationBadge $verificationBadge)
    {
        return view('management.portal.admin.verification-badges.edit', compact('verificationBadge'));
    }

    public function update(Request $request, VerificationBadge $verificationBadge)
    {
        $request->validate([
            'badge_type' => 'required|in:identity,business,creator,celebrity',
            'verification_reason' => 'nullable|string',
            'expires_at' => 'nullable|date|after:today',
            'is_active' => 'boolean'
        ]);

        $verificationBadge->update($request->only(['badge_type', 'verification_reason', 'expires_at', 'is_active']));

        return redirect()->route('admin.verification-badges.index')->with('success', 'Verification badge updated successfully.');
    }

    public function destroy(VerificationBadge $verificationBadge)
    {
        $verificationBadge->delete();
        return redirect()->route('admin.verification-badges.index')->with('success', 'Verification badge deleted successfully.');
    }
}