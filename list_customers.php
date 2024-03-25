<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "id22006574_admin";
$password = "@Admin001";
$db_name = "id22006574_utswplab";
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Retrieve customer data
$sql = "SELECT * FROM customer WHERE user_id = '$user_id' ORDER BY FIELD(customer_stat, 'favourite') DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>

<head>
    <title>List Customers</title>
    <style>
        body {
            background-color: #1a1a1a;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #fff;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #333;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        a {
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-align: center;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
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
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['customer_name'] . "</td>";
                echo "<td>" . $row['customer_company'] . "</td>";
                echo "<td>" . $row['customer_phone'] . "</td>";
                echo "<td>" . $row['customer_email'] . "</td>";
                echo "<td>" . $row['customer_stat'] . "</td>";
                echo "<td><a href='delete_customer.php?customer_id=" . $row['customer_id'] . "'>Delete</a><a href='edit_customer.php?customer_id=" . $row['customer_id'] . "'>Edit</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No customers found</td></tr>";
        }
        ?>
    </table>
    <a href="index.php">Back to Index</a>
</body>

</html>
<?php
// Close connection
$conn->close();
?>