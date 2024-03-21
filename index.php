<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Management System</title>
</head>
<body>
    <h1>Welcome <?php echo $_SESSION['username']; ?></h1>
    <a href="add_customer.php">Add Customer</a>
    <a href="list_customers.php">List Customers</a>
    <a href="logout.php">Logout</a>
</body>
</html>
