<?php

        /**
         * ====================================================================
         * = Members Page
         * ====================================================================
         */

        ob_start();  // Output Buffring Start
        session_start();
        $pageTitle = 'Members';

        if(isset($_SESSION['UserName'])){

            include 'init.php';

            $do = isset($_GET['do']) ? $do = $_GET['do'] : 'Manage';

            if($do == 'Manage'){ // Manage Page

                $query = '';
                if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
                    $query = 'AND RegStatus = 0';
                }
            
                $rows = getAllTable("*", "users", "WHERE GroupID != 1", $query, "UserID", "");
            
            ?>

                <h1 class="text-center">Manage Member</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table manage-members text-center table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Avatar</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Full Name</td>
                                <td>Registred Date</td>
                                <td>Control</td>
                            </tr>
                            <?php

                                foreach($rows as $row){

                                    echo "<tr>" .
                                            "<td>" . $row['UserID'] . 
                                            "</td><td class='avatar-img'>";
                                            if(empty($row['avatar'])){
                                                echo "<img src='layout/image/img.jpg' alt=''>";
                                            }else{
                                                echo "<img src='upload/avatar/" . $row['avatar'] ."' alt=''>";
                                            } 
                                            echo "</td><td>" . $row['UserName'] . 
                                            "</td><td>" . $row['Email'] . 
                                            "</td><td>" . $row['FullName'] .
                                            "</td><td>" . $row['Date'] . 
                                            "</td><td>
                                            <a href='members.php?do=Edit&userid=" . $row['UserID'] . "' 
                                               class='btn btn-success'>
                                               <i class='fa fa-edit'></i> Edit</a>
                                            <a href='members.php?do=Delete&userid=" . $row['UserID'] . "' 
                                               class='btn btn-danger confirm'>
                                               <i class='fa fa-close'></i> Delete</a>"; 
                                            if($row['RegStatus'] == 0){
                                                echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "' 
                                                        class='btn btn-info activate'>
                                                        <i class='fa fa-check'></i> Activate</a>"; 
                                            }
                                    echo "</td></tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <a href="members.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
                </div>

      <?php }elseif($do == 'Add'){ // Add Page ?>

                <h1 class="text-center">Add New Member</h1>
                <div class="container">
                    <div class="form-container">
                    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                        <!-- Start UserName -->
                            <div class="mb-2 row">
                                <label class="col-sm-2 col-form-label">User Name</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop">
                                </div>
                            </div>
                        <!-- End UserName -->
                        <!-- Start Email -->
                        <div class="mb-2 row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="email" class="form-control" required="required" placeholder="Email Must Be Valid">
                                </div>
                            </div>
                        <!-- End Email -->
                        <!-- Start Password -->
                        <div class="mb-2 row">
                                <label class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="Password Must Be Hard & Complex">
                                    <i class="show-pass fa fa-eye fa-1x"></i>
                                </div>
                            </div>
                        <!-- End Password -->
                        <!-- Start Full Name -->
                        <div class="mb-2 row">
                                <label class="col-sm-2 col-form-label">Full Name</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page">
                                </div>
                            </div>
                        <!-- End FullName -->
                        <!-- Start Avatar Field -->
                        <div class="mb-2 row">
                                <label class="col-sm-2 col-form-label">User Avatar</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="file" name="avatar" class="form-control" required="required">
                                </div>
                            </div>
                        <!-- End Avatar Field -->
                        <!-- Start Submit -->
                        <div class="mb-2 row">
                                <div class="offset-sm-2 col-sm-10">
                                    <input type="submit" value="Add Member" class=" btn btn-primary ">
                                </div>
                            </div>
                        <!-- End Submit -->
                    </form>
                    </div>
                </div> 

      <?php }elseif($do == 'Insert'){  // Insert Page

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    echo "<h1 class='text-center'>Insert Member</h1>";
                    echo "<div class='container'>";

                    // Upload Variable
                    
                    $avatarName = $_FILES['avatar']['name'];
                    $avatarType = $_FILES['avatar']['type'];
                    $avatarSize = $_FILES['avatar']['size'];
                    $avatarTmp  = $_FILES['avatar']['tmp_name'];

                    // List Of Allowed File Typed To Upload

                    $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                    // Get Avatar Extension

                    @$avatarExtension = strtolower(end(explode('.', $avatarName)));

                    // Get Vairables From The Form

                    $user = $_POST['username'];
                    $email = $_POST['email'];
                    $pass = $_POST['password'];
                    $name = $_POST['full'];

                    $hashPass = sha1($_POST['password']);

                    $formArray = array();

                    if(strlen($user) < 4){
                        $formArray[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
                    }
                    if(strlen($user) > 20){
                        $formArray[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
                    }
                    if(empty($user)){
                        $formArray[] = 'Username Cant Be <strong>Empty</strong>';
                    }
                    if(empty($email)){
                        $formArray[] = 'Email Cant Be <strong>Empty</strong>';
                    }
                    if(empty($pass)){
                        $formArray[] = 'Password Cant Be <strong>Empty</strong>';
                    }
                    if(empty($name)){
                        $formArray[] = 'Full Name Cant Be <strong>Empty</strong>';
                    }
                    if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
                        $formArray[] = 'This Extension Is Not <strong>Allowed</strong>';
                    }
                    if(empty($avatarName)){
                        $formArray[] = 'Avatar Is <strong>Required</strong>';
                    }
                    if($avatarSize > 4194304){
                        $formArray[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
                    }

                    // Loop Into Error Array And Echo It
                    foreach($formArray as $errors){
                        echo '<div class="alert alert-danger">' . $errors . '</div>';
                    }
                    
                    // Check If There's No Erorr Proceed The Update Operations

                    if(empty($formArray)){

                        $avatar = rand(0, 100000) . '_' . $avatarName;
                        move_uploaded_file($avatarTmp, "upload\avatar\\" . $avatar);
                        

                        // Chick If User Exist In Databas

                        $chick = chickItem("UserName", "users", $user);

                        if($chick == 1){

                            $TheMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
                            redirectHome($TheMsg, 'back', 5);

                        }else{

                            // Insert Userinfo Into Database

                            $stmt = $con->prepare("INSERT INTO 
                                                        users(UserName, Email, Pass, FullName, RegStatus, `Date`, avatar)
                                                    VALUES(:zuser, :zmail, :zpass, :zname, 0, now(), :zavatar)");
                            $stmt->execute(array(
                                'zuser'   => $user,
                                'zmail'   => $email,
                                'zpass'   => $hashPass,
                                'zname'   => $name,
                                'zavatar' => $avatar
                            ));

                            //Echo Success Message

                            $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                            redirectHome($TheMsg, 'back', 5);

                        }

                    }

                        echo "</div>";

                }else{

                    $TheMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                    redirectHome($TheMsg, 'back', 5);

                }
                
            
            }elseif($do == 'Edit'){ // Edit Page 

                // Check If Get Request userid Is Numeric & Get The Integer Value Of It 
                
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

                // Select All Data Depend On This ID

                $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

                // Execute Query

                $stmt->execute(array($userid));

                // Fecth The Data

                $row = $stmt->fetch();

                // The Row Count
                $count = $stmt->rowCount();

                // If There's Such ID Show The Form


                if($stmt->rowCount() > 0 ){ ?>

                    <h1 class="text-center">Edit Member</h1>
                    <div class="container">
                        <div class="form-container">
                        <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                            <!-- Start UserName -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">User Name</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="username" value="<?php echo $row['UserName']; ?>" class="form-control" autocomplete="off" required="required">
                                    </div>
                                </div>
                            <!-- End UserName -->
                            <!-- Start Email -->
                            <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="email" value="<?php echo $row['Email']; ?>" class="form-control" required="required">
                                    </div>
                                </div>
                            <!-- End Email -->
                            <!-- Start Password -->
                            <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="hidden" name="oldpassword" value="<?php echo $row['Pass']; ?>"> 
                                        <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Bland If You Dont WantTo Change">
                                    </div>
                                </div>
                            <!-- End Password -->
                            <!-- Start Full Name -->
                            <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Full Name</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="full" value="<?php echo $row['FullName']; ?>" class="form-control" required="required">
                                    </div>
                                </div>
                            <!-- End FullName -->
                            <!-- Start Avatar Field -->
                            <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">User Avatar</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input 
                                            type="file" 
                                            name="avatar" 
                                            value="<?php echo $row['avatar'] ?>"
                                            class="form-control" 
                                            required="required">
                                    </div>
                                </div>
                            <!-- End Avatar Field -->
                            <!-- Start Submit -->
                            <div class="mb-2 row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <input type="submit" value="Update" class=" btn btn-primary ">
                                    </div>
                                </div>
                            <!-- End Submit -->
                        
                        </form>
                        </div>
                    </div>    
<?php

                }// End If Row Count

                // If There's No Such ID Show Error Message

                else{

                    $TheMsg = '<div class="alert alert-danger">Thete\'s No Such ID</div>';
                    redirectHome($TheMsg);

                } // End Else RowCount

           } // End Edit Page

           elseif($do == 'Update'){ // Update Page

            echo "<h1 class='text-center'>Update Member</h1>";
            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Upload Variable
                
                $avatarName = $_FILES['avatar']['name'];
                $avatarType = $_FILES['avatar']['type'];
                $avatarSize = $_FILES['avatar']['size'];
                $avatarTmp  = $_FILES['avatar']['tmp_name'];

                // List Of Allowed File Typed To Upload

                $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                // Get Avatar Extension

                @$avatarExtension = strtolower(end(explode('.', $avatarName)));


                // Get Vairables From The Form

                $id     = $_POST['userid'];
                $user   = $_POST['username'];
                $email  = $_POST['email'];
                $name   = $_POST['full'];

                // Password Trick

                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

                $formArray = array();

                if(strlen($user) < 4){
                    $formArray[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
                }
                if(strlen($user) > 20){
                    $formArray[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
                }
                if(empty($user)){
                    $formArray[] = 'Username Cant Be <strong>Empty</strong>';
                }
                if(empty($email)){
                    $formArray[] = 'Email Cant Be <strong>Empty</strong>';
                }
                if(empty($name)){
                    $formArray[] = 'Full Name Cant Be <strong>Empty</strong>';
                }
                if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
                    $formArray[] = 'This Extension Is Not <strong>Allowed</strong>';
                }
                if(empty($avatarName)){
                    $formArray[] = 'Avatar Is <strong>Required</strong>';
                }
                if($avatarSize > 4194304){
                    $formArray[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
                }

                // Loop Into Error Array And Echo It
                foreach($formArray as $errors){
                    $TheMsg = '<div class="alert alert-danger">' . $errors . '</div>';
                    redirectHome($TheMsg, 'back', 10);
                }

                // Check If There's No Erorr Proceed The Update Operations

                if(empty($formArray)){

                    $avatar = rand(0, 100000) . '_' . $avatarName;
                    move_uploaded_file($avatarTmp, "upload\avatar\\" . $avatar);

                    $stmt2 = $con->prepare("SELECT
                                                *
                                            FROM
                                                users
                                            WHERE
                                                UserName = ?
                                            AND
                                                UserID != ?");
                    $stmt2->execute(array($user, $id));

                    $count = $stmt2->rowCount();

                    if($count == 1){

                        $TheMsg = "<div class='alert alert-danger'>Sorry This User Is Exist</div>";
                        redirectHome($TheMsg, 'back');

                    }else{

                        // Update The Database With This Info

                        $stmt = $con->prepare("UPDATE users SET UserName = ?, Email = ?, FullName = ?, Pass = ?, avatar = ? WHERE UserID = ?");
                        $stmt->execute(array($user, $email, $name, $pass, $avatar, $id));

                        //Echo Success Message

                        $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                        redirectHome($TheMsg, 'back');

                    }

                }

            }else{

                $TheMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
                redirectHome($TheMsg);

            }

           }elseif($do == 'Delete'){ // Delete Member

                echo "<h1 class='text-center'>Update Member</h1>";
                

                // Check If Get Request userid Is Numeric & Get The Integer Value Of It 
                
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

                // Select All Data Depend On This ID

                $chick = chickItem("UserID", "users", $userid);

                // If There's Such ID Show The Form
                

                if($chick > 0 ){ 

                    deleteRecord("users", "UserID", $userid);

                    $TheMsg = "<div class='alert alert-success'>" . $chick . ' Record Deleted</div>';
                    redirectHome($TheMsg, 'back', 5);
                }else{
                    $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
                    redirectHome($TheMsg);
                }
                
           }elseif($do == 'Activate'){

                echo "<h1 class='text-center'>Activate Member</h1>";

                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

                // Select All Data Depend On This ID

                $chick = chickItem("UserID", "users", $userid);

                // If There's Such ID Show The Form
                

                if($chick > 0 ){ 

                    $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
                    $stmt->execute(array($userid));

                    $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                    redirectHome($TheMsg);
                }

           }else{

                $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
                redirectHome($TheMsg);
           }

            include $tepl . 'footer.php';

        } // End If $_SESSION['UserName']
        
        else{

            header('Location: index.php');

            exit();
        }// End Else $_SESSION['UserName']

        ob_end_flush();

?>