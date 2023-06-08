<?php
    session_start();
    ini_set("display_errors", 0);
    error_reporting(~E_ALL);
    /* 
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
    */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Regisztráció</title>
</head>
<body>
    <?php include 'header.php';?>
    <main>
        <h1>Regisztráció</h1>
        
        <?php
            if(isset($_SESSION["flash"]["register"]["msg"])){
        ?>
            <div class="<?php print $_SESSION["flash"]["register"]["msg"]["type"]?>">
                <?php 
                    foreach($_SESSION["flash"]["register"]["msg"]["value"] as $value){
                        print "<p>$value</p>";
                    }
                ?>
            </div>
        <?php
            }
        ?>
        <form action="server.php" method="post">
            <label for="name">Név: </label><br>
            <input type="text" id="name" name="name" value="<?php print($_SESSION["flash"]["register"]["post"]["name"]??'')?>"><br><br>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email"  value="<?php print($_SESSION["flash"]["register"]["post"]["email"]??'')?>"><br><br>
            <label for="password">Jelszó:</label><br>
            <input type="password"  id="password" name="password"><br><br>
            <label for="password_confirm">Jelszó megerősítése:</label><br>
            <input type="password"  id="password_confirm" name="password_confirm"><br><br>
            <input type="text" name="referrer_page" value="register" style="display: none">
            <button>Elküld</button>
        </form>
    </main>
    <?php include 'footer.php';?>

    <script src="script.js"></script>
</body>
</html>
<?php unset($_SESSION["flash"]);?>