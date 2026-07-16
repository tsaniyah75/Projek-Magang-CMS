@extends('layouts.app')

@section('content')
    @include('partials.header')
    @include('partials.cms-button')
    @include('partials.toasts')
    
    @yield('frontend_content')
    
    @include('partials.footer')
    @include('partials.modals')
    @include('partials.scripts')
@endsection
