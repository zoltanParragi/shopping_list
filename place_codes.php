<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Hely kódok</title>
</head>
<body>
    <?php include 'header.php';?>
    <main>
        <h1>Hely kódok</h1>
        <div id="placeCodes"></div>
    </main>
    <?php include 'footer.php';?>

    <script src="getPlaceCodes.js"></script>
    <script src="script.js"></script>
</body>
</html>