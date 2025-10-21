<x-app-layout>
    <div class="container p-4 mx-auto">
        <x-account-status-banner />

        <x-wallet-system />

        <!-- Suggestions Section -->
        <div class="mt-6 px-4">
            <div class="text-[15px] font-semibold text-black dark:text-white tracking-wide">Suggestions For You</div>
        </div>
        <div class="mt-2 px-4 overflow-x-auto flex gap-2 hide-scrollbar" id="suggestions">
            <!-- Explore Trending Websites -->
            <div class="min-w-[240px] h-[86px] rounded-2xl p-[14px_16px] flex items-center justify-between gap-2.5 shadow-lg snap-start"
                 style="background: radial-gradient(110% 140% at 88% 18%, rgba(255,255,255,.12) 0%, transparent 54%), linear-gradient(135deg, #2546e6, #1135d0);">
                <div>
                    <h4 class="m-0 mb-1 text-[12px] font-extrabold text-white tracking-wide leading-tight">Explore trending<br/>websites</h4>
                    <button class="appearance-none border-0 bg-[#0b1a7a] text-[#dbe3ff] rounded-full py-1 px-2.5 font-extrabold text-[9px] tracking-wide shadow-[inset_0_0_0_1px_rgba(255,255,255,.06)] cursor-pointer">BROWSE NOW</button>
                </div>
                <div class="w-20 h-16 relative opacity-90" aria-hidden="true">
                    <div class="absolute w-16 h-12 right-1.5 top-1.5 rounded-xl rotate-2 filter saturate-110"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #5ad3ff 0%, #33b5ff 35%, #0e83f1 100%);"></div>
                    <div class="absolute w-10 h-9 right-6 bottom-0 rounded-xl opacity-88 rotate-2 filter saturate-110"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #5ad3ff 0%, #33b5ff 35%, #0e83f1 100%);"></div>
                </div>
            </div>

            <!-- Start Selling Digital Assets -->
            <div class="min-w-[240px] h-[86px] rounded-2xl p-[14px_16px] flex items-center justify-between gap-2.5 shadow-lg snap-start"
                 style="background: radial-gradient(110% 140% at 88% 18%, rgba(255,255,255,.10) 0%, transparent 54%), linear-gradient(135deg, #2f7bff, #1730ae);">
                <div>
                    <h4 class="m-0 mb-1 text-[12px] font-extrabold text-white tracking-wide leading-tight">Start selling your<br/>digital assets</h4>
                    <button class="appearance-none border-0 bg-[#0b1a7a] text-[#dbe3ff] rounded-full py-1 px-2.5 font-extrabold text-[9px] tracking-wide shadow-[inset_0_0_0_1px_rgba(255,255,255,.06)] cursor-pointer">GET STARTED</button>
                </div>
                <div class="w-20 h-16 relative opacity-90" aria-hidden="true">
                    <div class="absolute w-16 h-12 right-1.5 top-1.5 rounded-xl rotate-2 filter saturate-110 overflow-hidden"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #5ad3ff 0%, #33b5ff 35%, #0e83f1 100%);">
                        <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover opacity-60" alt="Store">
                    </div>
                    <div class="absolute w-10 h-9 right-6 bottom-0 rounded-xl opacity-88 rotate-2 filter saturate-110 overflow-hidden"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #5ad3ff 0%, #33b5ff 35%, #0e83f1 100%);">
                        <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover opacity-60" alt="Digital">
                    </div>
                </div>
            </div>

            <!-- Mobile App Templates -->
            <div class="min-w-[240px] h-[86px] rounded-2xl p-[14px_16px] flex items-center justify-between gap-2.5 shadow-lg snap-start"
                 style="background: radial-gradient(110% 140% at 88% 18%, rgba(255,255,255,.10) 0%, transparent 54%), linear-gradient(135deg, #9333ea, #7c3aed);">
                <div>
                    <h4 class="m-0 mb-1 text-[12px] font-extrabold text-white tracking-wide leading-tight">Check out new mobile<br/>app templates</h4>
                    <button class="appearance-none border-0 bg-[#581c87] text-[#ddd6fe] rounded-full py-1 px-2.5 font-extrabold text-[9px] tracking-wide shadow-[inset_0_0_0_1px_rgba(255,255,255,.06)] cursor-pointer">VIEW APPS</button>
                </div>
                <div class="w-20 h-16 relative opacity-90" aria-hidden="true">
                    <div class="absolute w-16 h-12 right-1.5 top-1.5 rounded-xl rotate-2 filter saturate-110"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #c084fc 0%, #a855f7 35%, #9333ea 100%);"></div>
                    <div class="absolute w-10 h-9 right-6 bottom-0 rounded-xl opacity-88 rotate-2 filter saturate-110"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #c084fc 0%, #a855f7 35%, #9333ea 100%);"></div>
                </div>
            </div>

            <!-- Join Affiliate Program -->
            <div class="min-w-[240px] h-[86px] rounded-2xl p-[14px_16px] flex items-center justify-between gap-2.5 shadow-lg snap-start"
                 style="background: radial-gradient(110% 140% at 88% 18%, rgba(255,255,255,.10) 0%, transparent 54%), linear-gradient(135deg, #059669, #047857);">
                <div>
                    <h4 class="m-0 mb-1 text-[12px] font-extrabold text-white tracking-wide leading-tight">Join our affiliate<br/>program</h4>
                    <button class="appearance-none border-0 bg-[#064e3b] text-[#d1fae5] rounded-full py-1 px-2.5 font-extrabold text-[9px] tracking-wide shadow-[inset_0_0_0_1px_rgba(255,255,255,.06)] cursor-pointer">JOIN NOW</button>
                </div>
                <div class="w-20 h-16 relative opacity-90" aria-hidden="true">
                    <div class="absolute w-16 h-12 right-1.5 top-1.5 rounded-xl rotate-2 filter saturate-110 overflow-hidden"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #6ee7b7 0%, #34d399 35%, #10b981 100%);">
                        <img src="https://images.unsplash.com/photo-1559526324-4b87b5e36e44?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover opacity-60" alt="Affiliate">
                    </div>
                    <div class="absolute w-10 h-9 right-6 bottom-0 rounded-xl opacity-88 rotate-2 filter saturate-110 overflow-hidden"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #6ee7b7 0%, #34d399 35%, #10b981 100%);">
                        <img src="https://images.unsplash.com/photo-1553729459-efe14ef6055d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover opacity-60" alt="Network">
                    </div>
                </div>
            </div>
        </div>

        <!-- Savings Plans Section -->
        <div class="mt-6 px-4">
            <div class="text-[15px] font-semibold text-black dark:text-white tracking-wide">My Savings Plans</div>
        </div>
        <div class="mt-2 px-4 overflow-x-auto flex gap-2 hide-scrollbar">
                <div class="relative rounded-2xl p-3 overflow-hidden shadow-xl w-32 h-32 flex-shrink-0"
                     style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), #0f2130;">
                    <div class="absolute top-1.5 right-1.5 bg-gradient-to-br from-[#2546e6] to-[#1730ae] text-[#dfe7ff] rounded-full py-1 px-1.5 font-extrabold text-[9px] shadow-lg">₦8.6M</div>
                    <div class="mt-8 font-bold text-[#eef1f4] text-sm tracking-wide">SafeLock</div>
                    <div class="h-1 rounded-full bg-[#23384a] overflow-hidden my-1.5">
                        <div class="h-full w-7/20 bg-gradient-to-r from-[#6dd3ff] to-[#2ea7ff]"></div>
                    </div>
                    <div class="text-[#b8c1cc] text-[9px] opacity-90">Lock funds</div>
                </div>
                <div class="relative rounded-2xl p-3 overflow-hidden shadow-xl w-32 h-32 flex-shrink-0"
                     style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), #0f1f2d;">
                    <div class="absolute top-1.5 right-1.5 bg-gradient-to-br from-[#1d52ff] to-[#0e36bd] text-[#dfe7ff] rounded-full py-1 px-1.5 font-extrabold text-[9px] shadow-lg">₦2.2M</div>
                    <div class="mt-8 font-bold text-[#eef1f4] text-sm tracking-wide">PiggyBank</div>
                    <div class="h-1 rounded-full bg-[#23384a] overflow-hidden my-1.5">
                        <div class="h-full w-[22%] bg-gradient-to-r from-[#6dd3ff] to-[#2ea7ff]"></div>
                    </div>
                    <div class="text-[#b8c1cc] text-[9px] opacity-90">Auto savings</div>
                </div>
                <div class="relative rounded-2xl p-3 overflow-hidden shadow-xl w-32 h-32 flex-shrink-0"
                     style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), #2d1b69;">
                    <div class="absolute top-1.5 right-1.5 bg-gradient-to-br from-[#8b5cf6] to-[#7c3aed] text-[#dfe7ff] rounded-full py-1 px-1.5 font-extrabold text-[9px] shadow-lg">₦1.5M</div>
                    <div class="mt-8 font-bold text-[#eef1f4] text-sm tracking-wide">FlexSave</div>
                    <div class="h-1 rounded-full bg-[#23384a] overflow-hidden my-1.5">
                        <div class="h-full w-[45%] bg-gradient-to-r from-[#a78bfa] to-[#8b5cf6]"></div>
                    </div>
                    <div class="text-[#b8c1cc] text-[9px] opacity-90">Flexible plan</div>
                </div>
                <div class="relative rounded-2xl p-3 overflow-hidden shadow-xl w-32 h-32 flex-shrink-0"
                     style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), #1e3a8a;">
                    <div class="absolute top-1.5 right-1.5 bg-gradient-to-br from-[#3b82f6] to-[#1d4ed8] text-[#dfe7ff] rounded-full py-1 px-1.5 font-extrabold text-[9px] shadow-lg">₦5.1M</div>
                    <div class="mt-8 font-bold text-[#eef1f4] text-sm tracking-wide">GoalSave</div>
                    <div class="h-1 rounded-full bg-[#23384a] overflow-hidden my-1.5">
                        <div class="h-full w-[68%] bg-gradient-to-r from-[#60a5fa] to-[#3b82f6]"></div>
                    </div>
                    <div class="text-[#b8c1cc] text-[9px] opacity-90">Target goals</div>
                </div>
                <div class="relative rounded-2xl p-3 overflow-hidden shadow-xl w-32 h-32 flex-shrink-0"
                     style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), #7c2d12;">
                    <div class="absolute top-1.5 right-1.5 bg-gradient-to-br from-[#f97316] to-[#ea580c] text-[#dfe7ff] rounded-full py-1 px-1.5 font-extrabold text-[9px] shadow-lg">₦3.8M</div>
                    <div class="mt-8 font-bold text-[#eef1f4] text-sm tracking-wide">QuickSave</div>
                    <div class="h-1 rounded-full bg-[#23384a] overflow-hidden my-1.5">
                        <div class="h-full w-[30%] bg-gradient-to-r from-[#fb923c] to-[#f97316]"></div>
                    </div>
                    <div class="text-[#b8c1cc] text-[9px] opacity-90">Quick access</div>
                </div>
                <div class="relative rounded-2xl p-3 overflow-hidden shadow-xl w-32 h-32 flex-shrink-0 flex items-center justify-center cursor-pointer hover:opacity-80 transition-opacity"
                     style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), #1a1a2e;">
                    <div class="text-center">
                        <div class="text-white font-bold text-sm mb-1">See More</div>
                        <div class="text-gray-400 text-xs">+</div>
                    </div>
                </div>
        </div>

        @php
            $recentOrders = auth()->user()->orders()->latest()->take(5)->get();
        @endphp
        
        @if($recentOrders->count() > 0)
            <!-- Orders Section -->
            <div class="mt-6 px-4">
                <div class="text-[15px] font-semibold text-black dark:text-white tracking-wide">Orders</div>
            </div>
            <div class="mt-2 px-4 overflow-x-auto flex gap-2 hide-scrollbar">
                @php
                    $statusStyles = [
                        'pending' => ['bg' => '#92400e', 'badge' => 'from-[#f59e0b] to-[#d97706]', 'progress' => 'from-[#fbbf24] to-[#f59e0b]', 'width' => 'w-[15%]'],
                        'confirmed' => ['bg' => '#1e40af', 'badge' => 'from-[#3b82f6] to-[#1d4ed8]', 'progress' => 'from-[#60a5fa] to-[#3b82f6]', 'width' => 'w-[30%]'],
                        'processing' => ['bg' => '#6b21a8', 'badge' => 'from-[#8b5cf6] to-[#7c3aed]', 'progress' => 'from-[#a78bfa] to-[#8b5cf6]', 'width' => 'w-[50%]'],
                        'shipped' => ['bg' => '#3730a3', 'badge' => 'from-[#6366f1] to-[#4f46e5]', 'progress' => 'from-[#818cf8] to-[#6366f1]', 'width' => 'w-[75%]'],
                        'delivered' => ['bg' => '#065f46', 'badge' => 'from-[#10b981] to-[#059669]', 'progress' => 'from-[#34d399] to-[#10b981]', 'width' => 'w-[90%]'],
                        'completed' => ['bg' => '#374151', 'badge' => 'from-[#6b7280] to-[#4b5563]', 'progress' => 'from-[#9ca3af] to-[#6b7280]', 'width' => 'w-full'],
                        'cancelled' => ['bg' => '#991b1b', 'badge' => 'from-[#ef4444] to-[#dc2626]', 'progress' => 'from-[#f87171] to-[#ef4444]', 'width' => 'w-0']
                    ];
                @endphp
                
                @foreach($recentOrders as $order)
                    @php
                        $status = strtolower($order->status);
                        $style = $statusStyles[$status] ?? $statusStyles['pending'];
                    @endphp
                    <a href="{{ route('orders.view', $order->id) }}" class="relative rounded-2xl p-3 overflow-hidden shadow-xl w-32 h-32 flex-shrink-0 cursor-pointer hover:opacity-80 transition-opacity"
                       style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), {{ $style['bg'] }};">
                        <div class="absolute top-1.5 right-1.5 bg-gradient-to-br {{ $style['badge'] }} text-[#dfe7ff] rounded-full py-1 px-1.5 font-extrabold text-[9px] shadow-lg">{{ $order->order_number ?? $order->id }}</div>
                        <div class="mt-8 font-bold text-[#eef1f4] text-sm tracking-wide">{{ ucfirst($order->status) }}</div>
                        <div class="h-1 rounded-full bg-[#23384a] overflow-hidden my-1.5">
                            <div class="h-full {{ $style['width'] }} bg-gradient-to-r {{ $style['progress'] }}"></div>
                        </div>
                        <div class="text-[#b8c1cc] text-[9px] opacity-90">${{ number_format($order->total_amount) }}</div>
                    </a>
                @endforeach
                
                <a href="{{ route('orders.index') }}" class="relative rounded-2xl p-3 overflow-hidden shadow-xl w-32 h-32 flex-shrink-0 flex items-center justify-center cursor-pointer hover:opacity-80 transition-opacity"
                   style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), #1a1a2e;">
                    <div class="text-center">
                        <div class="text-white font-bold text-sm mb-1">See More</div>
                        <div class="text-gray-400 text-xs">+</div>
                    </div>
                </a>
            </div>
        @endif


    </div>



    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .text-shadow-lg {
            text-shadow: 0 6px 16px rgba(0,0,0,.25);
        }
    </style>

    @push('scripts')
    <script>

        // Scroll the suggestions to the first card on load
        const suggestions = document.getElementById('suggestions');
        window.addEventListener('load', () => {
            if (suggestions) {
                suggestions.scrollTo({left: 0, behavior: 'smooth'});
            }
        });

        // Ripple-like feedback for the FAB
        const fab = document.querySelector('.fixed button');
        if (fab) {
            fab.addEventListener('click', (e) => {
                const circle = document.createElement('span');
                const size = 120;
                circle.style.position = 'absolute';
                circle.style.width = circle.style.height = size + 'px';
                circle.style.left = (e.offsetX - size/2) + 'px';
                circle.style.top = (e.offsetY - size/2) + 'px';
                circle.style.borderRadius = '50%';
                circle.style.background = 'rgba(255,255,255,.25)';
                circle.style.pointerEvents = 'none';
                circle.style.transform = 'scale(0.2)';
                circle.style.transition = 'transform .35s ease, opacity .4s ease';
                fab.appendChild(circle);
                requestAnimationFrame(() => {
                    circle.style.transform = 'scale(1)';
                    circle.style.opacity = '0';
                });
                setTimeout(() => circle.remove(), 420);
            });
        }
    </script>
    @endpush
</x-app-layout>