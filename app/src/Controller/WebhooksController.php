<?php

declare(strict_types=1);


namespace App\Controller;

use App\CDP\Http\CdpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WebhooksController extends AbstractController
{
    public function __construct(
        private CdpClient $cdpClient,
    ) {
    }

    #[Route(path: '/webhook', name: 'webhook', methods: ['POST'])]
    public function handleWebhook(Request $request): Response
    {
        // Handle the webhook request
        // You can use $this->cdpClient to send data to the CDP

        return new Response(status: 204);
    }
}

