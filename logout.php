<?php 

session_start();
unset($_SESSION["user"]);
unset($_SESSION["flash"]);
header("location: index.php");