<?php

require 'boot.php';

//One Micro Framework - Hello World
//remember enable the .htacess in this folder
require_once('lib/OnePHP/one_framework.php');
/*
 * Remember remove this examples to avoid collisions in routes
 */
//load Micro Framework with debug enabled
$app = new \OnePHP\App();
$app->get('/telegramBot/', function() use ( $app, $aTParam ) {//Action on the Root URL
    return $app->ResponseHTML("
        <a href=\"https://api.telegram.org/bot" . $aTParam['token'] . "/setWebhook?url=" . $aTParam['urlWebhooks'] . "\"> attiva WebHooks </a> <br/>
        <a href=\"https://api.telegram.org/bot" . $aTParam['token'] . "/setWebhook?url=\"> disattiva WebHooks </a> <br/>
        <a href=\"https://api.telegram.org/bot" . $aTParam['token'] . "/getUpdates\"> getUpdate WebHooks </a> <br/>
        <a href=\"https://api.telegram.org/bot" . $aTParam['token'] . "/getMe\"> getMe </a> <br/>"
    );
});

$app->post('/telegramBot/command.php', function() use ( $app, $database ) {

    log::addLog('Chiamata');
    
    try {
        $message = json_decode(file_get_contents('php://input'), true);

        log::addLog( print_r($message, true));

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
        log::addLog('Caught exception: ' . $e->getMessage() );
    }

    return $app->ResponseHTML("Finito.");
});

$app->get('/telegramBot/message.php', function( ) use ( $app, $aTParam ) {

    $data = array(
        'chat_id' => 28751773,
        'text' => 'ciao io funziono...'
    );

    $request = new HTTPRequest($aTParam['urlCommand'] . 'sendMessage', HTTP_METH_POST);
    $request->setRawPostData($data);
    $request->send();
    $response = $request->getResponseBody();

    print_r($response);
//// use key 'http' even if you send the request to https://...
//    $options = array(
//        'http' => array(
//            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
//            'method' => 'POST',
//            'content' => http_build_query($data),
//        ),
//    );
//    $context = stream_context_create($options);
//    $result = file_get_contents($aTParam['urlCommand'] . 'sendMessage', false, $context);
//
//    var_dump($result);
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
