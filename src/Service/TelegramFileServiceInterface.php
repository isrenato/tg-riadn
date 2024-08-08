<?php

declare(strict_types=1);

namespace App\Service;

interface TelegramFileServiceInterface
{
    public function downloadFile(string $tgFilePath): string;
}
