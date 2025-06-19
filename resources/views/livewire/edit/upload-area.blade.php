@php
    $totalImages = count($existingImages ?? []) + count($uploadedImages ?? []);
    $isLimitReached = $totalImages >= $this->maxImages;
@endphp
<div class="relative mb-4">
    @if($isLimitReached)
        {{-- Upload Limit Reached --}}
        <div class="border-2 border-dashed border-red-300 dark:border-red-600 rounded-2xl bg-red-50/50 dark:bg-red-900/20 p-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>

                <h4 class="text-lg font-semibold text-red-800 dark:text-red-300 mb-2">
                    @if(auth()->user()->subscribed())
                        ใช้ครบ {{ $this->maxImages }} รูปแล้ว
                    @else
                        ถึงขีดจำกัดแพลน Free ({{ $this->maxImages }} รูป)
                    @endif
                </h4>

                <p class="text-sm text-red-600 dark:text-red-400 mb-6">
                    @if(!auth()->user()->subscribed())
                        อัปเกรดเป็น Pro เพื่อใช้ได้ถึง 10 รูป หรือลบรูปเดิมก่อน
                    @else
                        ลบรูปเดิมเพื่อเพิ่มรูปใหม่
                    @endif
                </p>

                @if(!auth()->user()->subscribed())
                    <a href="{{ route('pricing') }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 font-medium shadow-lg">
                        <i class="fas fa-crown mr-2"></i>
                        อัปเกรดเป็น Pro
                    </a>
                @endif
            </div>
        </div>
    @else
        {{-- Normal Upload Area --}}
        <input type="file"
            multiple
            wire:model="uploadedImages"
            accept="image/*"
            id="imageUpload"
            class="hidden" />

        <div class="upload-zone relative border-2 border-dashed border-blue-300 dark:border-blue-600 rounded-2xl bg-blue-50/50 dark:bg-blue-700/50 transition-all duration-300 cursor-pointer hover:border-blue-400 hover:bg-blue-100/50 group"
            onclick="document.getElementById('imageUpload').click()"
            ondrop="handleDrop(event)"
            ondragover="handleDragOver(event)"
            ondragenter="handleDragEnter(event)"
            ondragleave="handleDragLeave(event)">

            <div class="p-8 text-center">
                <div class="mb-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg group-hover:scale-105 transition-transform duration-200 drag-safe">
                        <i class="fas fa-cloud-upload-alt text-white text-2xl drag-safe"></i>
                    </div>
                </div>

                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">
                    <span class="drag-text drag-safe">ลากรูปภาพมาวาง หรือ คลิกเพื่อเลือกไฟล์</span>
                </h4>

                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 drag-safe">
                    รองรับ: JPG, PNG, GIF • สูงสุด {{ $this->maxImageSize/1024 }}MB ต่อรูป •
                    เหลือ {{ $this->maxImages - $totalImages }} รูป
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm drag-safe">
                    <div class="flex items-center justify-center space-x-2 text-slate-600 dark:text-slate-400 drag-safe">
                        <i class="fas fa-chart-area text-blue-500 drag-safe"></i>
                        <span class="drag-safe">Chart Analysis</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2 text-slate-600 dark:text-slate-400 drag-safe">
                        <i class="fas fa-search text-emerald-500 drag-safe"></i>
                        <span class="drag-safe">Pattern Recognition</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2 text-slate-600 dark:text-slate-400 drag-safe">
                        <i class="fas fa-history text-purple-500 drag-safe"></i>
                        <span class="drag-safe">Trade Review</span>
                    </div>
                </div>
            </div>

            <div class="drag-overlay absolute inset-0 bg-blue-500/20 backdrop-blur-sm rounded-2xl hidden items-center justify-center">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                        <i class="fas fa-download text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-800 dark:text-blue-200 mb-2">วางรูปภาพที่นี่</h3>
                    <p class="text-blue-600 dark:text-blue-300">ปล่อยเพื่ออัพโหลด</p>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="uploadedImages" class="absolute inset-0 bg-white/75 dark:bg-slate-800/75 backdrop-blur-sm rounded-2xl flex items-center justify-center z-10">
            <div class="flex items-center space-x-3 text-blue-600 dark:text-blue-400">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <span class="text-sm font-medium">กำลังประมวลผลรูปภาพ...</span>
            </div>
        </div>
    @endif
</div>

{{-- Error Messages --}}
@error('uploadedImages')
    <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
    </div>
@enderror
@error('uploadedImages.*')
    <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
    </div>
@enderror
