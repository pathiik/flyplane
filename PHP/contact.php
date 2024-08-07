<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flyplane";


// Creating connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting and sanitizing form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS messageForm (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255),
        userEmail VARCHAR(255) NOT NULL,
        userMessage VARCHAR(1000) NOT NULL
    )");

    $stmt = $conn->prepare("INSERT INTO messageForm (userName, userEmail, userMessage) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
