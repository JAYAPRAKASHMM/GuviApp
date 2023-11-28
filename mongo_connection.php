<?php
require __DIR__ . '/vendor/autoload.php';
$mongoUri = 'mongodb://localhost:27017/my_application_database';
try {
    $mongoClient = new MongoDB\Client($mongoUri);
    $mongoDB = $mongoClient->selectDatabase('my_application_database');
    $users=$mongoDB->users;

} catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
    echo json_encode(['status' => 'error', 'message' => 'MongoDB Connection failed: ' . $e->getMessage()]);
}
?>
