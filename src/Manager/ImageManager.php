<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\TelegramFileServiceInterface;
use App\Service\TelegramImageServiceInterface;
use Luzrain\TelegramBotApi\Type\Message;

class ImageManager implements ImageManagerInterface
{
    private const HR_IMAGE = 3;

    public function __construct(
        private TelegramImageServiceInterface $telegramImageService,
        private TelegramFileServiceInterface $fileService,
        private AddressManagerInterface $addressManager
    ) {
    }

    public function process(Message $message): string
    {
        $fileData = $this->telegramImageService->getImageUrl($message->photo[self::HR_IMAGE]->fileId);
        $downloadedFilePath = $this->fileService->downloadFile($fileData->filePath);
        $addresses = $this->addressManager->recognizeAddress($downloadedFilePath, $message->from->id);

        return $addresses;
    }
}
