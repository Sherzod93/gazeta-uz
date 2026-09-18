<?php

declare(strict_types=1);

namespace App\Admin\Auth;

final readonly class AdminCredentials
{
    public function __construct(
        public string $username,
        public string $passwordHash,
    ) {}
}
