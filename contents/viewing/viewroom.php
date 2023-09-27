<?php
include "config.php"; // Load in any variables

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

// Insert DB code from here onwards
// Check if the connection was successful
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; // Stop processing the page further
}

// Do some simple validation to check if 'id' exists
$id = $_GET['id'];
if (empty($id) or !is_numeric($id)) {
    echo "<h2>Invalid Room ID</h2>"; // Simple error feedback
    exit;
}

// Prepare a query and send it to the server
// NOTE: For simplicity purposes ONLY, we are not using prepared queries.
// Make sure you ALWAYS use prepared queries when creating custom SQL like below
$query = 'SELECT * FROM room WHERE roomid=' . $id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
?>

<?php
// Makes sure we have the Room
if ($rowcount > 0) {
    echo "<fieldset><legend>Room detail #$id</legend><dl>";
    $row = mysqli_fetch_assoc($result);
    echo "<dt>Room name:</dt><dd>" . $row['roomname'] . "</dd>" . PHP_EOL;
    echo "<dt>Description:</dt><dd>" . $row['description'] . "</dd>" . PHP_EOL;
    echo "<dt>Room type:</dt><dd>" . $row['roomtype'] . "</dd>" . PHP_EOL;
    echo "<dt>Sleeps:</dt><dd>" . $row['beds'] . "</dd>" . PHP_EOL;
    echo '</dl></fieldset>' . PHP_EOL;
} else {
    echo "<h2>No Room found!</h2>"; // Suitable feedback
}
mysqli_free_result($result); // Free any memory used by the query
mysqli_close($db_connection); // Close the connection once done
?>
</body>

</html>
