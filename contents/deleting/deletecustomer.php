<?php
include "config.php"; // Load in any variables
include "cleaninput.php";

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}

// Retrieve the customer ID from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) || !is_numeric($id)) {
        echo "<h2>Invalid Customer ID</h2>";
        exit;
    }
}

// Check if the form was submitted for deletion
if (isset($_POST['submit']) && !empty($_POST['submit']) && $_POST['submit'] == 'Delete') {
    $error = 0;
    $msg = 'Error: ';

    if (isset($_POST['id']) && !empty($_POST['id']) && is_integer(intval($_POST['id']))) {
        $id = cleanInput($_POST['id']);
    } else {
        $error++;
        $msg .= 'Invalid Customer ID ';
        $id = 0;
    }

    if ($error == 0 && $id > 0) {
        $query = "DELETE FROM customer WHERE customerID=?";
        $stmt = mysqli_prepare($db_connection, $query);

        if (!$stmt) {
            die("Error in preparing statement: " . mysqli_error($db_connection));
        }

        mysqli_stmt_bind_param($stmt, 'i', $id);

        if (!mysqli_stmt_execute($stmt)) {
            die("Error in executing statement: " . mysqli_error($db_connection));
        }

        mysqli_stmt_close($stmt);
        echo "<h2>Customer details deleted.</h2>";

    } else {
        echo "<h2>$msg</h2>" . PHP_EOL;
    }
}

// Prepare a query and send it to the server
$query = 'SELECT * FROM customer WHERE customerid=' . $id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
?>

<!-- Include the HTML content here -->
<?php include 'viewcustomer.html'; ?>
