{{-- resources/views/trades/partials/image-sections/new-images-preview.blade.php --}}
@if(!empty($uploadedImages) && count($uploadedImages) > 0)
    <div class="space-y-4">
        @foreach($uploadedImages as $index => $image)
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-blue-200/50 dark:border-blue-700/50 p-5 shadow-sm">
                <div class="flex flex-col md:flex-row gap-6">
                    {{-- New Image Preview --}}
                    <div class="relative flex-shrink-0" data-uploaded-image>
                        <img src="{{ $image->temporaryUrl() }}"
                            class="w-32 h-32 object-cover rounded-2xl border-2 border-blue-200 dark:border-blue-600 shadow-lg cursor-pointer transition-transform hover:scale-105"
                            loading="lazy"
                            onclick="openPreviewModal('{{ $image->temporaryUrl() }}', 'รูปใหม่ {{ $index + 1 }}')">

                        {{-- Delete Button --}}
                        <button type="button" wire:click="removeNewImage({{ $index }})"
                            class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm transition-all duration-200 shadow-lg hover:scale-110">
                            <i class="fas fa-times"></i>
                        </button>

                        {{-- New Image Badge --}}
                        <div class="absolute -bottom-2 -left-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-3 py-1 rounded-xl text-xs font-medium shadow-lg">
                            ใหม่ {{ $index + 1 }}
                        </div>

                        {{-- File Size --}}
                        <div class="absolute top-2 left-2 bg-black/60 text-white px-2 py-1 rounded-lg text-xs">
                            {{ number_format($image->getSize() / 1024, 1) }}KB
                        </div>
                    </div>

                    {{-- New Image Note --}}
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-blue-700 dark:text-blue-300 mb-3">
                            <i class="fas fa-tag text-blue-600 dark:text-blue-400 mr-2"></i>
                            คำอธิบายรูปภาพใหม่ {{ $index + 1 }}
                            <span class="text-xs text-slate-500 ml-2">({{ $image->getClientOriginalName() }})</span>
                        </label>
                        {{-- ใช้ index ที่ถูกต้องสำหรับรูปใหม่ --}}
                        <textarea wire:model.defer="imageNotes.{{ count($existingImages ?? []) + $index }}" rows="4"
                            placeholder="อธิบายสิ่งที่เห็นในชาร์ต เช่น จุดเข้า, Support/Resistance, Pattern, Indicators..."
                            class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-blue-200 dark:border-blue-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 text-sm resize-none"></textarea>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    {{-- Upload Instructions เมื่อไม่มีรูปใหม่ --}}
    <div class="text-center py-4">
        <div class="text-slate-600 dark:text-slate-400 mb-2">
            <i class="fas fa-info-circle mr-2"></i>
            ใช้พื้นที่ด้านบนเพื่อเพิ่มรูปภาพใหม่
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400">
            รองรับการลากวาง (Drag & Drop) หรือคลิกเพื่อเลือกไฟล์
        </p>
    </div>
@endif
