<?php

namespace App\Logging\Telegram;

use Monolog\Logger;

class TelegramLoggingFactory
{
    /**
     * Create a custom Monolog instance.
     * @param  array  $config
     * @return Logger
     */
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('telegram');
        $logger->pushHandler(new TelegramLoggingHandler($config));
        return $logger;
    }
}
