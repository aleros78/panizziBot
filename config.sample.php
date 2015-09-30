<?php

$token = '123T0k3n321';
$botname = 'nameof_bot';
$urlWebhooks = 'https://url.the.webhook/';

$database = new medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'dbname',
	'server' => 'localhost',
	'username' => 'user',
	'password' => 'pass',
	'charset' => 'utf8'
]);