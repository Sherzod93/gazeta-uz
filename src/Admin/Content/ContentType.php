<?php

declare(strict_types=1);

namespace App\Admin\Content;

enum ContentType: string
{
    case News = 'news';
    case Reportings = 'reportings';
    case Articles = 'articles';

    public function table(): string
    {
        return $this->value;
    }

    public function label(): string
    {
        return match ($this) {
            self::News => 'Новости',
            self::Reportings => 'Репортажи',
            self::Articles => 'Статьи',
        };
    }
}
