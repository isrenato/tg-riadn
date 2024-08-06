<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Image;
use App\Service\TelegramImageServiceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Luzrain\TelegramBotApi\Type\Message;

class ImageManager implements ImageManagerInterface
{
    private const HR_IMAGE = 3;

    public function __construct(
        private TelegramImageServiceInterface $telegramImageService,
        private ServiceEntityRepository $userRepository,
        private ManagerInterface $manager
    ){
    }

   public function process(Message $message): Image
   {
        $fileData = $this->telegramImageService->getImageUrl($message->photo[self::HR_IMAGE]->fileId);
        $user = $this->userRepository->findOneBy(['telegramId' => $message->from->id]);
        $image = (new Image())->setPath($fileData->filePath)->setTelegramUser($user);

        return $this->create($image);
   }

    private function create(Image $entity): Image
    {
        $this->manager->create($entity);

        return $entity;
    }
}