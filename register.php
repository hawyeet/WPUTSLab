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
        
            echo "Registration successful! Your ID is: " . sprintf('%04d', $newId);
            
        } else {
            echo "Sorry, there was an error uploading your file.";
            
        }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="resource/css/style.css">
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
    </form>
</div>
</body>
</html>
