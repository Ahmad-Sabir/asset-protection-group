@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))
@section('image')
    <img src="/assets/images/429.jpg" width="100%" height="100%">
@endsection