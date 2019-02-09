<?php
include 'inc/fonction.php';
require_once 'inc/database.php';
$user_id=$_GET['id'];
$token=$_GET['token'];
$req=$bdd->prepare('SELECT * FROM users WHERE id=?');
$req->execute(array($user_id));
$user=$req->fetch();
 //voyons l'id existe et que le token obtenir en get correspond a celui de la db'
if ($user && $user->confirm_token == $token){
    session_start();
    //annulé le token
    $req=$bdd->prepare('UPDATE users SET confirm_token= NULL, dat_confirm=NOW() WHERE id=?');
    $req->execute($user->id);
    $_SESSION['auth']=$user;
    header('Location: profil.php');
}else{
    die('pas ok');
}