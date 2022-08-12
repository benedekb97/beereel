<?php

declare(strict_types=1);

namespace App\Entity;

enum ReactionType: string
{
    case LOVE = 'love';
    case SMILE = 'smile';
    case WOW = 'wow';
    case ANGRY = 'angry';
    case LIKE = 'like';
    case LOL = 'lol';

    public function getHtmlCharacter(): string
    {
        return match($this) {
            self::LOVE => '&#10084;',
            self::SMILE => '&#128522;',
            self::WOW => '&#128558;',
            self::ANGRY => '&#128545;',
            self::LIKE => '&#128077;',
            self::LOL => '&#128514;'
        };
    }
}
