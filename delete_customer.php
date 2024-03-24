<?php
session_start();
include("connect.php");

// Redirect to login if user is not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if customer ID is provided in the URL
if (!isset($_GET['customer_id']) || empty($_GET['customer_id'])) {
    header("Location: list_customers.php");
    exit();
}

// Get customer ID from the URL
$customer_id = $_GET['customer_id'];

// Get the username from session
$username = $_SESSION['username'];

// Prepare SQL statement to delete the customer
$sql = "DELETE FROM customer WHERE customer_id = ? AND user_id = (SELECT user_id FROM user WHERE username = ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters to the placeholders
$stmt->bind_param("is", $customer_id, $username);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to the list customers page after successful deletion
    header("Location: list_customers.php");
    exit();
} else {
    // If deletion fails, display an error message
    echo "Error: " . $stmt->error;
}

// Close the statement
$stmt->close();

// Close the connection
$conn->close();
