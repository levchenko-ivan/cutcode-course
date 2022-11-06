<?php

namespace Support\Logging\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Services\Telegram\TelegramBotApi;
use Throwable;

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
        $message = "Error: ".$record['message'];

        if(
            isset($record['context']['exception'])
            && $record['context']['exception'] instanceof Throwable
        ) {
            /**
             * @var $exception Throwable
             */
            $exception = $record['context']['exception'];
            $message .= "\nFile: {$exception->getFile()}: {$exception->getLine()}";
        }

        $message .= "\nUser: ". userIp();

        TelegramBotApi::sendMessage($this->token, $this->chatId, $message);
    }
}
