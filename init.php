<?php

    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    include 'admin/connect.php';

    $sessionUser = '';
    if(isset($_SESSION['user'])){
        $sessionUser = $_SESSION['user'];
    }

    $lang    = 'include/languages/'; // Language Directory
    $tepl    = 'include/templates/'; // Templates Directory
    $css     = 'layout/css/'; // Css Directory
    $js      = 'layout/js/';  // JS Directory
    $func    = 'include/functions/'; // Functions Directory

    // Include The Impottant Files

    include $func . 'function.php';
    include $lang . 'en.php';
    include $tepl . 'header.php';
    include $tepl . 'navbar.php';


  
    
 