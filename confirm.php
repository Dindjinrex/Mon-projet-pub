<?php
include 'inc/fonction.php';
require_once 'inc/database.php';
$user_id=$_GET['id'];
$token=$_GET['token'];
$req=$bdd->prepare('SELECT * FROM users WHERE id=?');
$req->execute(array($user_id));
$users=$req->fetch();
session_start();
 //voyons l'id existe et que le token obtenir en get correspond a celui de la db'
if ($users && $user->confirm_token == $token){
    //annulé le token
    $req=$bdd->prepare('UPDATE users SET confirm_token= NULL , dat_confirm=NOW() WHERE id=?');
    $req->execute($users->id);
    $_SESSION['auth']=$users;
    $_SESSION['flash']['success']= "Compte a bien été créé et vous êtes maintenant connecté(e)";
    header('Location: profil.php');
}else{
    header('Location: login.php');
}