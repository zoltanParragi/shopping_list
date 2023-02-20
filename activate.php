<?php
session_start();
ini_set("error_reporting", 1);
require('config.php');

$token = $_GET["token"];

$user_in_db_row = mysqli_query($connection, "select * from users where verification_token = '$token'");

if( mysqli_num_rows($user_in_db_row) === 1 ) {
    $date = date('Y.m.d , H:i:s');
    mysqli_query($connection, "update users set email_verified_at='$date' where verification_token ='$token'");

    
    $_SESSION["flash"]["activate"] = ['value' => 'Sikeres megerősítetted a regisztrációdat. <br><br> Most már be tudsz lépni a fiókodba.', 'type' => 'successmsg'];
    

    if($err = mysqli_error($connection)){
        exit($err);
    }
} else {
    $_SESSION["flash"]["activate"] = ['value' => 'A regisztráció megerősítése nem volt sikeres. <br><br> Próbáld újra vagy lépj kapcsolaba az adminnal.', 'type' => 'errormsg'];
}


header("location: activation_response.php");