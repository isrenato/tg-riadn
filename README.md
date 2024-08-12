# TelegramBot for recognising addresses in photos
[![PHP >=8.2](https://img.shields.io/badge/PHP->=8.2-777bb3.svg?style=flat)](https://www.php.net/releases/8.2/en.php)
![Symfony ^7.0](https://img.shields.io/badge/Symfony-^7.0-374151.svg?style=flat)


## Getting started

### Configure .env
```env
TG_API_TOKEN=

TG_WEBHOOK=

DATABASE_URL=

GEMINI_API_KEY=
```

### Configure bundle
```yaml
# config/packages/telegram_bot.yaml

telegram_bot:
  api_token: API_TOKEN
#  webhook:
#    url: https://localhost/tg-webhook
```

### Optional. Configure webhook route
```yaml
# config/routes.yaml

# ...
telegram_webhook:
  path: /tg-webhook
  controller: telegram_bot.webhook_controller
```

Note that *symfony/http-client* and *nyholm/psr7* are not necessary. You can use any PSR-18 client and PSR-17 factories.  
Set custom services in *http_client*, *request_factory*, *stream_factory* options in *telegram_bot.yaml* configuration file.  
Here is an example how to use [guzzle](https://github.com/guzzle/guzzle) http client:

```yaml
# config/services.yaml

psr18.guzzle_client:
  class: GuzzleHttp\Client
  arguments:
    - http_errors: false

psr17.guzzle_factory:
  class: GuzzleHttp\Psr7\HttpFactory
```

```yaml
# config/packages/telegram_bot.yaml

telegram_bot:
  http_client: psr18.guzzle_client
  request_factory: psr17.guzzle_factory
  stream_factory: psr17.guzzle_factory
  api_token: API_TOKEN
```

For a complete list of available options with documentation, see the command output.
```bash
$ bin/console config:dump-reference telegram_bot
```

### Getting messages from telegram
There are two ways to receive messages from Telegram.
#### Webhook. Recommended way.
You must configure the webhook route and make it available from the Internet.  
Configure *webhook.url* option in *telegram_bot.yaml* configuration file;  
Update the webhook configuration in telegram bot with the command.
```bash
$ bin/console telegram:webhook:update
```

Note that each time you change *webhook* and *allowed_updates* options in configuration files you should run this command for update telegram bot settings.

