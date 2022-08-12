<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entity\Day;
use App\Entity\PostInterface;
use App\Entity\UserInterface;
use App\Repository\PostRepository;
use App\Repository\PostRepositoryInterface;
use App\Resolver\CurrentDayResolver;
use App\Resolver\CurrentDayResolverInterface;
use App\Resolver\PostResolver;
use App\Resolver\PostResolverInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DashboardController
{
    private CurrentDayResolverInterface $currentDayResolver;

    private PostRepositoryInterface $postRepository;

    private Guard $auth;

    private PostResolverInterface $postResolver;

    private EntityManagerInterface $entityManager;

    public function __construct(
        CurrentDayResolver $currentDayResolver,
        PostRepository $postRepository,
        AuthManager $authManager,
        PostResolver $postResolver,
        EntityManager $entityManager
    )
    {
        $this->currentDayResolver = $currentDayResolver;
        $this->postRepository = $postRepository;
        $this->auth = $authManager->guard(config('auth.guards.default'));
        $this->postResolver = $postResolver;
        $this->entityManager = $entityManager;
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

        $dayRepository = $this->entityManager->getRepository(Day::class);

        $nextDay = $dayRepository->createQueryBuilder('o')
            ->where('o.time > :time')
            ->setParameter('time', new \DateTime())
            ->addOrderBy('o.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        $posts = $this->postRepository->getCurrentPosts();

        if (!$this->auth->user()->isAdministrator()) {
            $posts = array_filter($posts, static function (PostInterface $post) {
                return !$post->isBlocked() || $post->getUser() === $this->auth->user();
            });
        }

        return view('dashboard',
        [
            'day' => $this->currentDayResolver->resolve(),
            'posts' => $posts,
            'currentPost' => $currentPost,
            'nextDay' => $nextDay,
            'user' => $this->auth->user(),
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

    public function profile(): Factory|View|Application|Response
    {
        if (!$this->auth->check()) {
            return new RedirectResponse(route('login'));
        }

        $posts = $this->postRepository->getPostsForUser($this->auth->user());

        return view('profile', ['posts' => $posts]);
    }
}
