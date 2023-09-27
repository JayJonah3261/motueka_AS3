<?php
include "cleaninput.php";

if (isset($_POST['submit']) && !empty($_POST['submit']) && ($_POST['submit'] == 'Add')) {
    include "config.php";
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit;
    }

    $error = 0;
    $msg = 'Error: ';

    if (isset($_POST['roomname']) && !empty($_POST['roomname']) && is_string($_POST['roomname'])) {
        $fn = cleanInput($_POST['roomname']);
        $roomname = (strlen($fn) > 50) ? substr($fn, 1, 50) : $fn;
    } else {
        $error++;
        $msg .= 'Invalid roomname ';
        $roomname = '';
    }

    $description = cleanInput($_POST['description']);
    $roomtype = cleanInput($_POST['roomtype']);
    $beds = cleanInput($_POST['beds']);

    if ($error == 0) {
        $query = "INSERT INTO room (roomname,description,roomtype,beds) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($db_connection, $query);
        mysqli_stmt_bind_param($stmt, 'sssd', $roomname, $description, $roomtype, $beds);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>New room added to the list</h2>";
    } else {
        echo "<h2>$msg</h2>";
    }
    mysqli_close($db_connection);
}
?>
