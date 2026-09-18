<?php

declare(strict_types=1);

namespace App\Shared;

use DateTimeImmutable;

final class RussianDate
{
    private const MONTHS = [
        1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня',
        7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря',
    ];

    private const WEEKDAYS = [
        1 => 'понедельник', 2 => 'вторник', 3 => 'среда', 4 => 'четверг',
        5 => 'пятница', 6 => 'суббота', 7 => 'воскресенье',
    ];

    public static function today(): string
    {
        return self::full(new DateTimeImmutable());
    }

    public static function full(DateTimeImmutable $date): string
    {
        return sprintf(
            '%d %s, %s',
            (int) $date->format('j'),
            self::MONTHS[(int) $date->format('n')],
            self::WEEKDAYS[(int) $date->format('N')],
        );
    }

    /**
     * Formats a date as "16 сентября 2026, 21:43".
     */
    public static function dateTime(DateTimeImmutable $date): string
    {
        return sprintf(
            '%d %s %s, %s',
            (int) $date->format('j'),
            self::MONTHS[(int) $date->format('n')],
            $date->format('Y'),
            $date->format('H:i'),
        );
    }

    /**
     * Formats a date as "Сегодня, 16:15", "Вчера, 21:43" or "3 сентября, 16:15".
     */
    public static function relative(DateTimeImmutable $date): string
    {
        $now = new DateTimeImmutable();

        if ($date->format('Y-m-d') === $now->format('Y-m-d')) {
            return 'Сегодня, ' . $date->format('H:i');
        }

        if ($date->format('Y-m-d') === $now->modify('-1 day')->format('Y-m-d')) {
            return 'Вчера, ' . $date->format('H:i');
        }

        return sprintf(
            '%d %s, %s',
            (int) $date->format('j'),
            self::MONTHS[(int) $date->format('n')],
            $date->format('H:i'),
        );
    }
}
