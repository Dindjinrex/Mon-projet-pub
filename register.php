<?php require 'inc/header.php' ; ?>


<?php
    if (!empty($_POST)){
        //tableau contenant les erreurs
        $errors=[];

        //verification du pseudo
        if(empty($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9_]+$#',  $_POST['pseudo'])){

            $errors['pseudo']= "Votre pseudo n'est pas valide ou comporte des caractères speciaux";
        }

        //verification de l'email
        if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

            $errors['email']= "Veuillez entrer une adresse email valide";
        }

        //verification de mot de passe
        if(empty($_POST['pass']) || $_POST['pass'] != $_POST['pass_confirm']){

            $errors['password']="Votre mot de passe est vide ou ne correspondent pas";
        }

        require_once 'inc/database.php';
debug($errors);


    }


?>


<h1> S'inscrire</h1>

    <form action="" method="post">
        <div class="form-group">
            <label for="pseudo"> Pseudo</label>
            <input type="text"  id="pseudo" name="pseudo" class="form-control">
        </div>

        <div class="form-group">
            <label for="email"> Email</label>
            <input type="text"  name="email" id="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="pass"> Mot de passe</label>
            <input type="password" name="pass" id="pass" class="form-control">
        </div>

        <div class="form-group">
            <label for="pass_confirm"> Confirmez votre mot de passe</label>
            <input type="password" id="pass_confirm" name="pass_confirm" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary"> M'inscrire</button>

    </form>

<?php require 'inc/footer.php' ; ?>