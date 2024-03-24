<?php
include("connect.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $count = $result->num_rows;

    $stmt->close();

    if($count == 1){
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];

            header("Location: index.php");
            exit;
        } 
        else {
            echo '<script>
                alert("Login failed. Incorrect password.");
                window.location.href = "login.php";
            </script>';
            exit;
        }
    } else {
        echo '<script>
            alert("Login failed. User not found.");
            window.location.href = "login.php";
        </script>';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="resource/css/style.css">
</head>
<body>
<div class="login-container">
    <h2>Login Form</h2>
    <form name="form" action="login.php" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" id="user" name="username" required></br></br>

        <label for="password">Password:</label>
        <input type="password" id="pass" name="password" required></br></br>

        <input type="submit" id="btn" value="Login" name="submit">
    </form>
</div>
</body>
</html>
