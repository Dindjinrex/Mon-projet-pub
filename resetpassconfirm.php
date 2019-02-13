<?php
session_start();
require_once 'inc/fonction.php' ;
?>

<?php
$errors=[];
if(!empty($_POST)){
    if (empty($_POST['newPass']) || empty($_POST['newPassConfirm']) || $_POST['newPass']!=$_POST['newPassConfirm']){
        $errors['passInvalid']="Votre de passe est invalide";
    }else{
        require 'inc/database.php';
        $i=$_SESSION['emailReset']->email;
        $password=password_hash($_POST['newPass'], PASSWORD_BCRYPT );
        $req=$bdd->prepare('UPDATE users SET pass_word=?  WHERE email=?');
        $req->execute([$password, $i]);

        $_SESSION['flash']['success']="Votre mot de passe a bien été changé";
        header('Location:login.php');
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
        <label for="pass"> Nouveau mot de passe</label>
        <input type="password" name="newPass" id="pass" class="form-control">
    </div>

    <div class="form-group">
        <label for="pass_confirm"> Confirmez nouveau mot de passe</label>
        <input type="password" id="pass_confirm" name="newPassConfirm" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary"> Soumettre </button>

</form>

<?php include 'inc/footer.php' ; ?>
