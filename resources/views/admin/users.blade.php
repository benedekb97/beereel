@extends('layouts.home')

@section('title', 'Felhasználók')

@section('content')
    <div class="col-lg-6 mt-3 offset-lg-3">
        @foreach($users as $user)
            <div class="row">
                <div class="col">
                    <a href="{{ route('admin.user', ['user' => $user->getId()]) }}">{{ $user->getUsername() }}</a>
                </div>
                <div class="col" style="text-align: right;">{{ $user->getPosts()->count() }}</div>
            </div>
        @endforeach
    </div>
@endsection
