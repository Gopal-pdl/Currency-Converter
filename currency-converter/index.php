<?php
$mysqli = new mysqli("localhost", "root", "", "currency_converter");
 $query_result= '';
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT DISTINCT currency_from FROM currency_rates ORDER BY currency_from";
$result = $mysqli->query($query);
$currencies_from = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $currencies_from[] = $row['currency_from'];
    }
}

$query = "SELECT DISTINCT currency_to FROM currency_rates ORDER BY currency_to";
$result = $mysqli->query($query);
$currencies_to = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $currencies_to[] = $row['currency_to'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    $from_currency = $_POST["from_currency"];
    $to_currency = $_POST["to_currency"];

    if (isset($currencies_from[$from_currency]) && isset($currencies_to[$to_currency])) {
        $query_result = convertCurrency($amount, $currencies_from[$from_currency], $currencies_to[$to_currency]);
    } else {
        $query_result = "Invalid currencies selected.";
    }
}

function convertCurrency($amount, $from, $to)
{
    global $mysqli;
    $query = "SELECT rate FROM currency_rates WHERE currency_from='$from' AND currency_to='$to'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $amount * $row['rate'];
    } else {
        return "Conversion rate not available.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 400px;
            max-width: 100%;
        }

        h2 {
            margin-top: 0;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="number"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Currency Converter</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="number" name="amount" placeholder="Amount" required><br>
            <select name="from_currency" required>
                <option value="">Select From Currency</option>
                <?php
                foreach ($currencies_from as $index => $currency) {
                    echo "<option value='$index'>$currency</option>";
                }
                ?>
            </select><br>
            <select name="to_currency" required>
                <option value="">Select To Currency</option>
                <?php
                foreach ($currencies_to as $index => $currency) {
                    echo "<option value='$index'>$currency</option>";
                }
                ?>
            </select><br>
            <input type="submit" value="Convert">
        </form>
        <div class="result"><?php echo $query_result; ?></div>
    </div>
</body>
</html>

