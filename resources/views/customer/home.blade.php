@extends('customer.layouts.app')

@section('content')
    <div class="container mx-auto mt-8 mb-24">
        @include('customer.components.hero')
    </div>
    <div class="container mx-auto mt-8 mb-24">
        @include('customer.components.hero-2')
    </div>
    <div class="container mx-auto mt-8 mb-24">
        @include('customer.components.hero-3')
    </div>
    <div class="container mx-auto mt-8 mb-24">
        @include('customer.components.ai-stylist')
    </div>
    <div class="container mx-auto mt-8 mb-24">
        @include('customer.components.featured-products')
    </div>
    <div class="container mx-auto mt-8 mb-24">
        @include('customer.components.testimonials')
    </div>
    <div class="container mx-auto mt-8 mb-24">
        @include('customer.components.faq')
    </div>
    
@endsection