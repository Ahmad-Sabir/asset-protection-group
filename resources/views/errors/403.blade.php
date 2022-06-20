@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('image')
    <img src="/assets/images/403.webp" width="100%" height="100%">
@endsection