<?php
include "config.php"; // Load in any variables
include "cleaninput.php";

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
$error = 0;
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; // Stop processing the page further
}

// Retrieve the roomID from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid room ID</h2>"; // Simple error feedback
        exit;
    }
}

// Check if the form was submitted for updating the room
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
    // Validate incoming data
    $error = 0; // Clear our error flag
    $msg = 'Error: ';

    // RoomID (sent via a form, it is a string not a number, so we try a type conversion)
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
        $id = cleanInput($_POST['id']);
    } else {
        $error++; // Bump the error flag
        $msg .= 'Invalid room ID '; // Append error message
        $id = 0;
    }

    // Room name
    $room_name = cleanInput($_POST['roomname']);

    // Description
    $description = cleanInput($_POST['description']);

    // Room type
    $room_type = cleanInput($_POST['roomtype']);

    // Beds
    $beds = cleanInput($_POST['beds']);

    // Save the room data if the error flag is still clear and room id is > 0
    if ($error == 0 && $id > 0) {
        $query = "UPDATE room SET roomname=?, description=?, roomtype=?, beds=? WHERE roomID=?";
        $stmt = mysqli_prepare($db_connection, $query); // Prepare the query
        mysqli_stmt_bind_param($stmt, 'ssssi', $room_name, $description, $room_type, $beds, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Room details updated.</h2>";
    } else {
        echo "<h2>$msg</h2>";
    }
}

// Locate the room to edit by using the roomID
// We also include the room ID in our form for sending it back for saving the data
$query = 'SELECT roomID, roomname, description, roomtype, beds FROM room WHERE roomID=' . $id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
    $row = mysqli_fetch_assoc($result);
    ?>

    <!-- Include HTML content here -->
    <form method="POST" action="editroom.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <p>
            <label for="roomname">Room name: </label>
            <input type="text" id="roomname" name="roomname" minlength="5" maxlength="50"
                value="<?php echo $row['roomname']; ?>" required>
        </p>
        <p>
            <label for="description">Description: </label>
            <input type="text" id="description" name="description" size="100" minlength="5" maxlength="200"
                value="<?php echo $row['description']; ?>" required>
        </p>
        <p>
            <label for="roomtype">Room type: </label>
            <input type="radio" id="roomtype" name="roomtype" value="S"
                <?php echo $row['roomtype'] == 'S' ? 'checked' : ''; ?>> Single
            <input type="radio" id="roomtype" name="roomtype" value="D"
                <?php echo $row['roomtype'] == 'D' ? 'checked' : ''; ?>> Double
        </p>
        <p>
            <label for="beds">Sleeps (1-5): </label>
            <input type="number" id="beds" name="beds" min="1" max="5" value="1" value="<?php echo $row['beds']; ?>"
                required>
        </p>
        <input type="submit" name="submit" value="Update">
    </form>
    <!-- End of HTML content -->

<?php
} else {
    echo "<h2>Room not found with that ID</h2>"; // Simple error feedback
}
mysqli_close($db_connection); // Close the connection once done
?>
