<?php
ob_start();
session_start();

$pageTitle = 'HomePage';

include 'init.php';



?>

<div class="container view-item">
    <div class="row col-items">
        <?php 

            if(isset($_SESSION['user'])){
            
                $itemsAll = getItems("", "", 'Item_ID');
                if(empty($itemsAll)){

                    echo "<div class='naice-message'>Sorry This Category Is Empty</div>";
    
                }else{
                   
                    foreach($itemsAll as $item){
                        
                        ?>
                        
                        <div class="card-items">
                            <div class="front">
                                <?php
                                    if($item['Approve'] == 0){
                                        echo "<span class='approve-status'>Waiting Approval</span>";
                                    }
                                ?>
                                <span class='price-items'>$<?php echo  $item['Price']?></span>
                                <div class='img-items'>
                                    <?php echo "<img src='admin/upload/avatar/" . $item['avatar'] ."' alt='' class='img-top'>";?>
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
               }
                
            }else{

                $itemsAll = getItems(' ', 'AND Approve = 1', 'Item_ID');
                if(empty($itemsAll)){

                    echo "<div class='naice-message'>Sorry This Category Is Empty</div>";
    
                }else{
                    foreach($itemsAll as $item){?>
                    
                        <div class="card-items">
                            <div class="front">
                                <span class='price-items'><?php echo $item['Price']?></span>
                                <div class='img-items'>
                                <?php echo "<img src='admin/upload/avatar/" . $item['avatar'] ."' alt='' class='img-top'>";?>
                                </div>
                                <h3><a href='#'> <?php echo $item['Name']?></a></h3>
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
               }
            
            }?>
            

    </div>
</div> 

<?php
include $tepl . 'footer.php';
ob_end_flush();
?>