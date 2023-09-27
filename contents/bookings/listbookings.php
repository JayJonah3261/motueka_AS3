<?php
// Include database configuration file
include "config.php";

// Establish a database connection
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

// Check Database connection
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}

// Query to retrieve booking data
$query = 'SELECT b.bookingID, b.checkInDate, b.checkOutDate, r.roomname, c.firstname, c.lastname FROM Booking b
          INNER JOIN room r ON b.roomID = r.roomID
          INNER JOIN customer c ON b.customerID = c.customerID';
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);

// Check if there are bookings
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookingID = $row['bookingID'];
        $roomname = $row['roomname'];
        $checkInDate = $row['checkInDate'];
        $checkOutDate = $row['checkOutDate'];
        $customerName = $row['firstname'] . ' ' . $row['lastname'];

        // Display booking information in a table row
        echo '<tr>';
        echo '<td>' . $roomname . ', ' . $checkInDate . ', ' . $checkOutDate . '</td>';
        echo '<td>' . $customerName . '</td>';
        echo '<td>';
        // Create links for viewing, editing, and deleting bookings
        echo '<a href="viewbookings.php?id=' . $bookingID . '">View</a> ';
        echo '<a href="editbooking.php?id=' . $bookingID . '">Edit</a> ';
        echo '<a href="' . $bookingID . '">Manage Reviews</a> ';
        echo '<a href="deletebookings.php?id=' . $bookingID . '">Delete</a> ';
        echo '</td>';
        echo '</tr>';
    }
} else {
    // Display a message when no bookings are found
    echo '<tr><td colspan="3">No bookings found!</td></tr>';
}

mysqli_free_result($result);
mysqli_close($db_connection);
?>
