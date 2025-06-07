<?php

namespace App\Contracts;

interface UserInterface
{
    public function getId(): int;

    public function getName(): string;
}
