<?php
session_start();
require('./db/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = $conn->prepare("SELECT id, role, password FROM user WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            $_SESSION['judge_id'] = $user['id'];
            
            if ($user['role'] == 1) {
                header("Location: splash.php");
            } elseif ($user['role'] == 2) {
                header("Location: adminDashboard.php");
            } else {
                $_SESSION['error_message'] = "Invalid role.";
                header("Location: index.php");
            }
        } else {
            $_SESSION['error_message'] = "Invalid password.";
            header("Location: index.php");
        }
    } else {
        $_SESSION['error_message'] = "No user found with that username.";
        header("Location: index.php");
    }

    $conn->close();
    exit;
}
