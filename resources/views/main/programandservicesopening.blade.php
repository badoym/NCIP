@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
@stop

@section('content')
    <div id="app">
        <program-services-opening-component>
        </program-services-opening-component>
    </div>
@stop


@section('js')
    <script src="{{ asset('js/app.js') }}" defer></script>
@stop

