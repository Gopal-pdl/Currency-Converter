<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currency_from = $_POST["currency_from"];
    $currency_to = $_POST["currency_to"];
    $rate = $_POST["rate"];

    $mysqli = new mysqli("localhost", "root", "", "currency_converter");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("INSERT INTO currency_rates (currency_from, currency_to, rate) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $currency_from, $currency_to, $rate);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
