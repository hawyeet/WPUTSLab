<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to database
$mysqli = new mysqli("localhost", "username", "password", "customer_management");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle add customer form submission
    // Retrieve form data and insert into database
    // Assuming form handling logic here
    $customer_name = $_POST['customer_name'];
    $customer_company = $_POST['customer_company'];
    $customer_phone = $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'];

    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO customer (user_id, customer_name, customer_company, customer_phone, customer_email) VALUES ('$user_id', '$customer_name', '$customer_company', '$customer_phone', '$customer_email')";
    if ($mysqli->query($sql) === TRUE) {
        echo "Customer added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
</head>
<body>
    <h2>Add Customer</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Customer Name: <input type="text" name="customer_name" required><br><br>
        Customer Company: <input type="text" name="customer_company" required><br><br>
        Customer Phone: <input type="text" name="customer_phone" required><br><br>
        Customer Email: <input type="email" name="customer_email" required><br><br>
        <input type="submit" value="Add Customer">
    </form>
</body>
</html>
