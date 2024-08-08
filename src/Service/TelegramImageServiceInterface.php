<?php

declare(strict_types=1);

namespace App\Service;

use Luzrain\TelegramBotApi\Type\File;
use Psr\Http\Message\StreamInterface;

interface TelegramImageServiceInterface
{
    public function getImageUrl(string $imageId): File;

    public function getImage(string $path): StreamInterface;
}
