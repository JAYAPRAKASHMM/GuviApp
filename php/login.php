<?php
include_once('../mongo_connection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    error_log("Received data: username=$username, password=$password");
    $userDocument = $mongoDB->users->findOne(['username' => $username]);
    if ($userDocument && password_verify($password, $userDocument['password'])) {
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
}
?>