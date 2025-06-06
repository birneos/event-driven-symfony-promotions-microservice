<?php

declare(strict_types=1);

namespace App\CDP\Http;

use App\CDP\Analytics\Model\ModelInterface;

interface CdpClientInterface
{
    public function track(ModelInterface $model): void;

    public function identify(ModelInterface $model): void;
}
