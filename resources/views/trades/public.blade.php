<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การเทรดที่แชร์ - {{ $trade->symbol }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800 mb-2">การเทรดที่แชร์</h1>
            <p class="text-slate-600">แชร์โดย {{ $trade->user->name ?? 'Anonymous' }}</p>
        </div>

        <!-- Trade Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- Trade Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ $trade->symbol }}</h2>
                            <p class="text-blue-100">{{ ucfirst($trade->order_type) }} Order</p>
                        </div>
                    </div>

                    <!-- P&L (ถ้ามี) -->
                    @if($trade->pnl)
                    <div class="text-right">
                        <div class="text-3xl font-bold">
                            {{ $trade->pnl > 0 ? '+' : '' }}${{ number_format($trade->pnl, 2) }}
                        </div>
                        @if($trade->result)
                        <div class="text-sm opacity-90">{{ ucfirst($trade->result) }}</div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Trade Details -->
            <div class="p-6 space-y-6">

                <!-- ข้อมูลการเข้า -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-sign-in-alt text-green-600 mr-2"></i>
                        ข้อมูลการเข้า
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="text-sm text-slate-600 mb-1">วันที่เข้า</div>
                            <div class="font-semibold text-slate-800">
                                {{ \Carbon\Carbon::parse($trade->entry_date)->format('d/m/Y') }}
                            </div>
                        </div>

                        @if($trade->entry_time)
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="text-sm text-slate-600 mb-1">เวลาเข้า</div>
                            <div class="font-semibold text-slate-800">
                                {{ \Carbon\Carbon::parse($trade->entry_time)->format('H:i') }}
                            </div>
                        </div>
                        @endif

                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="text-sm text-slate-600 mb-1">ราคาเข้า</div>
                            <div class="font-mono font-bold text-slate-800 text-lg">
                                {{ number_format($trade->entry_price, 5) }}
                            </div>
                        </div>

                        @if($trade->lot_size)
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="text-sm text-slate-600 mb-1">ขนาดล็อต</div>
                            <div class="font-semibold text-slate-800">{{ $trade->lot_size }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- ข้อมูลการออก (ถ้ามี) -->
                @if($trade->exit_price || $trade->exit_date)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-sign-out-alt text-red-600 mr-2"></i>
                        ข้อมูลการออก
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($trade->exit_date)
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="text-sm text-slate-600 mb-1">วันที่ออก</div>
                            <div class="font-semibold text-slate-800">
                                {{ \Carbon\Carbon::parse($trade->exit_date)->format('d/m/Y') }}
                            </div>
                        </div>
                        @endif

                        @if($trade->exit_time)
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="text-sm text-slate-600 mb-1">เวลาออก</div>
                            <div class="font-semibold text-slate-800">
                                {{ \Carbon\Carbon::parse($trade->exit_time)->format('H:i') }}
                            </div>
                        </div>
                        @endif

                        @if($trade->exit_price)
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="text-sm text-slate-600 mb-1">ราคาออก</div>
                            <div class="font-mono font-bold text-slate-800 text-lg">
                                {{ number_format($trade->exit_price, 5) }}
                            </div>
                        </div>
                        @endif

                        @if($trade->pips)
                        <div class="bg-slate-50 rounded-lg p-4">
                            <div class="text-sm text-slate-600 mb-1">Pips</div>
                            <div class="font-semibold {{ $trade->pips > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $trade->pips > 0 ? '+' : '' }}{{ $trade->pips }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Stop Loss & Take Profit (ถ้ามี) -->
                @if($trade->stop_loss || $trade->take_profit)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-shield-alt text-purple-600 mr-2"></i>
                        การจัดการความเสี่ยง
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($trade->stop_loss)
                        <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-500">
                            <div class="text-sm text-red-600 font-medium mb-1">Stop Loss</div>
                            <div class="font-mono font-bold text-red-700">
                                {{ number_format($trade->stop_loss, 5) }}
                            </div>
                        </div>
                        @endif

                        @if($trade->take_profit)
                        <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                            <div class="text-sm text-green-600 font-medium mb-1">Take Profit</div>
                            <div class="font-mono font-bold text-green-700">
                                {{ number_format($trade->take_profit, 5) }}
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($trade->risk_reward)
                    <div class="mt-4 text-center">
                        <div class="inline-flex items-center bg-blue-50 px-4 py-2 rounded-lg">
                            <i class="fas fa-balance-scale text-blue-600 mr-2"></i>
                            <span class="text-sm text-blue-600 font-medium">Risk:Reward</span>
                            <span class="ml-2 font-bold text-blue-700">1:{{ $trade->risk_reward }}</span>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- กลยุทธ์ (ถ้ามี) -->
                @php
                    $displayStrategy = $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
                @endphp
                @if($displayStrategy)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-3 flex items-center">
                        <i class="fas fa-chess text-indigo-600 mr-2"></i>
                        กลยุทธ์
                    </h3>
                    <span class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-800 rounded-lg font-medium">
                        {{ ucfirst($displayStrategy) }}
                    </span>
                </div>
                @endif

                <!-- รูปภาพการเทรด (ถ้ามี) -->
                @php
                    // แปลง images จาก JSON string เป็น array ถ้าจำเป็น
                    $images = $trade->images;
                    if (is_string($images)) {
                        $images = json_decode($images, true) ?? [];
                    }
                    $images = $images ?? [];
                @endphp

                @if(!empty($images) && count($images) > 0)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-images text-pink-600 mr-2"></i>
                        รูปภาพการเทรด
                        <span class="ml-2 text-sm bg-pink-100 text-pink-800 px-2 py-1 rounded-full">
                            {{ count($images) }} รูป
                        </span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($images as $index => $image)
                        <div class="relative group">
                            <!-- Image Container -->
                            <div class="bg-slate-100 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                                <img src="{{ $awsUrl . '/' . $image['path'] }}"
                                     alt="Trade Image {{ $index + 1 }}"
                                     class="w-full h-64 object-cover cursor-pointer hover:scale-105 transition-transform duration-300"
                                     onclick="openImageModal({{ $index }})">

                                <!-- Image Overlay -->
                                {{-- <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <i class="fas fa-expand text-white text-2xl"></i>
                                    </div>
                                </div> --}}
                            </div>

                            <!-- Image Note -->
                            @if(isset($image['note']) && $image['note'])
                            <div class="mt-3 p-3 bg-slate-50 rounded-lg">
                                <p class="text-sm text-slate-700">
                                    <i class="fas fa-comment-alt text-blue-500 mr-2"></i>
                                    {{ $image['note'] }}
                                </p>
                            </div>
                            @endif

                            <!-- Image Info -->
                            <div class="mt-2 flex justify-between items-center text-xs text-slate-500">
                                <span>
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($image['uploaded_at'])->format('d/m/Y H:i') }}
                                </span>
                                @if(isset($image['size']))
                                <span>
                                    <i class="fas fa-file mr-1"></i>
                                    {{ number_format($image['size'] / 1024, 1) }} KB
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- บันทึก (ถ้ามี) -->
                @if($trade->notes)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-3 flex items-center">
                        <i class="fas fa-sticky-note text-yellow-600 mr-2"></i>
                        บันทึก
                    </h3>
                    <div class="bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-400">
                        <p class="text-slate-700">{{ $trade->notes }}</p>
                    </div>
                </div>
                @endif

            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-slate-600">
            <p class="text-sm">
                <i class="fas fa-share-alt mr-1"></i>
                แชร์เมื่อ {{ $trade->updated_at->diffForHumans() }}
            </p>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 hidden">
        <div class="relative max-w-5xl max-h-full p-4">
            <!-- Close Button -->
            <button onclick="closeImageModal()"
                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-300">
                <i class="fas fa-times text-lg"></i>
            </button>

            <!-- Navigation Buttons -->
            <button onclick="previousImage()"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-300"
                    id="prevBtn">
                <i class="fas fa-chevron-left text-lg"></i>
            </button>

            <button onclick="nextImage()"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-300"
                    id="nextBtn">
                <i class="fas fa-chevron-right text-lg"></i>
            </button>

            <!-- Main Image -->
            <img id="modalImage"
                 src=""
                 alt="Trade Image"
                 class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">

            <!-- Image Info -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg">
                <p id="imageNote" class="text-sm text-center"></p>
                <p id="imageCounter" class="text-xs text-center mt-1 opacity-75"></p>
            </div>
        </div>
    </div>

    <!-- JavaScript สำหรับ Image Modal -->
    <script>
        let currentImageIndex = 0;
        // แปลง images data อย่างปลอดภัย
        let images = [];

        @if(!empty($images))
            images = @json($images);
        @endif

        const awsUrl = '{{ $awsUrl }}';

        function openImageModal(index) {
            currentImageIndex = index;
            showImage();
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function showImage() {
            if (images.length === 0) return;

            const image = images[currentImageIndex];
            const modalImage = document.getElementById('modalImage');
            const imageNote = document.getElementById('imageNote');
            const imageCounter = document.getElementById('imageCounter');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            // แสดงรูป
            modalImage.src = awsUrl + '/' + image.path;

            // แสดงหมายเหตุ
            imageNote.textContent = image.note || 'ไม่มีหมายเหตุ';

            // แสดงตัวนับ
            imageCounter.textContent = `${currentImageIndex + 1} / ${images.length}`;

            // แสดง/ซ่อนปุ่มนำทาง
            prevBtn.style.display = images.length > 1 ? 'flex' : 'none';
            nextBtn.style.display = images.length > 1 ? 'flex' : 'none';
        }

        function previousImage() {
            if (currentImageIndex > 0) {
                currentImageIndex--;
            } else {
                currentImageIndex = images.length - 1;
            }
            showImage();
        }

        function nextImage() {
            if (currentImageIndex < images.length - 1) {
                currentImageIndex++;
            } else {
                currentImageIndex = 0;
            }
            showImage();
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('imageModal');
            if (!modal.classList.contains('hidden')) {
                switch(e.key) {
                    case 'Escape':
                        closeImageModal();
                        break;
                    case 'ArrowLeft':
                        if (images.length > 1) previousImage();
                        break;
                    case 'ArrowRight':
                        if (images.length > 1) nextImage();
                        break;
                }
            }
        });

        // Click outside to close
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>
</body>
</html>
