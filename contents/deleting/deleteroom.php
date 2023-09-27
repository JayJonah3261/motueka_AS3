<?php
include "config.php"; // Load in any variables
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}

// Function to clean input but not validate type and content
function cleanInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Retrieve the Room ID from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid Room ID</h2>"; // Simple error feedback
        exit;
    }
}

// Check if the form was submitted for deletion
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Delete')) {
    $error = 0; // Clear our error flag
    $msg = 'Error: ';
    // Room ID (sent via a form it is a string not a number so we try a type conversion!)
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
        $id = cleanInput($_POST['id']);
    } else {
        $error++; // Bump the error flag
        $msg .= 'Invalid Room ID '; // Append error message
        $id = 0;
    }

    // Save the Room data if the error flag is still clear and Room id is > 0
    if ($error == 0 and $id > 0) {
        $query = "DELETE FROM room WHERE roomID=?";
        $stmt = mysqli_prepare($db_connection, $query); // Prepare the query
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Room details deleted.</h2>";
    } else {
        echo "<h2>$msg</h2>" . PHP_EOL;
    }
}

// Prepare a query and send it to the server
$query = 'SELECT * FROM room WHERE roomID=' . $id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
?>

<!-- Include the HTML content here -->
<?php include '/deleteroom.html'; ?>
