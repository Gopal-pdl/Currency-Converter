<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Currency Rate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], input[type="submit"] {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Currency Rate</h2>
        <form action="update_currency_rate_process.php" method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <label for="currency_from">From Currency:</label>
            <input type="text" id="currency_from" name="currency_from" value="EUR" required>
            <label for="currency_to">To Currency:</label>
            <input type="text" id="currency_to" name="currency_to" value="USD" required>
            <label for="rate">Rate:</label>
            <input type="number" id="rate" name="rate" step="any" value="1.20" required>
            <input type="submit" value="Update Rate">
        </form>
    </div>
</body>
</html>
