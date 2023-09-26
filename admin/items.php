<?php

    /**
     * ====================================================================
     * = Items Page
     * ====================================================================
     */

    ob_start(); // Output Buffring Start

    session_start();

    

    if(isset($_SESSION['UserName'])){

        $pageTitle = 'Items';

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if($do == 'Manage'){
            //if(!empty($stmt)){
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
                                    ORDER BY
                                        Item_ID DESC");

            $stmt->execute();

            $items = $stmt->fetchAll();
            
            ?>

            <h1 class='text-center'>Manage Items</h1>
            <div class='container'>
                <div class="table-responsive">
                    <table class="main-table text-center manage-members  table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Image</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Adding Date</td>
                            <td>Category</td>
                            <td>Member</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach($items as $item){
                                echo "<tr>". 
                                           "<td>" . $item['Item_ID']. 
                                           "</td><td class='avatar-img'>";
                                        if(empty($item['avatar'])){
                                            echo "<img src='layout/image/img.jpg' alt=''>";
                                        }else{
                                            echo "<img src='upload/avatar/" . $item['avatar'] ."' alt=''>";
                                        } 
                                        echo "</td><td>" . $item['Name'] . 
                                           "<td class='td-decription'>" . $item['Description'] . 
                                           "<td>" . $item['Price'] . 
                                           "<td>" . $item['Add_Date'] .
                                           "<td>" . $item['Category_Name'] .
                                           "<td>" . $item['UserName'] .
                                           "<td>" . 
                                                  "<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' 
                                                      class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>". 
                                                  "<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' 
                                                      class='btn btn-danger confirm'>
                                                      <i class='fa fa-close'></i> Delete</a>";
                                                    if($item['Approve'] == 0){
                                                        echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
                                                                class='btn btn-info activate'>
                                                                <i class='fa fa-check'></i> Approve</a>"; 
                                                    }
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
                <a href="items.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
            </div>

            <?php
           // }
        }elseif($do == 'Add'){ // Add Page ?>

            <h1 class="text-center">Add New Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <!-- Start Name Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                 class="form-control"
                                 type="text" 
                                 name="name"  
                                 placeholder="Name Of The Item">
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Start Description Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                 class="form-control" 
                                 type="text" 
                                 name="description"                                 
                                 placeholder="Description of The Item">
                        </div>
                    </div>
                    <!-- End Description Field -->
                    <!-- Start Price Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                 class="form-control" 
                                 type="text" 
                                 name="price" 
                                  
                                 placeholder="Price of The Item">
                        </div>
                    </div>
                    <!-- End Price Field -->
                    <!-- Start Country Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Country</label>
                        <div class="col-sm-10 col-md-9">
                            <input
                                 class="form-control" 
                                 type="text"
                                 name="country"
                                 
                                 placeholder="Country of The Made">
                                 
                        </div>
                    </div>
                    <!-- End Country Field -->
                    <!-- Start Status Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="status">
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->
                    <!-- Start Members Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Member</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="member">
                                <option value="0">...</option>
                                <?php
                                    $allMembers = getAllTable('*', 'users', '', '', 'UserID', 'ASC', '');
                                    foreach($allMembers as $user){
                                        echo '<option value="' . $user['UserID'] . '">' . $user['UserName'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Members Field -->
                    <!-- Start Categories Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="category">
                                <option value="0">...</option>
                                <?php
                                    $allCats = getAllTable('*', 'categories', 'WHERE Parent = 0', '', 'ID', 'ASC');
                                    foreach($allCats as $cat){
                                        echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                        $childCats = getAllTable("*", "categories", "WHERE Parent = {$cat['ID']}", "", "ID", "ASC");
                                        foreach($childCats as $child){
                                            echo "<option value='" . $child['ID'] . "'>----- " . $child['Name'] . "</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Categories Field -->
                    <!-- Start Tags Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Tags</label>
                        <div class="col-sm-10 col-md-9">
                            <input
                                 class="form-control" 
                                 type="text"
                                 name="tags"
                                 placeholder="Separate Tags With Comma (,)">
                        </div>
                    </div>
                    <!-- End Tags Field -->
                    <!-- Start Image Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Avatar</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="file" name="avatar" class="form-control" required="required">
                        </div>
                    </div>
                    <!-- End Image Field -->
                    <!-- Start Submit Field -->
                    <div class="mb-2 row">
                        <div class="offset-sm-2 col-sm-10">
                            <input type="submit" value="Add Item" class="btn btn-primary">
                        </div>
                    </div>
                    <!-- End Submit Field -->
                </form>
            </div>

        <?php

        }elseif($do == 'Insert'){ // Insert Page

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<h1 class="text-center">Insert Page</h1>';
                echo '<div class="container">';

                // Upload Variable
                
                    // Upload Variable
                    
                    $avatarName = $_FILES['avatar']['name'];
                    $avatarType = $_FILES['avatar']['type'];
                    $avatarSize = $_FILES['avatar']['size'];
                    $avatarTmp  = $_FILES['avatar']['tmp_name'];

                    // List Of Allowed File Typed To Upload

                    $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                    // Get Avatar Extension

                    @$avatarExtension = strtolower(end(explode('.', $avatarName)));

                // Get Variables From The Form

                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $status     = $_POST['status'];
                $member     = $_POST['member'];
                $category   = $_POST['category'];
                $tags       = $_POST['tags'];

                // Validate The Form

                $formError = array();

                if(empty($name)){
                    $formError[] = 'Name Can\'t be <strong>Empty</strong>';
                }
                if(empty($desc)){
                    $formError[] = 'Description Can\'t be <strong>Empty</strong>';
                }
                if(empty($price)){
                    $formError[] = 'Price Can\'t be <strong>Empty</strong>';
                }
                if(empty($country)){
                    $formError[] = 'Country Can\'t be <strong>Empty</strong>';
                }
                if($status == 0){
                    $formError[] = 'You Must Choose The <strong>Status</strong>';
                }
                if($member == 0){
                    $formError[] = 'You Must Choose The <strong>Member</strong>';
                }
                if($category == 0){
                    $formError[] = 'You Must Choose The <strong>Category</strong>';
                }
                if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
                    $formError[] = 'This Extension Is Not <strong>Allowed</strong>';
                }
                if(empty($avatarName)){
                    $formError[] = 'Avatar Is <strong>Required</strong>';
                }
                if($avatarSize > 4194304){
                    $formError[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
                }


                // Loop Into Errors Array And Echo It

                foreach($formError as $error){

                    echo '<div class="alert alert-danger">' . $error . '</div>';
                    
                }

                if(empty($formError)){

                    $avatar = rand(0, 100000) . '_' . $avatarName;
                    move_uploaded_file($avatarTmp, "upload\avatar\\" . $avatar);

                    $stmt = $con->prepare("INSERT INTO
                                    items(`Name`, `Description`, Price, Country_Made, `Status`, Add_Date, Cat_ID, Member_ID, Tags, avatar)
                                VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags, :zavatar)");
                    $stmt->execute(array(

                        'zname'     => $name,
                        'zdesc'     => $desc,
                        'zprice'    => $price,
                        'zcountry'  => $country,
                        'zstatus'   => $status,
                        'zcat'      => $category,
                        'zmember'   => $member,
                        'ztags'     => $tags,
                        'zavatar'    => $avatar
                    ));

                    $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                    redirectHome($TheMsg, 'back');


                }

            }else{

                $TheMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                redirectHome($TheMsg);


            }
            echo '</div>';

        }elseif($do == 'Edit'){// Edit Page

            // Check If Get Request itemid Is Numeric & Get The Integer Value Of It

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");

            // Execute Query

            $stmt->execute(array($itemid));

            // Fetch The Data

            $item = $stmt->fetch();

            // The Row Count

            $count = $stmt->rowCount();

            if($count > 0){ ?>

                <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
                        <!-- Start Name Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 col-md-9">
                                <input 
                                    class="form-control"
                                    type="text" 
                                    name="name"  
                                    placeholder="Name Of The Item"
                                    value="<?php echo $item['Name']; ?>">
                            </div>
                        </div>
                        <!-- End Name Field -->
                        <!-- Start Description Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10 col-md-9">
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    name="description"                                 
                                    placeholder="Description of The Item"
                                    value="<?php echo $item['Description']; ?>">
                            </div>
                        </div>
                        <!-- End Description Field -->
                        <!-- Start Price Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10 col-md-9">
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    name="price" 
                                    
                                    placeholder="Price of The Item"
                                    value="<?php echo $item['Price']; ?>">
                            </div>
                        </div>
                        <!-- End Price Field -->
                        <!-- Start Country Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Country</label>
                            <div class="col-sm-10 col-md-9">
                                <input
                                    class="form-control" 
                                    type="text"
                                    name="country"
                                    
                                    placeholder="Country of The Made"
                                    value="<?php echo $item['Country_Made']; ?>">
                                    
                            </div>
                        </div>
                        <!-- End Country Field -->
                        <!-- Start Status Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="status">
                                    <option value="1" <?php if($item['Status'] == 1){echo 'selected';} ?>>New</option>
                                    <option value="2" <?php if($item['Status'] == 2){echo 'selected';} ?>>Like New</option>
                                    <option value="3" <?php if($item['Status'] == 3){echo 'selected';} ?>>Used</option>
                                    <option value="4" <?php if($item['Status'] == 4){echo 'selected';} ?>>Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Field -->
                        <!-- Start Members Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Member</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="member">
                                    <?php
                                        $users = getAllTable("*", "users", "", "", "UserID", "ASC", "");
                                        foreach($users as $user){
                                            echo '<option value="' . $user['UserID'] . '"';
                                            if($item['Member_ID'] == $user['UserID']){echo 'selected';}
                                            echo '>' . $user['UserName'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Members Field -->
                        <!-- Start Categories Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="category">
                                    <?php
                                        $cats = getAllTable("*", "categories", "", "", "ID", "ASC", "");
                                        foreach($cats as $cat){
                                            echo '<option value="' . $cat['ID'] . '"';
                                            if($item['Cat_ID'] == $cat['ID']){echo 'selected';}
                                            echo '>' . $cat['Name'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Categories Field -->
                        <!-- Start Tags Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Tags</label>
                            <div class="col-sm-10 col-md-9">
                                <input
                                    class="form-control" 
                                    type="text"
                                    name="tags"
                                    placeholder="Separate Tags With Comma (,)"
                                    value="<?php echo $item['Tags']; ?>">
                            </div>
                        </div>
                        <!-- End Tags Field -->
                        <!-- Start Image Field -->
                        <div class="mb-2 row">
                                <label class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10 col-md-9">
                                    <input 
                                        type="file" 
                                        name="avatar" 
                                        value="<?php echo $item['avatar'] ?>"
                                        class="form-control" 
                                        required="required">
                                </div>
                            </div>
                        <!-- End Image Field -->
                        <!-- Start Submit Field -->
                        <div class="mb-2 row">
                            <div class="offset-sm-2 col-sm-10">
                                <input type="submit" value="Update Item" class="btn btn-primary">
                            </div>
                        </div>
                        <!-- End Submit Field -->
                    </form>

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
                                        WHERE item_id = ?");
                $stmt->execute(array($itemid));

                $rows = $stmt->fetchAll();

                if(! empty($rows)){

                ?>

                    <h1 class="text-center">Manage [ <?php echo $item['Name']; ?> ] Comments</h1>
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>Comment</td>
                            <td>Adding Date</td>
                            <td>Member</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach($rows as $row){
                                echo "<tr>". 
                                    "<td>" . $row['Comment'] . 
                                    "<td>" . $row['Comment_Date'] . 
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
                <?php }?>
                </div>

            <?php

            }else{

                $TheMsg = '<div class="alert alert-danger">Thete\'s No Such ID</div>';
                redirectHome($TheMsg);

            }

        }elseif($do == 'Update'){ // Update Page

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<h1 class="text-center">Update Item</h1>';

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

                $id         = $_POST['itemid'];
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $status     = $_POST['status'];
                $member     = $_POST['member'];
                $category   = $_POST['category'];
                $tags       = $_POST['tags'];

                // Validate The Form

                $formError = array();

                if(empty($name)){
                    $formError[] = 'Name Can\'t be <strong>Empty</strong>';
                }
                if(empty($desc)){
                    $formError[] = 'Description Can\'t be <strong>Empty</strong>';
                }
                if(empty($price)){
                    $formError[] = 'Price Can\'t be <strong>Empty</strong>';
                }
                if(empty($country)){
                    $formError[] = 'Country Can\'t be <strong>Empty</strong>';
                }
                if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
                    $formError[] = 'This Extension Is Not <strong>Allowed</strong>';
                }
                if(empty($avatarName)){
                    $formError[] = 'Avatar Is <strong>Required</strong>';
                }
                if($avatarSize > 4194304){
                    $formError[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
                }

                // Loop Into Errors Array And Echo It

                foreach($formError as $error){

                    echo '<div class="alert alert-danger">' . $error . '</div>';
                    
                }

                // Check If There's No Erorr Proceed The Update Operations

                if(empty($formError)){

                    $avatar = rand(0, 100000) . '_' . $avatarName;
                    move_uploaded_file($avatarTmp, "upload\avatar\\" . $avatar);

                    // Update The Database With This Info

                    $stmt = $con->prepare("UPDATE 
                                                items 
                                            SET 
                                                `Name` = ?,
                                                `Description` = ?, 
                                                Price = ?,
                                                Country_Made = ?, 
                                                `Status` = ?, 
                                                Cat_ID = ?, 
                                                Member_ID = ?,
                                                Tags = ?,
                                                avatar = ?
                                            WHERE 
                                                Item_ID = ?");
                    $stmt->execute(array($name, $desc, $price, $country, $status, $category, $member, $tags, $avatar, $id ));

                    //Echo Success Message

                    $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                    redirectHome($TheMsg, 'back', 5);

                }

            }else{

                $TheMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
                redirectHome($TheMsg);

            }

        }elseif($do == 'Delete'){

            echo '<h1 class="text-center"> Delete Item</h1>';

            // Check If Get Request userid Is Numeric & Get The Integer Value Of It 

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            // Select All Data Depend On This ID

            $chick = chickItem('Item_ID', 'items', $itemid);

            if($chick > 0){

                deleteRecord('items', 'Item_ID', $itemid);

                $TheMsg = "<div class='alert alert-success'>" . $chick . ' Record Deleted</div>';
                redirectHome($TheMsg, 'back', 5);

            }else{

                $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
                redirectHome($TheMsg);

            } 

        }elseif($do == 'Approve'){

            echo "<h1 class='text-center'>Approve Item</h1>";

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            // Select All Data Depend On This ID

            $chick = chickItem("Item_ID", "items", $itemid);

            // If There's Such ID Show The Form
            

            if($chick > 0 ){ 

                $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
                $stmt->execute(array($itemid));

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