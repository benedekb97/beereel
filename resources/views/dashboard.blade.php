@extends('views.layouts.home')

@section('title', 'Kagi')

@section('content')
    @isset($day)
        {{ $day->getTime()->format('Y-m-d H:i:s') }}
    @endisset
@endsection
