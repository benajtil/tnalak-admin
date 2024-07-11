<?php
require('../db/db_connection.php'); // Use the correct path to your MySQL connection script

$scores = [];
$all_scores = [];
$judges = [];
$entries = [];

// Fetch contestant names
$contestant_query = "SELECT entry_num, name FROM contestant";
try {
    $contestant_result = $conn->query($contestant_query);

    if ($contestant_result) {
        while ($row = $contestant_result->fetch_assoc()) {
            $entries[$row['entry_num']] = $row['name'];
        }
    } else {
        echo "Error fetching contestants: " . $conn->error;
    }
} catch (Exception $e) {
    echo "SQL error: " . $e->getMessage();
}

// Fetch scores with deductions
$sql = "SELECT entry_num, 
               AVG(overall_appearance) AS avg_oa, 
               AVG(artistry_design) AS avg_ad, 
               AVG(craftsmanship) AS avg_cr, 
               AVG(relevance_theme) AS avg_rt, 
               IFNULL(MAX(deductions), 0) AS max_deduction, 
               (AVG(overall_appearance) + AVG(artistry_design) + AVG(craftsmanship) + AVG(relevance_theme) - IFNULL(MAX(deductions), 0)) AS avg_total 
        FROM scores 
        GROUP BY entry_num 
        ORDER BY avg_total DESC";

try {
    $result = $conn->query($sql);

    if ($result) {
        $ranking = 1;
        while ($row = $result->fetch_assoc()) {
            $row['ranking'] = $ranking++;
            $scores[$row['entry_num']] = $row;
        }
    } else {
        echo "Error fetching scores: " . $conn->error;
    }
} catch (Exception $e) {
    echo "SQL error: " . $e->getMessage();
}

// Fetch judge scores
$score_query = "SELECT entry_num, judge_name, total_score FROM scores";
try {
    $score_result = $conn->query($score_query);

    if ($score_result) {
        while ($score_row = $score_result->fetch_assoc()) {
            if (!isset($all_scores[$score_row['entry_num']])) {
                $all_scores[$score_row['entry_num']] = [];
            }
            $all_scores[$score_row['entry_num']][$score_row['judge_name']] = $score_row['total_score'];
        }
    } else {
        echo "Error fetching judge scores: " . $conn->error;
    }
} catch (Exception $e) {
    echo "SQL error: " . $e->getMessage();
}

// Fetch judges
$judge_query = "SELECT id, name FROM user WHERE role = 1 ORDER BY id";
try {
    $judge_result = $conn->query($judge_query);

    if ($judge_result) {
        while ($judge_row = $judge_result->fetch_assoc()) {
            $judges[] = $judge_row;
        }
    } else {
        echo "Error fetching judges: " . $conn->error;
    }
} catch (Exception $e) {
    echo "SQL error: " . $e->getMessage();
}

$conn->close(); // Close the MySQL connection
?>
