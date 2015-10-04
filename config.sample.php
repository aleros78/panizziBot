<?php

$token = '123T0k3n321';
$botname = 'nameof_bot';
$urlWebhooks = 'https://url.the.webhook/';
$urlCommand = "https://api.telegram.org/file/bot$token/";

$aTParam = array(
    'token'         => $token,
    'botname'       => $botname,
    'urlWebhooks'   => $urlWebhooks,
    'urlCommand'    => $urlCommand   
);

$database = new medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'dbname',
	'server' => 'localhost',
	'username' => 'user',
	'password' => 'pass',
	'charset' => 'utf8'
]);