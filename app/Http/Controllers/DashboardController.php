<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entity\UserInterface;
use App\Repository\PostRepository;
use App\Repository\PostRepositoryInterface;
use App\Resolver\CurrentDayResolver;
use App\Resolver\CurrentDayResolverInterface;
use App\Resolver\PostResolver;
use App\Resolver\PostResolverInterface;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\String\b;

class DashboardController
{
    private CurrentDayResolverInterface $currentDayResolver;

    private PostRepositoryInterface $postRepository;

    private Guard $auth;

    private PostResolverInterface $postResolver;

    public function __construct(
        CurrentDayResolver $currentDayResolver,
        PostRepository $postRepository,
        AuthManager $authManager,
        PostResolver $postResolver
    )
    {
        $this->currentDayResolver = $currentDayResolver;
        $this->postRepository = $postRepository;
        $this->auth = $authManager->guard(config('auth.guards.default'));
        $this->postResolver = $postResolver;
    }

    public function index(): Factory|View|Application|Response
    {
        $user = $this->auth->user();

        if (!$user instanceof UserInterface) {
            return new RedirectResponse(route('login'));
        }

        $currentPost = $this->postResolver->resolve($user);

        if ($currentPost === null) {
            return new RedirectResponse(route('create'));
        }

        return view('dashboard',
        [
            'day' => $this->currentDayResolver->resolve(),
            'posts' => $this->postRepository->getCurrentPosts(),
            'currentPost' => $currentPost,
        ]);
    }

    public function create(): Factory|View|Application|Response
    {
        $post = $this->postResolver->resolve($this->auth->user());

        if ($post !== null) {
            return new RedirectResponse(route('index'));
        }

        return view('create');
    }
}
