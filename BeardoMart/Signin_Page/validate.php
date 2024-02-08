<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_startup_errors',1);
ini_set('display_errors',1);

$servername = "localhost"; // The server name for XAMPP is usually 'localhost'
$username = "root"; // Default username for XAMPP is 'root'
$password = ""; // Default password for XAMPP is blank
$database = "beardomart"; // Replace with the name of your database

// Create a connection
$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $loginUsername = mysqli_real_escape_string($connection, $_POST['loginUsername'] ) ;
    $loginPassword = mysqli_real_escape_string($connection, $_POST['loginPassword']);

    // Validate the username (contains only characters, spaces, and dots)
    if (!preg_match('/^[a-zA-Z. ]+$/', $loginUsername)) {
        echo "Invalid username format.";
    } else {
        // Check if the username exists in the database
        $query = "SELECT * FROM beardomart.users WHERE uname = '$loginUsername' AND password1='$loginPassword'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 0) {
            echo "No User Exists, Please Sign-Up";
        } else if ( mysqli_num_rows($result) == 1 ) {
            header('location: Product_View/productview.html');
        } else {
                echo "Password is incorrect.";
        }
    }
}


if (isset($_POST['signup'])) {
    $signupUsername = $_POST['signupUsername'];
    $signupEmail = $_POST['signupEmail'];
    $signupPassword = $_POST['signupPassword'];

    // Validate the username, email, and password
    if (!preg_match('/^[a-zA-Z. ]+$/', $signupUsername)) {
        echo "Invalid username format.";
    } elseif (!filter_var($signupEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif (!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{5,}$/', $signupPassword)) {
        echo "Password must contain at least 5 characters, 1 special character, and 1 number.";
    } else {

        // Insert the user data into the database
        $insertQuery = "INSERT INTO beardomart.users (uname, email, password1) VALUES ('$signupUsername', '$signupEmail', '$signupPassword')";
        $insertResult = mysqli_query($connection, $insertQuery);

        if ($insertResult) {
            // Successful signup, redirect to another HTML file
            header("Location: Product_View/productview.html");
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
}

mysqli_close($connection);

?>


