<?php

declare(strict_types=1);

namespace App\Service;

interface TesseractOCRServiceInterface
{
    public function recognizeTextFromImage(string $filePath, ?string $lang = 'deu'): string;
}
