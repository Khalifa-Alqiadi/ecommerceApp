<?php

    include 'connect.php';

    $lang    = 'include/languages/'; // Language Directory
    $tepl    = 'include/templates/'; // Templates Directory
    $css     = 'layout/css/'; // Css Directory
    $js      = 'layout/js/';  // JS Directory
    $func    = 'include/functions/'; // Functions Directory

    // Include The Impottant Files

    include $func . 'function.php';
    include $lang . 'en.php';
    include $tepl . 'header.php';

    // Include Navbar On All Pages Expect The One With $noNavbar Vairable

    if(!isset($noNavbar)){ include $tepl . 'navbar.php'; }
    
 