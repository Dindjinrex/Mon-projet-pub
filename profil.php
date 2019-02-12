<?php session_start();
require_once 'inc/fonction.php ';
deconnect(); //tant que session n'est pas definir redirection vers login
require 'inc/header.php'
?>


<h1> Le compte de <?=  $_SESSION['auth']->pseudo ?></h1>




<?php require 'inc/footer.php '; ?>