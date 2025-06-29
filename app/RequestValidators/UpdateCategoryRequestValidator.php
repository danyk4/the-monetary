<?php

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Entity\User;
use App\Exception\ValidationException;
use Doctrine\ORM\EntityManager;
use Valitron\Validator;

class UpdateCategoryRequestValidator implements RequestValidatorInterface
{
    public function validate(array $data): array
    {
        $v = new Validator($data);
        
        $v->rule('required', ['name', 'id']);
        $v->rule('lengthMax', 'name', 50);
        $v->rule('integer', 'id');

        if ($v->validate()) {
            echo 'Validation passed.';
        } else {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
