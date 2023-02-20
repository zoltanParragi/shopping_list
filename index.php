<?php
    session_start();

    require('config.php');

    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    /* 
        ini_set("display_errors", 0);
        error_reporting(~E_ALL);
    */

    /* $connection = mysqli_connect("localhost", "root", "1234", "test");
    if($err = mysqli_connect_error()) {
        exit($err);
    } */
    
    $list = mysqli_fetch_all(mysqli_query($connection, "select * from list"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Bevásárló lista</title>
</head>
<body>
    <?php include 'header.php';?>
    <main>
        <h1>Bevásárló lista</h1>
        
        <?php
            if(isset($_SESSION["user"])){
        ?>
            <div id="listItemForm">
                <div><img src="images/closeBlack.png" width="24px" alt="close button"></div>
                <h2>Vásárolni való hozzáadása</h2>
                <form action="server.php" method="post">
                    <label for="description">Leírás: </label>
                    <input type="text" id="description" name="description" value="<?php print($_SESSION["flash"]["post"]["description"]??'')?>"><br><br>
                    <label for="place_code">Helykód:</label>
                    <input type="text" id="place_code" name="place_code"  value="<?php print($_SESSION["flash"]["post"]["place_code"]??'')?>"><br><br>
                    <input type="text" id="referrer_page" name="referrer_page"  value="index" style="display: none;">
                    <button>Hozzáad</button>
                </form>
            </div>
            <table>
                <tr>
                    <th>Leírás</th>
                    <th>H.</th>
                    <th>K.</th>
                    <th>T.</th>
                </tr>
                <?php
                    usort($list, function($a, $b) {
                        return $a[2] <=> $b[2];
                    });
                    foreach($list as $key => $item){
                ?>
                <tr id="<?php print($item[0]) ?>" data-description="<?php print($item[1]) ?>">
                    <?php
                        foreach($item as $key_item => $item_data) {
                            if( $key_item !== 0) { 
                                print "<td>$item_data</td>";
                            }
                        }
                    ?>
                    <td class="inTrolley"><img src="images/trolley.png" width="25px" alt="trolley icon"></td>
                    <td class="del"><img src="images/deleteIcon.png" width="25px" alt="delete icon"></td>
                </tr>
                <?php } ?>
            </table>
            
            <button id="addListItem">Hozzáadás</button>

            <section id="delConfirmationPopup">
                <h2>Bitztosan törlöd?</h2>
                <div></div>
                <button>Mégsem</button>
                <a href=""><button>Igen</button></a>
            </section>
        <?php
            } else {
        ?>
            <div>
                <p>A lista megtekintéséhez be kell jelentkezned.</p>
            </div>
        <?php
            }
        ?>
    </main>
    <footer></footer>
    <script src="script.js"></script>
</body>
</html>
<?php unset($_SESSION["flash"]);?>