<?php
session_start();
require('../db/db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$user_query = "SELECT name FROM user WHERE id = ?";
$stmt = $conn->prepare($user_query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($judge_name);
$stmt->fetch();
$stmt->close();

$total_scores_query = "
    SELECT 
        s.entry_num, 
        SUM(s.overall_appearance + s.artistry_design + s.craftsmanship + s.relevance_theme) AS total_score 
    FROM scores s
    WHERE s.judge_name = ?
    GROUP BY s.entry_num";
$stmt = $conn->prepare($total_scores_query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("s", $judge_name);
$stmt->execute();
$stmt->bind_result($entry_num, $total_score);
$scores = [];
while ($stmt->fetch()) {
    $scores[] = ['entry_num' => $entry_num, 'total_score' => $total_score];
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Scores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #444;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f9;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #444;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Total Scores Submitted by <?php echo htmlspecialchars($judge_name); ?></h1>
        <table>
            <thead>
                <tr>
                    <th>Contestant Number</th>
                    <th>Total Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores as $score): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($score['entry_num']); ?></td>
                        <td><?php echo htmlspecialchars($score['total_score']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="judgeTable.php">Back to Judging</a>
    </div>
</body>

</html>
