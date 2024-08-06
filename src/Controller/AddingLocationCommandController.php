<?php

declare(strict_types=1);

namespace App\Controller;

use Luzrain\TelegramBotApi\Method;
use Luzrain\TelegramBotApi\Method\SendMessage;
use Luzrain\TelegramBotApi\Type;
use Luzrain\TelegramBotBundle\Attribute\OnCommand;
use Luzrain\TelegramBotBundle\TelegramCommand;

class AddingLocationCommandController extends TelegramCommand
{
    #[OnCommand('/add', description: 'adding new location', publish: true)]
    public function __invoke(Type\Message $message, string ...$data): SendMessage
    {
        return new Method\SendMessage(
            chatId:   $message->chat->id,
            text: sprintf("Added %s", implode(' ', $data))
        );
    }
}
