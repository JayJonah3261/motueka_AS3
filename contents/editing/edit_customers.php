<?php
include "config.php"; // Load in any variables
include "cleaninput.php";

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
$error = 0;

// Check if the connection was successful
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; // Stop processing the page further
}

// Retrieve the customer ID from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid Customer ID</h2>"; // Simple error feedback
        exit;
    }
}

// Check if the form was submitted for updating
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
    // Validate incoming data - only the first field is done for you in this example - the rest is up to you to validate
    $error = 0; // Clear our error flag
    $msg = 'Error: ';

    // Customer ID (sent via a form, it is a string not a number so we try a type conversion!)
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
        $id = cleanInput($_POST['id']);
    } else {
        $error++; // Bump the error flag
        $msg .= 'Invalid Customer ID '; // Append error message
        $id = 0;
    }

    // First name
    $firstname = cleanInput($_POST['firstname']);

    // Last name
    $lastname = cleanInput($_POST['lastname']);

    // Email
    $email = cleanInput($_POST['email']);

    // Save the customer data if the error flag is still clear and customer ID is > 0
    if ($error == 0 and $id > 0) {
        $query = "UPDATE customer SET firstname=?, lastname=?, email=? WHERE customerID=?";
        $stmt = mysqli_prepare($db_connection, $query); // Prepare the query
        mysqli_stmt_bind_param($stmt, 'sssi', $firstname, $lastname, $email, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Customer details updated.</h2>";
    } else {
        echo "<h2>$msg</h2>";
    }
}

// Locate the customer to edit by using the customer ID
// We also include the customer ID in our form for sending it back for saving the data
$query = 'SELECT customerID, firstname, lastname, email FROM customer WHERE customerid=' . $id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);

// Include the HTML content
include 'editcustomer.html';

mysqli_close($db_connection); // Close the connection once done
?>
