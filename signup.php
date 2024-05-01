<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "user") or die(mysqli_error($con));

// Initialize variables for form submission
$username = $email = $password = $confirm_password = $mobile_number = $pin = '';
$errors = array();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $pin = mysqli_real_escape_string($con, $_POST['pin']);

    // Validate username, email, password, mobile number, and PIN...
    
    // Validate username
    if (empty($username)) {
        $errors['username'] = "Username is required";
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters";
    }

    // Validate confirm password
    if ($password != $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    // Validate mobile number
    if (empty($mobile_number)) {
        $errors['mobile_number'] = "Mobile number is required";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobile_number)) {
        $errors['mobile_number'] = "Invalid mobile number";
    }

    // Validate PIN
    if (empty($pin)) {
        $errors['pin'] = "PIN is required";
    } elseif (!preg_match("/^[0-9]{4}$/", $pin)) {
        $errors['pin'] = "Invalid PIN";
    }

    // If no validation errors, proceed with checking for existing user and inserting data into the database
    if (empty($errors)) {
        // Check if user already exists
        $query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $result = mysqli_query($con, $query);
        $user = mysqli_fetch_assoc($result);
        if ($user) {
            if ($user['username'] === $username) {
                $errors['username'] = "Username already exists";
                header("login.php");
            }
            if ($user['mobile_number'] === $mobile_number) {
                $errors['mobile_number'] = "Mobile number already exists";
                header("login.php");
            }
            if ($user['email'] === $email) {
                $errors['email'] = "Email already exists";
                header("login.php");
            }
        } else {
            // Generate a 14-digit ID
            $id = mt_rand(10000000000000, 99999999999999);

            // Insert user data into the database
            $sql = "INSERT INTO users (id, username, email, password, mobile_number, pin) VALUES ('$id', '$username', '$email', '$password', '$mobile_number', '$pin')";
            mysqli_query($con, $sql) or die(mysqli_error($con));

            // Generate PDF of user data
            require_once('tcpdf.php'); // Include TCPDF library

            // Create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Set document information
             // Set document information
        $pdf->SetCreator('LibraryManager.com');
        $pdf->SetAuthor('LibraryManager.com');
        $pdf->SetTitle($username);
        $pdf->SetSubject($id);
        $pdf->SetKeywords('TCPDF, PDF, user, data');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Add a page
        $pdf->AddPage();

        // Set font for the PDF document
        $pdf->SetFont('times', '', 12);

        // Add HTML content to PDF
        $html = '<br><br>
        <img src="file:///C:/xampp_2/htdocs/library/WhatsApp%20Image%202024-04-23%20at%203.25.28%20PM(1)(1).png">
            <center><h1>Signup Data</h1></center><br><br>
            <center><h2>Your credentials</h2></center><br><br>
            <center><p>Your data for the LibraryManager.com domain, store it for future use.</p></center>
            <p>Date of Generation: ' . date('d-m-Y H:i:s', time() + 5.5 * 3600) . '</p><br><br>
            <p>ID: ' . $id . '</p>
            <p>Username: ' . $username . '</p>
            <p>Email: ' . $email . '</p>
            <p>Mobile Number: ' . $mobile_number . '</p>
            <p>PIN: ' . $pin . '</p>
        ';
            $pdf->writeHTML($html, true, false, true, false, '');

            // Save PDF to a file
            $pdf->Output('user_data_' . $id . '.pdf', 'D'); // Download the PDF file with the name including the user ID

            // Redirect to login.php after signing up
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
}
?>