<?php
// Include your database connection configuration (config.php)
include "config.php";

// Check if fromDate and toDate are provided via POST
if (isset($_POST['fromDate']) && isset($_POST['toDate'])) {
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];

    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit;
    }

    // Perform SQL query to find available rooms
    $query = "SELECT * FROM room WHERE roomID NOT IN (
        SELECT roomID FROM booking
        WHERE checkInDate >= '$fromDate'
        AND checkOutDate <= '$toDate'
    )";

    $result = mysqli_query($db_connection, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Display available rooms
            echo "<h2>Available Rooms:</h2>";
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>" . $row['roomname'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No available rooms found for the selected dates.</p>";
        }
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($db_connection);
    }

    mysqli_close($db_connection);
}
?>