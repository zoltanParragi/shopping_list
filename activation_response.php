<?php
    session_start();

    require('config.php');

    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    //exit(print_r($_SESSION["flash"]["activate"], 1));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Aktiváció visszaigazolás</title>
</head>
<body>
    <?php include 'header.php';?>
    <main>
        <h1>Regisztráció megerősítése</h1>
        <section>
            <?php print($_SESSION["flash"]["activate"]['value'])?>
        </section>
    </main>
    <?php include 'footer.php';?>
    
    <script src="script.js"></script>
</body>
</html>
<?php unset($_SESSION["flash"]);?>