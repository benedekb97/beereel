<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    private Guard $auth;

    public function __construct(
        EntityManager $entityManager,
        AuthManager $authManager
    )
    {
        parent::__construct($entityManager);

        $this->auth = $authManager->guard(config('auth.defaults.guard'));
    }

    public function login(Request $request): Factory|View|Application|Response
    {
        if ($this->auth->check()) {
            return new RedirectResponse(route('index'));
        }

        return view('login');
    }

    public function logout(): Response
    {
        $this->auth->logout();

        return new RedirectResponse(route('login'));
    }

    public function authenticate(Request $request): Response
    {
        $username = $request->get('username');
        $password = $request->get('password');

        if ($this->auth->attempt(
            [
                'username' => $username,
                'password' => $password,
            ]
        )) {
            return new RedirectResponse(route('index'));
        }

        return new RedirectResponse(route('login'));
    }

    public function register(Request $request): Factory|View|Application
    {
        $kagi = $request->get('kagi');

        return view('register', ['kagi' => $kagi]);
    }

    public function registration(Request $request): Response
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $password2 = $request->get('password2');

        if ($password !== $password2 || $password === '' || strlen($password) < 8) {
            return new RedirectResponse(route('register', ['kagi' => 'password']));
        }

        $userRepository = $this->entityManager->getRepository(User::class);

        if ($userRepository->findOneBy(['username' => $username]) !== null) {
            return new RedirectResponse(route('register', ['kagi' => 'username']));
        }

        $user = new User();

        $user->setUsername($username);
        $user->setPassword(bcrypt($password));
        $user->setCreatedAtNow();

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->auth->login($user);

        return new RedirectResponse(route('index'));
    }
}
