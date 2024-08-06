<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\ImageManagerInterface;
use Luzrain\TelegramBotApi\Event\Message;
use Luzrain\TelegramBotApi\Method;
use Luzrain\TelegramBotApi\Method\SendMessage;
use Luzrain\TelegramBotBundle\Attribute\OnEvent;
use Luzrain\TelegramBotBundle\TelegramCommand;
use Luzrain\TelegramBotApi\Type;

class PhotoMessageController extends TelegramCommand
{
    public function __construct(
        private readonly ImageManagerInterface $manager
    ) {
    }

    #[OnEvent(event: Message::class, priority: 9)]
    public function __invoke(Type\Message $message): ?SendMessage
    {
        $this->manager->process($message);

        //todo move to Builder
        $inlineKeyboard =
            new Type\ReplyKeyboardMarkup(
                keyboard: Type\KeyboardButtonArrayBuilder::create()->addButton(
                            new Type\KeyboardButton(text: 'Calculate')
                        )
            );

        return new Method\SendMessage(
            chatId:      $message->chat->id,
            text:        "Added photo. Please add new one or press 'Calculate'",
            replyMarkup: $inlineKeyboard
        );
    }
}
