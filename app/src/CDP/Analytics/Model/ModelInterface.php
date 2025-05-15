<?php

declare(strict_types=1);

namespace App\CDP\Analytics\Model;

interface ModelInterface
{
    public const IDENTIFY_TYPE = 'identify';

    public const TRACK_TYPE = 'track';


  /**
   * Convert the model to an array representation.
   *
   * @return array<string, mixed>
   */
    public function toArray(): array;
}
