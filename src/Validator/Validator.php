<?php declare(strict_types=1);

namespace App\Validator;

interface Validator
{
    public function validate($input): bool;
}