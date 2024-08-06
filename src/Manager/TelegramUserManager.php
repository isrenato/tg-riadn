<?php

declare(strict_types=1);

namespace App\Manager;

use App\DataTransformer\TGUserDataTransformerInterface;
use App\Entity\TelegramUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Luzrain\TelegramBotApi\Type\User;

final readonly class TelegramUserManager implements TelegramUserManagerInterface
{
    public function __construct(
        private TGUserDataTransformerInterface $transformer,
        private ServiceEntityRepository $repository,
        private ManagerInterface $manager
    ) {
    }

    public function process(User $user): TelegramUser
    {
        $telegramUserEntity = $this->repository->findOneBy(['telegramId' => $user->id]);

        if (null === $telegramUserEntity) {
            return $this->create($user);
        }

        return $this->update($user, $telegramUserEntity);
    }

    private function create(User $user): TelegramUser
    {
        $entity = $this->transformer->transform($user);
        $this->manager->create($entity);

        return $entity;
    }

    private function update(User $user, TelegramUser $userEntity): TelegramUser
    {
        $entity = $this->transformer->transform($user, $userEntity);
        $this->manager->update();

        return $entity;
    }
}
