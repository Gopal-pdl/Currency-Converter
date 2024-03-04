<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $mysqli = new mysqli("localhost", "root", "", "currency_converter");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("DELETE FROM currency_rates WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
} else {
    header("Location: dashboard.php");
    exit;
}
?>
