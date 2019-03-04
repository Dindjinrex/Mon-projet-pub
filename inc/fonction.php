<?php
    function debug($variable){
        echo '<pre>' .print_r($variable). '</pre>';
    }


    function str_random($length) {
        $alphabet="azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890" ;
        return  substr( str_shuffle(str_repeat($alphabet, $length)), 0, $length) ;
    }


    function deconnect()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(!isset($_SESSION['auth'])){
            header('Location:login.php');
            $_SESSION['flash']['danger']="Vous ne pouvez pas acceder tant que vous vous n'etes pas connecté";
            exit();
        }
    }


    function input_text_ok($text){
        htmlentities(htmlspecialchars(trim($text)));
        return $text;
    }

    function length_test ( $min_lenght, $max_lenght,  $test){
        $inputLenght= strlen($test);
        if ($inputLenght > $max_lenght || $inputLenght<$min_lenght) {
            return true;
        }else{
            return false;
        }
    }
