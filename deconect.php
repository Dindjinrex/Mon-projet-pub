<?php
session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success']= "Vous etes maintenat deconnecté(e)";
header('Location: login.php');