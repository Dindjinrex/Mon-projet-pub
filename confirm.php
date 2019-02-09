<?php
require_once 'inc/database.php';
$user_id=$_GET['user_id'];
$token=$_GET['token'];
$req=$bdd->prepare('SELECT id confirm_token FROM users WHERE id=?');
$req->execute(array($user_id));
$user_confirm=$req->fetch();
 //voyons l'id existe et que le token obtenir en get correspond a celui de la db'
if ($user_confirm && $user_confirm->confirm_token==$token){
    header('Location:profil.php');
}