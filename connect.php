<?php
$servername = "localhost";
$username = "id22006574_admin";
$password = "@Admin001";
$db_name = "id22006574_utswplab";
$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
    die("code 0 : " . $conn->connect_error);
}
