<?php
$mysqlHost = 'localhost';
$mysqlUsername = 'root';
$mysqlPassword = 'valo12345';
$mysqlDatabase = 'guvi';
$mysqli = new mysqli($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase);
if ($mysqli->connect_error) {
    die("MySQL Connection failed: " . $mysqli->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $status = $_POST['status'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $stmt = $mysqli->prepare("INSERT INTO user_status (username, status, time, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $status, $time, $date);
    if($stmt->execute()) {
        echo "User status saved in MySQL successfully";
    } else {
        echo "Error saving user status in MySQL: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request method";
}
$mysqli->close(); 
?>
