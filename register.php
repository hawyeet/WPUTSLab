<?php
include("connect.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists
    $checkQuery = $conn->prepare("SELECT COUNT(*) as count FROM user WHERE username = ?");
    $checkQuery->bind_param("s", $username);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Username already exists
        echo '<script>
            alert("Username already exists. Please choose a different username.");
            window.location.href = "register.php";
        </script>';
        exit;
    }

    // Fetch the number of entries in the user table
    $countResult = $conn->query("SELECT COUNT(*) as count FROM user");
    $countRow = $countResult->fetch_assoc();
    $count = $countRow['count'];

    // Assign an ID (assuming the ID is an integer with a maximum length of 4)
    $newId = ($count < 9999) ? $count + 1 : 1;

    // Use prepared statement to prevent SQL injection
    $userInsertStmt = $conn->prepare("INSERT INTO user (user_id, username, password) VALUES (?, ?, ?)");
    $userInsertStmt->bind_param("iss", $newId, $username, $hashedPassword); // Store hashed password

    // Execute the user insertion statement
    $userInsertStmt->execute();

    $userInsertStmt->close();

    // Redirect to login page after successful registration
    header("Location: login.php");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
    body {
        background-color: #1a1a1a;
        color: #fff;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .login-container {
        background-color: #333;
        padding: 20px;
        border-radius: 10px;
        width: 300px;
        margin: 100px auto;
    }

    .login-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-container form {
        display: flex;
        flex-direction: column;
    }

    .login-container label {
        margin-bottom: 10px;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        background-color: #555;
        color: #fff;
        outline: none;
    }

    .login-container input[type="submit"] {
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        outline: none;
    }

    .login-container input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .login-container a {
        color: #fff;
        text-decoration: none;
        text-align: center;
        display: block;
        margin-top: 10px;
        /* Added margin top */
    }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Registration Form</h2>
        <form name="form" action="register.php" method="post" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="user" name="username" required></br></br>

            <label for="password">Password:</label>
            <input type="password" id="pass" name="password" required></br></br>

            <input type="submit" id="btn" value="Register" name="submit">
            <a href="login.php">Already have an account? Login.</a>
        </form>
    </div>
</body>

</html>