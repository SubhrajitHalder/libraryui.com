<?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "user") or die(mysqli_error($con));

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];

// Validate username and password
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    // Authentication successful
    $_SESSION['username'] = $username;
    header("Location: welcome.php");
} else {
    // Authentication failed
    echo "Invalid username or password";
}

mysqli_close($con);
?>
