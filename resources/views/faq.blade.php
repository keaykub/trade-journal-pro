@extends('layouts.app')

@section('title', 'คำถามที่พบบ่อย - Trade Journal')

@section('content')
    @include('partials.navigation')
    @include('partials.faq-hero')
    @include('partials.faq-categories')

    <!-- Dynamic FAQ Content -->
    <section class="py-16 px-6">
        <div class="max-w-4xl mx-auto" x-data="{ active: null }">
            @if(isset($faqData))
                @foreach($faqData as $sectionKey => $section)
                <div id="{{ $sectionKey }}" class="mb-16">
                    <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
                        <i class="{{ $section['icon'] }} text-{{ $section['color'] }}-600 mr-3"></i>
                        {{ $section['title'] }}
                    </h2>

                    <div class="space-y-4">
                        @foreach($section['faqs'] as $index => $faq)
                        @php $faqId = $sectionKey . '_' . $index @endphp
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                            <button
                                @click="active = active === '{{ $faqId }}' ? null : '{{ $faqId }}'"
                                class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                            >
                                <span class="font-semibold text-gray-800">{{ $faq['question'] }}</span>
                                <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': active === '{{ $faqId }}' }"></i>
                            </button>
                            <div x-show="active === '{{ $faqId }}'" x-transition class="px-6 pb-6">
                                @if(isset($faq['type']) && $faq['type'] === 'list')
                                    @php $listItems = explode(': ', $faq['answer'], 2); @endphp
                                    @if(count($listItems) > 1)
                                        <p class="text-gray-600 leading-relaxed mb-4">{{ $listItems[0] }}:</p>
                                        @php $steps = explode(' ', $listItems[1]); @endphp
                                        <ol class="list-decimal list-inside text-gray-600 space-y-2">
                                            @foreach(range(1, 4) as $step)
                                                <li>{{ $step }}. {{ $step === 1 ? 'คลิก "เริ่มต้นใช้ฟรี"' : ($step === 2 ? 'กรอกอีเมลและรหัสผ่าน' : ($step === 3 ? 'ยืนยันอีเมล' : 'เริ่มบันทึกการเทรดได้ทันที')) }}</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
                                    @endif
                                @elseif(isset($faq['type']) && $faq['type'] === 'detailed')
                                    @php $parts = explode(': ', $faq['answer'], 2); @endphp
                                    @if(count($parts) > 1)
                                        <p class="text-gray-600 leading-relaxed mb-4">{{ $parts[0] }}:</p>
                                        @php $items = explode(', ', $parts[1]); @endphp
                                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                                            @foreach($items as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
                                    @endif
                                @else
                                    <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- @include('partials.faq-stats') --}}
    @include('partials.faq-support')
    @include('partials.footer')
@endsection

<script>
function scrollToSection(sectionId) {
    document.getElementById(sectionId).scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

function openChat() {
    // Implement chat widget opening logic
    alert('Live Chat จะเปิดขึ้นมา (ต้องติดตั้ง Chat Widget)');
}
</script>
