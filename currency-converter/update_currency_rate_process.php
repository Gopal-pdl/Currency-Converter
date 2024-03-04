<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $currency_from = $_POST["currency_from"];
    $currency_to = $_POST["currency_to"];
    $rate = $_POST["rate"];

    $mysqli = new mysqli("localhost", "root", "", "currency_converter");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("UPDATE currency_rates SET currency_from=?, currency_to=?, rate=? WHERE id=?");
    $stmt->bind_param("ssdi", $currency_from, $currency_to, $rate, $id);

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
