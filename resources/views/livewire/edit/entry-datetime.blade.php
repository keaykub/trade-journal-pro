{{-- resources/views/trades/partials/fields/entry-datetime.blade.php --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-calendar-plus text-blue-600 dark:text-blue-400 text-sm"></i>
        </div>
        Entry Date & Time
        <span class="text-red-500 ml-2 font-bold">*</span>
    </label>

    <div class="grid grid-cols-2 gap-3">
        {{-- Entry Date (Flatpickr) --}}
        <div class="relative"
            x-data="{
                instance: null,
                init() {
                    this.instance = flatpickr($refs.entryDate, {
                        locale: 'th',
                        dateFormat: 'Y-m-d',
                        defaultDate: $wire.entryDate,
                        onChange: function(selectedDates, dateStr) {
                            $wire.set('entryDate', dateStr);
                        }
                    });
                }
            }"
            x-init="init()"
            x-effect="instance.setDate($wire.entryDate, false)">
            <input x-ref="entryDate"
                type="text"
                required
                placeholder="เลือกวันที่เข้า"
                class="w-full pl-12 pr-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 dark:text-white shadow-sm hover:shadow-md">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-500 pointer-events-none">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>

        {{-- Entry Time (Flatpickr - Time Only) --}}
        <div class="relative"
            x-data="{
                instance: null,
                init() {
                    this.instance = flatpickr($refs.entryTime, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: 'H:i',
                        time_24hr: true,
                        defaultDate: $wire.entryTime,
                        onChange: function(selectedDates, timeStr) {
                            $wire.set('entryTime', timeStr);
                        }
                    });
                }
            }"
            x-init="init()"
            x-effect="instance.setDate($wire.entryTime, false)">
            <input x-ref="entryTime"
                type="text"
                placeholder="เลือกเวลาเข้า"
                class="w-full pl-12 pr-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 dark:text-white shadow-sm hover:shadow-md">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-500 pointer-events-none">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    @error('entryDate')
    <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
    </div>
    @enderror

    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
        เวลาที่เปิดโพซิชัน (เวลาเป็นตัวเลือก)
    </p>
</div>
