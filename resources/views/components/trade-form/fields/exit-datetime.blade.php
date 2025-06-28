{{-- resources/views/components/trade-form/fields/exit-datetime.blade.php --}}
<div class="group">
    {{-- Label --}}
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-calendar-minus text-orange-600 dark:text-orange-400 text-sm"></i>
        </div>
        Exit Date & Time
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Optional</div>
    </label>

    {{-- Grid --}}
    <div class="grid grid-cols-2 gap-3">
        {{-- Exit Date --}}
        <div
            class="relative"
            x-data="{
                instance: null,
                init() {
                    this.instance = flatpickr($refs.exitDate, {
                        locale: 'th',
                        dateFormat: 'Y-m-d',
                        defaultDate: $wire.exitDate,
                        onChange: function(selectedDates, dateStr) {
                            $wire.set('exitDate', dateStr);
                        }
                    });
                }
            }"
            x-init="init()"
            x-effect="instance.setDate($wire.exitDate, false)"
        >
            <input x-ref="exitDate"
                type="text"
                placeholder="เลือกวันที่ออก"
                class="w-full pl-12 pr-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 dark:text-white shadow-sm hover:shadow-md"
            >
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-orange-500 pointer-events-none">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>

        {{-- Exit Time --}}
        <div
            class="relative"
            x-data="{
                instance: null,
                init() {
                    this.instance = flatpickr($refs.exitTime, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: 'H:i',
                        time_24hr: true,
                        defaultDate: $wire.exitTime,
                        onChange: function(selectedDates, timeStr) {
                            $wire.set('exitTime', timeStr);
                        }
                    });
                }
            }"
            x-init="init()"
            x-effect="instance.setDate($wire.exitTime, false)"
        >
            <input x-ref="exitTime"
                type="text"
                placeholder="เลือกเวลาออก"
                class="w-full pl-12 pr-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 dark:text-white shadow-sm hover:shadow-md"
            >
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-orange-500 pointer-events-none">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    {{-- Description --}}
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
        เวลาที่ปิดโพซิชัน (ถ้ายังไม่ปิดสามารถข้ามได้)
    </p>
</div>
