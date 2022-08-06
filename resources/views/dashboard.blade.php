@extends('layouts.home')

@section('title', 'Kagi')

@section('content')
    @foreach ($posts as $post)
        <div class="col-lg-4 offset-lg-4 mt-3">
            <div class="card bg-black">
                <img class="card-img-top" src="{{ asset($post->getFrontImagePath()) }}">
                <div class="card-body bg-dark text-white">
                    {{ $post->getUser()->getUsername() }}
                </div>
            </div>
        </div>
    @endforeach
@endsection
