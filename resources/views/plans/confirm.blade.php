@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-12">
    <h2 class="text-xl font-bold mb-6">ยืนยันแผนที่เลือก: {{ strtoupper($plan) }} ({{ $yearly ? 'รายปี' : 'รายเดือน' }})</h2>

    <form id="subscription-form" method="POST" action="{{ route('plans.subscribe') }}">
        @csrf
        <input type="hidden" name="plan" value="{{ $plan }}">
        <input type="hidden" name="yearly" value="{{ $yearly ? '1' : '0' }}">
        <input type="hidden" name="payment_method" id="payment-method">

        <div id="card-element" class="mb-6 border p-3 rounded"></div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-3 font-bold rounded-lg hover:bg-blue-700 transition">
            ยืนยันและชำระเงิน
        </button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('subscription-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: card,
        });

        if (error) {
            alert(error.message);
        } else {
            document.getElementById('payment-method').value = paymentMethod.id;
            form.submit();
        }
    });
</script>
@endsection
