<?php
include "config.php"; // Load in any variables
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

// Check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; // Stop processing the page further
}

// Prepare a query and send it to the server
$query = 'SELECT roomID, roomname, roomtype FROM room ORDER BY roomtype';
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
?>