<?php

namespace App\Contracts;

interface RequestValidatorInterface
{
    /**
     * @param array<int,mixed> $data
     * @return array<int,mixed>
     */
    public function validate(array $data): array;
}
