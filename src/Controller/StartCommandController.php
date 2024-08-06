<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\TelegramUserManager;
use Luzrain\TelegramBotApi\Method;
use Luzrain\TelegramBotApi\Method\SendMessage;
use Luzrain\TelegramBotApi\Type;
use Luzrain\TelegramBotBundle\Attribute\OnCommand;
use Luzrain\TelegramBotBundle\TelegramCommand;

class StartCommandController extends TelegramCommand
{
    public function __construct(
        private readonly TelegramUserManager $manager
    ) {
    }

    #[OnCommand('/start')]
    public function __invoke(Type\Message $message): SendMessage
    {
        $this->manager->process($message->from);

        return new Method\SendMessage(
            chatId:   $message->chat->id,
            text: sprintf("Hi %s", $message->from->firstName)
        );
    }
}
