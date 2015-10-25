<?php

namespace Longman\TelegramBot\Commands;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Command;
use Longman\TelegramBot\Entities\Update;

class SalutaCommand extends Command
{
    protected $name = 'saluta';
    protected $description = 'fa un saluto';
    protected $usage = '/saluta';
    protected $version = '1.0.0';
    protected $enabled = true;
    protected $public = true;

    public function execute()
    {
        $update = $this->getUpdate();
        $message = $this->getMessage();

        $chat_id = $message->getChat()->getId();
        //$text = $message->getText(true);

        $data = array();
        $data['chat_id'] = $chat_id;
        $data['text'] = "Ciao dal tuo bot...";

        $result = Request::sendMessage($data);
        return $result;
    }
}
