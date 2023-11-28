<?php
include_once('../mongo_connection.php');
header('Content-Type: application/json'); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    try {
        $existingUser = $mongoDB->users->findOne(['username' => $username]);
        if ($existingUser) {
            echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
        } else{
            $userDocument = [
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'dob' => '',
                'gender' => '',
                'institution' => '',
                'yearOfPassing' => '',
                'phoneNumber' => ''
            ];
            $result = $mongoDB->users->insertOne($userDocument);
            if ($result->getInsertedCount() > 0) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
            } else {
                http_response_code(500); 
                echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
            }
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred']);
    }
} else{
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>