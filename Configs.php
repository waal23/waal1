<?php
require 'vendor/autoload.php';

use Parse\ParseClient;
use Parse\ParseSessionStorage;

error_reporting(null);

session_start();

try {
    ParseClient::initialize('HSnoUGSH5VrAik7tnZ9QrLi2TX5VugKptx8WHHh8', '1FwIvuhKA7KwFrQwJ1D5acDc2kdGQ1q7dtUlJFMf', 'ZGHAZgNdGUwHUb4jjKMvDOpl5DOQvY30b42iRSDk');
    ParseClient::setServerURL('https://parseapi.back4app.com/', '/');
    ParseClient::setStorage(new ParseSessionStorage());
} catch (Exception $e) {
}

$health = ParseClient::getServerHealth();
if ($health['status'] !== 200) {
}

// Website root url
$GLOBALS['WEBSITE_PATH'] = 'http://localhost/AdminPanel';
