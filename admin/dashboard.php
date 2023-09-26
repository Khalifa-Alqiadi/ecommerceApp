<?php

        /**
         * ====================================================================
         * = Dashboard Page
         * ====================================================================
         */

    ob_start(); // Output Buffring Start

    session_start();

    if(isset($_SESSION['UserName'])){

        $pageTitle = 'Dashboard';
        
        include 'init.php';

        $numUsers = 7;

        $latestUsers = getAllTable("*", "users", "", "", "UserID", "LIMIT $numUsers");

        $numItems = 6;

        $latestItems = getAllTable("*", "items","", "", "Item_ID", "LIMIT $numItems");

        $numComments = 10;

        /** Start Dashboard Page */
?>
        <div class="container home-stats text-center">
            <h1><?php echo lang('DASHBOAEDS'); ?></h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        <i class="fa fa-users"></i>
                        <div class="info">
                            Total Members
                            <span><a href="members.php"><?php echo countItems('UserID', 'users'); ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                        <i class="fa fa-user-plus"></i>
                        <div class="info">
                            Bending Members
                            <span><a href="members.php?do=Manage&page=Pending"><?php echo chickItem('RegStatus', 'users', 0); ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            Total Items
                            <span><a href="items.php"><?php echo countItems('Item_ID', 'items'); ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            Total Comments
                            <span><a href="comments.php"><?php echo countItems('C_ID', 'comments'); ?></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-users"></i> <?php echo 'Latest  <span class="btn btn-info numbers">' . $numUsers . '</span>  Registerd Users'; ?> 
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <ul class=" list-unstyled latest-users">
                                <?php
                                    foreach($latestUsers as $username){
                                        echo '<li>';
                                            echo $username['FullName'];
                                            echo '<a href="members.php?do=Edit&userid=' . $username['UserID'] . '">';
                                                echo '<span class="btn btn-success pull-right">';
                                                    echo '<i class="fa fa-edit"></i>Edit';
                                                    if($username['RegStatus'] == 0){
                                                        echo "<a href='members.php?do=Activate&userid=" 
                                                        . $username['UserID'] . "' 
                                                        class='btn btn-info pull-right activate'><i class='fa fa-check'></i> Activate</a>"; 
                                                    }
                                                echo '</span>';
                                            echo '</a>';
                                         echo '</li>';
                                    }
                                
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-tag"></i> <?php echo 'Latest  <span class="btn btn-info numbers">' . $numItems . '</span>  Items'; ?> 
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                    foreach($latestItems as $items){
                                        echo '<li>';
                                            echo $items['Name'];
                                            echo '<a href="items.php?do=Edit&itemid=' . $items['Item_ID'] . '">';
                                                echo '<span class="btn btn-success pull-right">';
                                                    echo '<i class="fa fa-edit"></i> Edit';
                                                    if($items['Approve'] == 0){
                                                        echo '<a href="items.php?do=Approve&itemid=' 
                                                        . $items['Item_ID'] . '" 
                                                        class="btn btn-info pull-right activate"><i class="fa fa-check"></i> Approve</a>';
                                                    }
                                                echo '</span>';
                                            echo '</a>';
                                        echo '</li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-comments-o"></i> <?php echo 'Latest  <span class="btn btn-info numbers">' . $numComments . '</span>  Comments'; ?>   
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="card-body">

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
                                                ORDER BY
                                                    C_ID DESC
                                                LIMIT $numComments");

                                $stmt->execute();

                                $rows = $stmt->fetchAll();

                                foreach($rows as $row){
                                    echo "<div class='comment-box'>";
                                        echo "<span class='member-n'>
                                              <a href='comments.php?do=UserComment&comid=" . $row['C_ID'] . "'>" . $row['UserName'] . "</a></span>";
                                        echo "<p class='comment-c'>" . $row['Comment'] . "</p>";
                                    echo "</div>";
                                }
                        
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php

        /** End Dashboard Page */

        include $tepl . 'footer.php';

    }else{

        header('Location: index.php');

        exit();
    }

    ob_end_flush();
    ?>