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

//        if ($id_pub!=$_SESSION['pubs']->id_pub){
//            $_SESSION['flash']['danger']="Vous tentez d'acceder a une autre publication";
//            header('Location:profil.php');
//            exit();
//        }

        if(isset($_GET)){
            $req=$bdd->query('SELECT * FROM article');

            $pubs=$req->fetch();
        }


    ?>

    <?php require 'inc/header.php '; ?>

    <div class="jumbotron">
        <h1><?php echo $pubs->title_pub; ?></h1>
        <p><?php echo $pubs->publication;  ?></p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
    </div>















    <?php require 'inc/footer.php '; ?>