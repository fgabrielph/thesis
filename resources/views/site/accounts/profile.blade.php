@extends('site.master')

@section('title') {{Auth::user()->name}} @endsection

@section('content')

    HELLO {{Auth::user()->name}}

@endsection

@section('footer')

    @include('site.includes.footer')

@endsection
