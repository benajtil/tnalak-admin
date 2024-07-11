<?php
session_start();
require('../db/db_connection.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "You must be logged in to access this page.";
    header("Location: ../index.php");
    exit;
}

$user_query = "SELECT role, name FROM user WHERE id = ?";
$stmt = $conn->prepare($user_query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($role, $judge_name);
$stmt->fetch();
$stmt->close();

if ($role !== 1) {
    $_SESSION['error_message'] = "You do not have permission to score.";
    exit;
}

if (!isset($_GET['entry_num'])) {
    echo "No contestant selected.";
    exit;
}

$entry_num = $_GET['entry_num'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deduction</title>
    <link rel="stylesheet" href="../float/css/judgeTable.css?v=1.0">
</head>
<body>
<?php 
    include ('../float/include/navigation.php');
?>
<div class="container">
<div class="contestantname"> 
    <h1><?php echo '<strong>Contestant ' . htmlspecialchars($entry_num) . '</strong>'; ?> </h1>
</div>
    <h1>FLOAT COMPETITION: DEDUCTION</h1>
    <form action="submit_deduction.php" method="post" onsubmit="return confirmSubmission()">
        <input type="hidden" id="entry_num" name="entry_num" value="<?php echo htmlspecialchars($entry_num); ?>">
        <div class="form-group">
            <label for="deduction_points">Deduction Points:</label>
            <input id="deduction_points" name="deduction_points" type="number" min="1" max="100" placeholder="1-100" required>
        </div>
        <div class="buttons">
            <button type="submit">Submit</button>
        </div>
    </form>
    <div id="message" style="display:none;"></div>
</div>
<div class="background">
    <img src="../images/tnalakbg.png" alt="t`nalak Background">
</div>

<script>
    function confirmSubmission() {
        return confirm('Are you sure you want to submit?');
    }
</script>
<script src="../float/js/judgeTable.js"></script>
</body>
</html>
