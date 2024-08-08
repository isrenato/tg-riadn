<?php

declare(strict_types=1);

namespace App\Service;

use Luzrain\TelegramBotApi\BotApi;
use Luzrain\TelegramBotApi\Method\GetFile;
use Luzrain\TelegramBotApi\Type\File;
use Psr\Http\Message\StreamInterface;

class TelegramImageService implements TelegramImageServiceInterface
{
    public function __construct(
        private readonly BotApi $botApiProvider,
    ) {
    }

    public function getImageUrl(string $imageId): File
    {
        return $this->botApiProvider->call(new GetFile($imageId));
    }

    public function getImage(string $imageId): StreamInterface
    {
        return $this->botApiProvider->downloadFile($imageId);
    }
}
