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
    $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

    if ($data !== null) {
        $stmt = $mysqli->prepare("INSERT INTO user_details (username, dob, gender, institution, year_of_passing, phone_number)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        username= VALUES(username),
        dob = VALUES(dob),
        gender = VALUES(gender),
        institution = VALUES(institution),
        year_of_passing = VALUES(year_of_passing),
        phone_number = VALUES(phone_number);");

        $stmt->bind_param("ssssss", $data['username'], $data['dob'], $data['gender'], $data['institution'], $data['yearOfPassing'], $data['phoneNumber']);

        if ($stmt->execute()) {
            echo "User data saved successfully";
        } else {
            echo "Error saving user data in MySQL: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error decoding JSON data";
    }
} else {
    echo "Invalid request method";
}

$mysqli->close();
?>
