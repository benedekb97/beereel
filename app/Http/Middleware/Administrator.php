<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Entity\UserInterface;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Administrator extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $user = $this->auth->guard($guard)->user();

                if (!$user instanceof UserInterface) {
                    throw new UnauthorizedHttpException('User unauthorized');
                }

                if (!$user->isAdministrator()) {
                    throw new UnauthorizedHttpException('User unauthorized');
                }

                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }
}
