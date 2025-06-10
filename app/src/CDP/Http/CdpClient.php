<?php

// src/App/CDP/Http/CdpClient.php

declare(strict_types=1);

namespace App\CDP\Http;

use App\CDP\Analytics\Model\ModelInterface;
use App\Error\WebhookException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CdpClient
{
  
    public function __construct(
        private HttpClientInterface $httpClient,
         #[Autowire('%cdp.api_key%')] private string $apiKey,
         #[Autowire('%env(CDP_API_URL)%')] private readonly string $cdpurl,
         )
    {
    }

    public function track(ModelInterface $model): void
    {
        $response = $this->httpClient->request('POST', $this->cdpurl . '/track', [
                'body' => json_encode($model->toArray(), JSON_THROW_ON_ERROR),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'API-KEY' => $this->apiKey,
                ]
            ]);


        try {
            $response->toArray();
        } catch (\Throwable $e) {
            // Handle the exception, e.g., log it or rethrow it
            throw new WebhookException(message: $response->getContent(false), previous: $e);
        }
    }

    public function identify(ModelInterface $model): void
    {
        $response = $this->httpClient->request('POST', $this->cdpurl . '/identify', [
                'body' => json_encode($model->toArray(), JSON_THROW_ON_ERROR),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'API-KEY' => $this->apiKey,
                ]
            ]);

        try {
            $response->toArray();
        } catch (\Throwable $e) {
            // Handle the exception, e.g., log it or rethrow it
            throw new WebhookException(message:  $response->getContent(false), previous: $e);
        }
    }
}
