<?php

declare(strict_types=1);

namespace App\Handler;

use App\DTO\Webhook;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class HandlerDelegator
{
    public function __construct(
        #[AutowireIterator(tag: 'webhook.handler')] private iterable $handlers,
    ) {
    }

    public function delegate(Webhook $webhook): void
    {
      //Loop through all the handlers and check if they support the webhook
      //If they do, call the handle method
        foreach ($this->handlers as $handler) {
            if ($handler->supports($webhook)) {
                $handler->handle($webhook);
            }
        }
    }
}
