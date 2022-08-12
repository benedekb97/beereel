@extends('layouts.home')

@section('title', 'Profilom')

@section('content')
    @foreach ($posts as $post)
        <div class="col-lg-6 offset-lg-3 mt-3">
            <div class="card bg-black">
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
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('modals')
    @foreach($posts as $post)

        <div class="modal fade" id="reactions-{{ $post->getId() }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-body" id="reaction-container-{{ $post->getId() }}">
                        @foreach ($post->getReactions() as $reaction)
                            <div class="row" id="reaction-list-post-{{ $post->getId() }}-user-{{ \Auth::id() }}">
                                <div class="col">{{ $reaction->getUser()->getUsername() }}</div>
                                <div class="col" style="text-align:right;" id="reaction-{{ $reaction->getId() }}">{!! $reaction->getType()->getHtmlCharacter() !!}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
