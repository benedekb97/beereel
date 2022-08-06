<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entity\UserInterface;
use App\Generator\PostGenerator;
use App\Generator\PostGeneratorInterface;
use App\Resolver\CurrentDayResolver;
use App\Resolver\CurrentDayResolverInterface;
use App\Resolver\PostResolver;
use App\Resolver\PostResolverInterface;
use Doctrine\ORM\EntityManager;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Size;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    private const FILE_MAX_SIZE = 20*1024*1024;

    private PostGeneratorInterface $postGenerator;

    private PostResolverInterface $postResolver;

    private Guard $auth;

    private Filesystem $filesystem;

    private CurrentDayResolverInterface $currentDayResolver;

    public function __construct(
        PostGenerator $postGenerator,
        PostResolver $postResolver,
        EntityManager $entityManager,
        AuthManager $authManager,
        FilesystemManager $filesystemManager,
        CurrentDayResolver $currentDayResolver
    ) {
        parent::__construct($entityManager);

        $this->postGenerator = $postGenerator;
        $this->postResolver = $postResolver;
        $this->auth = $authManager->guard(config('auth.guards.default'));
        $this->filesystem = $filesystemManager->disk(config('filesystems.default'));
        $this->currentDayResolver = $currentDayResolver;
    }

    public function upload(Request $request): Response
    {
        if ($this->postResolver->resolve($this->getUser()) !== null) {
            return new RedirectResponse(route('index'));
        }

        $front = $request->files->get('front');
        $back = $request->files->get('back');

        if (!$front instanceof UploadedFile || !$back instanceof UploadedFile) {
            return new RedirectResponse(route('create'));
        }

        if ($front->getSize() > self::FILE_MAX_SIZE || $back->getSize() > self::FILE_MAX_SIZE) {
            return new RedirectResponse(route('create'));
        }

        $post = $this->postGenerator->generateForUserAndDay($this->getUser(), $this->currentDayResolver->resolve());

        $this->filesystem->putFileAs('images', $back, $backPath = 'back.' . $this->getUser()->getId() . '.' . $post->getDay()->getId() . '.' . $back->getClientOriginalExtension());
        $this->filesystem->putFileAs('images', $front, $frontPath = 'front.' . $this->getUser()->getId() . '.' . $post->getDay()->getId() . '.' . $front->getClientOriginalExtension());

        $frontFirstFront = Image::make(storage_path('app/images/' . $frontPath));
        $frontFirstBack = Image::make(storage_path('app/images/' . $backPath));

        if ($frontFirstFront->getWidth() > $frontFirstFront->getHeight()) {
            $frontFirstFront->rotate(270);
        }

        if ($frontFirstBack->getWidth() > $frontFirstBack->getHeight()) {
            $frontFirstBack->rotate(270);
        }

        $frontFirstBack->resize(150, null, static function ($constraint) {
            $constraint->aspectRatio();
        });
        $frontFirstFront->resize(500, null, static function ($constraint) {
            $constraint->aspectRatio();
        });

        $backFirstFront = Image::make(storage_path('app/images/' . $frontPath));
        $backFirstBack = Image::make(storage_path('app/images/' . $backPath));

        if ($backFirstBack->getWidth() > $backFirstBack->getHeight()) {
            $backFirstBack->rotate(270);
        }

        if ($backFirstFront->getWidth() > $backFirstFront->getHeight()) {
            $backFirstFront->rotate(270);
        }

        $backFirstFront->resize(150, null, static function ($constraint) {
            $constraint->aspectRatio();
        });
        $backFirstBack->resize(500, null, static function ($constraint) {
            $constraint->aspectRatio();
        });

        $backFirstBack->insert($backFirstFront, 'top-left', 10, 10);

        $frontFirstFront->insert($frontFirstBack, 'top-left', 10, 10);

        if (!$this->filesystem->exists('images/posts')) {
            $this->filesystem->makeDirectory('images/posts');
        }

        $backFirstBack->save(storage_path('app/public/images/posts/back.' . $this->getUser()->getId() . '.' . $post->getDay()->getId(). '.' . $back->getClientOriginalExtension()), 80);
        $frontFirstFront->save(storage_path('app/public/images/posts/front.' . $this->getUser()->getId() . '.' . $post->getDay()->getId() . '.' . $front->getClientOriginalExtension()), 80);

        $post->setImagePath('storage/images/posts/front.' . $this->getUser()->getId() . '.' . $post->getDay()->getId() . '.' . $front->getClientOriginalExtension());

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        if (null !== $this->postResolver->resolve($this->getUser())) {
            return new RedirectResponse(route('index'));
        }

        return new RedirectResponse(route('index'));
    }

    private function getUser(): UserInterface
    {
        $user = $this->auth->user();

        if (!$user instanceof UserInterface) {
            throw new \InvalidArgumentException('User could not be found!');
        }

        return $user;
    }
}
