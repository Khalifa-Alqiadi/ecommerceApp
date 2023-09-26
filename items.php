<?php
ob_start();
session_start();
$pageTitle = 'Show Item';
include 'init.php';
// Check If Get Request Item Is Numeric & Get Its Integer Value
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
// Select All Data Depend On This ID

$stmt = $con->prepare("SELECT 
                            items.*,
                            categories.Name AS Category_Name,
                            users.UserName
                        FROM 
                            items
                        INNER JOIN
                            categories
                        ON
                            categories.ID = items.Cat_ID
                        INNER JOIN
                            users
                        ON
                            users.UserID = items.Member_ID 
                        WHERE Item_ID = ?
                        AND
                            Approve = 1");
// Execute Query
$stmt->execute(array($itemid));
// Fetch The Data 
$count = $stmt->rowCount();
    if($count > 0){
        $item = $stmt->fetch();
?>

        <h1 class="text-center"><?php echo $item['Name'] ?></h1>
        <div class="container">
            <div class="row">
                <div class="col-md-3 img-info">
                    <?php echo "<img src='admin/upload/avatar/" . $item['avatar'] ."' alt='' class='img-responsive img-thumbnail'>";?>
                </div>
                <div class="col-md-9 items-info">
                    <h2><?php echo $item['Name'] ?></h2>
                    <p><?php echo $item['Description'] ?></p>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Add Date</span> : <?php echo $item['Add_Date'] ?>
                        </li>
                        <li>
                            <i class="fa fa-money fa-fw"></i>
                            <span>Price</span> : $<?php echo $item['Price'] ?>
                        </li>
                        <li>
                            <i class="fa fa-building fa-fw"></i>
                            <span>Made In</span> : <?php echo $item['Country_Made'] ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Category</span> : <a href="categories.php?catid=<?php echo $item['Cat_ID']?>">
                            <?php echo $item['Category_Name'] ?></a>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Added By</span> : <a href="#"><?php echo $item['UserName'] ?></a>
                        </li>
                        <li class="tags-items">
                            <i class="fa fa-user fa-fw"></i>
                            <span>Tags</span> : 
                            <?php
                            
                                $allTags = explode(",", $item['Tags']);
                                foreach($allTags as $tag){
                                    $tag = str_replace(' ', '', $tag);
                                    $lowerTags = strtolower($tag);
                                    if(! empty($tag)){
                                     echo "<a href='tags.php?name={$lowerTags}'>" . $tag . "</a> | ";
                                    }
                                }

                            ?>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="costom-hr">
            <?php if(isset($_SESSION['user'])){ ?>
            <!-- Start Session Add Comment -->
            <div class="row">
                <div class="offset-sm-3 col-md-9">
                    <div class="add-comment">
                        <h3>Add Your Comment</h3>
                        <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
                            <textarea name="comment" required></textarea>
                            <input class="btn btn-primary" type="submit" value="Add Comment">
                        </form>
                        <?php
                        
                            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                                $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                                $itemid  = $item['Item_ID'];
                                $userid  = $_SESSION['uid'];

                                if(!empty($comment)){

                                    $stmt = $con->prepare("INSERT INTO
                                                comments(Comment, `Status`, Comment_Date, item_id, `user_id`)
                                                VALUES(:zcomment, 0, now(), :zitemid, :zuserid)");
                                    $stmt->execute(array(

                                        'zcomment' => $comment,
                                        'zitemid'  => $itemid,
                                        'zuserid'  =>$userid
            
                                    ));

                                    if($stmt){
                                         echo "<div class='alert alert-success'>Comment Added</div>";
                                    }

                                }
        
                            }

                        ?>
                    </div>
                </div>
            </div>
            <!-- End Session Add Comment -->
            <?php }else{
                echo "<a href='login.php'>Login</a> Or <a href='login.php'>Register</a> To Add Comment";
            }?>
            <hr class="costom-hr">
            <?php  
            
                $stmt = $con->prepare("SELECT
                                            comments.*,
                                            users.UserName
                                        FROM
                                            comments
                                        INNER JOIN
                                            users
                                        ON
                                            users.UserID = comments.user_id
                                        WHERE
                                            item_id = ?
                                        
                                        ORDER BY
                                            C_ID DESC");
                $stmt->execute(array($item['Item_ID']));
                $comments = $stmt->fetchAll();

                foreach($comments as $comment){?>
                    <div class="comment-box">
                        <div class="row">
                            <?php
                            if($comment['Status'] == 0){
                                echo '<div class="col-md-10">';
                                    echo "<p class='leads alert alert-danger'>This Comment Is Waiting Approval</p>";
                                echo '</div>';
                            }else{ ?>
                                <div class="col-md-2 text-center">
                                    <img src="img.png" class="img-responsive img-thumbnail img-circle" alt="" />
                                    <?php echo $comment['UserName']?>
                                </div>
                                <div class="col-md-10">
                                    <p class='lead'><?php echo $comment['Comment']?><p>
                                </div>
                    <?php   } ?>
                        </div>
                    </div>
                    <hr class="costom-hr">
               <?php }
            
            ?>
        </div>

<?php
    }else{
        $theMessage =  "<div class='alert alert-danger'>There\'s No Such ID Or This Item Is Waiting Approval</div>";
        redirectHome($theMessage, 'back', 5);
    }
include $tepl . 'footer.php';
ob_end_flush();
?>