@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
@stop

@section('content')
<div id="app">
    <profile-information-component
        :indigenous_group="{{ json_encode($indigenous_group)}}"
        :regions="{{ json_encode($regions)}}"
        :user="{{ json_encode($user)}}">
    </profile-information-component>
</div>
@stop


@section('js')
<script src="{{ asset('js/app.js') }}" defer></script>
@stop