<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

//Get customer ID
$customerID = $_SESSION['customerID'];
include "config.php";
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

// Check connection
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}

$error = 0; // Initialize error flag
$msg = ''; // Initialize error message

// Check if the form was submitted for creating the booking
if (isset($_POST['submit']) && !empty($_POST['submit']) && $_POST['submit'] == 'Add Booking') {
    // Validate data
    var_dump($_POST);
    if (isset($_POST['room']) && !empty($_POST['room']) && is_numeric($_POST['room'])) {
        $roomID = mysqli_real_escape_string($db_connection, $_POST['room']);
    } else {
        $error++;
        $msg .= 'Invalid Room ID. ';
        $roomID = 0;
    }

    // Validate contactNumber
    if (isset($_POST['contactNumber']) && !empty($_POST['contactNumber'])) {
        $contactNumber = mysqli_real_escape_string($db_connection, $_POST['contactNumber']);
    } else {
        $error++;
        $msg .= 'Contact Number is required. ';
    }

    $checkInDate = date('Y-m-d', strtotime($_POST['checkInDate']));
    $checkOutDate = date('Y-m-d', strtotime($_POST['checkOutDate']));
    $bookingExtras = isset($_POST['bookingExtras']) ? mysqli_real_escape_string($db_connection, $_POST['bookingExtras']) : null;

    // Save the booking data if the error flag is still clear and room ID is greater than 0
    if ($error == 0 && $roomID > 0) {
        // Prepare and execute the SQL query to insert the booking data
        $query = "INSERT INTO booking (customerID, roomID, checkInDate, checkOutDate, contactNumber, bookingExtras) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($db_connection, $query);
        mysqli_stmt_bind_param($stmt, 'iissss', $customerID, $roomID, $checkInDate, $checkOutDate, $contactNumber, $bookingExtras);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Booking created successfully.</h2>";
    } else {
        echo "<h2>$msg</h2>";
    }
}

mysqli_close($db_connection);
?>
