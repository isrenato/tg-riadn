<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\GeminiServiceInterface;
use App\Service\TesseractOCRServiceInterface;

class AddressManager implements AddressManagerInterface
{
    public function __construct(
        private TesseractOCRServiceInterface $tesseractService,
        private GeminiServiceInterface       $geminiService
    )
    {
    }

    public function recognizeAddress(string $filePath): string
    {
        $text = $this->tesseractService->recognizeTextFromImage($filePath);
        $start = "Hauptstraße 23, Bischofsgrün 95493";

        $text = $this->geminiService->ask('get comma-separated addresses from string ' . $text);

        return $this->geminiService->ask('make route for google maps use addresses using them as points in the one route ' . $text . ', use ' . $start .' as start point');
    }
}
