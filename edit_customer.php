<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if customer ID is provided in the URL
if (!isset($_GET['customer_id']) || empty($_GET['customer_id'])) {
    header("Location: list_customers.php");
    exit();
}

$customer_id = $_GET['customer_id'];

// Connect to database
$servername = "localhost";
$username = "id22006574_admin";
$password = "@Admin001";
$db_name = "id22006574_utswplab";
// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Retrieve customer data
$sql = "SELECT * FROM customer WHERE user_id = '$user_id' AND customer_id = '$customer_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    // Redirect if customer not found
    header("Location: list_customers.php");
    exit();
}

// Update customer details
if (isset($_POST['submit'])) {
    $customer_name = $_POST['customer_name'];
    $customer_company = $_POST['customer_company'];
    $customer_phone = $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'];
    $customer_stat = $_POST['customer_stat'];

    // Update customer details in the database
    $update_sql = "UPDATE customer SET customer_name = '$customer_name', 
                    customer_company = '$customer_company', 
                    customer_phone = '$customer_phone', 
                    customer_email = '$customer_email',
                    customer_stat = '$customer_stat'
                    WHERE customer_id = '$customer_id' AND user_id = '$user_id'";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: list_customers.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Customer</title>
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

    form {
        width: 60%;
        margin: 20px auto;
        padding: 20px;
        background-color: #333;
        border-radius: 10px;
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"],
    input[type="email"],
    select {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        background-color: #555;
        color: #fff;
        outline: none;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        outline: none;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
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
    <h2>Edit Customer</h2>
    <form method="POST">
        <label for="customer_name">Customer Name</label><br>
        <input type="text" id="customer_name" name="customer_name" value="<?php echo $row['customer_name']; ?>"
            required><br><br>

        <label for="customer_company">Customer Company</label><br>
        <input type="text" id="customer_company" name="customer_company" value="<?php echo $row['customer_company']; ?>"
            required><br><br>

        <label for="customer_phone">Customer Phone</label><br>
        <input type="text" id="customer_phone" name="customer_phone" value="<?php echo $row['customer_phone']; ?>"
            required><br><br>

        <label for="customer_email">Customer Email</label><br>
        <input type="email" id="customer_email" name="customer_email" value="<?php echo $row['customer_email']; ?>"
            required><br><br>

        <label for="customer_stat">Customer Status</label><br>
        <select id="customer_stat" name="customer_stat">
            <option value="normal" <?php if ($row['customer_stat'] == 'normal') echo 'selected'; ?>>Normal</option>
            <option value="favourite" <?php if ($row['customer_stat'] == 'favourite') echo 'selected'; ?>>Favourite
            </option>
        </select><br><br>

        <input type="submit" name="submit" value="Update">
    </form>
    <a href="index.php">Back to Index</a>
</body>

</html>