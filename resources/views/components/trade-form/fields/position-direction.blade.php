{{-- resources/views/components/trade-form/fields/position-direction.blade.php --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-exchange-alt text-emerald-600 dark:text-emerald-400 text-sm"></i>
        </div>
        Position Direction
        <span class="text-red-500 ml-2 font-bold">*</span>
    </label>
    <div class="grid grid-cols-2 gap-3">
        {{-- Long Button --}}
        <button type="button"
            wire:click="$set('orderType', 'buy')"
            class="relative p-4 transition-all duration-300 rounded-2xl border-2 transform hover:scale-105
            {{ $orderType === 'buy'
                ? 'bg-gradient-to-r from-emerald-500 to-green-500 border-emerald-600 shadow-lg shadow-emerald-500/25'
                : 'bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border-emerald-200 dark:border-emerald-800 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-900/30 dark:hover:to-green-900/30' }}">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300
                    {{ $orderType === 'buy'
                        ? 'bg-white/20 backdrop-blur-sm'
                        : 'bg-emerald-600' }}">
                    <i class="fas fa-arrow-up text-white text-sm"></i>
                </div>
                <div>
                    <div class="font-semibold transition-colors duration-300
                        {{ $orderType === 'buy'
                            ? 'text-white'
                            : 'text-emerald-700 dark:text-emerald-300' }}">
                        Long
                    </div>
                    <div class="text-xs transition-colors duration-300
                        {{ $orderType === 'buy'
                            ? 'text-emerald-100'
                            : 'text-emerald-600 dark:text-emerald-400' }}">
                        Buy Position
                    </div>
                </div>
            </div>
            @if($orderType === 'buy')
            <div class="absolute top-2 right-2">
                <div class="w-5 h-5 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-white text-xs"></i>
                </div>
            </div>
            @endif
        </button>

        {{-- Short Button --}}
        <button type="button"
            wire:click="$set('orderType', 'sell')"
            class="relative p-4 transition-all duration-300 rounded-2xl border-2 transform hover:scale-105
            {{ $orderType === 'sell'
                ? 'bg-gradient-to-r from-red-500 to-rose-500 border-red-600 shadow-lg shadow-red-500/25'
                : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-200 dark:hover:border-red-800' }}">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300
                    {{ $orderType === 'sell'
                        ? 'bg-white/20 backdrop-blur-sm'
                        : 'bg-slate-400 hover:bg-red-500' }}">
                    <i class="fas fa-arrow-down text-white text-sm"></i>
                </div>
                <div>
                    <div class="font-semibold transition-colors duration-300
                        {{ $orderType === 'sell'
                            ? 'text-white'
                            : 'text-slate-600 hover:text-red-700 dark:text-slate-400 dark:hover:text-red-300' }}">
                        Short
                    </div>
                    <div class="text-xs transition-colors duration-300
                        {{ $orderType === 'sell'
                            ? 'text-red-100'
                            : 'text-slate-500 hover:text-red-600 dark:text-slate-500 dark:hover:text-red-400' }}">
                        Sell Position
                    </div>
                </div>
            </div>
            @if($orderType === 'sell')
            <div class="absolute top-2 right-2">
                <div class="w-5 h-5 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-white text-xs"></i>
                </div>
            </div>
            @endif
        </button>
    </div>
    @error('orderType')
    <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
    </div>
    @enderror
</div>
