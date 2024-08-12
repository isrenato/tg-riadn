<?php

declare(strict_types=1);

namespace App\Service;

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

class GeminiService implements GeminiServiceInterface
{
    public function __construct(
        private readonly Client $client
    ) {
    }

    public function ask(string $question): string
    {
        $response = $this->client->geminiPro()->generateContent(
            new TextPart($question),
        );

        return $response->text();
    }
}
