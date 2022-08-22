<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entity\Post;
use App\Entity\PostInterface;
use App\Entity\User;
use App\Entity\UserInterface;
use Doctrine\ORM\EntityManager;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    private Guard $auth;

    public function __construct(
        EntityManager $entityManager,
        AuthManager $authManager
    ) {
        parent::__construct($entityManager);

        $this->auth = $authManager->guard(config('auth.guards.default'));
    }

    public function users(Request $request): Factory|View|Application|Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        uasort($users, static function (UserInterface $a, UserInterface $b) {
            return $b->getPosts()->count() <=> $a->getPosts()->count();
        });

        return view('admin.users', ['users' => $users]);
    }

    public function user(string $user): Factory|View|Application|Response
    {
        /** @var UserInterface $user */
        $user = $this->entityManager->getRepository(User::class)->find($user);

        if (!$user instanceof UserInterface) {
            throw new NotFoundHttpException('User could not be found!');
        }

        return view('admin.user', ['user' => $user]);
    }

    public function block(string $user): RedirectResponse
    {
        /** @var UserInterface $user */
        $user = $this->entityManager->getRepository(User::class)->find($user);

        if (!$user instanceof UserInterface) {
            throw new NotFoundHttpException('User could not be found!');
        }

        if ($user === $this->auth->user()) {
            return redirect()->back();
        }

        $user->setBlocked(!$user->isBlocked());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return redirect()->back();
    }

    public function posts(Request $request): Factory|View|Application|Response
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();

        uasort($posts, static function (PostInterface $a, PostInterface $b) {
            return $b->getReactions()->count() <=> $a->getReactions()->count();
        });

        return view('admin.posts', ['posts' => $posts]);
    }
}
