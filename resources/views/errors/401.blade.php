@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))
@section('image')
    <img src="/assets/images/401.webp" width="100%" height="100%">
@endsection