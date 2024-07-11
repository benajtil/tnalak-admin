<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUDGING SHEET</title>
    <link rel="stylesheet" href="/float/css/float.css?v=1.0">
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
        require('../db/db_connection.php');

        // Prepare the SQL query to fetch scores for the selected judge
        $query = "SELECT entry_num, overall_appearance, artistry_design, craftsmanship, relevance_theme FROM scores WHERE judge_name = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("s", $judge);
        $stmt->execute();
        $stmt->bind_result($entry_num, $overall_appearance, $artistry_design, $craftsmanship, $relevance_theme);

        echo "<table>";
        echo "<thead><tr><th>Entry No.</th><th>Overall Appearance and Impact (30%) <p>(Overall look, aesthetic value, and attractiveness of the float)</p> </th><th>Artistry/Design (20%) <p>(Concept and artistic merits of the design and costumes if there is/are any taking into account balance, proportion, emphasis, harmony as primarily reflected in shapes/image and colors)</p> </th><th>Craftsmanship (30%) <p>(This pertains to how the design is realized and how the float is made. Such factors to be considered are the quality of the craftsmanship, stability of structure and decoration, choice, and creative use of materials)</p> </th><th>Relevance to the Festive Theme (20%) <p>Onward South Cotabato: Dreaming Big, Weaving more progress. Rising above challenges</p> </th><th>Total</th></tr></thead>";
        echo "<tbody>";

    
        // Display each contestant's scores
        while ($stmt->fetch()) {
            $total_score = $overall_appearance + $artistry_design + $craftsmanship + $relevance_theme;
            echo "<tr>";
            echo "<td>" . htmlspecialchars($entry_num) . "</td>";
            echo "<td>" . htmlspecialchars($overall_appearance) . "</td>";
            echo "<td>" . htmlspecialchars($artistry_design) . "</td>";
            echo "<td>" . htmlspecialchars($craftsmanship) . "</td>";
            echo "<td>" . htmlspecialchars($relevance_theme) . "</td>";
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