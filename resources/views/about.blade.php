@extends('layouts.app')

@section('title', 'เกี่ยวกับเรา - Trade Journal')

@section('content')
    @include('partials.navigation')
    @include('partials.about-hero')
    @include('partials.about-story')
    @include('partials.about-mission')
    @include('partials.about-values')
    @include('partials.about-achievements')
    @include('partials.about-cta')
    @include('partials.footer')
@endsection
