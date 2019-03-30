<?php

namespace Telegram;

use Exception;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class TelegramHandler extends AbstractProcessingHandler {

    private $bot_token;

    private $chat_id;

    private $app_name;

    private $app_env;

    private $text_format;


    public function __construct($level) {

        $level = Logger::toMonologLevel($level);

        parent:__construct($level, true);

        $this->bot_token = config('telegram.bot_token');
        $this->chat_id = config('telegram.chat_id');
        $this->app_name = config('app.name');
        $this->app_env = config('app.env');

        $this->text_format = config('telegram.text_format');



    }

    public function write(array $record) {
        // check if bot_token or chat_id is set.
        if(!$this->bot_token || !$this->chat_id) {
            return;
        }

        $message = $this->getFormatedText($record['formatted'], $record['level_name']);

        try {
            file_get_contents("https://api.telegram.org/bot{$this->bot_token}/sendMessage?" . http_build_query([
                    'text' => $message,
                    'chat_id' => $this->chat_id,
                    'parse_mode' => 'html'
                ]));
        } catch (Exception $e) {

        }
    }

    public function getFormatedText(string $text, $level) : string {
        $final_text = $this->text_format;
        $final_text = str_replace('{message}', $text,$final_text);
        $final_text = str_replace('{level}', $level,$final_text);
        return $final_text;
    }

}