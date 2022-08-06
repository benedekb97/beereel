@extends('layouts.home')

@section('title', 'Kagi')

@section('content')
    @isset($nextDay)
    <div class="col-lg-6 offset-lg-3 mt-3">
        <h3>A kövi <b>BeerEel</b> {{ $nextDay->getTime()->format('H:i:s') }}-kor lesz @if($nextDay->getTime()->format('d') !== (new \DateTime())->format('d'))
                {{ 'holnap' }}@endif.</h3>
    </div>
    @endisset
    @foreach ($posts as $post)
        <div class="col-lg-6 offset-lg-3 mt-3">
            <div class="card bg-black">
                <img id="image{{ $post->getId() }}" class="card-img-top" src="{{ asset($post->getFrontImagePath()) }}" onclick="switchTo(event, 'image{{ $post->getId() }}');">
                <div class="card-body bg-dark text-white">
                    {{ $post->getUser()->getUsername() }}
                </div>
            </div>
        </div>
    @endforeach
@endsection
