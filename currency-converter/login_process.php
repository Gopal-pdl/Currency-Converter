<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $mysqli = new mysqli("localhost", "root", "", "currency_converter");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if ($password === $user["password"]) {
            $_SESSION["username"] = true;
            header("Location: dashboard.php");
            exit;
        } else {
            header("Location: login_error.php?error=password");
            exit;
        }
    } else {
        header("Location: login_error.php?error=user");
        exit;
    }
}
?>
