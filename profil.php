<?php session_start();
require_once 'inc/fonction.php ';
deconnect();
?>

<?php require 'inc/header.php '; ?>


<h1> Le compte de <?=  $_SESSION['auth']->pseudo ?></h1>




<?php require 'inc/footer.php '; ?>