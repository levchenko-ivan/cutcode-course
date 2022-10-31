<?php

namespace Support\Logging\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Services\Telegram\TelegramBotApi;

final class TelegramLoggingHandler extends AbstractProcessingHandler
{
    private int $chatId;

    private string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);

        $this->chatId = (int) $config['chat_id'];

        $this->token = $config['token'];
    }

    protected function write(array $record): void
    {
        TelegramBotApi::sendMessage($this->token, $this->chatId, $record['message']);
    }
}
