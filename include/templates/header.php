<!DOCTYPE html>
<html>
    <head>
         <meta charset="UTF-8" />
         <title><?php getTitle(); ?></title>
         <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css">
         <link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css">
         <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css">
         <link rel="stylesheet" href="<?php echo $css ?>control.css">
    </head>
<body>
<div class="upper-bar">
     <div class="container">
          <?php
               if(isset($_SESSION['user'])){

                    //echo "Welcom: " . $_SESSION['user']. " ";

                    // echo "<a href='profile.php'>My Profile</a>";
                    ?>
                    <div class="navbar navbar-expand-lg session-user">
                         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                              <img src="img.png" class="img-thumbnail img-circle" alt="" />
                              <li class="nav-item dropdown">
                                   <a class="btn btn-default  nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                   <?php echo $sessionUser ?>
                                   </a>
                                   <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                        <li><a class="dropdown-item" href="newad.php">New Item</a></li>
                                        <li><a class="dropdown-item" href="profile.php#my-ads">My Items</a></li>
                                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                   </ul>
                              </li>
                         </ul>
                    </div>
                    <?php

               }else{ ?>

                    <a href="login.php">
                         <span class="login-header pull-right">Login/Signup</span>
                    </a>

          <?php }?>
     </div>
</div>
