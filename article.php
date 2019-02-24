<?php
session_start();
//  Si la session n'est pas demarer on demare'
// Si session auth ne contient des informations d'un utilisateur qui existe alors on le redirige vers login
    include 'inc/fonction.php';
    deconnect();
    require 'inc/database.php';
?>

    <?php
        $errors=[];
        $id_pub=input_text_ok($_GET['id_pub']);

        if(isset($_GET) && !empty($id_pub)){
            $req=$bdd->prepare('SELECT * FROM article WHERE id_pub=? ' );
            $req->execute(array($id_pub));
            $pubs=$req->fetch();
        }
    ?>

    <?php
        if (isset($_POST['commenter']) && !empty($_POST['comment']) ) {
            $commentaire = input_text_ok($_POST['comment']);
//          insertion dans la base de donné
            $req = $bdd->prepare('INSERT INTO comments(auteur_comment, title_article, commentaire, dat_comment) VALUES (?, ?, ?, NOW())');
            $req->execute([ $_SESSION['auth']->pseudo,  $pubs->title_pub,  $commentaire]);
            $req->closeCursor();
        }
    ?>

    <?php require 'inc/header.php '; ?>
<!--Affichage des artcile-->

    <div class="jumbotron">
        <h1><?= $pubs->title_pub; ?></h1>
        <p><?= $pubs->publication; ?></p>
    </div>
    <?php
//    selection des commentaire
        $req=$bdd->prepare('SELECT * FROM comments WHERE title_article=? ');
        $req->execute(array($pubs->title_pub));
        $nbr=$req->rowCount();
    ?>
    <div class="Bloc_comment">
        <?php while ($comments=$req->fetch()):  ?>
            <?php if ( $nbr===0):  ?>
                <div class="comment">
                    Soyez le premier à commenter
                </div>
            <?php endif;  ?>
            <div class="comment">
                <p> <strong><?= $comments->auteur_comment ?></strong>: <?= $comments->commentaire ?>  </p>
            </div>
        <?php endwhile;  ?>
        <form class="form-inline" method="post">
            <div class="form-group">
                <textarea  name="comment" class="form-control inputComment" cols="50" rows="2"></textarea>
            </div>
            <button type="submit" name="commenter" class="btn btn-primary">Commenter</button>
        </form>
    </div>















    <?php require 'inc/footer.php '; ?>