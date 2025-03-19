@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
@stop

@section('content')
<div id="app">
    <web-users-services-component>
    </web-users-services-component>
</div>
@stop


@section('js')
<script src="{{ asset('js/app.js') }}" defer></script>
@stop