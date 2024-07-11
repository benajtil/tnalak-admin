<?php
session_start();
require('../db/db_connection_festive.php');

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
$festive_spirit = $_POST['festive_spirit'];
$costume_and_props = $_POST['costume_and_props'];
$relevance_to_the_theme = $_POST['relevance_to_the_theme'];
$total_score = $festive_spirit + $costume_and_props + $relevance_to_the_theme;

// Check if the judge has already scored this contestant
$checkJudgeScoreSql = "SELECT * FROM scores WHERE entry_num = ? AND judge_name = ?";
$stmt = $conn->prepare($checkJudgeScoreSql);
$stmt->bind_param("is", $entry_num, $judge_name);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('You have already scored this contestant.'); window.location.href = 'navigation.php';</script>";
    exit;
}
$stmt->close();

// Insert the new score
$insertScoreSql = "INSERT INTO scores (entry_num, judge_name, festive_spirit, costume_and_props, relevance_to_the_theme, total_score) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertScoreSql);
$stmt->bind_param("isiiii", $entry_num, $judge_name, $festive_spirit, $costume_and_props, $relevance_to_the_theme, $total_score);
$stmt->execute();
$stmt->close();

$compiled_scores = $total_score;

$fetchAllScoresSql = "SELECT festive_spirit, costume_and_props, relevance_to_the_theme FROM scores WHERE entry_num = ?";
$stmt = $conn->prepare($fetchAllScoresSql);
$stmt->bind_param("i", $entry_num);
$stmt->execute();
$stmt->bind_result($fsp, $cap, $rt);

$total_fsp = 0;
$total_cap = 0;
$total_rt = 0;
$count = 0;

while ($stmt->fetch()) {
    $total_fsp += $fsp;
    $total_cap += $cap;
    $total_rt += $rt;
    $count++;
}

$stmt->close();

if ($count > 0) {
    $avg_fsp = $total_fsp / $count;
    $avg_cap = $total_cap / $count;
    $avg_rt = $total_rt / $count;
    $avg_compiled_scores = $avg_fsp + $avg_cap + $avg_rt;

    $updateOverallScoresSql = "INSERT INTO overallscores (entry_num, compiled_scores) VALUES (?, ?) ON DUPLICATE KEY UPDATE compiled_scores = ?";
    $stmt = $conn->prepare($updateOverallScoresSql);
    $stmt->bind_param("iii", $entry_num, $avg_compiled_scores, $avg_compiled_scores);
    $stmt->execute();
    $stmt->close();
}

header("Location: judgeTableFestive.php");
exit;
?>
