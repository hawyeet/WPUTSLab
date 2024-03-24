<!DOCTYPE html>
<html>

<head>
    <title>Add Customer</title>
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

        input[type="text"],
        input[type="email"] {
            width: calc(100% - 20px);
            /* Adjusted width to accommodate padding */
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

        .success-message {
            text-align: center;
            color: green;
        }
    </style>
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
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<div class='success-message'>Customer added successfully</div>";
    }
    ?>
    <a href="index.php">Back to Index</a>
</body>

</html>