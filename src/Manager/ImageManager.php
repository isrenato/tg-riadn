<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Image;
use App\Service\TelegramFileServiceInterface;
use App\Service\TelegramImageServiceInterface;
use App\Service\TesseractOCRServiceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Luzrain\TelegramBotApi\Type\Message;

class ImageManager implements ImageManagerInterface
{
    private const HR_IMAGE = 3;

    public function __construct(
        private TelegramImageServiceInterface $telegramImageService,
        private ServiceEntityRepository $userRepository,
        private ManagerInterface $manager,
        private TelegramFileServiceInterface $fileService,
        private TesseractOCRServiceInterface $tesseractService
    ) {
    }

    public function process(Message $message): string
    {
        $fileData = $this->telegramImageService->getImageUrl($message->photo[self::HR_IMAGE]->fileId);
        $user = $this->userRepository->findOneBy(['telegramId' => $message->from->id]);
        $image = (new Image())->setPath($fileData->filePath)->setTelegramUser($user);
        $downloadedFilePath = $this->fileService->downloadFile($fileData->filePath);
        $this->create($image);

        return $this->tesseractService->recognizeTextFromImage($downloadedFilePath);
    }

    private function create(Image $entity): Image
    {
        $this->manager->create($entity);

        return $entity;
    }
}
