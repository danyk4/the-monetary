<?php

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Entity\User;
use App\Exception\ValidationException;
use Doctrine\ORM\EntityManager;
use Valitron\Validator;

class RegisterUserRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
        // Initialization if needed
    }

    /**
     * @param array<int,mixed> $data
     * @return array<int,mixed>
     */
    public function validate(array $data): array
    {
        $v = new Validator($data);
        $v->rule('required', ['name', 'email', 'password', 'confirmPassword']);
        $v->rule('email', 'email');
        $v->rule('equals', 'confirmPassword', 'password')->label('Confirm Password');
        $v->rule(
            fn($field, $value, $params, $fields)
                    => ! $this->entityManager
                    ->getRepository(User::class)
                    ->count(['email' => $value]),
            'email',
        )
            ->message('This email is already registered.');

        if ($v->validate()) {
            echo 'Validation passed.';
        } else {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}

