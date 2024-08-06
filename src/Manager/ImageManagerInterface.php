<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Image;
use Luzrain\TelegramBotApi\Type\Message;

interface ImageManagerInterface
{
    public function process(Message $message): Image;
}