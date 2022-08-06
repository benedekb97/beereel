@extends('layouts.home')

@section('title', 'Kagi')

@section('content')
    @foreach ($posts as $post)
        <div class="col-lg-4 offset-lg-4">
            <div class="card">
                <img class="card-img-top" src="{{ asset($post->getFrontImagePath()) }}">
            </div>
        </div>
    @endforeach
@endsection
