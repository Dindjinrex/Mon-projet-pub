<?php session_start();
require_once 'inc/fonction.php ';
deconnect(); //tant que session n'est pas definir redirection vers login
require 'inc/header.php';
require 'inc/database.php';
?>

<?php
        $errors=[];
        $auteur_pseudo = $_SESSION['auth']->pseudo;


    if(!empty($_POST)) {

        $title_pub=input_text_ok($_POST['title_pub']);

        $article_pub=input_text_ok($_POST['article_pub']);

        if (empty($title_pub)){
            $errors['noTitle'] = "Veuillez donner un titre à votre publication";
        }


        if (length_test(4, 15, $title_pub)){
            $errors['longTitle']="Titre invalide: minimin 4 caractère et maximun 15 caractère";
        }


        if (empty($article_pub)) {
            $errors['noArticle'] = "Veuillez envoyer votre publication";
        }

        $file_name = $_FILES['img_pub']['name'];

//     On recupere  avec "strrchr" la dernier partie de la chaine du nom du fichier commencant par le '.'
//     Nous allons convertir avec "strtolower()" l'extension en miniscule

        $file_extension = strtolower(strrchr($file_name, ". "));
        $extensions_autorises = array('.jpg', '.jpeg', '.png', 'gif');

//      $id_order_pub sera un identifiant qui va permettre classer les image
        $identifiant = time();
        $image_id=$identifiant. '_' . $auteur_pseudo;

        $name_img = $image_id. $file_extension;

        if (empty($_FILES) || empty($_FILES['img_pub']['name'])) {
            $errors['file_empty'] = "Veuillez Choisr une image: le choix de l'image est Obligatoire";
        } else {
//            Est-ce que l'extention du fichier est parmi ceux autorisé
            if (!in_array($file_extension, $extensions_autorises)) {
                $errors['no_extens'] = "Ce type de fichier n'est pas autorisé";
            }

//          Verification de la taille du fichier
            $file_size = $_FILES['img_pub']['size'];
            $max_size = 3000000;
            if ($file_size > $max_size) {
                $errors['file_size'] = "Votre fichier est trop lourd";
            }

//          la destination du fichier, le nom du fcihier sera de la forme timstamp_frejus.jpg
            $file_dest = 'file_img_pub/' . $name_img;
            if (empty($errors)) {
                $upload = move_uploaded_file($_FILES['img_pub']['tmp_name'], $file_dest);
            } else {
                $errors['upload'] = "Votre fichier n'as pas pu etre chargé";
            }
        }
//        S'il $errors est vide alors o=insert dans la base de donnéé
        if (empty($errors)) {
            $req = $bdd->prepare('INSERT INTO article(auteur_pub, title_pub, publication, name_img, dat_pub) VALUES(?, ?, ?, ?, NOW())');
            $req->execute(array($_SESSION['auth']->pseudo, $title_pub, $article_pub, $name_img));
        }else{
            $errors['fail_upload']="Echec: Mr $auteur_pseudo votre publication n'a pu etre chargé ";
        }
    }
?>


<h1>Bienvenue Mr  <?=  $_SESSION['auth']->pseudo ?>  </h1>
<p>
    Vous êtes maintenant connecté sur compte. Vous avoir accès a nos publications et vous pouvez faire aussi de publications.
</p>
    <br><br>
<div class="container">
    <div class="row">
<!--        Affichage des erreur-->
        <?php  if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error):?>
                    <ul>
                        <li><?= $error ; ?></li>
                    </ul>
                <?php endforeach ; ?>
            </div>
        <?php  endif; ?>

<!--Affichage du message de succes-->
        <?php  if (!empty($_POST) && empty($errors)): ?>
            <div class="alert alert-success">
                <p> Waooo!!! Mr <?=  $auteur_pseudo; ?> Votre publication bien été postée </p>
            </div>
        <?php  endif; ?>

<!--        le formulaire-->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titre">Titre de la publication</label>
                <input type="text"  id="titre" name="title_pub" class="form-control">
            </div>

            <div class="form-group">
                <label for="img">L'image de votre Publication</label>
                <input type="file"  id="img" name="img_pub" class="">
            </div>

            <div class="form-group">
                <label for="pub"> Publication</label>
                <textarea name="article_pub" id="pub" cols="15" rows="4" class="form-control"></textarea>
            </div>
            <button type="submit" name="publier" class="btn btn-primary"> Publier</button>
        </form>
        <br>
    </div>
    <div class="row">
<!--        Selection des article-->
        <?php

        $req=$bdd->query('SELECT *FROM  article ORDER BY name_img DESC  ');
        $nbrParPage= 12;
        $nbrArticle= $req->rowCount();
        $nbrDePage=ceil($nbrArticle/$nbrDePage);
        ?>
        <div class=" pub container-fluid">
            <div class="row">
                <?php while ($pubs=$req->fetch()):  ?>
                    <div class=" col-md-3">
                        <div class="img-content">
                            <img src="file_img_pub/<?= $pubs->name_img ;  ?>"  class="thumbnail" alt="...">
                        </div>
                        <div class="caption">
                            <h4 style="text-transform: uppercase"><?= $pubs->title_pub;  ?></h4>
                            <h5>C'est une publication de <span class="auteur_pub"><?= $pubs->auteur_pub ; ?> </span> </h5>
                            <p>
                                <a href='article.php?id_pub=<?= $pubs->id_pub; ?>' class="btn btn-primary" role="button">Lire la publication</a>
                                <a href="" class="btn btn-danger">Supprimer </a>
                            </p>
                            <p>
                                <i class="far fa-clock"></i>
                                <?php setlocale (LC_ALL, 'fr_FR');
                                //                           %T represente heure minuite et seconde
                                //                           ucfirst permet de mettre la permière lettre des date en majuscule
                                //                            strtotime() convertir la date en timestamp
                                echo  ucfirst(strftime( "%A %d %B %Y à %T  ", strtotime($pubs->dat_pub) ))  ;
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile;  ?>
            </div>
        </div>
    </div>
</div>

<?php
for ($i=1; $i<=$nbrDePage; $i++){
    echo $i.'/';
}
?>

<?php require 'inc/footer.php '; ?>