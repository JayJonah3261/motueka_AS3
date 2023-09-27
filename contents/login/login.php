<?php
session_start();
include "config.php"; // Include your database connection configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];

    if ($role === 'customer') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $table = 'customer';
        $id_column = 'customerID';
        $password_column = 'password';
    } elseif ($role === 'admin') {
        $username = $_POST['admin_username'];
        $password = $_POST['admin_password'];
        $table = 'administrators';
        $id_column = 'admin_id';
        $password_column = 'password';
    } else {
        // Handle invalid role
        echo "Invalid role.";
        exit();
    }

    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit();
    }

    $query = "SELECT $id_column, $password_column FROM $table WHERE ";

    if ($role === 'customer') {
        $query .= "email = ?";
        $stmt = mysqli_prepare($db_connection, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
    } elseif ($role === 'admin') {
        $query .= "username = ?";
        $stmt = mysqli_prepare($db_connection, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row[$password_column])) {
            // Password is correct; create a session and redirect to a protected page
            $_SESSION['user_id'] = $row[$id_column];
            $_SESSION['role'] = $role;
            header("Location: index.php"); // Redirect to a protected page
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "User not found. Please try again.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db_connection);
}
?>