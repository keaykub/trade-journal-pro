<section class="py-20 px-6 bg-white">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12 text-gray-800">เทรดเดอร์ที่ใช้งานพูดว่าอย่างไร</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="p-6 bg-gray-50 rounded-2xl">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 {{ $testimonial['color'] }} rounded-full flex items-center justify-center text-white font-bold">
                        {{ $testimonial['initial'] }}
                    </div>
                    <div class="ml-4 text-left">
                        <p class="font-semibold">{{ $testimonial['name'] }}</p>
                        <p class="text-sm text-gray-500">{{ $testimonial['role'] }}</p>
                    </div>
                </div>
                <p class="text-gray-600">"{{ $testimonial['content'] }}"</p>
                <div class="flex text-yellow-400 mt-4">
                    @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
