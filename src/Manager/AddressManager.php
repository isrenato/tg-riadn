<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\GeminiServiceInterface;
use App\Service\TesseractOCRServiceInterface;

class AddressManager implements AddressManagerInterface
{
    public function __construct(
        private TesseractOCRServiceInterface $tesseractService,
        private GeminiServiceInterface $geminiService
    ) {
    }

    public function recognizeAddress(string $filePath): string
    {
        $text = $this->tesseractService->recognizeTextFromImage($filePath);

        return $this->geminiService->ask('get grupped comma-separated addresses from string '.$text);
    }
}
