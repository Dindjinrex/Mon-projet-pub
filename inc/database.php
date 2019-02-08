<?php
try{
    $bdd=new PDO('mysql:host=localhost;dbname=userspace', 'root', '' );
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); 	//recuperation d'un objet
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Gerer les erreurs

}catch(Exception $e){
    echo " impossible de se connecter à la base de donnée";
    echo $e->getMessage();
    die();

}
