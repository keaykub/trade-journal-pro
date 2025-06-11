<!-- Payment Modal -->
<div x-show="showPaymentModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50" @click="closePaymentModal()"></div>

    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-screen overflow-y-auto"
             @click.stop>

            <!-- Modal Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900">ชำระเงิน</h3>
                    <button @click="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Selected Plan Info -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">แผนที่เลือก</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-blue-600" x-text="selectedPlan.name"></span>
                            <p class="text-gray-600" x-text="selectedPlan.description"></p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-purple-600">
                                ฿<span x-text="Number(selectedPlan.price).toLocaleString()"></span>
                            </div>
                            <div class="text-gray-500 text-sm" x-text="selectedPlan.billing"></div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form @submit.prevent="submitPayment()">
                    <!-- Bank Transfer Information -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">วิธีการชำระเงิน</h4>

                        <!-- Bank Account Details -->
                        <div class="bg-green-50 border-2 border-green-200 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                </svg>
                                <h5 class="font-bold text-green-700 text-xl">โอนเงินผ่านธนาคาร</h5>
                            </div>

                            <div class="bg-white rounded-lg p-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">ธนาคาร</p>
                                        <p class="font-semibold text-gray-800">ธนาคารกสิกรไทย</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">ประเภทบัญชี</p>
                                        <p class="font-semibold text-gray-800">ออมทรัพย์</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">เลขที่บัญชี</p>
                                        <p class="font-bold text-lg text-green-700">053-1-44657-7</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">ชื่อบัญชี</p>
                                        <p class="font-semibold text-gray-800">บจก. วีเพย์ โพรฟิต</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-3 mt-1"></i>
                                    <div>
                                        <p class="font-semibold text-yellow-800 mb-1">คำแนะนำการชำระเงิน</p>
                                        <ul class="text-sm text-yellow-700 space-y-1">
                                            <li>• กรุณาโอนเงินตรงตามยอดที่แสดง <strong>฿<span x-text="Number(selectedPlan.price).toLocaleString()"></span></strong> บาท</li>
                                            <li>• เก็บสลิปการโอนเงินเพื่อแนบด้านล่าง</li>
                                            <li>• หลังจากโอนเงินแล้ว กรุณาแนบสลิปและส่งข้อมูล</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Slip Upload -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">แนบสลิปการชำระเงิน</h4>

                        <!-- File Upload Area -->
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors"
                             @dragover.prevent
                             @drop.prevent="handleFileUpload($event)">

                            <input type="file"
                                   id="payment-slip"
                                   accept="image/*"
                                   @change="handleFileUpload($event)"
                                   class="hidden">

                            <div x-show="!selectedFile">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600 mb-2">คลิกเพื่อเลือกไฟล์หรือลากไฟล์มาวางที่นี่</p>
                                <p class="text-sm text-gray-500">รองรับไฟล์ JPG, PNG, JPEG ขนาดไม่เกิน 10MB</p>
                                <button type="button"
                                        @click="document.getElementById('payment-slip').click()"
                                        class="mt-3 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                    <i class="fas fa-upload mr-2"></i>เลือกไฟล์สลิป
                                </button>
                            </div>

                            <!-- Preview -->
                            <div x-show="selectedFile" class="space-y-4">
                                <img x-show="previewUrl" :src="previewUrl" class="max-w-xs mx-auto rounded-lg shadow-md border">
                                <div class="flex items-center justify-center space-x-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-check-circle text-green-500"></i>
                                        <span class="text-sm text-gray-600" x-text="selectedFile?.name"></span>
                                    </div>
                                    <button type="button"
                                            @click="removeFile()"
                                            class="text-red-500 hover:text-red-700 transition-colors">
                                        <i class="fas fa-trash mr-1"></i> ลบ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex space-x-4">
                        <button type="submit"
                                :disabled="!selectedFile || isSubmitting"
                                :class="(!selectedFile || isSubmitting) ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'"
                                class="flex-1 text-white font-semibold py-3 rounded-lg transition-colors">
                            <span x-show="!isSubmitting">
                                <i class="fas fa-paper-plane mr-2"></i>ส่งข้อมูลการชำระเงิน
                            </span>
                            <span x-show="isSubmitting">
                                <i class="fas fa-spinner fa-spin mr-2"></i>กำลังตรวจสอบสลิป...
                            </span>
                        </button>
                        <button type="button"
                                @click="closePaymentModal()"
                                class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                            ยกเลิก
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Payment Modal -->
<div x-show="showPaymentModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50" @click="closePaymentModal()"></div>

    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-screen overflow-y-auto"
             @click.stop>

            <!-- Modal Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900">ชำระเงิน</h3>
                    <button @click="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Selected Plan Info -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">แผนที่เลือก</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-blue-600" x-text="selectedPlan.name"></span>
                            <p class="text-gray-600" x-text="selectedPlan.description"></p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-purple-600">
                                ฿<span x-text="Number(selectedPlan.price).toLocaleString()"></span>
                            </div>
                            <div class="text-gray-500 text-sm" x-text="selectedPlan.billing"></div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form @submit.prevent="submitPayment()">
                    <!-- Payment Methods -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">เลือกวิธีการชำระเงิน</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- QR Code Payment -->
                            <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer transition-colors"
                                 :class="paymentMethod === 'qr' ? 'border-blue-500 bg-blue-50' : 'hover:border-gray-300'"
                                 @click="paymentMethod = 'qr'">
                                <div class="flex items-center mb-3">
                                    <input type="radio" x-model="paymentMethod" value="qr" class="mr-3">
                                    <h5 class="font-semibold text-gray-800">QR Code</h5>
                                </div>
                                <div class="text-center" x-show="paymentMethod === 'qr'">
                                    <img src="https://unlinitimg.space/image-inventory/1748828930.jpg"
                                         alt="QR Code Payment"
                                         class="w-48 h-48 mx-auto rounded-lg shadow-md">
                                    <p class="text-sm text-gray-600 mt-2">สแกน QR Code เพื่อชำระเงิน</p>
                                </div>
                            </div>

                            <!-- Bank Transfer -->
                            <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer transition-colors"
                                 :class="paymentMethod === 'bank' ? 'border-blue-500 bg-blue-50' : 'hover:border-gray-300'"
                                 @click="paymentMethod = 'bank'">
                                <div class="flex items-center mb-3">
                                    <input type="radio" x-model="paymentMethod" value="bank" class="mr-3">
                                    <h5 class="font-semibold text-gray-800">โอนเงินผ่านธนาคาร</h5>
                                </div>
                                <div x-show="paymentMethod === 'bank'" class="space-y-2">
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <!-- ใช้ Heroicon (bank icon) -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                            </svg>
                                            <span class="font-semibold text-green-700">ธนาคารกสิกรไทย</span>
                                        </div>
                                        <div class="text-sm text-gray-700">
                                            <p><strong>เลขที่บัญชี:</strong> 053-1-44657-7</p>
                                            <p><strong>ชื่อบัญชี:</strong> บจก. วีเพย์ โพรฟิต</p>
                                            <p><strong>ประเภทบัญชี:</strong> ออมทรัพย์</p>
                                        </div>
                                    </div>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                        <p class="text-sm text-yellow-800">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            กรุณาโอนเงินตรงตามยอดที่แสดง <strong>฿<span x-text="Number(selectedPlan.price).toLocaleString()"></span></strong> บาท
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Slip Upload -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">แนบสลิปการชำระเงิน</h4>

                        <!-- File Upload Area -->
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors"
                             @dragover.prevent
                             @drop.prevent="handleFileUpload($event)">

                            <input type="file"
                                   id="payment-slip"
                                   accept="image/*"
                                   @change="handleFileUpload($event)"
                                   class="hidden">

                            <div x-show="!selectedFile">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600 mb-2">คลิกเพื่อเลือกไฟล์หรือลากไฟล์มาวางที่นี่</p>
                                <p class="text-sm text-gray-500">รองรับไฟล์ JPG, PNG, JPEG ขนาดไม่เกิน 5MB</p>
                                <button type="button"
                                        @click="document.getElementById('payment-slip').click()"
                                        class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    เลือกไฟล์
                                </button>
                            </div>

                            <!-- Preview -->
                            <div x-show="selectedFile" class="space-y-4">
                                <img x-show="previewUrl" :src="previewUrl" class="max-w-xs mx-auto rounded-lg shadow-md">
                                <div class="flex items-center justify-center space-x-4">
                                    <span class="text-sm text-gray-600" x-text="selectedFile?.name"></span>
                                    <button type="button"
                                            @click="removeFile()"
                                            class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i> ลบ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex space-x-4">
                        <button type="submit"
                                :disabled="!selectedFile || isSubmitting"
                                :class="(!selectedFile || isSubmitting) ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'"
                                class="flex-1 text-white font-semibold py-3 rounded-lg transition-colors">
                            <span x-show="!isSubmitting">ส่งข้อมูลการชำระเงิน</span>
                            <span x-show="isSubmitting">
                                <i class="fas fa-spinner fa-spin mr-2"></i>กำลังส่ง...
                            </span>
                        </button>
                        <button type="button"
                                @click="closePaymentModal()"
                                class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                            ยกเลิก
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 --}}
