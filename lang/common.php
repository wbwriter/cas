<?php
/**
 * Created by PhpStorm.
 * User: Trah
 * Date: 04/10/2016
 * Time: 10:41
 */


header('Cache-control: private'); // IE 6 FIX


/*
switch ($lang) {
    case 'en':
        $lang_file = 'lang.en.php';
        break;

    case 'fr':
        $lang_file = 'lang.fr.php';
        break;
    default:
        $lang_file = 'lang.en.php';

}
//include_once 'lang/'.$lang_file;
include_once $lang_file;
?>