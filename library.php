<?php
session_start(); // Start the session to track user login status

// Database connection
$con = mysqli_connect("localhost", "root", "", "user") or die(mysqli_error($con)); // Establish database connection or display error message if connection fails

// Check if user is logged in
if (!isset($_SESSION['username'])) { // Check if username is set in session (i.e., if user is logged in)
    header("Location: login.php"); // Redirect user to login page if not logged in
    exit(); // Stop script execution
}

// Retrieve user details from session
$username = $_SESSION['username']; // Get username from session

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if form is submitted via POST method
    // Get table name from form
    $tablename = mysqli_real_escape_string($con, $_POST['tablename']); // Get table name from form and escape special characters
    
    // Get column names from database
    $sql_columns = "SHOW COLUMNS FROM $tablename"; // SQL query to retrieve column names of the specified table
    $result_columns = mysqli_query($con, $sql_columns); // Execute SQL query to retrieve column names
    $columns = array(); // Initialize an empty array to store column names
    while ($row = mysqli_fetch_assoc($result_columns)) { // Loop through each row of the result set
        $columns[] = $row['Field']; // Add column name to array
    }

    // Insert data into table
    $values = array(); // Initialize an empty array to store values
    foreach ($columns as $column) { // Loop through each column
        if(isset($_POST[$column])) { // Check if the key exists in the form data
            $value = mysqli_real_escape_string($con, $_POST[$column]); // Get value of the corresponding column from form and escape special characters
            $values[] = "'$value'"; // Add value to array with appropriate SQL syntax
        } else {
            $values[] = "NULL"; // Add NULL value if key does not exist in the form data
        }
    }
    $sql_insert = "INSERT INTO `$tablename` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ")";
    if (mysqli_query($con, $sql_insert)) { // Execute SQL query to insert data
        echo "<p>Data inserted successfully.</p>"; // Display success message
    } else {
        echo "<p>Error inserting data: " . mysqli_error($con) . "</p>"; // Display error message if inserting data fails
    }
}
?>

<?php
// Hide error messages
ini_set('display_errors', 0);
error_reporting(0);

// Your PHP code here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .container{
            width: 50%;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 5px 10px 15px gray;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Books</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body><br>
    <div class="container mt-5 col-md-5"><br>
        <h1 class="mb-4 mt-2 txt-center">Library</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="tablename" class="form-label">Enter Table Name:</label>
                <input type="text" id="tablename" name="tablename" class="form-control" required autocomplete="off">
            </div>
            <?php foreach ($columns as $column): ?>
            <div class="mb-3">
                <label for="<?php echo $column; ?>" class="form-label"><?php echo ucfirst($column); ?>:</label>
                <input type="text" id="<?php echo $column; ?>" name="<?php echo $column; ?>" class="form-control" required autocomplete="off">
            </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Insert Data</button>
            <br><br>
        </form>
    </div>
    <script>
        function validate(){
            window.open("welcome.php");
        }
    </script>
</body>
</html>
