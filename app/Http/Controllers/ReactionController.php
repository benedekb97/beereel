<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entity\Post;
use App\Entity\PostInterface;
use App\Entity\ReactionType;
use App\Entity\UserInterface;
use App\Generator\ReactionGenerator;
use App\Generator\ReactionGeneratorInterface;
use App\Repository\ReactionRepository;
use App\Repository\ReactionRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ReactionController extends Controller
{
    private ObjectRepository $postRepository;

    private Guard $auth;

    private ReactionGeneratorInterface $reactionGenerator;

    private ReactionRepositoryInterface $reactionRepository;

    public function __construct(
        EntityManager $entityManager,
        AuthManager $authManager,
        ReactionGenerator $reactionGenerator,
        ReactionRepository $reactionRepository
    ) {
        parent::__construct($entityManager);

        $this->postRepository = $entityManager->getRepository(Post::class);
        $this->auth = $authManager->guard(config('auth.guards.default'));
        $this->reactionGenerator = $reactionGenerator;
        $this->reactionRepository = $reactionRepository;
    }

    public function reaction(Request $request): Response
    {
        $user = $this->getUser();
        $post = $this->postRepository->find($postId = $request->get('post'));
        $reactionTypeString = $request->get('reactionType');

        $reaction = $this->reactionRepository->findByUserAndPost($user, $post);

        if ($reactionTypeString === null) {
            return new JsonResponse(['code' => 400]);
        }

        if (!$post instanceof PostInterface) {
            throw new NotFoundHttpException(sprintf('Post with id %d could not be found.', $postId));
        }

        try {
            /** @var ReactionType $reactionType */
            $reactionType = constant(ReactionType::class . '::' . $reactionTypeString);
        } catch (\Throwable) {
            return new JsonResponse(['code' => 400]);
        }

        if (null === $reaction) {
            $reaction = $this->reactionGenerator->generate($post, $user);
        }

        if ($reactionType === $reaction->getType()) {
            $post->removeReaction($reaction);

            $this->entityManager->remove($reaction);
            $this->entityManager->flush();

            return new JsonResponse(null);
        } else {
            $reaction->setType($reactionType);

            $this->entityManager->persist($reaction);
            $this->entityManager->flush();
        }

        return new JsonResponse(
            [
                'post' => $post->getId(),
                'reactionType' => $reactionTypeString,
            ]
        );
    }

    private function getUser(): UserInterface
    {
        $user = $this->auth->user();

        if (!$user instanceof UserInterface) {
            throw new UnauthorizedHttpException('User not logged in');
        }

        return $user;
    }
}
