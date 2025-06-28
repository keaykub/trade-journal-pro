{{-- resources/views/livewire/trade-form.blade.php --}}
<div class="max-w-5xl mx-auto">
    {{-- Status Bar Component --}}
    @include('components.trade-form.status-bar', [
        'step' => $step,
        'totalSteps' => $totalSteps
    ])

    {{-- Form Content --}}
    <div class="pt-6">
        <form wire:submit.prevent="submit" enctype="multipart/form-data">
            {{-- Step 1: Basic Information --}}
            @if($step === 1)
                @include('components.trade-form.step-basic-info')
            @endif

            {{-- Step 2: Trade Details --}}
            @if($step === 2)
                @include('components.trade-form.step-trade-details')
            @endif

            {{-- Step 3: Strategy & Psychology --}}
            @if($step === 3)
                @include('components.trade-form.step-strategy-psychology')
            @endif

            {{-- Navigation Component --}}
            @include('components.trade-form.navigation', [
                'step' => $step,
                'totalSteps' => $totalSteps
            ])
        </form>
    </div>

    {{-- Preview Modal Component --}}
    @include('components.trade-form.preview-modal')

    {{-- Success Message Component --}}
    @include('components.trade-form.success-message')

    {{-- JavaScript Component --}}
    @include('components.trade-form.scripts')
</div>
