<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "utswplab";
$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
    die("code 0 : " . $conn->connect_error);
}
