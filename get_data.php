<?php
session_start(); // Start the session to track user login status

// Database connection
$con = mysqli_connect("localhost", "root", "", "user") or die(mysqli_error($con)); // Establish database connection or display error message if connection fails

// Check if user is logged in
if (!isset($_SESSION['username'])) { // Check if username is set in session (i.e., if user is logged in)
    header("Location: login.php"); // Redirect user to login page if not logged in
    exit(); // Stop script execution
}

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

    // Retrieve data from table
    $sql_select = "SELECT * FROM $tablename"; // SQL query to select all data from table
    $result_select = mysqli_query($con, $sql_select); // Execute SQL query to select data
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Your Books</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <style>
        .cont-one{
            box-shadow: 5px 10px 15px gray;
            padding-left: 10%;
            padding-right: 10%;
            padding-top: 2%;
            padding-bottom: 2%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <div class="container mt-5"><br>
        <div class="cont-one col-md-5">
        <h1 class="mb-4">Get Data</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="tablename" class="form-label">Enter Table Name:</label>
                <input type="text" id="tablename" name="tablename" class="form-control" required autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary">Get Data</button><br><br>
            <button class="btn btn-primary" onclick="validate()">Home</button><br><br> 
        </form>
        </div><br>

        <?php if (isset($result_select) && mysqli_num_rows($result_select) > 0): ?>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <th><?php echo ucfirst($column); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_select)): ?>
                        <tr>
                            <?php foreach ($columns as $column): ?>
                                <td><?php echo $row[$column]; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="export_pdf.php?tablename=<?php echo $tablename; ?>" class="btn btn-success">Export as PDF</a>
        <?php endif; ?>
    </div>
    <script>
        function validate(){
            window.open("welcome.php");
        }
    </script>
</body>
</html>
