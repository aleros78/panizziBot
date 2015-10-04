<?php

require_once 'lib/medoo.php';
require_once 'class/log.class.php';
require __DIR__ . '/vendor/autoload.php';

if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    die('Local config not found. Please create one from config.sample.php and name it config.php');
}

require_once 'class/log.class.php';
require __DIR__ . '/vendor/autoload.php';

try {
    log::addLog('Chiamata webhooks');
    // create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($token, $botname);
    $telegram->enableMySQL($credentials);
    $telegram->enableAdmins(array($adminId));
    $telegram->setLogRequests(true);
    $telegram->setLogPath($botname . '.log');
    $COMMANDS_FOLDER = __DIR__.'/command/';
    $telegram->addCommandsPath($COMMANDS_FOLDER);
    
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    log::addLog(print_r($e, true));
}