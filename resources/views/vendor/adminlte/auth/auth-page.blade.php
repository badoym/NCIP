@extends('adminlte::master')

@php
$authType = $authType ?? 'login';
$dashboardUrl = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

if (config('adminlte.use_route_url', false)) {
$dashboardUrl = $dashboardUrl ? route($dashboardUrl) : '';
} else {
$dashboardUrl = $dashboardUrl ? url($dashboardUrl) : '';
}

$bodyClasses = "{$authType}-page";

if (! empty(config('adminlte.layout_dark_mode', null))) {
$bodyClasses .= ' dark-mode';
}
@endphp

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body'){{ $bodyClasses }}@stop

@section('body')
<div class="w-100 h-100 d-flex align-items-center justify-content-center login">



    <div class="{{ $authType }}-box">

        {{-- Logo --}}
        <div class="{{ $authType }}-logo">
            <a href="{{ $dashboardUrl }}">

                {{-- Logo Image --}}
                {{-- @if (config('adminlte.auth_logo.enabled', false))
                <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                    alt="{{ config('adminlte.auth_logo.img.alt') }}" @if (config('adminlte.auth_logo.img.class', null))
                    class="{{ config('adminlte.auth_logo.img.class') }}" @endif @if
                    (config('adminlte.auth_logo.img.width', null)) width="{{ config('adminlte.auth_logo.img.width') }}"
                    @endif @if (config('adminlte.auth_logo.img.height', null))
                    height="{{ config('adminlte.auth_logo.img.height') }}" @endif>
                @else
                <img src="{{ asset(config('adminlte.logo_img')) }}" alt="{{ config('adminlte.logo_img_alt') }}"
                    height="50">
                @endif --}}

                {{-- Logo Label --}}

                <img src="{{ asset('images/mabinay_logo.jpg') }}" alt="{{ config('adminlte.logo_img_alt') }}"
                    height="100" style="border-radius: 50%">
                <div class="mt-2 w-100">
                    <h1 style="font-size: 20px; color: white"> <span style="font-size: 50px;font-weight: bolder"> NCIP
                            MABINAY </span>
                        ONLINE VERIFICATION SYSTEM</h1>
                </div>
            </a>
        </div>

        {{-- Card Box --}}
        <div class="card p-2">

            {{-- Card Header --}}
            @hasSection('auth_header')
            <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                <h3 class="card-title float-none text-center">
                    Login your credentials
                </h3>
            </div>
            @endif

            {{-- Card Body --}}
            <div class="card-body {{ $authType }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                @yield('auth_body')
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
            <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                @yield('auth_footer')
            </div>
            @endif


        </div>

    </div>
</div>
@stop

@section('adminlte_js')
@stack('js')
@yield('js')
@stop

<style scoped>
    .login {
        position: relative;
        z-index: 1;
        background-image: url('{{ asset("images/mabinay_bg.jpg") }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .login::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Adjust the opacity as needed */
        z-index: -1;
    }
</style>