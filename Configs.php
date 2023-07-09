<?php
require 'vendor/autoload.php';

use Parse\ParseClient;
use Parse\ParseSessionStorage;

error_reporting(null);

session_start();

try {
    ParseClient::initialize('tzmWfWsT7bic1xKj8IwghdetigS4UYehLTy9Xa2G', 'Xk8riNBh3O8dxPht72K5PLqUtB9IcQuvgpeWcAaJ', 'mBLIFDALIl3yRRlwkuiytIOncLwFrX2DY1ZozN1s');
    ParseClient::setServerURL('https://parseapi.back4app.com/', '/');
    ParseClient::setStorage(new ParseSessionStorage());
} catch (Exception $e) {
}

$health = ParseClient::getServerHealth();
if ($health['status'] !== 200) {
}

// Website root url
$GLOBALS['WEBSITE_PATH'] = 'http://localhost/AdminPanel';
