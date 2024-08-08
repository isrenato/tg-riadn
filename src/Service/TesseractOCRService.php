<?php

declare(strict_types=1);

namespace App\Service;

use thiagoalessio\TesseractOCR\TesseractOCR;

class TesseractOCRService implements TesseractOCRServiceInterface
{
    public function recognizeTextFromImage(string $filePath, ?string $lang = 'deu'): string
    {
        return (new TesseractOCR($filePath))
            ->lang('deu')
            ->run();
    }
}
