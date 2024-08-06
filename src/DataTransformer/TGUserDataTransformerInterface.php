<?php

namespace App\DataTransformer;

use App\Entity\TelegramUser;
use Luzrain\TelegramBotApi\Type;

interface TGUserDataTransformerInterface
{
    public function transform(Type\User $source, TelegramUser $entity = null): TelegramUser;
}