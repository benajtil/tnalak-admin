
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
$overall_appearance = $_POST['overall_appearance'];
$artistry_design = $_POST['artistry_design'];
$craftsmanship = $_POST['craftsmanship'];
$relevance_theme = $_POST['relevance_theme'];


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


$insertScoreSql = "INSERT INTO scores (entry_num, judge_name, overall_appearance, artistry_design, craftsmanship, relevance_theme) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertScoreSql);
$stmt->bind_param("isiiii", $entry_num, $judge_name, $overall_appearance, $artistry_design, $craftsmanship, $relevance_theme);
$stmt->execute();
$stmt->close();


$compiled_scores = $overall_appearance + $artistry_design + $craftsmanship + $relevance_theme;


$fetchAllScoresSql = "SELECT overall_appearance, artistry_design, craftsmanship, relevance_theme FROM scores WHERE entry_num = ?";
$stmt = $conn->prepare($fetchAllScoresSql);
$stmt->bind_param("i", $entry_num);
$stmt->execute();
$stmt->bind_result($oa, $ad, $cr, $rt);

$total_oa = 0;
$total_ad = 0;
$total_cr = 0;
$total_rt = 0;
$count = 0;

while ($stmt->fetch()) {
    $total_oa += $oa;
    $total_ad += $ad;
    $total_cr += $cr;
    $total_rt += $rt;
    $count++;
}

$stmt->close();

if ($count > 0) {
    $avg_oa = $total_oa / $count;
    $avg_ad = $total_ad / $count;
    $avg_cr = $total_cr / $count;
    $avg_rt = $total_rt / $count;
    $avg_compiled_scores = $avg_oa + $avg_ad + $avg_cr + $avg_rt;

    $updateOverallScoresSql = "INSERT INTO overallscores (entry_num, compiled_scores) VALUES (?, ?) ON DUPLICATE KEY UPDATE compiled_scores = ?";
    $stmt = $conn->prepare($updateOverallScoresSql);
    $stmt->bind_param("iii", $entry_num, $avg_compiled_scores, $avg_compiled_scores);
    $stmt->execute();
    $stmt->close();
}

header("Location: judgeTable.php");
exit;
?>
