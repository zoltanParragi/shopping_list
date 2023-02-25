<?php
session_start();
ini_set("error_reporting", 1);

require('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

/* if($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(403);
    exit;
} */

$post= "";
$get= "";
$description = "";
$referrer_page = "";
$id_to_del = "";

$post = $_POST;
extract($post); 
//user: $name, $email, $password, $password_confirm, $referrer_page = register
//list item: $description, $place_code,  $referrer_page = index

$get = $_GET;
extract($get);
// $referrer_page, $id_to_del

//exit(print_r($post, 1));

switch(true) {
    case ($referrer_page === "index" and $description !== ""):
        mysqli_query($connection, "insert into list (description, place_code) values('$description', '$place_code')");

        if($err = mysqli_error($connection)){
            exit($err);
        }
        
        unset($_SESSION["flash"]);
        unset($_POST);
        header("location: ". $referrer_page.".php");
    break;

    case ($referrer_page === "index" and $id_to_del !== ""):
        mysqli_query($connection, "delete from list where id='".$id_to_del."' limit 1");
        if($err = mysqli_error($connection)){
            exit($err);
        }
        //$_SESSION["flash"]["msg"] = ['value' => ['Sikeres törlés'], 'type' => 'successmsg'];
        //unset($_SESSION["userId_to_del"]);
        unset($_GET);
        header("location: ".$referrer_page.".php");
    break;
    
    case ($referrer_page === "register"):
        $errors = Array();
        $length = mb_strlen(trim($name), 'UTF-8');
        if($length < 3 or $length > 30) {
            $errors[] = "A név hossza legalább 3 és legfeljebb 30 karakter.";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Az email cím nem megfelelő.";
        } else {
            $result = mysqli_query($connection, "select id from users where email ='$email'");
            $found = mysqli_num_rows($result);
            if( $found ) {
                $errors[] = "Az email cím már foglalt.";
            }
        }

        $length = mb_strlen(trim($password), 'UTF-8');
        if($length < 4 or $length > 20) {
            $errors[] = "A jelszó hossza legalább 4 és legfeljebb 20 karakter.";
        } elseif($password !== $password_confirm) {
            $errors[] = "A megadott két jelszó nem egyezik.";
        }

        if(count($errors) > 0){
            $_SESSION["flash"]["register"]["post"] = $post;
            $_SESSION["flash"]["register"]["msg"] = ['value' => $errors, 'type' => 'errormsg'];
        } else {
            // data storing in the db
            $password = password_hash($password, PASSWORD_DEFAULT);
            $email = mysqli_real_escape_string($connection, $email);
            $name = mysqli_real_escape_string($connection, $name);

            $token = md5(rand(111111, 999999).time());
            
            //while() {} token összehasonlítása az adatbáziban taláhatókkal, út token generálás az egyediségig 

            //http://localhost/full-stack-course/5_php/3_5_account/activate.php?token=$token
            
            mysqli_query($connection, "insert into users (name, email, password, verification_token) values('$name', '$email', '$password', '$token')");
            
            //-- sending email ... ---
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();//!!!! COMMENT THIS LINE OUT ON SERVER,  IT ONLY WORKS ON LOCALHOST       // Set mailer to use SMTP
                $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = SMTP_USERNAME;                 // SMTP username
                $mail->Password = SMTP_PASSWORD;                           // SMTP password
                //$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
                $mail->CharSet = 'UTF-8';

                $mail->setFrom( 'zparragi@gmail.com' , 'Parragi Zoltán' );
                $mail->addAddress($email, $name);     // Add a recipient
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = 'Regisztráció visszaigazolás';
                $mail->Body    = nl2br("Kedves $name!

                ".date('Y.m.d , H:i:s')."-kor, a(z) ".$_SERVER["REMOTE_ADDR"]." IP címről ezzel az email címmel regisztráltak.

                Ha te voltál kattints az alábbi linkre:
                http://localhost/full-stack-course/my_projects/shopping_list/activate.php?token=$token
                
                
                Üdvözlettel
                
                Buga Jakab");
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
             
                $mail->send();
   
                /* if(!$mail->send()) {
                    exit(print("no"));
                    //header("Location: login.php");
                } else {
                    exit(print("ok"));
                    //header("Location: index.php");
                } */
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            
            //-- sending email end ---
            
            if($err = mysqli_error($connection)){
                exit($err);
            }

            $_SESSION["flash"]["register"]["msg"] = ['value' => ['Sikeres regisztráció. <br><br> A regisztráció megerősítéséhez kattints az emailben kapott linkre.'], 'type' => 'successmsg'];
        }

        header("location: ".$referrer_page.".php");
    break;

    case ($referrer_page === "login"):
        
        $errors = Array();

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Az email formátuma nem megfelelő.<br>";
        }

        if(count($errors) > 0){
            $_SESSION["flash"]["login"]["post"] = $post;
            $_SESSION["flash"]["login"]["msg"] = ['value' => $errors, 'type' => 'errormsg'];
        } else {
            $password = mysqli_real_escape_string($connection, $password);
            $email = mysqli_real_escape_string($connection, $email);

            $user_in_db_row = mysqli_query($connection, "select * from users where email = '$email' ");

            if( mysqli_num_rows($user_in_db_row) === 1 ) {
                $user_in_db = mysqli_fetch_assoc($user_in_db_row);
                $user_password_in_db = $user_in_db["password"];
                $is_email_verified = $user_in_db["email_verified_at"] !== null;
                
                if( !password_verify( $password , $user_password_in_db )) {
                    $_SESSION["flash"]["login"]["post"] = $post;
                    $_SESSION["flash"]["login"]["msg"] = ['value' => ['Hibás belépési adatok.'], 'type' => 'errormsg'];
                    header("location: ".$referrer_page.".php");
                    exit; // OR return;
                } else {
                    if($is_email_verified) {
                        $_SESSION["user"] = $user_in_db;
                        header("location: index.php");
                        exit; // OR return;
                    } else {
                        $_SESSION["flash"]["login"]["post"] = $post;
                        $_SESSION["flash"]["login"]["msg"] = ['value' => ['Még nem erősítetted meg a regisztrációd. <br><br> A regisztráció megerősítéséhez kattints az e-mailben kapott linkre.'], 'type' => 'errormsg'];
                        header("location: ".$referrer_page.".php");
                        exit; // OR return;
                    }
                }
            }
        }
    break;

    case ($referrer_page === "profile"):
        $errors = Array();

        $length = mb_strlen(trim($name), 'UTF-8');
        if($length < 4 or $length > 30) {
            $errors[] = "A név hosszának legalább 4 és legfeljebb 30 karakternek kell lennie.<br>";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email formátum hiba.<br>";
        } else {
            $result = mysqli_query($connection, "select id from users where email ='$email' and id !='".$_SESSION["user"]["id"]."'");
            $found = mysqli_num_rows($result);
            if( $found ) {
                $errors[] = "Az email cím már foglalt.";
            }
        }

        if(count($errors) > 0){
            $_SESSION["flash"]["post"] = $post;
            $_SESSION["flash"]["msg"] = ['value' => $errors, 'type' => 'errormsg'];
        } else {
            $email = mysqli_real_escape_string($connection, $email);
            $name = mysqli_real_escape_string($connection, $name);
            
            mysqli_query($connection, "update users set name='$name', email='$email' where id='".$_SESSION["user"]["id"]."' limit 1");

            if($err = mysqli_error($connection)){
                exit($err);
            }

            $_SESSION["flash"]["msg"] = ['value' => ['Sikeres módosítás. :)'], 'type' => 'successmsg'];
        }
        
        header("location: ".$referrer_page.".php");
        
    break;

}
