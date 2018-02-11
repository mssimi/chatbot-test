<?php declare(strict_types=1);

namespace App\Validator;

interface Validator
{
    /**
     * @param mixed $input
     */
    public function validate($input): bool;
}
