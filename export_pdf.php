<?php
require_once('tcpdf.php'); // Include TCPDF library

// Get table name from URL parameter
$tablename = $_GET['tablename'];

// Database connection
$con = mysqli_connect("localhost", "root", "", "user") or die(mysqli_error($con)); // Establish database connection or display error message if connection fails

// Retrieve data from table
$sql_select = "SELECT * FROM $tablename"; // SQL query to select all data from table
$result_select = mysqli_query($con, $sql_select); // Execute SQL query to select data

// Initialize $columns variable
$columns = array();

if ($result_select && mysqli_num_rows($result_select) > 0) {
    // Get column names from database
    $sql_columns = "SHOW COLUMNS FROM $tablename"; // SQL query to retrieve column names of the specified table
    $result_columns = mysqli_query($con, $sql_columns); // Execute SQL query to retrieve column names

    if ($result_columns) {
        // Loop through each row of the result set
        while ($row = mysqli_fetch_assoc($result_columns)) {
            // Add column name to array
            $columns[] = $row['Field'];
        }
    }
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// Register Poppins font with TCPDF
// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Subhrajit Halder');
$pdf->SetTitle('LibraryManager.com');
$pdf->SetSubject('Export the data of the books.');
$pdf->SetKeywords('TCPDF, PDF, table, data, export');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Add logo
$pdf->Image('file:///C:/xampp_2/htdocs/library/WhatsApp%20Image%202024-04-23%20at%203.25.28%20PM(1)(1).png', 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

// Add heading
$pdf->SetFont('times', 'B', 16);
$pdf->Cell(0, 10, 'Table Data Export', 0, 1, 'C');

// Add paragraph
$pdf->SetFont('times', '', 12);
$pdf->MultiCell(0, 10, 'This PDF contains the data from the table ' . $tablename, 0, 'C');

// Add table
$pdf->SetFont('times', '', 12);
$pdf->Ln();
$pdf->SetFont('times', 'B', 12);

// Header
$header = array();
foreach ($columns as $column) {
    $header[] = ucfirst($column);
}
$pdf->SetFont('times', 'B', 10);
$pdf->Write(0, implode("   ", $header), '', 0, 'L', true, 0, false, false, 0);

// Data
$pdf->SetFont('times', '', 10);
$pdf->Ln();

if ($result_select && mysqli_num_rows($result_select) > 0) {
    while ($row = mysqli_fetch_assoc($result_select)) {
        foreach ($columns as $column) {
            $pdf->Cell(40, 8, $row[$column], 1);
        }
        $pdf->Ln();
    }
}

// Close and output PDF
$pdf->Output('listed-data.pdf', 'D');
