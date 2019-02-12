<?php require_once 'inc/fonction.php' ; ?>
<?php include 'inc/header.php' ; ?>

<form action="" method="post">
    <div class="form-group">
        <label for="email"> Email</label>
        <input type="text"  name="email" id="email" class="form-control" value="<?php  if( isset($_POST['email']) && empty($errors['email']) && empty($errors['emailexist'])){ echo $_POST['email'];} ?>" >
    </div>
</form>
<?php include 'inc/footer.php' ; ?>


