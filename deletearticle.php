<?php  
session_start();
require 'inc/database.php';
if(isset($_GET['id_pub']) && $_GET['id_pub']>0 ){
   $req=$bdd->prepare('SELECT *FROM artcile WHERE id_pub=?');
   $req->execute([$_GET['id_pub']]);
   $pubs=$req->fetch();
   $auteur=$_SESSION['auth']->pseudo;
   
   if($auteur==$pubs->auteur_pub){
       $req=$bdd->prepare('DELETE FROM article WHERE id_pub=?');
       $req->execute([$_GET['id_pub']]);
       $_SESSION['flash']['success']=" ucfirst($auteur) Votre publication a bien été supprimée";
       header('Location: profil.php');
       exit();
   }else{
    $_SESSION['flash']['danger']="ucfirst($auteur) Vous tentez de supprimeer une publication qui n'est pas la voter";
    header('Location: profil.php');
       exit();
   }
    
}