<?php
session_start();

// If user is already logged in, redirect to welcome page
if(isset($_SESSION['username'])) {
    header("Location: welcome.php");
    exit();
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "user") or die(mysqli_error($con));

// Retrieve form data
if(isset($_POST['username']) && isset($_POST['password'])) {
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 mx-auto" style="max-width: 500px;">
            <h2 class="mb-4 text-center">Login</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" required required autocomplete="off">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" required required autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
