{{-- resources/views/trades/partials/fields/trading-strategy.blade.php --}}
<div class="group col-span-1 lg:col-span-2">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">
        <div class="w-6 h-6 bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-chess text-indigo-600 dark:text-indigo-400 text-sm"></i>
        </div>
        Trading Strategy
        <span class="text-red-500 ml-2 font-bold">*</span>
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Required</div>
    </label>

    {{-- Strategy Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
        <button type="button" wire:click="$set('strategy', 'breakout')"
            class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'breakout' ? 'bg-gradient-to-r from-blue-500 to-indigo-500 border-blue-600 text-white shadow-lg shadow-blue-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-200 dark:hover:border-blue-800' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'breakout' ? 'bg-white/20' : 'bg-blue-100 dark:bg-blue-900/30' }}">
                <i class="fas fa-rocket {{ $strategy === 'breakout' ? 'text-white' : 'text-blue-600 dark:text-blue-400' }} text-sm"></i>
            </div>
            <div class="font-semibold text-sm {{ $strategy === 'breakout' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Breakout</div>
        </button>

        <button type="button" wire:click="$set('strategy', 'scalping')"
            class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'scalping' ? 'bg-gradient-to-r from-emerald-500 to-green-500 border-emerald-600 text-white shadow-lg shadow-emerald-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-200 dark:hover:border-emerald-800' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'scalping' ? 'bg-white/20' : 'bg-emerald-100 dark:bg-emerald-900/30' }}">
                <i class="fas fa-bolt {{ $strategy === 'scalping' ? 'text-white' : 'text-emerald-600 dark:text-emerald-400' }} text-sm"></i>
            </div>
            <div class="font-semibold text-sm {{ $strategy === 'scalping' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Scalping</div>
        </button>

        <button type="button" wire:click="$set('strategy', 'swing')"
            class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'swing' ? 'bg-gradient-to-r from-purple-500 to-pink-500 border-purple-600 text-white shadow-lg shadow-purple-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:border-purple-200 dark:hover:border-purple-800' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'swing' ? 'bg-white/20' : 'bg-purple-100 dark:bg-purple-900/30' }}">
                <i class="fas fa-wave-square {{ $strategy === 'swing' ? 'text-white' : 'text-purple-600 dark:text-purple-400' }} text-sm"></i>
            </div>
            <div class="font-semibold text-sm {{ $strategy === 'swing' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Swing</div>
        </button>

        <button type="button" wire:click="$set('strategy', 'trend')"
            class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'trend' ? 'bg-gradient-to-r from-orange-500 to-red-500 border-orange-600 text-white shadow-lg shadow-orange-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:border-orange-200 dark:hover:border-orange-800' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'trend' ? 'bg-white/20' : 'bg-orange-100 dark:bg-orange-900/30' }}">
                <i class="fas fa-chart-line {{ $strategy === 'trend' ? 'text-white' : 'text-orange-600 dark:text-orange-400' }} text-sm"></i>
            </div>
            <div class="font-semibold text-sm {{ $strategy === 'trend' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Trend</div>
        </button>

        <button type="button" wire:click="$set('strategy', 'reversal')"
            class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'reversal' ? 'bg-gradient-to-r from-cyan-500 to-blue-500 border-cyan-600 text-white shadow-lg shadow-cyan-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 hover:border-cyan-200 dark:hover:border-cyan-800' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'reversal' ? 'bg-white/20' : 'bg-cyan-100 dark:bg-cyan-900/30' }}">
                <i class="fas fa-undo {{ $strategy === 'reversal' ? 'text-white' : 'text-cyan-600 dark:text-cyan-400' }} text-sm"></i>
            </div>
            <div class="font-semibold text-sm {{ $strategy === 'reversal' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Reversal</div>
        </button>

        <button type="button" wire:click="$set('strategy', 'range')"
            class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'range' ? 'bg-gradient-to-r from-teal-500 to-green-500 border-teal-600 text-white shadow-lg shadow-teal-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-teal-50 dark:hover:bg-teal-900/20 hover:border-teal-200 dark:hover:border-teal-800' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'range' ? 'bg-white/20' : 'bg-teal-100 dark:bg-teal-900/30' }}">
                <i class="fas fa-arrows-alt-h {{ $strategy === 'range' ? 'text-white' : 'text-teal-600 dark:text-teal-400' }} text-sm"></i>
            </div>
            <div class="font-semibold text-sm {{ $strategy === 'range' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Range</div>
        </button>

        <button type="button" wire:click="$set('strategy', 'news')"
            class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'news' ? 'bg-gradient-to-r from-yellow-500 to-orange-500 border-yellow-600 text-white shadow-lg shadow-yellow-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:border-yellow-200 dark:hover:border-yellow-800' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'news' ? 'bg-white/20' : 'bg-yellow-100 dark:bg-yellow-900/30' }}">
                <i class="fas fa-newspaper {{ $strategy === 'news' ? 'text-white' : 'text-yellow-600 dark:text-yellow-400' }} text-sm"></i>
            </div>
            <div class="font-semibold text-sm {{ $strategy === 'news' ? 'text-white' : 'text-slate-800 dark:text-white' }}">News</div>
        </button>

        <button type="button" wire:click="$set('strategy', 'other')"
            class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'other' ? 'bg-gradient-to-r from-slate-500 to-gray-500 border-slate-600 text-white shadow-lg shadow-slate-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-600 hover:border-slate-300 dark:hover:border-slate-500' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'other' ? 'bg-white/20' : 'bg-slate-100 dark:bg-slate-600' }}">
                <i class="fas fa-plus {{ $strategy === 'other' ? 'text-white' : 'text-slate-600 dark:text-slate-400' }} text-sm"></i>
            </div>
            <div class="font-semibold text-sm {{ $strategy === 'other' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Other</div>
        </button>
    </div>

    @error('strategy')
    <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
    </div>
    @enderror
</div>

{{-- Custom Strategy Input --}}
@if($strategy === 'other')
<div class="group col-span-1 lg:col-span-2">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-edit text-orange-600 dark:text-orange-400 text-sm"></i>
        </div>
        Custom Strategy
    </label>
    <input type="text" wire:model.defer="customStrategy"
        placeholder="อธิบายกลยุทธ์ของคุณ เช่น 'Fibonacci Retracement + RSI Divergence'"
        class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 shadow-sm hover:shadow-md"/>
</div>
@endif
