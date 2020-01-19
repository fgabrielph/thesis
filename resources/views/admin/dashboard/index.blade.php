@extends('admin.master')

@section('title') Dashboard @endsection

@section('content')

WELCOME {{ Auth::user()->name }}

@endsection
