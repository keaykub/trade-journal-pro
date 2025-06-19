{{-- resources/views/trades/partials/image-sections/summary.blade.php --}}
<div class="mt-6">
    @if(!empty($existingImages) || (!empty($uploadedImages) && count($uploadedImages) > 0))
        <div class="bg-gradient-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/20 dark:to-blue-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-slate-700 dark:text-slate-300">
                    <i class="fas fa-check-circle text-emerald-600 mr-3"></i>
                    <span class="font-medium">
                        รูปภาพทั้งหมด: {{ count($existingImages) + count($uploadedImages) }}/{{ $this->maxImages }} รูป
                    </span>
                </div>
                <div class="flex items-center space-x-4 text-sm">
                    @if(!empty($existingImages))
                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full">
                            เดิม: {{ count($existingImages) }}
                        </span>
                    @endif
                    @if(!empty($uploadedImages) && count($uploadedImages) > 0)
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                            ใหม่: {{ count($uploadedImages) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
