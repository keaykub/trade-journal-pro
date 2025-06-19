<div class="max-w-5xl mx-auto">
    {{-- Status Bar --}}
    @include('livewire.edit.status-bar')

    {{-- Form Content --}}
    <div class="pt-6">
        <form wire:submit.prevent="submit" enctype="multipart/form-data">
            {{-- Step 1: Basic Information --}}
            @if($step === 1)
                @include('livewire.edit.step-1-basic-info')
            @endif

            {{-- Step 2: Trade Details --}}
            @if($step === 2)
                @include('livewire.edit.step-2-trade-details')
            @endif

            {{-- Step 3: Strategy & Psychology --}}
            @if($step === 3)
                @include('livewire.edit.step-3-strategy-psychology')
            @endif

            {{-- Navigation Buttons --}}
            @include('livewire.edit.navigation-buttons')
        </form>
    </div>

    {{-- Modals --}}
    @include('livewire.edit.preview-modal')

    {{-- Success Message --}}
    @include('livewire.edit.success-message')
</div>

{{-- JavaScript --}}
@include('livewire.edit.scripts')
