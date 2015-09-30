<?php

// Spazio per le customizzazioni, ad esempio per impostare user e password del db
if (file_exists('config.php')) {
    require_once 'config.php';
    require_once 'class/medoo.php';
} else {
    die ('Local config not found. Please create one from config.sample.php and name it config.php');
}
