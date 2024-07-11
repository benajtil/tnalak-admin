<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUDGING SHEET</title>
    <link rel="stylesheet" href="/float/css/float.css?v=1.0">
    <style>
        .top10 {
            background-color: white;
            color: black;
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
        <h1>FLOAT COMPETITION</h1>
        <h1>Overall Results</h1>
        <table>
            
        </table>
        <table class="criteria">
            <thead class="criteriamain">
                <tr>
                    <th>Entry No.</th>
                    <th>Overall Appearance and Impact (30%)
                        <p>(Overall look, aesthetic value, and attractiveness of the float)</p>
                    </th>
                    <th>Artistry/Design (20%)
                        <p>(Concept and artistic merits of the design and costumes if there is/are any taking into account balance, proportion, emphasis, harmony as primarily reflected in shapes/image and colors)</p>
                    </th>
                    <th>Craftsmanship (30%)
                        <p>(This pertains to how the design is realized and how the float is made. Such factors to be considered are the quality of the craftsmanship, stability of structure and decoration, choice, and creative use of materials)</p>
                    </th>
                    <th>Relevance to the Festive Theme (20%)
                        <p>("Onward South Cotabato: Dreaming Big, Weaving more progress. Rising above challenges")</p>
                    </th>
                    <th>Total</th>
                    <th>Ranking</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'fetch_scores.php';
                foreach ($scores as $score) {
                    $class = $score['ranking'] <= 10 ? 'top10' : '';
                    echo "<tr class='{$class}'>";
                    echo "<td>" . htmlspecialchars($score['entry_num']) . "</td>";
                    echo "<td>" . htmlspecialchars($score['avg_oa']) . "</td>";
                    echo "<td>" . htmlspecialchars($score['avg_ad']) . "</td>";
                    echo "<td>" . htmlspecialchars($score['avg_cr']) . "</td>";
                    echo "<td>" . htmlspecialchars($score['avg_rt']) . "</td>";
                    echo "<td>" . htmlspecialchars($score['avg_total']) . "</td>";
                    echo "<td>" . htmlspecialchars($score['ranking']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>

        </table>
        <table></table>
    </div>

</body>

</html>