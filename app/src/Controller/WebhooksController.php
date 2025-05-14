<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class WebhooksController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route(path: '/webhook', name: 'webhook', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {

      // Handle the webhook request
      // You can use $this->cdpClient to send data to the CDP
        try {
            $webhook = $this->serializer->deserialize(
                $request->getContent(),
                Webhook::class,
                'json'
            );

            $webhook->setRawPayload(json_decode($request->getContent(), true));

            dd($webhook);

            return new Response(status: 204);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}
