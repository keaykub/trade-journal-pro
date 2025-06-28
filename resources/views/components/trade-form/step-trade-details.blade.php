{{-- resources/views/components/trade-form/step-trade-details.blade.php --}}
<div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
    {{-- Header Section --}}
    <div class="relative bg-gradient-to-r from-emerald-600/10 via-blue-600/10 to-indigo-600/10 dark:from-emerald-600/20 dark:via-blue-600/20 dark:to-indigo-600/20 px-6 py-8 border-b border-slate-200/50 dark:border-slate-700/50">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative">
            <div class="flex items-center space-x-4 mb-3">
                <div class="w-12 h-12 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                    <i class="fas fa-calculator text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Financial Analysis</h3>
                    <p class="text-slate-600 dark:text-slate-400">กรอกราคาและข้อมูลการคำนวณ P&L</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Content --}}
    <div class="p-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Entry Price --}}
            @include('components.trade-form.fields.entry-price')

            {{-- Exit Price --}}
            @include('components.trade-form.fields.exit-price')

            {{-- Stop Loss --}}
            @include('components.trade-form.fields.stop-loss')

            {{-- Take Profit --}}
            @include('components.trade-form.fields.take-profit')

            {{-- Position Size --}}
            @include('components.trade-form.fields.position-size')

            {{-- Order Type --}}
            @include('components.trade-form.fields.order-type')
        </div>

        {{-- Real-time Analysis Panel --}}
        @include('components.trade-form.analysis-panel')
    </div>
</div>
