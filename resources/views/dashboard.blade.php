@extends('layouts.main')

@section('title', 'Kagi')

@section('content')
    @isset($day)
        {{ $day->getTime()->format('Y-m-d H:i:s') }}
    @endisset
@endsection
