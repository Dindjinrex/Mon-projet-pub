<?php
//  Si la session n'est pas demarer on demare'
// Si session auth ne contient des informations d'un utilisateur qui existe alors on le redirige vers login
    include 'inc/fonction.php';
    deconnect();
    require 'inc/database.php';
?>

    <?php
        $errors=[];
        $id_pub=htmlspecialchars($_GET['id_pub']);

        if(isset($_GET) && !empty($id_pub)){
            $req=$bdd->prepare('SELECT * FROM article WHERE id_pub=? ' );
            $req->execute(array($id_pub));
            $pubs=$req->fetch();
        }
    ?>

    <?php require 'inc/header.php '; ?>
<!--Affichage des artcile-->

    <div class="jumbotron">
        <h1><?= $pubs->title_pub; ?></h1>
        <p><?= $pubs->publication;  ?></p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
    </div>















    <?php require 'inc/footer.php '; ?>