<?php

declare(strict_types=1);

namespace App\Service;

use Luzrain\TelegramBotApi\Type\File;

interface TelegramImageServiceInterface
{
    public function getImageUrl(string $imageId): File;
}