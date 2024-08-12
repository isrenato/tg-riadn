<?php

declare(strict_types=1);

namespace App\Service;

interface GeminiServiceInterface
{
    public function ask(string $question): string;
}
