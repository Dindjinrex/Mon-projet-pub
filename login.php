
<?php
    if( isset($_POST) && !empty($_POST['pseudo']) && !empty($_POST['pass'])){
        require_once 'inc/fonction.php';
        require_once 'inc/database.php';
        $req=$bdd->prepare('SELECT * FROM users WHERE pseudo=?');
        $req->execute(array($_POST['pseudo']));
        $users=$req->fetch();
        session_start();
        if(empty($users)){
            $_SESSION['flash']['danger']='Aucun  compte ne corespond à ces informations; Veuillez vous inscrire';
        }elseif (password_verify($_POST['pass'], $users->pass_word)){
//         Si le pseduo et le mot de passe exitent et corresponde, on les stock dans session auth puis dirige l'utilisateur vers son profil'
            $_SESSION['auth']=$users;
            $_SESSION['flash']['success']="Connection réussir";
            header('Location:profil.php');
            exit();
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
        <input type="text"  id="pseudo" name="pseudo" class="form-control" value="<?php  if( isset($_POST['pseudo'])){ echo $_POST['pseudo'];} ?>" >
    </div>

    <div class="form-group">
        <label for="pass"> Mot de passe</label>
        <input type="password" name="pass" id="pass" class="form-control">
    </div>

    <div class="form-group">
        <label >
        <input type="checkbox" name="remenber"   value="1"> Se Souvenir de moi
        </label>
    </div>

    <button type="submit" class="btn btn-primary"> Me connecter</button>
    <a href="resetpass.php">Vous avez oublié votre mot de passe ?</a>
</form>

<?php  include 'inc/footer.php';?>