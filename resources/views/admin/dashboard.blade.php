@extends('layouts.app')

@section('content')

@if(\Request::segment(2) == 'dashboard')
    {{$title}}
@endif

@yield('admin')
@endsection

@section('js')

@yield('js_form')

@endsection