<?php

declare(strict_types=1);

use App\CDP\Analytics\Model\ModelInterface;
use App\CDP\Http\CdpClientInterface;

class FakeCdpClient implements CdpClientInterface
{
    private int $identifyCallCount = 0;

    private ModelInterface $identifyModel;

    private int $trackCallCount = 0;

    private ModelInterface $trackModel;

    public function track(ModelInterface $model): void
    {
        // Do nothing
    }
    public function identify(ModelInterface $model): void
    {
        // Do nothing
    }

    public function getIdentifyCallCount(): int
    {
        return $this->identifyCallCount;
    }

    public function getIdentifyModel(): ModelInterface
    {
        return $this->identifyModel;
    }

    public function getTrackCallCount(): int
    {
        return $this->trackCallCount;
    }

    public function getTrackModel(): ModelInterface
    {
        return $this->trackModel;
    }
}
