<?php session_start();
require_once 'inc/fonction.php ';
deconnect(); //tant que session n'est pas definir redirection vers login
require 'inc/header.php';
require 'inc/database.php';
?>

<?php
    $errors=[];
    if(!empty($_POST)){

        // si on clic sur publier publier
        if (empty($_POST['title_pub'])){
            $errors['noTitle']="Veuillez donner un titre à votre publication";
        }
//        Si la publication est vide
        if (empty($_POST['article_pub'])){
            $errors['noArticle']="Veuillez envoyer votre publication";
        }

//        Sans Envoyer une image
        if (empty($_FILES)){
            $errors['file_empty']="Veuillez Choisr une image";
        }else{
            $file_name=$_FILES['img_pub']['name'];
            // On recupere la dernier partie de la chaine du nom du fichier

            $file_extension =strrchr($file_name, ". ");
            $extensions_autorises =array('.jpg', '.JPG', '.jpeg', '.JPEG', '.png', '.PNG');

//            Est-ce que l'extention du fichier est parmi ceux autorisé
            if (!in_array($file_extension, $extensions_autorises )){
                $errors['no_extens']="Ce type de fichier n'est pas autorisé";
            }$file_size=$_FILES['img_pub']['size'];
            $max_size=3000000;

            $file_tmp_name=$_FILES['img_pub']['tmp_name'];
            $file_dest='file_img_pub/'.$file_name;

            if ($file_size>$max_size){
                $errors['file_size']="Votre fichier est trop lourd";

            }elseif( move_uploaded_file($file_tmp_name, $file_dest)){
                die('Fiuchier envoyer avec succes');
            }else{

                $errors['upload']="Votre fichier n'as pas pu etre chargé";
            }
        }
    }

var_dump($_FILES);

?>

<h1>Bienvenue Mr  <?=  $_SESSION['auth']->pseudo ?>  </h1>
<p>
    Vous êtes maintenant connecté sur compte. Vous avoir accñs a nos publications et faire aussi de publications.
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
        <?php $pubs=$bdd->query('SELECT *FROM  article') ?>
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