<?php
include "config.php"; // Load in any variables
include "cleaninput.php";

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
$error = 0;
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; // Stop processing the page further
}

// Retrieve the customerID from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid Customer ID</h2>"; // Simple error feedback
        exit;
    }
}

// Check if the form was submitted for updating the customer
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
    // Validate incoming data
    $error = 0; // Clear our error flag
    $msg = 'Error: ';

    // CustomerID (sent via a form, it is a string, so we try a type conversion)
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
        $id = cleanInput($_POST['id']);
    } else {
        $error++; // Bump the error flag
        $msg .= 'Invalid Customer ID '; // Append error message
        $id = 0;
    }

    // First name
    $first_name = cleanInput($_POST['firstname']);

    // Last name
    $last_name = cleanInput($_POST['lastname']);

    // Email
    $email = cleanInput($_POST['email']);

    // Save the customer data if the error flag is still clear and customer id is > 0
    if ($error == 0 && $id > 0) {
        $query = "UPDATE customer SET first_name=?,last_name=?,email=? WHERE customerID=?";
        $stmt = mysqli_prepare($db_connection, $query); // Prepare the query
        mysqli_stmt_bind_param($stmt, 'sssi', $first_name, $last_name, $email, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Customer details updated.</h2>";
    } else {
        echo "<h2>$msg</h2>";
    }
}

// Locate the customer to edit by using the customerID
// We also include the customer ID in our form for sending it back for saving the data
$query = 'SELECT customerID,first_name,last_name,email FROM customer WHERE customerID=' . $id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
    $row = mysqli_fetch_assoc($result);
    ?>

    <!-- Include HTML content here -->
    <form method="POST" action="editcustomer.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <p>
            <label for="first_name">First name: </label>
            <input type="text" id="firstname" name="firstname" minlength="1" maxlength="50" required
                   value="<?php echo $row['first_name']; ?>">
        </p>
        <p>
            <label for="last_name">Last name: </label>
            <input type="text" id="lastname" name="lastname" minlength="1" maxlength="50" required
                   value="<?php echo $row['last_name']; ?>">
        </p>
        <p>
            <label for="email">Email: </label>
            <input type="email" id="email" name="email" maxlength="100" size="50" required
                   value="<?php echo $row['email']; ?>">
        </p>

        <input type="submit" name="submit" value="Update">
    </form>
    <!-- End of HTML content -->

    <?php
} else {
    echo "<h2>Customer not found with that ID</h2>"; // Simple error feedback
}
mysqli_close($db_connection); // Close the connection once done
?>
