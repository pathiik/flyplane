<?php
//start new session
session_start();
//database parameters to my machine, needs to change for each machine
$serverName = 'localhost:3307';
$userName = 'root';
$password = '';
$dbname = 'rdbmsclass207';
//connects and test if it is possible to connect to database
$conn = mysqli_connect($serverName, $userName, $password, $dbname);
if ($conn->connect_error) {
    die("Internal Connection Problem. Try again later." . $conn->connect_error);
}
//checks if it is using POST and stores all the information in new variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['signup-email'];
    $username = $_POST['signup-username'];
    $password = $_POST['signup-password'];
    $confirmPassword = $_POST['signup-confirm-password'];
    //if the passwords are different give an error and finish
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }
    //open connection to database  and check if email exists
    $stmt = $conn->prepare("SELECT id FROM usersnew WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Email already exists.";
        $stmt->close();
        exit();
        //if email exists in the table give an error message and finish
    }
    //hash the password to store it in the table
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    //connnect and sends all the data to the database
    $stmt = $conn->prepare("INSERT INTO usersnew (email, userName, passwords) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $username, $hashedPassword);
    //if it executes give a message, otherwise inform the error
    if ($stmt->execute()) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
