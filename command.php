<?php

require  'boot.php';

    // decoding input
    $message = json_decode(file_get_contents('php://input'), true);
    $data = new DateTime();
    $filename = 'tempLog/' . $data->format('Ymd') . '-phpinput.log';
    $file = fopen($filename, 'a+');
    fwrite($file, $data->format('YmdHis') . " " . print_r($message,true) . PHP_EOL);
    fclose($file);
    
    $database->insert("log", [
		"chat_idMessage" => $message['message']['message_id'],
		"chat_idUser" => $message['message']['from']['id'],
		"chat_name" => $message['message']['from']['first_name'],
		"chat_surname" => $message['message']['from']['last_name'],
		"chat_username" => $message['message']['from']['username'],
		"chat_date" => $message['message']['date'],
		"chat_text" => $message['message']['text'],
		"chat_log" => print_r($message,true)
	]);

    echo "finito";
    
