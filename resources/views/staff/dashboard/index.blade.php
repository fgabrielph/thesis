@extends('staff.master')

@section('title') Dashboard @endsection

@section('content')

    WELCOME {{ Auth::user()->name }}

@endsection
