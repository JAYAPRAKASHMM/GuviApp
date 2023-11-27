<?php
include_once('../mongo_connection.php');
header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $user = $mongoDB->users->findOne(['username' => $username]);

    if ($user) {
        $updateFields = [];
        if (!empty($_POST['password'])) {
            $updateFields['password'] = $_POST['password'];
        }

        if (!empty($_POST['email'])) {
            $updateFields['email'] = $_POST['email'];
        }

        if (!empty($_POST['dob'])) {
            $updateFields['dob'] = $_POST['dob'];
        }

        if (!empty($_POST['gender'])) {
            $updateFields['gender'] = $_POST['gender'];
        }

        if (!empty($_POST['institution'])) {
            $updateFields['institution'] = $_POST['institution'];
        }

        if (!empty($_POST['yearOfPassing'])) {
            $updateFields['yearOfPassing'] = $_POST['yearOfPassing'];
        }

        if (!empty($_POST['phoneNumber'])) {
            $updateFields['phoneNumber'] = $_POST['phoneNumber'];
        }
        $mongoDB->users->updateOne(['_id' => $user['_id']], ['$set' => $updateFields]);
        $updatedUser = $mongoDB->users->findOne(['_id' => $user['_id']]);
        echo json_encode(['status' => 'success', 'user' => $updatedUser, 'message' => 'User details updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $username = $_GET['username'];
    $user = $mongoDB->users->findOne(['username' => $username]);

    if ($user) {
        echo json_encode(['status' => 'success', 'user' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
