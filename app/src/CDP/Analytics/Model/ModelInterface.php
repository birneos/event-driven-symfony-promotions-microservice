<?php

declare(strict_types=1);

namespace App\CDP\Analytics\Model;

interface ModelInterface
{
  /**
   * Get the unique identifier of the model.
   *
   * @return mixed
   */
    public function getId();

  /**
   * Convert the model to an array representation.
   *
   * @return array
   */
    public function toArray(): array;

  /**
   * Populate the model with data from an array.
   *
   * @param array $data
   * @return void
   */
    public function fromArray(array $data): void;
}
