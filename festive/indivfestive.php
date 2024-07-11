<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUDGING SHEET</title>
    <link rel="stylesheet" href="/festive/css/festive.css">
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
    </style>
</head>

<body>
    <div class="tnalaklogo">
        <img src="../tnalak.png" alt="t'nalak image">
    </div>
    <div class="emblem">
        <img src="../emblem.png" alt="t'nalak image">
    </div>

    <div class="container">
        <?php
        // Retrieve judge name from query string
        $judge = isset($_GET['judge']) ? htmlspecialchars($_GET['judge']) : '';

        // Display judge's scores or perform necessary operations
        // Include database connection
        require('../db/db_connection_festive.php');

        // Prepare the SQL query to fetch scores for the selected judge
        $query = "SELECT entry_num, festive_spirit, costume_and_props, relevance_to_the_theme FROM scores WHERE judge_name = ?";

        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("s", $judge);
        $stmt->execute();
        $stmt->bind_result($entry_num, $festive_spirit, $costume_and_props, $relevance_to_the_theme);

        echo "<table>";
        echo "<thead><tr><th>Entry No.</th><th>Festive Spirit Of Parade Participants (50%) <p>(Festive-feel, Festive-look, Festivity, Color, Use of Liveners, Enthusiasm)</p> </th><th>Costume and Props (30%) <p>(Creativity & Uniqueness)</p> </th><th>Relevance to the Theme (20%) <p>(Theme: Onward South Cotabato: Dreaming Big, Weaving more progress. Rising above challenges)</p> </th><th>Total</th></tr></thead>";
        echo "<tbody>";

    
        // Display each contestant's scores
        while ($stmt->fetch()) {
            $total_score = $festive_spirit + $costume_and_props + $relevance_to_the_theme;
            echo "<tr>";
            echo "<td>" . htmlspecialchars($entry_num) . "</td>";
            echo "<td>" . htmlspecialchars($festive_spirit) . "</td>";
            echo "<td>" . htmlspecialchars($costume_and_props) . "</td>";
            echo "<td>" . htmlspecialchars($relevance_to_the_theme) . "</td>";
            echo "<td>" . htmlspecialchars($total_score) . "</td>";
            echo "</tr>";
            
        }
        echo "</tbody></table>";
        echo "<h2><u>$judge</u></h2>";
        // Close statement and connection
        $stmt->close();
        $conn->close();
        ?>
        <h3>Judge</h3>
    </div>
</body>

</html>