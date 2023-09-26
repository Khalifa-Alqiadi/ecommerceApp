<?php 
ob_start();
session_start();

$pageTitle = 'Categories';

include 'init.php'; ?>

<div class="container view-items">
        <?php 
        if(isset($_GET['name'])){
            $tags = $_GET['name'];
            echo "<h1 class='text-center'>" . $tags . "</h1>";
            echo '<div class="row row-cols-md-4">';
            $tagsItems = getItems("where Tags like '%$tags%'", "AND Approve = 1", "Item_ID");
            if(! empty($tagsItems)){
                foreach($tagsItems as $item){?>
                    <div class="card-items">
                        <div class="front">
                            <span class='price-items'><?php echo $item['Price']?></span>
                            <div class='img-items'>
                                <?php echo "<img src='admin/upload/avatar/" . $item['avatar'] ."' alt='' class='img-responsive img-thumbnail img-top'>";?>
                            </div>
                            <h3><a href='items.php?itemid=<?php echo $item['Item_ID']?>'> <?php echo $item['Name']?></a></h3>
                        </div>
                        <div class="back">
                            <ul class='list-items'>
                                <li>Added By: <span><i class='fa fa-user'></i> <?php echo $item['UserName']?></span></li>
                                <li>Added For Date: <span><i class='fa fa-book'></i> <?php echo $item['Add_Date']?></span></li>
                                <li>Numbers The comments: <span>
                                    <i class='fa fa-comment'></i>  
                                    <?php echo countComment("item_id", "comments", $item['Item_ID'])?></span>
                                </li>
                            </ul>
                            <p class='text-items'><?php echo $item['Description']?></p>
                        </div>
                    </div>
            <?php }
            }else{
                echo "<div class='naice-message'>Sorry This Category Is Empty</div>";
            }

        }else{
            
            echo "<div class='naice-message'>You Must Add Page ID</div>";
        }
        ?>
    </div>
</div>   
      
<?php include $tepl . 'footer.php'; 
ob_end_flush();
?>