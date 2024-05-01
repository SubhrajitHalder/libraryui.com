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
    // Get table name and column details from form
    $tablename = mysqli_real_escape_string($con, $_POST['tablename']); // Get table name from form and escape special characters
    $num_columns = $_POST['num_columns']; // Get number of columns from form

    // Create table with columns
    $columns = array(); // Initialize an empty array to store column names
    for ($i = 1; $i <= $num_columns; $i++) { // Loop through each column number specified by the user
        $column_name = mysqli_real_escape_string($con, $_POST["column{$i}"]); // Get column name from form and escape special characters
        array_push($columns, "`$column_name` VARCHAR(255) NOT NULL"); // Add column name to array with appropriate SQL syntax
    }
    $sql_create_table = "CREATE TABLE $tablename (" . implode(', ', $columns) . ")"; // SQL query to create table with specified columns
    if (mysqli_query($con, $sql_create_table)) { // Execute SQL query to create table
        // Redirect to library.php
        header("Location: library.php"); // Redirect user to library.php after successful table creation
        exit(); // Stop script execution
    } else {
        echo "<p>Error creating table: " . mysqli_error($con) . "</p>"; // Display error message if creating table fails
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <style>
        .container{
            box-shadow: 5px 10px 15px gray;
        }
    </style>
    <div class="container mt-5 col-md-5"><br>
        <h1 class="mb-4">Create Table</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="tablename" class="form-label">Enter Table Name:</label>
                <input type="text" id="tablename" name="tablename" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="num_columns" class="form-label">Number of Columns:</label>
                <input type="number" id="num_columns" name="num_columns" class="form-control" min="1" required>
            </div>
            
            <div id="columnDetails" style="display: none;">
                <h3 class="mb-3">Column Details:</h3>
                <div id="columnInputs"></div>
            </div>
            
            <button type="button" onclick="addColumnInputs()" class="btn btn-primary">Add Column Details</button><br><br>
            <button type="submit" id="submitBtn" style="display: none;" class="btn btn-success">Create Table</button>
        </form>
    </div>

    <script>
        function addColumnInputs() {
            var numColumns = document.getElementById('num_columns').value;
            var columnInputs = document.getElementById('columnInputs');
            columnInputs.innerHTML = '';

            for (var i = 1; i <= numColumns; i++) {
                var label = document.createElement('label');
                label.setAttribute('for', 'column' + i);
                label.innerText = 'Column ' + i + ' Name:';
                columnInputs.appendChild(label);

                var input = document.createElement('input');
                input.setAttribute('type', 'text');
                input.setAttribute('id', 'column' + i);
                input.setAttribute('name', 'column' + i);
                input.setAttribute('class', 'form-control');
                input.setAttribute('required', true);
                columnInputs.appendChild(input);

                columnInputs.appendChild(document.createElement('br'));
                columnInputs.appendChild(document.createElement('br'));
            }

            var submitBtn = document.getElementById('submitBtn');
            submitBtn.style.display = 'block';

            var columnDetails = document.getElementById('columnDetails');
            columnDetails.style.display = 'block';
        }
    </script>
</body>
</html>
