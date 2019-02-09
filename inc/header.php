<?php
//si la session n'est pas demarré sa valeyr est PHP_SESSION_NONE alors on la demare'
    if(session_status() == PHP_SESSION_NONE ){
        session_start();
    }

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Projet2</title>
</head>
<body>
<?php //include 'fonction.php' ; ?>

<nav class="navbar navbar-inverse ">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Mon espace membre</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li ><a href="../register.php">S'inscrire</a></li>
                <li><a href="../login">Se connecter</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php  if (isset($_SESSION['flash'])): ?>
            <?php foreach ($_SESSION['flash'] as $type=>$message ):?>
            <div class="alert alert-<?= $type; ?>">
                <?=  $message; ?>
            </div>
            <?php endforeach ; ?>
             <?php  unset($_SESSION['flash']); ?>
    <?php  endif; ?>

