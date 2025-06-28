{{-- resources/views/components/trade-form/step-basic-info.blade.php --}}
<div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
    {{-- Header Section --}}
    <div class="relative bg-gradient-to-r from-blue-600/10 via-indigo-600/10 to-purple-600/10 dark:from-blue-600/20 dark:via-indigo-600/20 dark:to-purple-600/20 px-8 py-6 border-b border-slate-200/50 dark:border-slate-700/50">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative">
            <div class="flex items-center space-x-4 mb-3">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                    <i class="fas fa-database text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Trade Information</h3>
                    <p class="text-slate-600 dark:text-slate-400">กรอกข้อมูลพื้นฐานสำหรับการวิเคราะห์ผลงาน</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Content --}}
    <div class="p-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {{-- Trading Pair --}}
            @include('components.trade-form.fields.trading-pair')

            {{-- Position Direction --}}
            @include('components.trade-form.fields.position-direction')

            {{-- Entry Date & Time --}}
            @include('components.trade-form.fields.entry-datetime')

            {{-- Exit Date & Time --}}
            @include('components.trade-form.fields.exit-datetime')
        </div>
    </div>
</div>
