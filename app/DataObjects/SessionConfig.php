<?php

namespace App\DataObjects;

use App\Enum\SameSite;

class SessionConfig
{
    public function __construct(
        public readonly string $name,
        public readonly string $flashName,
        public readonly bool $secure,
        public readonly bool $httponly,
        public readonly SameSite $samesite,
    ) {
        //
    }
}
