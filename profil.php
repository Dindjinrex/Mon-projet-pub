<?php session_start();
require_once 'inc/fonction.php ';
deconnect(); //tant que session n'est pas definir redirection vers login
require 'inc/header.php';
require 'inc/database.php';
?>

<?php
        $errors=[];

    if(!empty($_POST)) {
        // si on clic sur publier publier
        if (empty($_POST['title_pub'])) {
            $errors['noTitle'] = "Veuillez donner un titre à votre publication";
        }
//        Si la publication est vide
        if (empty($_POST['article_pub'])) {
            $errors['noArticle'] = "Veuillez envoyer votre publication";
        }
//        Sans Envoyer une image
        $file_name = $_FILES['img_pub']['name'];

//     On recupere  avec "strrchr" la dernier partie de la chaine du nom du fichier comment par le '.'
//     Nous allons convertir avec "strtolower()" l'extension en miniscule

        $file_extension = strtolower(strrchr($file_name, ". "));
        $extensions_autorises = array('.jpg', '.jpeg', '.png', 'gif');

        $auteur_pseudo = $_SESSION['auth']->pseudo;

//      $id_order_pub sera un identifiant qui va permettre classer les image
        $image_id = time();
        $name_img = $image_id. '_' . $auteur_pseudo . $file_extension;

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

//            Destination du fichier
            $file_dest = 'file_img_pub/' . $name_img;
            if (empty($errors)) {
                $upload = move_uploaded_file($_FILES['img_pub']['tmp_name'], $file_dest);
            } else {
                $errors['upload'] = "Votre fichier n'as pas pu etre chargé";
            }
        }
//        S'il $errors est vide alors o=insert dans la base de donnéé
        if (empty($errors)) {
            $req = $bdd->prepare('INSERT INTO article(auteur_pub, titre_pub, publication, image, dat_pub) VALUES(?, ?, ?, ?, NOW())');
            $req->execute(array($_SESSION['auth']->pseudo, $_POST['title_pub'], $_POST['article_pub'], $image_id));
            $success=" Votre publication a bien été";
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

    </div>
    <div class="row">
        <?php $pubs=$bdd->query('SELECT *FROM  article ORDER BY dat_pub ') ?>
        <?php foreach ($pubs as $pub):  ?>
            <div class=" pub col-sm-6 col-md-3">
                <div class="thumbnail">
                    <img src="img/enfant.jpg" alt="...">
                    <div class="caption">
                        <h3>Thumbnail label</h3>
                        <p>...</p>
                        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
                    </div>
                </div>
            </div>
        <?php endforeach;  ?>
    </div>


</div>



<?php require 'inc/footer.php '; ?>