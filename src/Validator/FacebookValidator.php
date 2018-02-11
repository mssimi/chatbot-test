<?php declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

final class FacebookValidator implements Validator
{
    /**
     * @inheritdoc
     */
    public function validate($input): bool
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'fields' => [
                'entry' => $this->entry(),
            ],
            'allowExtraFields' => true,
        ]);

        $errors = $validator->validate($input, $constraint);

        return count($errors) === 0;
    }

    private function entry(): Assert\Collection
    {
        return new Assert\Collection([
            '0' => new Assert\Collection([
                'fields' => [
                    'messaging' => $this->messaging(),
                ],
                'allowExtraFields' => true,
            ]),
        ]);
    }

    private function messaging(): Assert\Collection
    {
        return new Assert\Collection([
            '0' => new Assert\Collection([
                'fields' => [
                    'sender' => new Assert\Collection([
                        'id' => new Assert\NotBlank(),
                    ]),
                    'recipient' => new Assert\Collection([
                        'id' => new Assert\NotBlank(),
                    ]),
                    'message' => new Assert\Collection([
                        'fields' => [
                            'text' => new Assert\NotBlank(),
                            'nlp' => new Assert\Collection([]),
                        ],
                        'allowExtraFields' => true,
                    ]),
                ],
                'allowExtraFields' => true,
            ]),
        ]);
    }
}
