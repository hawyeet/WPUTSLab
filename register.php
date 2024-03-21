<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "utswplab";
    $conn = new mysqli($servername, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL query
    $check_username_sql = "SELECT * FROM user WHERE username = '$username'";
    $check_username_result = $conn->query($check_username_sql);

    if ($check_username_result === FALSE) {
        echo "Error: " . $conn->error;
    } else {
        if ($check_username_result->num_rows > 0) {
            echo "Username already exists";
        } else {
            $insert_user_sql = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
            if ($conn->query($insert_user_sql) === TRUE) {
                echo "Registration successful";
            } else {
                echo "Error: " . $insert_user_sql . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
