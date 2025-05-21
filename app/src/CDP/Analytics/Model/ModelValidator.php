<?php

declare(strict_types=1);

namespace App\CDP\Analytics\Model;

use App\Error\WebhookException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ModelValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function validate(ModelInterface $model): void
    {

        $violations = $this->validator->validate($model);

        if (count($violations) > 0) {
            $failingProperties = [];

            foreach ($violations as $violation) {
                $failingProperties[] = $violation->getPropertyPath();
            }

            $reflectionClass = new \ReflectionClass($model);

            throw new WebhookException('Invalid ' . $reflectionClass->getShortName() . ' properties: ' . implode(', ', $failingProperties));
        }
        // If there are no errors, the model is valid
    }
}
