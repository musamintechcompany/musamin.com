<!-- Mobile Wallets -->
<div class="block md:hidden">
    <div x-data="mobileCarousel()" class="relative overflow-hidden">
        <div class="flex transition-transform duration-300"
             x-ref="slider"
             @touchstart="startTouch($event)"
             @touchend="endTouch($event)"
             :style="`transform: translateX(-${activeSlide * 100}%)`">

            <!-- Wallet 1 -->
            <div class="flex-shrink-0 w-full p-1">
                <div class="flex items-center justify-between p-2 rounded-md bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm">
                    <div class="flex items-center min-w-0 space-x-1">
                        <i class="fas fa-coins text-yellow-400 text-sm"></i>
                        <span class="truncate text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white">
                            {{ number_format(auth()->user()->spendable_coins ?? 0) }}
                        </span>
                    </div>
                    <i class="fas fa-wallet text-white text-base"></i>
                </div>
            </div>

            <!-- Wallet 2 -->
            <div class="flex-shrink-0 w-full p-1">
                <div class="flex items-center justify-between p-2 rounded-md bg-gradient-to-br from-green-500 to-green-600 shadow-sm">
                    <div class="flex items-center min-w-0 space-x-1">
                        <i class="fas fa-coins text-yellow-400 text-sm"></i>
                        <span class="truncate text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white">
                            {{ number_format(auth()->user()->earned_coins ?? 0) }}
                        </span>
                    </div>
                    <i class="fas fa-trophy text-white text-base"></i>
                </div>
            </div>
        </div>

        <!-- Carousel Dots -->
        <div class="flex justify-center mt-1 space-x-2">
            <button @click="goToSlide(0)" class="w-2 h-2 rounded-full transition" :class="activeSlide === 0 ? 'bg-blue-500 w-4' : 'bg-gray-300'"></button>
            <button @click="goToSlide(1)" class="w-2 h-2 rounded-full transition" :class="activeSlide === 1 ? 'bg-green-500 w-4' : 'bg-gray-300'"></button>
        </div>
    </div>
</div>

<!-- Desktop Wallets -->
<div class="hidden grid-cols-1 gap-2 md:grid md:grid-cols-2">
    <div class="flex items-center justify-between p-2 rounded-md bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm">
        <div class="flex items-center min-w-0 space-x-1">
            <i class="fas fa-coins text-yellow-400 text-sm"></i>
            <span class="truncate text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white">
                {{ number_format(auth()->user()->spendable_coins ?? 0) }}
            </span>
        </div>
        <i class="fas fa-wallet text-white text-base"></i>
    </div>
    <div class="flex items-center justify-between p-2 rounded-md bg-gradient-to-br from-green-500 to-green-600 shadow-sm">
        <div class="flex items-center min-w-0 space-x-1">
            <i class="fas fa-coins text-yellow-400 text-sm"></i>
            <span class="truncate text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white">
                {{ number_format(auth()->user()->earned_coins ?? 0) }}
            </span>
        </div>
        <i class="fas fa-trophy text-white text-base"></i>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('mobileCarousel', () => ({
            activeSlide: 0,
            touchStartX: 0,
            touchEndX: 0,

            goToSlide(i) {
                this.activeSlide = i;
            },
            startTouch(e) {
                this.touchStartX = e.changedTouches[0].screenX;
            },
            endTouch(e) {
                this.touchEndX = e.changedTouches[0].screenX;
                this.handleSwipe();
            },
            handleSwipe() {
                if (this.touchEndX < this.touchStartX - 50) {
                    if (this.activeSlide < 1) this.activeSlide++;
                }
                if (this.touchEndX > this.touchStartX + 50) {
                    if (this.activeSlide > 0) this.activeSlide--;
                }
            }
        }));
    });
</script>
@endpush