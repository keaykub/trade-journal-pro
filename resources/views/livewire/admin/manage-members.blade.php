<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">จัดการการชำระเงิน</h2>

        <!-- ช่องค้นหาและฟิลเตอร์ -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <input
                type="text"
                wire:model.live="search"
                placeholder="ค้นหาชื่อหรืออีเมลสมาชิก..."
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
            >
            <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                <option value="all">สถานะทั้งหมด</option>
                <option value="pending">รอดำเนินการ</option>
                <option value="verified">ยืนยันแล้ว</option>
                <option value="rejected">ปฏิเสธ</option>
            </select>
        </div>

        <!-- สถิติ -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">ทั้งหมด</h3>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalPayments }}</p>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-yellow-900 dark:text-yellow-100">รอดำเนินการ</h3>
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $pendingPayments }}</p>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-green-900 dark:text-green-100">ยืนยันแล้ว</h3>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $verifiedPayments }}</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-red-900 dark:text-red-100">ปฏิเสธ</h3>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $rejectedPayments }}</p>
            </div>
        </div>

        <!-- ตารางการชำระเงิน -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">สมาชิก</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">แผน</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">จำนวนเงิน</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">วันที่ชำระ</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">หมายเหตุ</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">สถานะ</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">หลักฐาน</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">{{ substr($payment->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $payment->user->name }}</div>
                                    <div class="text-gray-500 text-xs">{{ $payment->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            {{ $payment->plan->name ?? 'ไม่ระบุแผน' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <span class="font-medium">฿{{ number_format($payment->amount, 2) }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            {{ $payment->created_at->format('d/m/Y H:i') }}
                            @if($payment->ref_id)
                                <div class="text-xs text-gray-500">REF: {{ $payment->ref_id }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            @if($payment->note)
                                <div class="max-w-xs truncate" title="{{ $payment->note }}">
                                    {{ $payment->note }}
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($payment->isPending())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    <i class="fas fa-clock mr-1"></i> รอดำเนินการ
                                </span>
                            @elseif($payment->status === 'verified')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <i class="fas fa-check mr-1"></i> ยืนยันแล้ว
                                </span>
                            @elseif($payment->isRejected())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    <i class="fas fa-times mr-1"></i> ปฏิเสธ
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($payment->slip_url)
                                <a href="{{ asset('storage/' . $payment->slip_url) }}" target="_blank"
                                   class="inline-flex items-center space-x-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <i class="fas fa-image"></i>
                                    <span>ดูสลิป</span>
                                </a>
                                <!-- ปุ่มดูตัวอย่างรูป -->
                                <button
                                    onclick="showImageModal('{{ asset('storage/' . $payment->slip_url) }}')"
                                    class="ml-2 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                    <i class="fas fa-eye"></i>
                                </button>
                            @else
                                <span class="text-gray-400">ไม่มีสลิป</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex flex-col space-y-2">
                                <!-- Quick Actions -->
                                @if($payment->isPending())
                                    <div class="flex items-center space-x-1">
                                        <button
                                            wire:click="approvePayment('{{ $payment->id }}')"
                                            wire:confirm="แน่ใจหรือไม่ว่าต้องการยืนยันการชำระเงินนี้? ระบบจะสร้าง subscription ให้อัตโนมัติ"
                                            class="px-2 py-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded">
                                            <i class="fas fa-check"></i> ยืนยัน
                                        </button>
                                        <button
                                            wire:click="rejectPayment('{{ $payment->id }}')"
                                            wire:confirm="แน่ใจหรือไม่ว่าต้องการปฏิเสธการชำระเงินนี้?"
                                            class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded">
                                            <i class="fas fa-times"></i> ปฏิเสธ
                                        </button>
                                    </div>
                                @endif

                                <!-- Status Dropdown -->
                                <div class="relative">
                                    <select
                                        wire:change="updateStatus('{{ $payment->id }}', $event.target.value)"
                                        class="text-xs px-2 py-1 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">เปลี่ยนสถานะ...</option>
                                        <option value="pending" {{ $payment->status === 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                                        <option value="verified" {{ $payment->status === 'verified' ? 'selected' : '' }}>ยืนยันแล้ว</option>
                                        <option value="rejected" {{ $payment->status === 'rejected' ? 'selected' : '' }}>ปฏิเสธ</option>
                                    </select>
                                </div>

                                <!-- Verifier Info -->
                                @if($payment->verifier)
                                    <div class="text-xs text-gray-500">
                                        โดย {{ $payment->verifier->name }}<br>
                                        <span class="text-gray-400">{{ $payment->verified_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            ไม่มีข้อมูลการชำระเงิน
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center space-x-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.fixed.top-4').remove();
            }, 3000);
        </script>
    @endif

    @if (session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center space-x-2">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.fixed.top-4').remove();
            }, 3000);
        </script>
    @endif

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center">
        <div class="relative max-w-4xl max-h-full p-4">
            <button
                onclick="closeImageModal()"
                class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <img id="modalImage" src="" alt="Payment Slip" class="max-w-full max-h-full object-contain">
        </div>
    </div>

    <script>
        function showImageModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // ปิด modal เมื่อคลิกที่พื้นหลัง
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // ปิด modal เมื่อกด ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</div>
