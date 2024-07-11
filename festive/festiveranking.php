<?php
session_start();
require('../db/db_connection_festive.php');

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

// Query to get users with role 1
$judge_query = "SELECT name FROM user WHERE role = 1";
$judge_stmt = $conn->prepare($judge_query);
if ($judge_stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$judge_stmt->execute();
$judge_stmt->bind_result($judge);
$judges = [];
while ($judge_stmt->fetch()) {
    $judges[] = $judge;
}
$judge_stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUDGING SHEET</title>
    <link rel="stylesheet" href="/festive/css/festive.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        .top10 {
            background-color: blue;
            color: white;
        }

        .judge-signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .judge-signature {
            text-align: center;
            width: 45%;
        }

        .judge-signature .line {
            border-bottom: 1px solid black;
            margin-bottom: 5px;
        }

        .button {
            display: inline-block;
            border-radius: 4px;
            background-color: #e7ecef;
            border: none;
            color: #030404;
            text-align: center;
            font-size: 28px;
            padding: 20px;
            width: 200px;
            transition: all 0.5s;
            cursor: pointer;
            margin: 5px;
        }

        .button span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }

        .button span:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }

        .button:hover span {
            padding-right: 25px;
        }

        .button:hover span:after {
            opacity: 1;
            right: 0;
        }

        .no-underline {
            text-decoration: none;
        }
    </style>
</head>

<body>
<div class="deductionn">
                    </div>
    <div class="tnalaklogo">
        <img src="../tnalak.png" alt="t'nalak image">
    </div>

    <div class="overall">
        <a href="judgesfestive.php"><button class="judging">Tabulation Sheet</button></a>
        <a href="overallfestive.php"><button>Judging Sheet</button></a>
        <a href="overallscoreswithname.php"><button>Tab with Names</button></a>

    </div>

    <div class="emblem">
        <img src="../emblem.png" alt="t'nalak image">
    </div>

    <div class="container_festive">
        <h1>FESTIVE COMPETITION</h1>
        <h1>JUDGING SHEET</h1>
        <div class="judge-signatures">
            <?php 
            $judgeCount = 1;
            foreach ($judges as $judge) : ?>
                <div class="judge-signature" style="font-family:Kanit, sans-serif; text-decoration:none">
                    <a href="/festive/indivfestive.php?judge=<?php echo htmlspecialchars($judge); ?>" class="no-underline">
                        <img src="/images/tnalakfest.png" style="height:auto; width:70%" alt="">
                        <p style="font-size:100%"><?php echo htmlspecialchars($judge); ?></p>
                    </a>
                    <p style="font-size:20px">Judge <?php echo $judgeCount; ?></p>
                </div>
            <?php 
            $judgeCount++;
            endforeach; ?>
        </div>
    </div>
</body>

</html>
