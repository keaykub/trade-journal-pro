@extends('layouts.app')

@section('title', '#1 Trade Journal - ระบบบันทึกการเทรดของคุณ')

@section('content')
    @include('partials.navigation')
    @include('partials.hero-section')
    @include('partials.features-section')
    @include('partials.stats-preview')
    @include('partials.testimonials')
    @include('partials.final-cta')
    @include('partials.footer')
@endsection
