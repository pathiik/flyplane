<?php
//start the session
session_start();

// Connecting to the database
$serverName = 'localhost';
$userName = 'root';
$password = '';
$dbname = 'flyplane';

$conn = mysqli_connect($serverName, $userName, $password, $dbname);
// Checking connection
if ($conn->connect_error) {
    die("Internal Connection Problem. Try again later." . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['login-email'];
    $userPassword = $_POST['login-password'];
    // Selecting the data from the user email informed by user
    $stmt = $conn->prepare("SELECT id, username, userEmail, userPassword FROM userData WHERE userEmail = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    // Store the result of the query
    $result = $stmt->get_result();
    // If one user is found
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Checks to see if the user input password is the same as it is saved in the db
        if (password_verify($password, $row['userPassword'])) {
            // If correct password sends the user to index and store the userName in a new variable to be used
            $_SESSION['username'] = $row['username'];
            // Sends the user to a new page
            header('Location: index.php');
            exit();
            // If wrong password exits and prints message
        } else {
            echo "Wrong Password";
        }
    } else {
        // If wrong user exits and prints message
        echo "User does not exist. Please sign up";
    }
    $stmt->close();
}

$conn->close();
