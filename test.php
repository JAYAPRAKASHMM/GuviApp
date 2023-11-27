<?php
require __DIR__ . '/vendor/autoload.php';
$mongoUri = 'mongodb://localhost:27017/my_application_database';


    $mongoClient = new MongoDB\Client();
    $mongoDB = $mongoClient->my_application_database;
    $users=$mongoDB->users;

// $mysqli->close();
$l=$users->find();
foreach($l as $dc)
var_dump($dc);
$suma = $users->updateOne(
    ['username'=>'cecsa2034142'],
    ['$set'=>['email'=>'aliyar']],['upsert'=>true]
)
?>

