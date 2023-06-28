<?php
    session_start();
    
    require('config.php');

    ini_set("display_errors", 0);
    error_reporting(~E_ALL);

    $user = mysqli_fetch_assoc(mysqli_query($connection, "select * from users where id = '".$_SESSION["user"]["id"]."'"));
  
    function getinput($key, $user) {
        if(isset($_SESSION["flash"]["post"][$key])){
            print($_SESSION["flash"]["post"][$key]??'');
        } else {
            print($user[$key]??'');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Profilom</title>
</head>
<body>
    <?php include 'header.php';?>    
    <?php
        if(isset($_SESSION["flash"]["msg"])){
    ?>
        <div class="<?php print $_SESSION["flash"]["msg"]["type"]?>">
            <?php 
                foreach($_SESSION["flash"]["msg"]["value"] as $value){
                    print "<p>$value</p>";
                }
            ?>
        </div>
    <?php
        }
    ?>
    <main>    
    <div class="mainWrapper">
        <h1>Profilom</h1>
        <h4>Adatok módosítása</h4>
        <br>
        <form action="server.php" method="post">
            <label for="name">Név: </label>
            <input type="text" value="<?php getinput("name", $user) ?>" name="name" id="name" placeholder="Add meg a neved!">
            <br><br>
            <label for="name">Email: </label>
            <input type="text" value="<?php getinput("email", $user) ?>" name="email" id="email" placeholder="Add meg az email címed!">
            <input type="text" name="referrer_page" value="profile" style="display: none">
            <br><br>
            <button>Mentés</button>
        </form>
    </div>
    </main>
    <?php include 'footer.php';?>
    
    <script src="script.js"></script>
</body>
</html>
<?php unset($_SESSION["flash"]);?>