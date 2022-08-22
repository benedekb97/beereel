@extends('layouts.home')

@section('title', 'Képek')

@section('content')
    @foreach ($posts as $post)
        <div class="col-lg-4 mt-3">
            <div class="card @if($post->isBlocked()) bg-danger @else bg-black @endif">
                <img id="image{{ $post->getId() }}" class="card-img-top" src="{{ asset($post->getFrontImagePath()) }}" onclick="switchTo(event, 'image{{ $post->getId() }}');">
                <div class="card-body bg-dark text-white row m-0">
                    <div class="col">
                        {{ $post->getUser()->getUsername() }}<br>
                        <small>{{ (new Carbon\Carbon($post->getCreatedAt()))->diffForHumans() }}</small>
                    </div>
                    <div style="text-align:right" class="col">
                        <button
                            class="btn btn-sm bg-dark border-0 text-white"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#reactions-{{ $post->getId() }}"
                            id="reaction-button-{{ $post->getId() }}"
                            @if ($post->getReactions()->count() === 0)
                            style="display:none"
                            @endif
                        ><span id="reaction-count-{{ $post->getId() }}">{{ $post->getReactions()->count() }}</span> reacc</button>
                        @if ($post->getUser() !== \Auth::user())
                            <button class="btn btn-sm bg-dark border-0 text-white" type="button" data-bs-toggle="modal" data-bs-target="#reaction-modal-{{ $post->getId() }}">+</button>
                        @endif
                        @if (\Auth::user()->isAdministrator())
                            <a class="btn btn-sm btn-danger border-0" href="{{ route('admin.block', ['postId' => $post->getId()]) }}">
                                @if ($post->isBlocked())
                                    felold
                                @else
                                    letilt
                                @endif
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
