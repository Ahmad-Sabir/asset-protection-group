@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))
@section('image')
    <img src="/assets/images/500.webp" width="100%" height="100%">
@endsection