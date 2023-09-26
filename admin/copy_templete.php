<?php

    /**
     * ====================================================================
     * = Members Page
     * ====================================================================
     */

    ob_start(); // Output Buffring Start

    session_start();

    

    if(isset($_SESSION['UserName'])){

        $pageTitle = '';

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] :'Manage';

        if($do == 'Manage'){

        }elseif($do == 'Add'){

        }elseif($do == 'Insert'){

        }elseif($do == 'Edit'){

        }elseif($do == 'Update'){

        }elseif($do == 'Delete'){

        }elseif($do == 'Activate'){

        }
        
    include $tepl . 'footer.php';

    }else{

        header('Location: index.php');
        exit();
    }

    ob_end_flush();

?>