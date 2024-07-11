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

if (isset($_GET['entry_num'])) {
    $_SESSION['last_clicked_entry_num'] = $_GET['entry_num'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Judge Panel</title>
    <link rel="stylesheet" href="../festive/css/navigation.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lastClickedEntryNum = '<?php echo isset($_SESSION["last_clicked_entry_num"]) ? $_SESSION["last_clicked_entry_num"] : ""; ?>';
            if (lastClickedEntryNum) {
                const lastClickedPanel = document.querySelector(`.panel[data-entry-num="${lastClickedEntryNum}"]`);
                if (lastClickedPanel) {
                    lastClickedPanel.classList.add("clicked");
                }
            }

            document.querySelectorAll(".panel").forEach(panel => {
                panel.addEventListener("click", function() {
                    if (this.classList.contains("clicked")) return;

                    document.querySelectorAll(".panel").forEach(p => p.classList.remove("clicked"));
                    this.classList.add("clicked");
                    const entryNum = this.getAttribute("data-entry-num");
                    localStorage.setItem("lastClickedEntryNum", entryNum);
                    window.location.href = "judgeTableFestive.php?entry_num=" + entryNum;
                });
            });
        });
    </script>
</head>
<style>
    .panel.clicked {
        background-color: rgb(68, 133, 255); 
        transform: translateY(2px); 
        pointer-events: none;
    }
</style>
<body>
    <div class="sidebyside">
        <div class="sidebar">
            <div class="eulaplogo">
                <img src="../images/eulaplogo.png" alt="Eulap image">
            </div>

            <?php
            $sql = "SELECT entry_num FROM contestant";
            $result = $conn->query($sql);

            if ($result === false) {
                die('Query failed: ' . htmlspecialchars($conn->error));
            }

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $entry_num = $row["entry_num"];
                    $class = '';

                    $checkJudgeScoreSql = "SELECT * FROM scores WHERE entry_num = ? AND judge_name = ?";
                    $stmt = $conn->prepare($checkJudgeScoreSql);

                    if ($stmt === false) {
                        die('Prepare failed: ' . htmlspecialchars($conn->error));
                    }

                    $stmt->bind_param("ss", $entry_num, $judge_name);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        $class = 'scored';
                    }

                    $stmt->close();

                    echo '<a href="judgeTableFestive.php?entry_num=' . htmlspecialchars($entry_num) . '" class="panel ' . $class . '" data-entry-num="' . htmlspecialchars($entry_num) . '"><strong>Contestant ' . htmlspecialchars($entry_num) . '</strong></a>';
                }
            } else {
                echo '<p>No contestants found</p>';
            }

            $conn->close();
            ?>

            <form method="post" action="../logout.php">
                <div class="logout-button">
                    <button type="submit" name="logout"><strong>LOGOUT</strong></button>
                </div>
                <div class="judgeName">
                    <h1>Welcome, <?php echo htmlspecialchars($judge_name); ?></h1>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
