<?php
session_start();
require_once 'inc/fonction.php' ;
?>

<?php

?>



<?php include 'inc/header.php' ; ?>

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
