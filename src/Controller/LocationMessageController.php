<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\LocationManagerInterface;
use Luzrain\TelegramBotApi\Event\Message;
use Luzrain\TelegramBotApi\Method\SendMessage;
use Luzrain\TelegramBotApi\Type;
use Luzrain\TelegramBotBundle\Attribute\OnEvent;
use Luzrain\TelegramBotBundle\TelegramCommand;

class LocationMessageController extends TelegramCommand
{
    public function __construct(
        private readonly LocationManagerInterface $manager
    ) {
    }

    #[OnEvent(event: Message::class, priority: 9)]
    public function __invoke(Type\Message $message): ?SendMessage
    {
        if (null === $message->location) {
            return null;
        }

        $this->manager->process($message);

        return new SendMessage(
            chatId: $message->chat->id,
            text: 'Your location has been added',
        );
    }
}
