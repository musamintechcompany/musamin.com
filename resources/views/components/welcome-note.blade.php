@if(auth()->check() && !session()->has('welcome_shown'))
    @php session()->put('welcome_shown', true); @endphp
    <!-- Nuclear-proof overlay with maximum z-index -->
    <div x-data="{
        showWelcome: true,
        progress: 100,
        duration: 3000,
        startProgress() {
            const interval = 30; // Smoother animation with 30ms intervals
            const steps = this.duration / interval;
            const stepAmount = 100 / steps;

            const timer = setInterval(() => {
                this.progress -= stepAmount;
                if (this.progress <= 0) {
                    clearInterval(timer);
                    this.showWelcome = false;
                }
            }, interval);
        }
    }"
    x-init="startProgress()"
    x-show="showWelcome"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-[2147483647] isolate flex items-center justify-center bg-black/70 backdrop-blur-[2px]">

        <!-- Card with enhanced shadow and border -->
        <div class="relative w-full max-w-md p-6 mx-4 overflow-hidden bg-white border border-gray-200 shadow-2xl dark:bg-gray-800 rounded-xl dark:border-gray-700">
            <div class="text-center">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full dark:bg-green-900/50">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="mt-3 text-lg font-medium text-gray-900 dark:text-white">Welcome, {{ auth()->user()->name }}!</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500 dark:text-gray-300">
                        You've successfully logged in to your account.
                    </p>
                </div>
            </div>

            <!-- Ultra-thin animated progress bar -->
            <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-gray-100 dark:bg-gray-700/50">
                <div class="h-full transition-all ease-linear bg-green-500 dark:bg-green-400 duration-30"
                     :style="`width: ${progress}%`"
                     x-transition></div>
            </div>
        </div>
    </div>
@endif
