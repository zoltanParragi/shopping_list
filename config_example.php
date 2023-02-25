<?php

define('SMTP_HOST', 'smtphostname');
define('SMTP_USERNAME', 'username');
define('SMTP_PASSWORD', 'password');
define('SMTP_PORT', 587);

define (DB_USER, "user");
define (DB_PASSWORD, "password");
define (DB_DATABASE, "databasename");
define (DB_HOST, "localhost");

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if($err = mysqli_connect_error()) {
    exit($err);
}
