{{-- resources/views/trades/partials/step-3-strategy-psychology.blade.php --}}
<div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
    {{-- Header Section --}}
    <div class="relative bg-gradient-to-r from-purple-600/10 via-pink-600/10 to-indigo-600/10 dark:from-purple-600/20 dark:via-pink-600/20 dark:to-indigo-600/20 px-6 py-8 border-b border-slate-200/50 dark:border-slate-700/50">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative">
            <div class="flex items-center space-x-4 mb-3">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/25">
                    <i class="fas fa-brain text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Trading Psychology</h3>
                    <p class="text-slate-600 dark:text-slate-400">วิเคราะห์กลยุทธ์และจิตวิทยาในการเทรด</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Content --}}
    <div class="p-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Trading Strategy --}}
            @include('livewire.edit.trading-strategy')

            {{-- Emotions --}}
            @include('livewire.edit.emotions')
        </div>

        {{-- Trading Notes --}}
        @include('livewire.edit.trading-notes')

        {{-- Chart Screenshots Section --}}
        @include('livewire.edit.chart-screenshots')
    </div>
</div>
