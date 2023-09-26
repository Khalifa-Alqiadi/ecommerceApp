<?php

        /**
         * ====================================================================
         * = Login Admin Page
         * ====================================================================
         */

      ob_start(); // Output Buffring Start

      session_start();
      $noNavbar = '';
      $pageTitle = 'Login';
       if(isset($_SESSION['UserName'])) {
             header('Location: dashboard.php');
       }    

      include 'init.php';

      // Check If User Coming From HTTP Post Request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

          $username = $_POST['user'];
          $password = $_POST['pass'];
          $hashePss = sha1($password);

          // Check If The User Exist In Database

          $stmt = $con->prepare("SELECT
                                      UserID, UserName, Pass
                                 FROM 
                                     users
                                 WHERE
                                      UserName = ? 
                                 AND 
                                      Pass = ? 
                                 AND 
                                      GroupID = 1
                                 LIMIT 1");

          $stmt->execute(@array($username,$hashePss));
          $row = $stmt->fetch();
          $count = $stmt->rowCount();

          // If Count > 0 This Mean The Database Contain Record About This UserName
          if($count > 0){

             $_SESSION['UserName'] = $username; // Register Session Name
             $_SESSION['ID'] = $row['UserID']; // Register Session ID
             header('Location: dashboard.php'); // Redirect Dashboard Page
             exit();

          }

      }

?>



     <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
     <h4 class="text-center" ><?php echo lang('ADMIN'); ?></h4>
     <input class="form-control" type="text" name="user" placeholder="<?php echo lang('USERNAMEADMIN'); ?>" autocomplete="of" />
     <input class="form-control" type="password" name="pass" placeholder="<?php echo lang('PASSWORDADMIN'); ?>" autocomplete="new-password" />
     <input class="btn btn-primary btn-block" type="submit" value="<?php echo lang('LOGINADMIN'); ?>" />

     </form>




<?php

      include $tepl . 'footer.php';

      ob_end_flush();
?>