<?php

declare(strict_types=1);

return [
    'username' => getenv('ADMIN_USERNAME') ?: 'admin',
    // Default hash below is for the local dev password "admin123" (matches .env.example).
    'passwordHash' => getenv('ADMIN_PASSWORD_HASH') ?: '$2y$10$d0TgXm3mqPdIptVe8eldhuhN9RMABEXxwL38Z9fycX9WMTFRxyXLC',
];
