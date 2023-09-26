<?php

    session_start();
    $pageTitle = 'Login';
    if(isset($_SESSION['user'])){
        header('Location: index.php');
    }
    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['login'])){

            $user = $_POST['username'];
            $pass = $_POST['password'];
            $hashedPass = sha1($pass);

            $stmt = $con->prepare("SELECT
                                        UserID, UserName, Pass
                                    FROM
                                        users
                                    WHERE
                                        UserName = ?
                                    AND
                                        Pass = ?");
            $stmt->execute(array($user, $hashedPass));

            $get = $stmt->fetch();

            $check = $stmt->rowCount();

            if($check > 0){

                $_SESSION['user'] = $user; // Register Session Name

                $_SESSION['uid'] = $get['UserID']; // Register User ID In Session 

                header('Location: index.php'); // Redirect To Dashboard Page
                exit();

            }
        }else{
            
            $formErrors = array();

            $username   = $_POST['username'];
            $fullname   = $_POST['fullname'];
            $email      = $_POST['email'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2'];
            
            if(isset($username)){

                $filterUser = filter_var($username, FILTER_SANITIZE_STRING);

                if(strlen($filterUser) < 4){

                    $formErrors [] = 'Username Must Be Lager Than 4 Characters';

                }

            }

            if(isset($fullname)){

                $filterUser = filter_var($fullname, FILTER_SANITIZE_STRING);

                if(strlen($filterUser) < 5){

                    $formErrors [] = 'Username Must Be Lager Than 5 Characters';

                }

            }

            if(isset($password) && isset($password2)){

                if(empty($password)){

                    $formErrors[] = 'Sorry Password Cant Be Empty ';

                }

                if(sha1($password) !== sha1($password2)){

                    $formErrors[] = 'Sorry Password Is Not Match';

                }

            }

            if(isset($email)){

                $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

                if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true){

                    $formErrors[] = 'Sorry This Email Is Not Valid';

                }

            }

            if(empty($formErrors)){

                $check = chickItem("UserName", "users", $username);

                if($check == 1){

                    $formErrors[] = 'This Username Is Exsit';

                }else{

                    // Insert Userinfo Into Database

                    $stmt = $con->prepare("INSERT INTO 
                                                users(UserName, Email, Pass, FullName, RegStatus, `Date`)
                                            VALUES(:zuser, :zmail, :zpass, :zname, 0, now())");
                    $stmt->execute(array(
                        'zuser'  => $username,
                        'zname'  => $fullname,
                        'zmail'  => $email,
                        'zpass'  => sha1($password)
                    ));

                    //Echo Success Message

                    $successMas = 'Congerat You Are Now Regestiret User';                    

                } 

            }

        }
    }
?>

    <div class="container login-page">
        <h1 class="text-center">
            <span class="selected" data-class="login">Login</span> | 
            <span data-class="signup">Signup</span>
        </h1>
        <!-- Start Login Form -->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="form-login-page">
                <input
                    title="Username Must Be 4 Characters"
                    class="form-control"
                    type="text" 
                    name="username"
                    autocomplete="off"
                    required
                    placeholder="Type Your Name" />
            </div>
            <div class="form-login-page">
                <input 
                    class="form-control" 
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    required
                    placeholder="Type Your Password" />
            </div>
            <input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
        </form>
        <!-- End Login Form -->
        <!-- Start Signup Form -->
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="form-login-page">
                <input
                    class="form-control"
                    type="text" 
                    name="username"
                    autocomplete="off"
                    required
                    placeholder="Enter Your Name" />
            </div>
            <div class="form-login-page">
                <input
                    class="form-control"
                    type="text" 
                    name="fullname"
                    autocomplete="off"
                    required
                    placeholder="Enter Your Full Name" />
            </div>
            <div class="form-login-page">
                <input
                    class="form-control" 
                    type="text"
                    name="email"
                    required
                    placeholder="Enter Your Email" />
            </div>
            <div class="form-login-page">
                <input 
                    class="form-control" 
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    required
                    placeholder="Enter Complex Password" />
            </div>
            <div class="form-login-page">
                <input 
                    class="form-control" 
                    type="password"
                    name="password2"
                    autocomplete="new-password"
                    required
                    placeholder="Enter a Password Again" />
            </div>
            <input class="btn btn-success btn-block" type="submit" name="signup" value="Signup">
        </form>
        <!-- End Signup Form -->
        <div class="the-errors text-center">
            <?php  
            
                if(!empty($formErrors)){

                    foreach($formErrors as $error){

                        echo "<div class='masg error'>" . $error . "</div>";

                    }

                }

                if(isset($successMas)){

                    echo "<div class='masg success'>" . $successMas . "</div>";

                }

            ?>
        </div>
    </div>

<?php  
    include $tepl . 'footer.php';
?>