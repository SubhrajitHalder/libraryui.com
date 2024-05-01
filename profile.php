<?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "user") or die(mysqli_error($con));

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user details from database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

// Retrieve user profile details from database (if exists)
$sql_profile = "SELECT * FROM user_two WHERE username='$username'";
$result_profile = mysqli_query($con, $sql_profile);
$user_profile = mysqli_fetch_assoc($result_profile);

// Check if form has been submitted
$form_submitted = false;
if(isset($_POST['submit_profile'])) {
    $form_submitted = true;
    $recovery_email = $_POST['recovery_email'];
    $recovery_mobile = $_POST['recovery_mobile'];
    $full_name = $_POST['full_name'];
    $building = $_POST['building'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pin_code = $_POST['pin_code'];

    // Save data to database
    $sql_update_profile = "INSERT INTO user_two (id, username, recovery_email, recovery_mobile, full_name, building, street, city, state, pin_code) VALUES ('$user[id]', '$username', '$recovery_email', '$recovery_mobile', '$full_name', '$building', '$street', '$city', '$state', '$pin_code') ON DUPLICATE KEY UPDATE recovery_email=VALUES(recovery_email), recovery_mobile=VALUES(recovery_mobile), full_name=VALUES(full_name), building=VALUES(building), street=VALUES(street), city=VALUES(city), state=VALUES(state), pin_code=VALUES(pin_code)";
    if (mysqli_query($con, $sql_update_profile)) {
        echo "<script>alert('Profile updated successfully');</script>";
        // Redirect to profile page
        header("Location: profile.php");
        exit();
    } else {
        echo "Error: " . $sql_update_profile . "<br>" . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 mx-auto" style="max-width: 800px;">
            <h2 class="mb-4 text-center">Your Details</h2>
            <form>
                <div class="row mb-3">
                    <label for="inputId" class="col-sm-2 col-form-label">ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputId" value="<?php echo $user['id']; ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputUsername" value="<?php echo $user['username']; ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputUsername" class="col-sm-2 col-form-label">email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputUsername" value="<?php echo $user['email']; ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputUsername" class="col-sm-2 col-form-label">pin</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputUsername" value="<?php echo $user['pin']; ?>" readonly>
                    </div>
                </div>
                <!-- Add more fields as needed (e.g., email, pin, password) -->

            </form>
        </div>
        <div class="card mt-5 p-4 mx-auto" style="max-width: 800px;">
            <h2 class="mb-4 text-center">Complete Your Profile</h2>
            <form action="" method="post">
                <div class="row mb-3">
                    <label for="inputRecoveryEmail" class="col-sm-2 col-form-label">Recovery Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputRecoveryEmail" required autocomplete="off" name="recovery_email" value="<?php echo $user_profile['recovery_email'] ?? ''; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputRecoveryMobile" class="col-sm-2 col-form-label">Recovery Mobile</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRecoveryMobile" required autocomplete="off" name="recovery_mobile" value="<?php echo $user_profile['recovery_mobile'] ?? ''; ?>" required pattern="[0-9]{10}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputRecoveryMobile" class="col-sm-2 col-form-label">Full Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRecoveryMobile" required autocomplete="off" name="full_name" value="<?php echo $user_profile['full_name'] ?? ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputRecoveryMobile" class="col-sm-2 col-form-label">Building No and Name</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" id="inputRecoveryMobile" required autocomplete="off" name="building" value="<?php echo $user_profile['building'] ?? ''; ?>">
                    </div>
                </div>
                <div class="flex-box" style="display: flex;">
                    
                <div class="row mb-3 col-md-7">
                    <label for="inputRecoveryMobile" class="col-sm-2 col-form-label">Street</label>
                    <div class="col-sm-10 col-md-6" style="margin-left: 12%;">
                        <input type="text" class="form-control" id="inputRecoveryMobile" required autocomplete="off" name="street" value="<?php echo $user_profile['street'] ?? ''; ?>">
                    </div>
                </div>
                <div class="row mb-3 col-md-6" style="margin-left: -5%;">
                    <label for="inputRecoveryMobile" class="col-sm-2 col-form-label">City</label>
                    <div class="col-sm-10 col-md-8">
                        <input type="text" class="form-control" id="inputRecoveryMobile" required autocomplete="off" name="city" value="<?php echo $user_profile['city'] ?? ''; ?>">
                    </div>
                </div>
                </div>
                <div class="flex-box" style="display: flex;">
                    
                <div class="row mb-3 col-md-10">
                    <label for="inputRecoveryMobile" class="col-sm-2 col-form-label">State</label>
                    <div class="col-sm-10 col-md-4" style="margin-left: 4%;">
                        <input type="text" class="form-control" id="inputRecoveryMobile" required autocomplete="off" name="state" value="<?php echo $user_profile['state'] ?? ''; ?>">
                    </div>
                </div>
                <div class="row mb-3 col-md-10" style="margin-left: -30%;">
                    <label for="inputRecoveryMobile" class="col-sm-2 col-form-label">Pin Code</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="tel" class="form-control" id="inputRecoveryMobile" required autocomplete="off" name="pin_code" value="<?php echo $user_profile['pin_code'] ?? ''; ?>" required pattern="[0-9]{6}">
                    </div>
                </div>
                </div>
                <!-- Add more fields as needed -->
                <?php if (!$form_submitted) { ?>
                <div class="row">
                    <div class="col text-center">
                        <button type="submit" name="submit_profile" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                <?php } ?>
            </form>
        </div><br><br>
    </div>
</body>
</html>
