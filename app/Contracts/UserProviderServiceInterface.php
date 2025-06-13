<?php

namespace App\Contracts;

use App\DataObjects\RegisterUserData;

interface UserProviderServiceInterface
{
    public function getById(int $userId): ?UserInterface;

    /**
     * @param array<int,mixed> $credentials
     */
    public function getByCredentials(array $credentials): ?UserInterface;

    public function createUser(RegisterUserData $data): UserInterface;
}
