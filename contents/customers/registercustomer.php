<!DOCTYPE HTML>
<html>

<head>
  <title>Register new customer</title>
  <link rel="stylesheet" type="text/css" href="registercustomer.css">

</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
    </style>

<body>
<?php
include "config.php"; // Include your database connection configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit;
    }

    $query = "INSERT INTO customer (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db_connection, $query);

    // Bind parameters and execute the query
    mysqli_stmt_bind_param($stmt, 'ssss', $firstname, $lastname, $email, $hashedPassword);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . mysqli_error($db_connection);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db_connection);
}
?>

  <h1>New Customer Registration</h1>
  <h2><a href='listcustomers.php'>[Return to the Customer listing]</a><a href='index.php'>[Return to the main page]</a>
  </h2>

  <form method="POST" action="registercustomer.php">
    <p>
      <label for="firstname">Name: </label>
      <input type="text" id="firstname" name="firstname" minlength="1" maxlength="50" required>
    </p>
    <p>
      <label for="lastname">Last Name: </label>
      <input type="text" id="lastname" name="lastname" minlength="1" maxlength="50" required>
    </p>
    <p>
      <label for="email">Email: </label>
      <input type="email" id="email" name="email" maxlength="100" size="50" required>
    </p>
    <p>
      <label for="password">Password: </label>
      <input type="password" id="password" name="password" minlength="8" maxlength="250" required>
    </p>

    <input type="submit" name="submit" value="Register">
  </form>
</body>

</html>