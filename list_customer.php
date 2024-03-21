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

$user_id = $_SESSION['user_id'];

// Retrieve customer data
$sql = "SELECT * FROM customer WHERE user_id = '$user_id' ORDER BY FIELD(customer_stat, 'favourite') DESC";
$result = $mysqli->query($sql);

$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>List Customers</title>
</head>
<body>
    <h2>List Customers</h2>
    <table border="1">
        <tr>
            <th>Customer Name</th>
            <th>Customer Company</th>
            <th>Customer Phone</th>
            <th>Customer Email</th>
            <th>Marking</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['customer_name'] . "</td>";
                echo "<td>" . $row['customer_company'] . "</td>";
                echo "<td>" . $row['customer_phone'] . "</td>";
                echo "<td>" . $row['customer_email'] . "</td>";
                echo "<td>" . $row['customer_stat'] . "</td>";
                echo "<td><a href='delete_customer.php?customer_id=" . $row['customer_id'] . "'>Delete</a> | <a href='edit_customer.php?customer_id=" . $row['customer_id'] . "'>Edit</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No customers found</td></tr>";
        }
        ?>
    </table>
</body>
</html
