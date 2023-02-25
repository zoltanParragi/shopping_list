<header>
    <nav>
        <div id="logo">
            <a href="index.php"><img src="images/logo.png" width="80px" alt="logo"></a>
        </div>
        <ul>
            <li><a href="index.php">Kezdőoldal</a></li>
            <?php
                if(isset($_SESSION["user"])){
            ?>
                <li><a href="profile.php"><?php print($_SESSION["user"]["name"])?></a></li>
                <li><a href="place_codes.php">Kódok</a></li>
                <li><a href="logout.php">Kilépés</a></li>
            <?php
                } else {
            ?>   
                <li><a href="login.php">Belépés</a></li>
                <li><a href="register.php">Regisztráció</a></li>
            <?php
                }
            ?>
        </ul>
        <div id="hamburger">
            <img src="images/hamburger.png" width="30" alt="hamburger icon">
        </div>
    </nav>
    <div id="mobileMenu">
        <div><img src="images/closeWhite.png" width="25" alt="close button"></div>
        <div><a href="index.php">Kezdőoldal</a></div>
        <?php
            if(isset($_SESSION["user"])){
        ?>
            <div><a href="profile.php"><?php print($_SESSION["user"]["name"])?></a></div>
            <div><a href="logout.php">Kilépés</a></div>
        <?php
            } else {
        ?>   
            <div><a href="login.php">Belépés</a></div>
            <div><a href="register.php">Regisztráció</a></div>
        <?php
            }
        ?>
    </div>
</header>