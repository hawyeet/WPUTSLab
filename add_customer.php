<?php
session_start();
include("connect.php");

// Redirect to login if user is not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle add customer form submission
    // Retrieve form data and insert into database

    // Assuming form handling logic here
    $customer_name = $_POST['customer_name'];
    $customer_company = $_POST['customer_company'];
    $customer_phone = $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'];

    // Get the username from session
    $username = $_SESSION['username'];

    // Prepare SQL statement with placeholders
    $sql = "INSERT INTO customer (user_id, customer_name, customer_company, customer_phone, customer_email) VALUES ((SELECT user_id FROM user WHERE username = ?), ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->bind_param("sssss", $username, $customer_name, $customer_company, $customer_phone, $customer_email);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Customer added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
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
