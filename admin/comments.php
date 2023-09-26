<?php

    /**
     * ====================================================================
     * = Items Page
     * ====================================================================
     */

     ob_start();

     session_start();

     if($_SESSION['UserName']){

        $pageTitle = 'Comments';

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if($do == 'Manage'){

            $stmt = $con->prepare("SELECT
                                        comments.*,
                                        items.Name AS Item_Name,
                                        users.UserName
                                    FROM
                                        comments
                                    INNER JOIN
                                        items
                                    ON
                                        items.Item_ID = comments.item_id
                                    INNER JOIN
                                        users
                                    ON
                                        users.UserID = comments.user_id
                                    ORDER BY
                                        C_ID DESC");
            $stmt->execute();

            $rows = $stmt->fetchAll();

            ?>

            <h1 class="text-center">Manage Comments</h1>
            <div class="container">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Adding Date</td>
                        <td>Item Name</td>
                        <td>Member</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($rows as $row){
                            echo "<tr>". 
                                "<td>" . $row['C_ID'] . 
                                "<td class='td-decription'>" . $row['Comment'] . "</td>" .
                                "<td>" . $row['Comment_Date'] . 
                                "<td>" . $row['Item_Name'] . 
                                "<td>" . $row['UserName'] . 
                                "<td>" . 
                                    "<a href='comments.php?do=Edit&comid=" . $row['C_ID'] . "'
                                        class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>" . 
                                    "<a href='comments.php?do=Delete&comid=" . $row['C_ID'] . "'
                                        class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                    if($row['Status'] == 0){
                                        echo "<a href='comments.php?do=Approve&comid=" . $row['C_ID'] . "'
                                                 class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
                                    }
                            echo "<tr>";
                        }
                    ?>
                </table>
            </div>

            <?php

        }elseif($do == 'Edit'){

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

            $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ?");

            $stmt->execute(array($comid));

            $comment = $stmt->fetch();

            $count = $stmt->rowCount();

            if($count > 0){ ?>

                <h1 class="text-center">Edit Comment</h1>
                <div class="container">
                    <form class="form-horizontal " action="?do=Update" method="POST">
                        <input type="hidden" name="comid" value="<?php echo $comid; ?>" />
                        <!-- Start Comment Field -->
                        <div class="mb-2 row">
                            <label  class="col-sm-2 col-form-label">Comment</label>
                            <div class="col-sm-10 col-md-9">
                                <textarea class="form-control" name="comment"><?php echo $comment['Comment'];?></textarea> 
                            </div>
                        </div>
                        <!-- End Comment Field -->
                        <!-- Start Submit Field -->
                        <div class="mb-2 row">
                            <div class="offset-sm-2 col-sm-10">
                                <input type="submit" value="Update Comment" class="btn btn-primary">
                            </div>
                        </div>
                        <!-- End Submit Field -->
                    </form>
                </div>

            <?php

            }else{

                $TheMsg = '<div class="alert alert-danger">Thete\'s No Such ID</div>';
                redirectHome($TheMsg);

            }

        }elseif($do == 'Update'){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo "<h1 class='text-center'>Update Comment</h1>";

                $comid     = $_POST['comid'];
                $comment   = $_POST['comment'];

                $stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE C_ID = ?");

                $stmt->execute(array($comment, $comid));

                    //Echo Success Message

                $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                redirectHome($TheMsg, 'back', 5);

            }else{

                $TheMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
                redirectHome($TheMsg);

            }

        }elseif($do == 'UserComment'){

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

            $stmt = $con->prepare("SELECT
                                        comments.*,
                                        items.Name AS Item_Name,
                                        users.UserName
                                    FROM
                                        comments
                                    INNER JOIN
                                        items
                                    ON
                                        items.Item_ID = comments.item_id
                                    INNER JOIN
                                        users
                                    ON
                                        users.UserID = comments.user_id
                                        WHERE C_ID = ?");
            $stmt->execute(array($comid));

            $rows = $stmt->fetchAll();

            ?>

            <h1 class="text-center">Manage Comment</h1>
            <div class="container">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Adding Date</td>
                        <td>Item Name</td>
                        <td>Member</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($rows as $row){
                            echo "<tr>". 
                                "<td>" . $row['C_ID'] . 
                                "<td class='td-comment'>" . $row['Comment'] . "</td>" . 
                                "<td>" . $row['Comment_Date'] . 
                                "<td>" . $row['Item_Name'] . 
                                "<td>" . $row['UserName'] . 
                                "<td>" . 
                                    "<a href='comments.php?do=Edit&comid=" . $row['C_ID'] . "'
                                        class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>" . 
                                    "<a href='comments.php?do=Delete&comid=" . $row['C_ID'] . "'
                                        class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                    if($row['Status'] == 0){
                                        echo "<a href='comments.php?do=Approve&comid=" . $row['C_ID'] . "'
                                                 class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
                                    }
                            echo "<tr>";
                        }
                    ?>
                </table>
            </div>

            <?php

        }elseif($do == 'Delete'){

            echo '<h1 class="text-center"> Delete Item</h1>';

            // Check If Get Request userid Is Numeric & Get The Integer Value Of It 

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

            // Select All Data Depend On This ID

            $chick = chickItem('C_ID', 'comments', $comid);

            if($chick > 0){

                deleteRecord('comments', 'C_ID', $comid);

                $TheMsg = "<div class='alert alert-success'>" . $chick . ' Record Deleted</div>';
                redirectHome($TheMsg);

            }else{

                $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
                redirectHome($TheMsg);

            } 

        }elseif($do == 'Approve'){

            echo "<h1 class='text-center'>Approve Comment</h1>";

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

            // Select All Data Depend On This ID

            $chick = chickItem("C_ID", "comments", $comid);

            // If There's Such ID Show The Form
            

            if($chick > 0 ){ 

                $stmt = $con->prepare("UPDATE comments SET `Status` = 1 WHERE C_ID = ?");
                $stmt->execute(array($comid));

                $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                redirectHome($TheMsg, 'back');
            }

       }else{

            $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
            redirectHome($TheMsg);
       }

        include $tepl . 'footer.php';

     }else{

        header('Location: index.php');
        exit();

     }

     ob_end_flush();

?>