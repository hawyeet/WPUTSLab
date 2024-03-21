<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle registration form submission
    // Validate input and insert new user into database
    // Assuming registration logic here
    $username = $_POST['root'];
    $password = $_POST[''];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Connect to database
    $mysqli = new mysqli("localhost", "username", "password", "customer_management");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Check if username already exists
    $check_username_sql = "SELECT * FROM user WHERE username = '$username'";
    $check_username_result = $mysqli->query($check_username_sql);
    if ($check_username_result->num_rows > 0) {
        echo "Username already exists";
    } else {
        // Insert new user
        $insert_user_sql = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
        if ($mysqli->query($insert_user_sql) === TRUE) {
            echo "Registration successful";
        } else {
            echo "Error: " . $insert_user_sql . "<br>" . $mysqli->error;
        }
    }

    $mysqli->close();
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
