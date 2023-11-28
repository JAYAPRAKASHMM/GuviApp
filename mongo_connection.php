<?php
require __DIR__ . '/vendor/autoload.php';
$mongoUri = 'mongodb://roundhouse.proxy.rlwy.net:23989/';
try {
    $mongoClient = new MongoDB\Client($mongoUri,array("username" => "mongo", "password" => "f3Ad41c6EE2bfB5BB2BF1Aad3HAbBbFf"));
    $mongoDB = $mongoClient->selectDatabase('my_application_database');
    $users=$mongoDB->users;
} catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
    echo json_encode(['status' => 'error', 'message' => 'MongoDB Connection failed: ' . $e->getMessage()]);
}
?>
