
<?php require_once 'inc/fonction.php' ; ?>

<?php
    if (!empty($_POST)){
        //tableau contenant les erreurs
        $errors=[];
        extract($_POST);
        require_once 'inc/database.php';


        if(empty($pseudo) || !preg_match('#^[a-zA-Z0-9_]+$#',  $pseudo)){
            $errors['pseudo']= "Votre pseudo n'est pas valide ou comporte des caractères speciaux";
        }else{
            $req=$bdd->prepare('SELECT id FROM users WHERE pseudo=?'); //existeance du pseudo
            $req->execute(array( $pseudo));
            $user=$req->fetch();
            if($user){
                $errors['pseudoexist']= "Votre pseudo existe déja";
            }
        }


        //verification de l'email
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email']= "Veuillez entrer une adresse email valide";
        }else{
            $req=$bdd->prepare('SELECT id FROM users WHERE email=?');//existeance de l'email
            $req->execute(array( $email));
            $users=$req->fetch();
            if($users){
                $errors['emailexist']= "Votre adresse email existe déja";
            }
        }


        //verification de mot de passe
        if(empty($pass) || $pass != $_POST['pass_confirm']){
            $errors['password']="Votre mot de passe est vide ou ne correspondent pas";
        }


        // s'il n'y a pas d'erreur on charge la base donnée et on continue
          if (empty($errors)){
              require 'inc/database.php';
                //insertion de l'utilisi
              $token=str_random(60);
              $password=password_hash($_POST['pass'], PASSWORD_BCRYPT);
            $req=$bdd->prepare("INSERT INTO users(pseudo, email, pass_word, confirm_token) VALUES (?, ?, ?, ?)");
            $req->execute(array($_POST['pseudo'] , $_POST['email'] , $password, $token));
            $user_id=$bdd->lastInsertId();
            mail(($_POST['email']), 'confirmation de compte', "cliquer ici poour confirmer votre
            compte\n\nhttp://localhost/php/projet2/confirm.php?id=$user_id&token=$token" );

            header('location:http://localhost/php/projet2/confirm.php?id='.$user_id.'&token='.$token );

          }
    }
?>


<?php require 'inc/header.php' ; ?>

<h1> S'inscrire</h1>

    <?php  if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <p>Vous n'avez pas bien rempli les champs:</p>
            <?php foreach ($errors as $error):?>
                 <ul>
                     <li><?= $error ; ?></li>
                 </ul>
            <?php endforeach ; ?>
        </div>
    <?php  endif; ?>


    <form action="" method="post">
        <div class="form-group">
            <label for="pseudo"> Pseudo</label>
            <input type="text"  id="pseudo" name="pseudo" class="form-control" value="<?php  if( isset($_POST['pseudo']) && empty($errors['pseudo']) && empty($errors['pseudoexist'])){ echo $_POST['pseudo'];} ?>" >
        </div>

        <div class="form-group">
            <label for="email"> Email</label>
            <input type="text"  name="email" id="email" class="form-control" value="<?php  if( isset($_POST['email']) && empty($errors['email']) && empty($errors['emailexist'])){ echo $_POST['email'];} ?>" >
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