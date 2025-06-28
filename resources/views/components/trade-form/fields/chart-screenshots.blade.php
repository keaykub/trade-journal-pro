{{-- resources/views/components/trade-form/fields/chart-screenshots.blade.php --}}
<div class="mt-8">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">
        <div class="w-6 h-6 bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-camera text-purple-600 dark:text-purple-400 text-sm"></i>
        </div>
        Chart Screenshots
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Optional</div>
    </label>

    {{-- File Upload Area --}}
    <div class="relative">
        {{-- Hidden File Input --}}
        <input type="file"
            multiple
            wire:model="newImages"
            accept="image/*"
            id="imageUpload"
            class="hidden" />

        {{-- Drag & Drop Zone --}}
        <div class="upload-zone relative border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-2xl bg-slate-50/50 dark:bg-slate-700/50 transition-all duration-200 cursor-pointer hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 mb-4"
            onclick="document.getElementById('imageUpload').click()"
            ondragenter="handleDragEnter(event)"
            ondragleave="handleDragLeave(event)"
            ondragover="handleDragOver(event)"
            ondrop="handleDrop(event)">

            {{-- Upload Content --}}
            <div class="p-6 text-center">
                <div class="mb-3">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg transition-transform hover:scale-105 duration-200">
                        <i class="fas fa-cloud-upload-alt text-white text-2xl"></i>
                    </div>
                </div>
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">
                    <span class="drag-text">ลากรูปภาพมาวาง หรือ คลิกเพื่อเลือกไฟล์</span>
                </h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    รองรับ: JPG, PNG, GIF • สูงสุด {{ $this->maxImageSize/1024 }}MB ต่อรูป • สูงสุด {{ $this->maxImages }} รูป
                </p>

                {{-- Upload Benefits --}}
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div class="flex items-center justify-center space-x-2 text-slate-600 dark:text-slate-400">
                        <i class="fas fa-chart-area text-blue-500"></i>
                        <span>Chart Analysis</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2 text-slate-600 dark:text-slate-400">
                        <i class="fas fa-search text-emerald-500"></i>
                        <span>Pattern Recognition</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2 text-slate-600 dark:text-slate-400">
                        <i class="fas fa-history text-purple-500"></i>
                        <span>Trade Review</span>
                    </div>
                </div>
            </div>

            {{-- Drag Overlay --}}
            <div class="drag-overlay absolute inset-0 bg-blue-500/20 backdrop-blur-sm rounded-2xl hidden items-center justify-center z-10 transition-all duration-200">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl animate-bounce">
                        <i class="fas fa-download text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-800 dark:text-blue-200 mb-2">วางรูปภาพที่นี่</h3>
                    <p class="text-blue-600 dark:text-blue-300">ปล่อยเพื่ออัพโหลด</p>
                </div>
            </div>
        </div>

        {{-- Loading Overlay --}}
        <div wire:loading wire:target="newImages" class="absolute inset-0 bg-white/75 dark:bg-slate-800/75 backdrop-blur-sm rounded-2xl flex items-center justify-center z-20 mb-4">
            <div class="flex items-center space-x-3 text-blue-600 dark:text-blue-400">
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                <span class="text-sm font-medium">กำลังประมวลผลรูปภาพ...</span>
            </div>
        </div>
    </div>

    {{-- Error Messages --}}
    @error('newImages')
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
        </div>
    @enderror
    @error('newImages.*')
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
        </div>
    @enderror

    {{-- Preview All Images (แสดงทั้งรูปเก่าและใหม่) --}}
    @if ($uploadedImages && count($uploadedImages) > 0)
        {{-- Preview Grid with Notes --}}
        <div class="space-y-4 mb-4">
            @foreach ($uploadedImages as $index => $image)
                <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-5">
                    <div class="flex flex-col md:flex-row gap-6">
                        {{-- Image Preview --}}
                        <div class="relative flex-shrink-0">
                            <img src="{{ $image->temporaryUrl() }}"
                                class="w-28 h-28 object-cover rounded-2xl border border-slate-200 dark:border-slate-600 shadow-lg cursor-pointer transition-transform hover:scale-105"
                                loading="lazy"
                                onclick="openPreviewModal('{{ $image->temporaryUrl() }}', 'Chart {{ $index + 1 }}')">

                            <button type="button" wire:click="removeImage({{ $index }})"
                                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center text-xs transition-all duration-200 shadow-lg hover:scale-110">
                                <i class="fas fa-times"></i>
                            </button>

                            <div class="absolute -bottom-2 -left-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-3 py-1 rounded-xl text-xs font-medium shadow-lg">
                                Chart {{ $index + 1 }}
                            </div>

                            {{-- File Size --}}
                            <div class="absolute top-2 left-2 bg-black/60 text-white px-2 py-1 rounded-lg text-xs">
                                {{ number_format($image->getSize() / 1024, 1) }}KB
                            </div>
                        </div>

                        {{-- Note Input --}}
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <i class="fas fa-tag text-blue-600 dark:text-blue-400 mr-2"></i>
                                Chart Description {{ $index + 1 }}
                                <span class="text-xs text-slate-500 ml-2">({{ $image->getClientOriginalName() }})</span>
                            </label>
                            <textarea wire:model.defer="imageNotes.{{ $index }}" rows="4"
                                placeholder="อธิบายสิ่งที่เห็นในชาร์ต เช่น จุดเข้า, Support/Resistance, Pattern, Indicators..."
                                class="w-full px-4 py-3 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 text-sm resize-none"></textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

         {{-- Success Summary --}}
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-4">
            <div class="flex items-center text-emerald-700 dark:text-emerald-300">
                <i class="fas fa-check-circle mr-3"></i>
                <span class="font-medium">อัพโหลดรูปภาพแล้ว: {{ count($uploadedImages) }}/{{ $this->maxImages }} รูป</span>
            </div>
        </div>
    @else
        {{-- Upload Instructions เมื่อไม่มีรูป --}}
        <div class="text-center py-4">
            <div class="text-slate-600 dark:text-slate-400 mb-2">
                <i class="fas fa-info-circle mr-2"></i>
                ใช้พื้นที่ด้านบนเพื่อเพิ่มรูปภาพ
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                รองรับการลากวาง (Drag & Drop) หรือคลิกเพื่อเลือกไฟล์
            </p>
        </div>
    @endif
</div>
