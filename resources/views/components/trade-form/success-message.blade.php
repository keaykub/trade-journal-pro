{{-- resources/views/components/trade-form/success-message.blade.php --}}
@if (session()->has('success'))
<div class="fixed top-6 right-6 z-50 max-w-sm">
    <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in-right">
        <i class="fas fa-check-circle text-xl"></i>
        <div>
            <p class="font-semibold">สำเร็จ!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif
