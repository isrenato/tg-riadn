<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\TelegramUserManagerInterface;
use Luzrain\TelegramBotApi\Method\SendMessage;
use Luzrain\TelegramBotApi\Type;
use Luzrain\TelegramBotBundle\Attribute\OnCommand;
use Luzrain\TelegramBotBundle\TelegramCommand;

class StartCommandController extends TelegramCommand
{
    public function __construct(
        private readonly TelegramUserManagerInterface $manager
    ) {
    }

    #[OnCommand('/start', priority: 0)]
    public function __invoke(Type\Message $message): SendMessage
    {
        $this->manager->process($message->from);

        return new SendMessage(
            chatId: $message->chat->id,
            text: sprintf('Hi %s', $message->from->firstName)
        );
    }
}
