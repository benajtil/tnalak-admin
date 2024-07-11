<?php
session_start()

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TNALAKTABULATION</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/splash.css?v=1.0">

</head>
<style>
    button a {
        text-decoration: none;
        color: black;
    }
    button a:hover{
        text-decoration: none;
        color: white;
    }
</style>

<body>
    <div class="backvid">
        <video autoplay loop muted>
            <source src="tnalakattemp02.mp4" type="video/mp4">
            
        </video>
        <!-- <img src="tnnn.png" alt=""> -->    
    </div>

    <div class="buttons">
        <button class="button" style="width:20%; margin-top:45%; margin-left: 0%; font-family:Josefin Sans; vertical-align:middle;"><a href="float/judgeTable.php">Float Competition</a></button>
        <button class="button" style="width:20%; margin-top:45%; margin-left: 10%; font-family:Josefin Sans; vertical-align:middle;"><a href="festive/judgeTableFestive.php">Most Festive Contingent</a></button>
    </div>
    <!-- Your content here -->
    <div class="content">
        <!-- Your HTML content goes here -->
    </div>
</body>

</html>