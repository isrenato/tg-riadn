<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Entity\TelegramUser;
use Luzrain\TelegramBotApi\Type\User;

class TGUserDataTransformer implements TGUserDataTransformerInterface
{
    public function transform(User $source, TelegramUser $entity = null): TelegramUser
    {
        if (null === $entity) {
            $entity = new TelegramUser();
        }

        return $entity->setUsername($source->username)
            ->setTelegramId($source->id);
    }
}