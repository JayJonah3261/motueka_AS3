<?php
// Connect to the database (Replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "motueka";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from the form
$roomname = $_POST["roomname"];
$roomtype = $_POST["roomtype"];
$beds = empty($_POST["beds"]) ? null : $_POST["beds"];
$checkInDate = $_POST["checkInDate"];
$checkOutDate = $_POST["checkOutDate"];
$contactNumber = $_POST["contactNumber"];
$bookingExtras = $_POST["bookingExtras"];
$description = $_POST['description'];

// Insert the data into the database
$sql = "INSERT INTO booking (checkInDate, checkOutDate, contactNumber, bookingExtras) VALUES ('$checkInDate', '$checkOutDate', '$contactNumber', '$bookingExtras')";

$sql = "INSERT INTO room (roomname, roomtype, description) VALUES ('$roomname', '$roomtype', '$description')";


if ($conn->query($sql) === TRUE) {
    echo "Booking added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
