<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Logout functionality
if(isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS ||<?php echo $_SESSION['username']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .card span{
        font-size: 25px;
        color: #fff;
        background-color: crimson;
        border-radius: 10px;
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .card p{
        font-size: 22px;
    }
</style>
<style>
    /* Dark Theme Styles */
    body {
      background-color: #fff;
      color: #000000;
      font-family: 'Poppins', sans-serif;
    }
    .navbar-dark .navbar-nav .nav-link {
      color: #ffffff;
    }
    .navbar-dark .navbar-nav .nav-link:hover {
      color: #6366f1;
    }
    .navbar-dark .navbar-toggler-icon {
      background-color: transparent;
    }
    .navbar-dark .navbar-toggler {
      border-color: #d1d5db;
    }
    .nav-item:hover{
      border-radius: 6px;
      background-color: #fff;
    }
    .navbar-dark .navbar-brand {
      color: #ffffff;
      display: flex;
      align-items: center;
    }
    .navbar-dark .navbar-brand:hover {
      color: #ffffff;
    }
    .dropdown-menu {
      background-color: #0062ec;
      border: none;
    }
    .dropdown-menu .dropdown-item {
      color: #ffffff;
    }
    .dropdown-menu .dropdown-item:hover {
      background-color: #064bbb;
      color: #f3f4f6;
    }
    .form-control {
      background-color: #fff;
    }
    .form-control:focus {
      background-color: #1f2937;
      border-color: #6366f1;
      color: #d1d5db;
    }
    .search-btn {
      background-color: #6366f1;
      border: 1px solid #ffffff;
      color: #fff;
    }
    .search-btn:hover {
      background-color: #ffffff;
      border: 1px solid #ffffff;
      color: #1f2937;
    }
    .navbar-brand{
      margin-left: 15%;
    }
    .navbar-nav{
      margin-left: 10%;
    }
    .navbar-brand span{
      font-size: 25px;
      color: #ffffff;
    }
    .d-flex{
      margin-left: 10%;
    }
    .heading{
      margin-top: 25%;
      margin-bottom: 5%;
      font-size: 35px;
      font-weight: 400;
      color: #000000;
    }
    .heading span{
      color: rgb(255, 0, 98);
    }
    .first{
      margin-left: 5%;
      width: 45%;
    }
    .second{
      width: 45%;
    }
    .btn-join{
      margin-top: 5%;
      outline: none;
      border: none;
      background-color: #6366f1;
    }
    .intro-p span{
      color: rgb(255, 0, 98);
      cursor: pointer;
    }
    .intro-p span:hover{
      text-decoration: underline;
    }
    .first-section{
        height: 100vh;
     }
    @media screen and (max-width: 800px) {
      body{
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
      }
      .first{
        width:100%;
        text-align: center;
        margin-left: 0;
        height: 80vh;
      }
      .intro-p{
        width: 80%;
        margin-left: auto;
        margin-right: auto;
      }
      .second{
        margin-top: 80vh;
        width: 100%;
        height: 100vh;
      }
      .second img{
        width: 80%;
        margin-left: auto;
        margin-right: auto;
      }
      .nav-item{
        padding-left: 5%;
      }
      .d-flex{
        margin-top: 5%;
      }
      .first-section{
        height: 100%;
      }
      .second img{
        height: 0;
        display: none;
      }
      .second{
        display: none;
      }
    }
    .section-two{
      height: 100vh;
      background-color: #dee3eb;
    }
    .navbar{
      background-color: #6366f1;
    }
    .navbar i{
      margin-right: 2%;
    }
    .second img{
      width: 70%;
      margin-top: 10%;
      margin-left: 10%;
    }
  </style>
  <nav class="navbar navbar-expand-lg navbar-dark">
  <script src="https://kit.fontawesome.com/a2d8d61300.js" crossorigin="anonymous"></script>
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="fa-solid fa-bookmark"></i> Library<span>Manager</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Library</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Need help?
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Help</a></li>
              <li><a class="dropdown-item" href="#">Support</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Contact Us</a></li>
            </ul>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success search-btn" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <style>
    /* Adjust sidebar width and color */
    .sidebar {
      position: fixed;
      top: 20%;
      left: 0;
      height: 60%;
      background-color: #fff;
      box-shadow: 5px 10px 15px gray;
      width: 250px; /* Adjust as needed */
      padding-top: 50px; /* Adjust top padding */
    }
    a{
        text-decoration: none;
    }
    /* Adjust sidebar link styling */
    .sidebar a {
      padding: 10px 15px;
      display: block;
      color: #333; /* Adjust link color */
    }

    /* Add active class to current/active link */
    .sidebar a.active {
      background-color: goldenrod; /* Adjust active link background color */
      color: #fff; /* Adjust active link text color */
    }
    .sidebar a.active i{
        margin-left: 5%;
    }
    .sidebar a.active:hover{
        background-color: crimson;
    }
    .sidebar a:hover{
        background-color: #007bff;
        color: #fff;
    }
    #one{
        left: 82%;
    }
  </style>
<body class="bg-light">
    <div class="container" style="display: flex;">
    <br><br>
<div class="sidebar mt-10">
    <h2 class="text-center">Your Section</h2>
  <a href="profile.php">Profile</a>
  <a href="create_database.php">Create Table</a>
  <a href="get_data.php">Your books</a>
  <a href="library.php">Add books</a>
  <a href="#" class="active">Manage books<i class="fa-solid fa-star"></i></a>
  <a href="news.php">Announcements</a>
</div>

    </div>
    <div class="container mt-5">
        <div class="card p-4 mx-auto" style="max-width: 500px;">
            <h2 class="mb-4 text-center">Welcome</h2>
            <p>Welcome, <span><?php echo $_SESSION['username']; ?></span></p>
            <form action="" method="post">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
    <div class="sidebar mt-10" id="one">
    <h2 class="text-center">Profile</h2>
    <div class="image" style="font-size: 55px; color: gray; text-align: center;"><i class="fa-solid fa-user"></i></div><br>
    <div class="name text-center"><?php echo $_SESSION['username']; ?></div>
</div>
    </div>
    
    
</body>
</html>
