<?php
    function debug($variable){
        echo '<pre>' .print_r($variable). '</pre>';
    }


    function str_random($length) {
        $alphabet="azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890" ;
        return  substr( str_shuffle(str_repeat($alphabet, $length)), 0, $length) ;
    }