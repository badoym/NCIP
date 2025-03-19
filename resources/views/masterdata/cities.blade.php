@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
@stop

@section('content')
    <div id="app">
        <cities-component
        :regions="{{ json_encode($regions) }}">
        </cities-component>
    </div>
@stop


@section('js')
    <script src="{{ asset('js/app.js') }}" defer></script>
@stop

