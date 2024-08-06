<?php

declare(strict_types=1);

namespace App\Service;

use Luzrain\TelegramBotApi\BotApi;
use Luzrain\TelegramBotApi\Method\GetFile;
use Luzrain\TelegramBotApi\Type\File;

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
}