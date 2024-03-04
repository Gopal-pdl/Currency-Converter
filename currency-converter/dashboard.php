
<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["username"] !== true) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin: 20px;

        }

        .btn:hover {
            background-color: #45a049;
        }

        .logout-btn-container {
            text-align: center; 
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Currency Converter Dashboard</h2>

        <h3>Add Currency Rate</h3>
        <form action="add_currency_rate.php" method="post">
            <label for="currency_from">From Currency:</label>
            <input type="text" id="currency_from" name="currency_from" required>
            <label for="currency_to">To Currency:</label>
            <input type="text" id="currency_to" name="currency_to" required>
            <label for="rate">Rate:</label>
            <input type="number" id="rate" name="rate" step="any" required>
            <input type="submit" value="Add" class="btn">
        </form>

        <h3>List of Currency Rates</h3>
        <table>
            <thead>
                <tr>
                    <th>From Currency</th>
                    <th>To Currency</th>
                    <th>Rate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mysqli = new mysqli("localhost", "root", "", "currency_converter");
                if ($mysqli->connect_error) {
                    die("Connection failed: " . $mysqli->connect_error);
                }

                $query = "SELECT * FROM currency_rates";
                $result = $mysqli->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["currency_from"] . "</td>";
                        echo "<td>" . $row["currency_to"] . "</td>";
                        echo "<td>" . $row["rate"] . "</td>";
                        echo "<td>";
                        echo "<a href='update_currency_rate.php?id=" . $row["id"] . "' class='btn'>Update</a>";
                        echo "<a href='delete_currency_rate.php?id=" . $row["id"] . "' class='btn'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No currency rates found.</td></tr>";
                }

                $mysqli->close();
                ?>
            </tbody>
        </table>
        <div class="logout-btn-container">
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>
</body>

</html>