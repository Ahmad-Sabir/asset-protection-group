@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '  OOPS!!')
@section('message', __('Page Not Found'))
@section('image')
    <img src="/assets/images/404.jpg" width="100%" height="100%">
@endsection