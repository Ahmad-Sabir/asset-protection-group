@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))
@section('image')
    <img src="/assets/images/503.jpg" width="100%" height="100%">
@endsection