<?php
session_start();
require_once 'inc/fonction.php' ;
?>

<?php
    $errors=[];
if (!empty($_POST)){
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['invalidMail']="Veuillez entrer un email valide";
    }else{
        require_once 'inc/database.php';
        $req=$bdd->prepare('SELECT *FROM users WHERE email=?');//existeance de l'email
        $req->execute(array( $_POST['email']));
        $users=$req->fetch();
        if($users){
            $_SESSION['flash']['info']="Un email de confirmation vous a été envoyé";
            header('Location:resetpassconfirm.php');
            exit();
        }else{
            $_SESSION['flash']['info']="Votre compte n'existe pas, Veuillez vous inscrire";
            header('Location: register.php');
            exit();
        }
    }
}

?>

    <?php include 'inc/header.php' ; ?>
    <?php  if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error):?>
                <ul>
                    <li><?= $error ; ?></li>
                </ul>
            <?php endforeach ; ?>
        </div>
    <?php  endif; ?>
<form action="" method="post">
    <div class="form-group">
        <label for="email">Entrez l'email de votre compte</label>
        <input type="text"  name="email" id="email" class="form-control"  >
    </div>
    <button type="submit" class="btn btn-primary"> Soumettre</button>
</form>
<?php include 'inc/footer.php' ; ?>


