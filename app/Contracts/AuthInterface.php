<?php

namespace App\Contracts;

interface AuthInterface
{
    public function user(): ?UserInterface;

    public function attemptLogin(array $data): bool;

    public function checkCredentials(UserInterface $user, array $credentials): bool;

    public function logOut(): void;
}
