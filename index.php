<?php

require 'boot.php';

//One Micro Framework - Hello World
//remember enable the .htacess in this folder
require_once('src/OnePHP/one_framework.php');
/*
 * Remember remove this examples to avoid collisions in routes
 */
//load Micro Framework with debug enabled
$app = new \OnePHP\App();
$app->get('/telegramBot/', function() use ( $app, $curlCommand1, $token, $urlWebhooks ) {//Action on the Root URL
    return $app->ResponseHTML("
        <br/>per attivare il webhook : <br/> $curlCommand1 <br/>
        <a href=\"https://api.telegram.org/bot$token/setWebhook?url=$urlWebhooks\"> attiva WebHooks </a> <br/>
        <a href=\"https://api.telegram.org/bot$token/setWebhook?url=\"> disattiva WebHooks </a> <br/>
        <a href=\"https://api.telegram.org/bot$token/getUpdates\"> getUpdate WebHooks </a> <br/>
        <a href=\"https://api.telegram.org/bot$token/getMe\"> getMe </a> <br/>"
    );
});

$app->get('/telegramBot/command/', function() use ( $app, $database ) {

    $data = new DateTime();
    $filename = 'tempLog/' . $data->format('Ymd') . '-phpinput.log';
    $file = fopen($filename, 'a+');
    fwrite($file, $data->format('YmdHis') . ' CHIAMATA ' . PHP_EOL);
    try {
        $message = json_decode(file_get_contents('php://input'), true);

        fwrite($file, $data->format('YmdHis') . " " . print_r($message, true) . PHP_EOL);
        fwrite($file, $data->format('YmdHis') . " " . print_r(array(
                    "chat_idMessage" => $message['message']['message_id'],
                    "chat_idUser" => $message['message']['from']['id'],
                    "chat_name" => $message['message']['from']['first_name'],
                    "chat_surname" => $message['message']['from']['last_name'],
                    "chat_username" => $message['message']['from']['username'],
                    "chat_date" => $message['message']['date'],
                    "chat_text" => $message['message']['text'],
                    "chat_log" => print_r($message, true)), true) . PHP_EOL);
        fclose($file);

        $database->insert("log", [
            "chat_idMessage" => $message['message']['message_id'],
            "chat_idUser" => $message['message']['from']['id'],
            "chat_name" => $message['message']['from']['first_name'],
            "chat_surname" => $message['message']['from']['last_name'],
            "chat_username" => $message['message']['from']['username'],
            "chat_date" => $message['message']['date'],
            "chat_text" => $message['message']['text'],
            "chat_log" => print_r($message, true)
        ]);

    } catch (Exception $e) {
        fwrite($file, $data->format('YmdHis') . 'Caught exception: ' . $e->getMessage() . PHP_EOL);
        fclose($file);
    }

    return $app->ResponseHTML("Finito.");
});
//    //test with slug in URL ( ':name' = '{name}' )
//    $app->get('/:name', function( $name ) use ( $app ){
//        echo "<h1> Hello <small> $name </small> </h1>";
//    });
//    //simple Json Response example
//    $app->get('/json/:name', function( $name ) use ( $app ){
//        return $app->JsonResponse(array('name' => $name));
//    });
$app->respond(function() use ( $app ) {
    return $app->ResponseHTML('<p> This is a response with code 404. </p>', 404);
});
//Run
$app->listen();
