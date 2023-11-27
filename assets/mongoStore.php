<?php
include_once('../mongo_connection.php');
header('Content-Type: application/json'); 


$users->updateOne(
    ['username'=>'cecsa2034142'],
    ['$set'=>['email'=>'aliyar']],['upsert'=>true]
)
?>