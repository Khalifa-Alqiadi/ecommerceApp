<?php

session_start();

$pageTitle = 'Profile';

include 'init.php';

if(isset($_SESSION['user'])){
    $getUser = $con->prepare("SELECT * FROM users WHERE UserName = ?");

    $getUser->execute(array($sessionUser));

    $infoUser = $getUser->fetch();
    $userid = $infoUser['UserID'];
?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">My Information</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Name</span> :               <?php echo $infoUser['UserName']; ?>
                        </li>
                        <li>
                            <i class="fa fa-envelope-o fa-fw"></i>
                            <span>Email</span> :              <?php echo $infoUser['Email']; ?>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Full Name</span> :          <?php echo $infoUser['FullName']; ?>
                        </li>
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Register Date</span> :      <?php echo $infoUser['Date']; ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Favouret Category</span> : 
                        </li>
                    </ul>
                    <a href="#" class="btn btn-default">Edit Information</a>
                </div>
            </div>
        </div>
    </div>

    <div id="view-items" class="view-items block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">My Items</div>
                <div class="card-body">
                    <div class="row row-cols-md-4">
                        <?php 

                            $items = getAllTable("*", "items", "where Member_ID = $userid", "", "Item_ID");

                            if(empty($items)){

                                echo "<div class='naice-message'>
                                        Not Exist Ads, Create <a href='newad.php'>New Add</a>
                                      </div>";

                            }else{
                                foreach($items as $item){
                                    echo "<div class='ads-user'>";
                                        echo "<div class='ads-items'>";
                                            if($item['Approve'] == 0){ 
                                                echo "<span class='approve-status'>Waiting Approval</span>"; 
                                            }
                                            echo "<span class='price-items'>" . $item['Price'] . "</span>";
                                            echo "<div class='img-items'>";
                                                echo "<img src='img.png' class='img-top' alt='' />";
                                            echo "</div>";
                                            echo "<div class='items-body'>";
                                                echo "<h3 class='title-items'>";
                                                    echo "<a href='items.php?itemid=" . $item['Item_ID'] . "'>";
                                                        echo $item['Name'];
                                                    echo "</a>";
                                                echo "</h3>";
                                                echo "<p class='text-items'>". $item['Description'] ."</p>";
                                                echo "<p class='date-items'>". $item['Add_Date'] ."</p>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-comment block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">Latests Comments</div>
                <div class="card-body">
                    <?php 
                        $myComments = getAllTable("Comment", "comments", "where `user_id` = $userid", "", "C_ID");

                        if(!empty($myComments)){

                            foreach($myComments as $comment){

                                echo "<p>" . $comment['Comment'] . "</p>";

                            }

                        }else{

                            echo "There\'s No Comments To Show";

                        }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
}else{

    header('Location: login.php');

    exit();

}

include $tepl . 'footer.php';

ob_end_flush();
?>