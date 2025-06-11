@extends('layouts.app')

@section('title', 'แผนราคา - Trade Journal')

@section('content')
    @include('partials.navigation')
    @include('partials.pricing-hero')
    @include('partials.pricing-cards')
    @include('partials.feature-comparison')
    @include('partials.pricing-faq')
    @include('partials.final-cta')
    @include('partials.footer')
@endsection
