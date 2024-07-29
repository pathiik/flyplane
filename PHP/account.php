<?php
//start the session
session_start();
//connect to the database, it is fixed to my machine everytime we change we have to adjust it
$serverName ='localhost:3307';
$userName='root';
$password='';
$dbname='rdbmsclass207';
//connection to databse
$conn = mysqli_connect($serverName, $userName, $password, $dbname);
//checks to see if connection is ok
if ($conn->connect_error) {
    //error message in case of error in connection
    die("Internal Connection Problem. Try again later." . $conn->connect_error);
}
//checks to see if the post method is beign used
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //saves data from the POST
    $username = $_POST['login-email'];
    $password = $_POST['login-password'];
    //this part below selects the data from the user email informed by user
    $stmt = $conn->prepare("SELECT id, userName, email, passwords FROM usersnew WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    //store the result of the query
    $result = $stmt->get_result();
    //if one user is found
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        //chacks to see if the user input password is the same as it is saved in the db
        if (password_verify($password, $row['passwords'])) {
            //if correct password sends the user to index and store the userName in a new variable to be used
            $_SESSION['username'] = $row['userName']; 
            //send the user to a new page
            header('Location: index.php');
            exit();
            //if wrong password exits and prints message
        } else {
            echo "Wrong Password";
        }
    } else {
        //if wrong user exits and prints message
        echo "User does not exist. Please sign up";
    }
    $stmt->close();
}

    $conn->close();
?>
