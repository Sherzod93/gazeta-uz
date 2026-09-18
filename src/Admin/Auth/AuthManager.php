<?php

declare(strict_types=1);

namespace App\Admin\Auth;

use Yiisoft\Session\SessionInterface;

final readonly class AuthManager
{
    private const SESSION_KEY = 'admin.username';

    public function __construct(
        private SessionInterface $session,
        private AdminCredentials $credentials,
    ) {}

    public function attempt(string $username, string $password): bool
    {
        if ($this->credentials->passwordHash === '' || !hash_equals($this->credentials->username, $username)) {
            return false;
        }

        if (!password_verify($password, $this->credentials->passwordHash)) {
            return false;
        }

        $this->session->set(self::SESSION_KEY, $username);

        return true;
    }

    public function isLoggedIn(): bool
    {
        return $this->session->get(self::SESSION_KEY) !== null;
    }

    public function logout(): void
    {
        $this->session->remove(self::SESSION_KEY);
    }
}
