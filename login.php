
<?php  require_once 'inc/fonction.php';?>
<?php
    if( isset($_POST) && !empty($_POST['pseudo']) && !empty($_POST['password'])){
        require 'inc/database.php';
        $req=$bdd->prepare('SELECT * FROM uers WHERE pseudo=?');
        $req->execute(array($_POST['pseudo']));
        $users=$req->fetch();
        if (password_verify($_POST['pass'], $users->pass_word)){
            session_start();
            $_SESSION['auth']=$users;
            $_SESSION['flash']['succes']="Connection réussir";
            header('Location:profil.php');
           // exit();
        }else{
            $_SESSION['flash']['danger']="Pseudo ou mot de passe incorrect";
        }
    }
?>

<?php  include 'inc/header.php';?>

 <h1> Se Connecter</h1>
<form action="" method="post">
    <div class="form-group">
        <label for="pseudo"> Pseudo</label>
        <input type="text"  id="pseudo" name="pseudo" class="form-control" value="<?php  if( isset($_POST['pseudo']) && empty($errors['pseudo']) && empty($errors['pseudoexist'])){ echo $_POST['pseudo'];} ?>" >
    </div>

    <div class="form-group">
        <label for="pass"> Mot de passe</label>
        <input type="password" name="pass" id="pass" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary"> M'inscrire</button>

</form>

<?php  include 'inc/footer.php';?>