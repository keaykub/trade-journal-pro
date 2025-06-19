{{-- resources/views/trades/partials/image-sections/existing-images.blade.php --}}
<div class="mb-8 p-6 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl border border-emerald-200 dark:border-emerald-800">
    <h4 class="text-lg font-semibold text-emerald-800 dark:text-emerald-300 mb-4 flex items-center">
        <i class="fas fa-images mr-3"></i>
        รูปภาพที่มีอยู่แล้ว
        <span class="ml-2 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm">{{ count($existingImages) }} รูป</span>
    </h4>

    <div class="space-y-4">
        @foreach($existingImages as $index => $existingImage)
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-emerald-200/50 dark:border-emerald-700/50 p-5 shadow-sm">
                <div class="flex flex-col md:flex-row gap-6">
                    {{-- Existing Image Preview --}}
                    <div class="relative flex-shrink-0" data-existing-image>
                        {{-- รูปเดิม: สร้าง URL เต็มถ้าจำเป็น --}}
                        @php
                            $imageUrl = $existingImage['url'];
                            if (!str_starts_with($imageUrl, 'http')) {
                                $imageUrl = 'https://pub-16760dab33ab4d1db0e1252b4577c03e.r2.dev' . '/' . ltrim($imageUrl, '/');
                            }
                        @endphp

                        <img src="{{ $imageUrl }}"
                            alt="{{ $existingImage['filename'] }}"
                            class="w-32 h-32 object-cover rounded-2xl border-2 border-emerald-200 dark:border-emerald-600 shadow-lg cursor-pointer transition-transform hover:scale-105"
                            loading="lazy"
                            onclick="openPreviewModal('{{ $imageUrl }}', 'รูปเดิม: {{ $existingImage['filename'] }}')"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'; console.error('Failed to load image:', '{{ $imageUrl }}');"
                            onload="this.style.display='block'; this.nextElementSibling.style.display='none'; console.log('Successfully loaded:', '{{ $imageUrl }}');">

                        {{-- Error Fallback --}}
                        <div class="w-32 h-32 bg-red-50 border-2 border-red-200 rounded-2xl flex flex-col items-center justify-center text-red-400 text-xs" style="display: none;">
                            <i class="fas fa-exclamation-triangle text-xl mb-2"></i>
                            <span class="font-medium">รูปเสียหาย</span>
                            <div class="text-center mt-2 px-2">
                                <div class="font-mono text-xs break-all">{{ $existingImage['filename'] }}</div>
                                <a href="{{ $imageUrl }}" target="_blank" class="text-blue-500 underline mt-1 block">ตรวจสอบ URL</a>
                            </div>
                        </div>

                        {{-- Delete Button --}}
                        <button type="button" wire:click="removeExistingImage({{ $index }})"
                            class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm transition-all duration-200 shadow-lg hover:scale-110">
                            <i class="fas fa-times"></i>
                        </button>

                        {{-- Existing Image Badge --}}
                        <div class="absolute -bottom-2 -left-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-3 py-1 rounded-xl text-xs font-medium shadow-lg">
                            เดิม {{ $index + 1 }}
                        </div>

                        {{-- File Info --}}
                        @if($existingImage['size'])
                            <div class="absolute top-2 left-2 bg-black/60 text-white px-2 py-1 rounded-lg text-xs">
                                {{ number_format($existingImage['size'] / 1024, 1) }}KB
                            </div>
                        @endif
                    </div>

                    {{-- Existing Image Note --}}
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-emerald-700 dark:text-emerald-300 mb-3">
                            <i class="fas fa-tag text-emerald-600 dark:text-emerald-400 mr-2"></i>
                            คำอธิบายรูปภาพ {{ $index + 1 }}
                            <span class="text-xs text-slate-500 ml-2">({{ $existingImage['filename'] }})</span>
                        </label>
                        <textarea wire:model.defer="imageNotes.{{ $index }}" rows="4"
                            placeholder="อธิบายสิ่งที่เห็นในชาร์ต เช่น จุดเข้า, Support/Resistance, Pattern, Indicators..."
                            class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-emerald-200 dark:border-emerald-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 text-sm resize-none"></textarea>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
