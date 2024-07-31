<?php
//start new session
session_start();

$serverName = 'localhost';
$userName = 'root';
$password = '';
$dbname = 'php';

$conn = mysqli_connect($serverName, $userName, $password, $dbname);
if ($conn->connect_error) {
    die("Internal Connection Problem. Try again later." . $conn->connect_error);
}
// Checks if it is using POST and stores all the information in new variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['signup-email'];
    $username = $_POST['signup-username'];
    $userPassword = $_POST['signup-password'];
    $confirmPassword = $_POST['signup-confirm-password'];
    // If the passwords are different give an error and finish
    if ($userPassword !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS userData (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        userEmail VARCHAR(255) NOT NULL,
        username VARCHAR(255),
        userPassword VARCHAR(255) NOT NULL
    )");

    // Open connection to database and check if email exists
    $stmt = $conn->prepare("SELECT id FROM userData WHERE userEmail = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Email already exists.";
        $stmt->close();
        exit();
        // If email exists in the table give an error message and finish
    }
    // Hashing the password to store it in the table
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    // Connnects and sends all the data to the database
    $stmt = $conn->prepare("INSERT INTO userData (userEmail, username, userPassword) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $userEmail, $username, $hashedPassword);
    // If it executes give a message, otherwise inform the error
    if ($stmt->execute()) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
