<?php
session_start();
require('../db/db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$user_query = "SELECT name FROM user WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($judge_name);
$stmt->fetch();
$stmt->close();

$entry_num = $_POST['entry_num'];
$deduction_points = $_POST['deduction_points'];

$insertDeductionSql = "INSERT INTO deductions (entry_num, judge_name, deduction_points) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE deduction_points = ?";
$stmt = $conn->prepare($insertDeductionSql);
$stmt->bind_param("isii", $entry_num, $judge_name, $deduction_points, $deduction_points);
$stmt->execute();
$stmt->close();

header("Location: ../float/overallranking.php");
exit;
?>
