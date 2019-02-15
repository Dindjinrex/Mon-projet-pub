<?php
session_start();
require_once 'inc/fonction.php' ;
?>

<?php
require 'inc/database.php';
$req=$bdd->prepare('SELECT *FROM users   WHERE email=?');
$req->execute([$_SESSION['emailReset']->email]);
$user=$req->fetch();
$errors=[];

if(!empty($_POST)){
    if (empty($_POST['newPass']) || empty($_POST['newPassConfirm']) || $_POST['newPass']!=$_POST['newPassConfirm']){
        $errors['passInvalid']="Votre de passe est invalide";
    }else{
        $password=password_hash($_POST['newPass'], PASSWORD_BCRYPT );
        $req=$bdd->prepare('UPDATE users SET pass_word=?  WHERE id=?');
        $req->execute([$password, $user->id]);
        $_SESSION['auth']=$user;
        $_SESSION['flash']['success']="Votre mot de passe a bien été Réinitalisé";
        header('Location:profil.php');
        exit();
    }
}
?>



<?php include 'inc/header.php' ; ?>
    <?php  if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error):?>
               <?= $error ; ?>
            <?php endforeach ; ?>
        </div>
    <?php  endif; ?>
<form action="" method="post">
    <div class="form-group">
        <label for="pass"> Entrez le code </label>
        <input type="text" name="code" id="pass" class="form-control" style="width: 15%" placeholder="S2drR2">
    </div>
    <div class="form-group">
        <label for="pass"> Nouveau mot de passe</label>
        <input type="password" name="newPass" id="pass" class="form-control">
    </div>

    <div class="form-group">
        <label for="pass_confirm"> Confirmez nouveau mot de passe</label>
        <input type="password" id="pass_confirm" name="newPassConfirm" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary"> Réinitialisé  </button>

</form>

<?php include 'inc/footer.php' ; ?>
