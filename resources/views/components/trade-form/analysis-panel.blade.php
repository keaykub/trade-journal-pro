{{-- resources/views/components/trade-form/analysis-panel.blade.php --}}
<div class="mt-10 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-800/50 dark:via-slate-700/50 dark:to-slate-600/50 rounded-3xl p-8 border border-slate-200/50 dark:border-slate-700/50 backdrop-blur-sm">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-chart-pie text-white text-lg"></i>
            </div>
            <div>
                <h4 class="text-xl font-bold text-slate-800 dark:text-white">Live Analysis</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400">การวิเคราะห์แบบ Real-time</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span class="text-xs text-slate-500 dark:text-slate-400">Live</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- P&L Card --}}
        @include('components.trade-form.analysis.pnl-card')

        {{-- Risk:Reward Card --}}
        @include('components.trade-form.analysis.risk-reward-card')

        {{-- Trade Status Card --}}
        @include('components.trade-form.analysis.trade-status-card')
    </div>
</div>
