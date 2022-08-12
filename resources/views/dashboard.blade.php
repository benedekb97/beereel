@extends('layouts.home')

@section('title', 'BeerEel')

@section('content')
    <input type="hidden" id="reaction-url" value="{{ route('api.reaction') }}">
    <input type="hidden" id="user-id" value="{{ \Auth::id() }}">
    @isset($nextDay)
    <div class="col-lg-6 offset-lg-3 mt-3">
        <h3>A kövi <b>BeerEel</b> {{ $nextDay->getTime()->format('H:i:s') }}-kor lesz @if($nextDay->getTime()->format('d') !== (new \DateTime())->format('d'))
                {{ 'holnap' }}@endif.</h3>
    </div>
    @endisset
    @foreach ($posts as $post)
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
    @foreach ($posts as $post)
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
        @if ($post->getUser() !== \Auth::user())
        <div class="modal fade" id="reaction-modal-{{ $post->getId() }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-body">
                        <button type="button" id="close-modal-{{ $post->getId() }}" style="display:none;" data-bs-dismiss="modal">lol geciocsmány de leszarom</button>
                        <div class="row">
                            <div class="col-2 d-grid p-0">
                                <button type="button" class="
                                btn border-0 btn-lg reaction-button
                                @if ($post->getReactionForUser($user) !== null && $post->getReactionForUser($user)->getType() === \App\Entity\ReactionType::LOVE)
                                    bg-secondary
                                @endif
                                " style="font-size:20pt;" id="react-{{ $post->getId() }}-LOVE" data-react="LOVE" data-post-id="{{ $post->getId() }}">❤</button>
                            </div>
                            <div class="col-2 d-grid p-0">
                                <button type="button" class="
                                btn border-0 btn-lg reaction-button
                                @if ($post->getReactionForUser($user) !== null && $post->getReactionForUser($user)->getType() === \App\Entity\ReactionType::LOL)
                                    bg-secondary
                                @endif
                                " style="font-size:20pt;" id="react-{{ $post->getId() }}-LOL" data-react="LOL" data-post-id="{{ $post->getId() }}">😂</button>
                            </div>
                            <div class="col-2 d-grid p-0">
                                <button type="button" class="
                                btn border-0 btn-lg reaction-button
                                @if ($post->getReactionForUser($user) !== null && $post->getReactionForUser($user)->getType() === \App\Entity\ReactionType::LIKE)
                                    bg-secondary
                                @endif
                                " style="font-size:20pt;" id="react-{{ $post->getId() }}-LIKE" data-react="LIKE" data-post-id="{{ $post->getId() }}">👍</button>
                            </div>
                            <div class="col-2 d-grid p-0">
                                <button type="button" class="
                                btn border-0 btn-lg reaction-button
                                @if ($post->getReactionForUser($user) !== null && $post->getReactionForUser($user)->getType() === \App\Entity\ReactionType::WOW)
                                    bg-secondary
                                @endif
                                " style="font-size:20pt;" id="react-{{ $post->getId() }}-WOW" data-react="WOW" data-post-id="{{ $post->getId() }}">😮</button>
                            </div>
                            <div class="col-2 d-grid p-0">
                                <button type="button" class="
                                btn border-0 btn-lg reaction-button
                                @if ($post->getReactionForUser($user) !== null && $post->getReactionForUser($user)->getType() === \App\Entity\ReactionType::SMILE)
                                    bg-secondary
                                @endif
                                " style="font-size:20pt;" id="react-{{ $post->getId() }}-SMILE" data-react="SMILE" data-post-id="{{ $post->getId() }}">😊</button>
                            </div>
                            <div class="col-2 d-grid p-0">
                                <button type="button" class="
                                btn border-0 btn-lg reaction-button
                                @if ($post->getReactionForUser($user) !== null && $post->getReactionForUser($user)->getType() === \App\Entity\ReactionType::ANGRY)
                                    bg-secondary
                                @endif
                                " style="font-size:20pt;" id="react-{{ $post->getId() }}-ANGRY" data-react="ANGRY" data-post-id="{{ $post->getId() }}">😡</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
@endsection
