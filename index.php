<?php
include("connect.php");
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Customer Management System</title>
    <style>
        body {
            background-color: #1a1a1a;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            margin-bottom: 30px;
            text-align: center;
        }

        .menu {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .menu a {
            display: block;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .menu a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome <?php echo $_SESSION['username']; ?></h1>
        <div class="menu">
            <a href="add_customer.php">Add Customer</a>
            <a href="list_customers.php">List Customers</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>

</html>