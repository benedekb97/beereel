@extends('layouts.home')

@section('title', $user->getUsername())

@section('content')
    <div class="col-lg-6 offset-lg-3 mt-3">
        <div class="card bg-black">
            <div class="card-header bg-dark text-white border-dark">
                <p class="card-title">{{ $user->getUsername() }}</p>
            </div>
            <div class="card-body bg-dark text-white border-dark">
                @if ($user !== \Auth::user())
                    <a
                        href="{{ route('admin.user.block', ['user' => $user->getId()]) }}"
                        class="btn @if($user->isBlocked()) btn-success @else btn-danger @endif btn-sm"
                    >Felhasználó @if($user->isBlocked()) feloldása @else letiltása @endif</a>
                @endif
            </div>
        </div>
    </div>
    @foreach ($user->getPosts() as $post)
        <div class="col-lg-6 offset-lg-3 mt-3">
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

@section('modals')
    @foreach ($user->getPosts() as $post)
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
