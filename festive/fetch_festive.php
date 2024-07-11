<?php
require('../db/db_connection_festive.php');

// Fetch contestant names
$contestant_query = "SELECT entry_num, name FROM contestant";
$contestant_result = $conn->query($contestant_query);

$entries = [];
if ($contestant_result && $contestant_result->num_rows > 0) {
    while ($row = $contestant_result->fetch_assoc()) {
        $entries[$row['entry_num']] = $row['name'];
    }
} else {
    echo "Error fetching contestants: " . $conn->error;
}

// Fetch scores with deductions and calculate rankings
$sql = "SELECT s.entry_num, 
               c.name AS contestant_name, 
               AVG(s.festive_spirit) AS avg_fsp, 
               AVG(s.costume_and_props) AS avg_cap, 
               AVG(s.relevance_to_the_theme) AS avg_rt, 
               IFNULL(MAX(s.deduction), 0) AS max_deduction, 
               (AVG(s.festive_spirit) + AVG(s.costume_and_props) + AVG(s.relevance_to_the_theme) - IFNULL(MAX(s.deduction), 0)) AS avg_total 
        FROM scores s
        JOIN contestant c ON s.entry_num = c.entry_num
        GROUP BY s.entry_num, c.name
        ORDER BY avg_total DESC";

$result = $conn->query($sql);

$scores = [];
$ranking = 1;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['ranking'] = $ranking++;
        $scores[$row['entry_num']] = $row;
    }
} else {
    echo "Error fetching scores: " . $conn->error;
}

// Fetch detailed scores for each entry
$score_query = "SELECT entry_num, judge_name, total_score FROM scores";
$score_result = $conn->query($score_query);

$all_scores = [];
if ($score_result && $score_result->num_rows > 0) {
    while ($score_row = $score_result->fetch_assoc()) {
        if (!isset($all_scores[$score_row['entry_num']])) {
            $all_scores[$score_row['entry_num']] = [];
        }
        $all_scores[$score_row['entry_num']][$score_row['judge_name']] = $score_row['total_score'];
    }
} else {
    echo "Error fetching detailed scores: " . $conn->error;
}

// Fetch judges
$judge_query = "SELECT id, name FROM user WHERE role = 1 ORDER BY id";
$judge_result = $conn->query($judge_query);

$judges = [];
if ($judge_result && $judge_result->num_rows > 0) {
    while ($judge_row = $judge_result->fetch_assoc()) {
        $judges[] = $judge_row;
    }
} else {
    echo "Error fetching judges: " . $conn->error;
}

$conn->close();
?>
