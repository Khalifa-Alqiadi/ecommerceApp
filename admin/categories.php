<?php

    /**
     * ====================================================================
     * = Members Page
     * ====================================================================
     */

    ob_start(); // Output Buffring Start

    session_start();

    

    if(isset($_SESSION['UserName'])){

        $pageTitle = 'Categories';

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] :'Manage';

        $sort = 'ASC';

        $sort_array = array('ASC', 'DESC');

        if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){

            $sort = $_GET['sort'];
        }

        if($do == 'Manage'){ // Manage Page

            $catsAll = getAllTable('*', 'categories', 'where Parent = 0', '', 'Ordering', $sort, '');
             ?>

            <h1 class="text-center">Manage Categories</h1>
            <div class="container categories">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-edit"></i> Manage Categories
                        <div class="option pull-right">
                            <i class="fa fa-sort"></i> Ordering: [  
                            <a class="<?php if($sort == 'ASC'){ echo 'active';} ?>" href="?sort=ASC"> ASC</a> | 
                            <a class="<?php if($sort == 'DESC'){ echo 'active';} ?>" href="?sort=DESC">DESC</a> ]
                            <i class="fa fa-eye"></i> View: [
                            <span class="active" data-view="full">Full</span> | 
                            <span data-view="classic">Classic</span> ]
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <?php
                        
                            foreach($catsAll as $cat){
                                echo '<div class="cat">';
                                    echo '<div class="hidden-button">';
                                        echo '<a href="categories.php?do=Edit&catid=' . $cat['ID'] . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                                        echo '<a href="categories.php?do=Delete&catid=' . $cat['ID'] . '" class="confirm btn btn-xs btn-danger"><i class="fa fa-close"></i> Delete</a>';
                                    echo '</div>';
                                    echo '<h3>' . $cat['Name'] . '</h3>';
                                    echo "<div class='full-view'>";
                                        echo '<p>'; if($cat['Description'] == ''){echo 'This Category Has No Description';}else{ echo $cat['Description'];} echo '</p>';
                                        if($cat['Visibility'] == 1){echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>';} 
                                        if($cat['Allow_Comment'] == 1){echo '<span class="commenting"><i class="fa fa-close"></i> Commernts Displeted</span>';} 
                                        if($cat['Allow_Ads'] == 1){echo '<span class="advertises"><i class="fa fa-close"></i> Ads Displeted</span>';} 
                                        // Get Child Categories
                                        $childCat = getAllTable("*", "categories", "where Parent = {$cat['ID']}", "", "ID", "ASC");
                                        if(! empty($childCat)){
                                            echo "<h5>Child Category</h5>";
                                            echo "<ul class='list-unstyled child-cats'>";
                                                foreach($childCat as $child){
                                                    echo "<li  class='child-link'>
                                                        <a href='categories.php?do=Edit&catid=" . $child['ID'] . "'>" . $child['Name'] . "</a>
                                                        <a href='categories.php?do=Delete&catid=" . $child['ID'] . "' class='confirm child-delete'> Delete</a>";
                                                    echo "</li>";
                                                    if($child['Visibility'] == 1){echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>';} 
                                                    if($child['Allow_Comment'] == 1){echo '<span class="commenting"><i class="fa fa-close"></i> Commernts Displeted</span>';} 
                                                    if($child['Allow_Ads'] == 1){echo '<span class="advertises"><i class="fa fa-close"></i> Ads Displeted</span>';}
                                                }
                                            echo "</ul>";
                                        }
                                    echo "</div>";
                                echo '</div>';
                                echo '<hr>';
                            }

                        ?>
                    </div>
                </div>
                <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New</a>
            </div>

        <?php

        }elseif($do == 'Add'){ // Add Page ?>

            <h1 class="text-center">Add New Categories</h1>
            <div class="container">
                <div class="form-container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">
                        <!-- Start Name Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category">
                            </div>
                        </div>
                        <!-- End Name Field -->
                        <!-- Start Description Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="description" class="form-control" placeholder="Describe The Category">
                            </div>
                        </div>
                        <!-- End Description Field -->
                        <!-- Start Ordering Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Ordering</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="ordering" class="form-control" placeholder="Number To Arrenge The Categories">
                            </div>
                        </div>
                        <!-- End Ordering Field -->
                        <!-- Start Categories Type -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Parent?</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="parent">
                                    <option value="0">None</option>
                                    <?php 
                                        $catsAll = getAllTable('*', 'categories', 'WHERE Parent = 0', '', 'ID', 'ASC', '');
                                        foreach($catsAll as $cats){
                                            echo "<option value='" . $cats['ID'] . "'>" . $cats['Name'] . "</option>"; 
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Categories Type -->
                        <!-- Start Visibility Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Visible</label>
                            <div class="col-sm-10 col-md-9">
                                <div>
                                    <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visibility" value="1"  />
                                    <label for="vis-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Visibility Field -->
                        <!-- Start Allow Comments Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Allow Comments</label>
                            <div class="col-sm-10 col-md-9">
                                <div>
                                    <input id="com-yes" type="radio" name="comment" value="0" checked />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="comment" value="1"  />
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Allow Comments Field -->
                        <!-- Start Allow Ads Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Allow Ads</label>
                            <div class="col-sm-10 col-md-9">
                                <div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" checked />
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1"  />
                                    <label for="ads-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Allow Ads Field -->
                        <!-- Start Submit -->
                        <div class="mb-2 row">
                            <div class="offset-sm-2 col-sm-10">
                                <input type="submit" value="Add Category" class=" btn btn-primary ">
                            </div>
                        </div>
                    <!-- End Submit -->
                    </form>
                </div>
            </div> 

<?php   }elseif($do == 'Insert'){ // Insert Page

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo "<h1 class='text-center'>Insert Category</h1>";
                

                // Get Vairables From The Form

                $name       = $_POST['name'];
                $describ    = $_POST['description'];
                $parent     = $_POST['parent'];
                $order      = $_POST['ordering'];
                $visible    = $_POST['visibility'];
                $comment    = $_POST['comment'];
                $ads        = $_POST['ads'];

                // Chick If Category Exist In Databas

                $chick = chickItem("Name", "categories", $name);

                if($chick == 1){

                    $TheMsg = '<div class="alert alert-danger">Sorry This Categories Is Exist</div>';
                    redirectHome($TheMsg, 'back', 5);

                }else{

                    // Insert Categories Info Into Database

                    $stmt = $con->prepare("INSERT INTO 
                                                categories(`Name`, `Description`, Parent, Ordering, Visibility, Allow_Comment, Allow_Ads)
                                            VALUES(:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads)");
                    $stmt->execute(array(
                        'zname'     => $name,
                        'zdesc'     => $describ,
                        'zparent'   => $parent,
                        'zorder'    => $order,
                        'zvisible'  => $visible,
                        'zcomment'  => $comment,
                        'zads'      => $ads
                    ));

                    //Echo Success Message

                    $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                    redirectHome($TheMsg, 'back', 5);

                }

            }else{

                $TheMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                redirectHome($TheMsg, 'back', 5);

            }

        }elseif($do == 'Edit'){ // Edit Page

                // Check If Get Request catid Is Numeric & Get The Integer Value Of It 
                
                $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

                // Select All Data Depend On This ID

                $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? ");

                // Execute Query

                $stmt->execute(array($catid));

                // Fecth The Data

                $cat = $stmt->fetch();

                // The Row Count
                $count = $stmt->rowCount();

                // If There's Such ID Show The Form

                if($count > 0 ){ ?>

                    <h1 class="text-center">Edit Categories</h1>
                    <div class="container">
                        <div class="form-container">
                            <form class="form-horizontal" action="?do=Update" method="POST">
                                <input type="hidden" name="catid" value="<?php echo $catid; ?>">
                                <!-- Start Name Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="name" class="form-control"  required="required" value="<?php echo $cat['Name'] ?>">
                                    </div>
                                </div>
                                <!-- End Name Field -->
                                <!-- Start Description Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="description" class="form-control" placeholder="This Description Is Empty" value="<?php echo $cat['Description'] ?>">
                                    </div>
                                </div>
                                <!-- End Description Field -->
                                <!-- Start Ordering Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Ordering</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="ordering" class="form-control" placeholder="Number To Arrenge The Categories" value="<?php echo $cat['Ordering'] ?>">
                                    </div>
                                </div>
                                <!-- End Ordering Field -->
                                <!-- Start Categories Type -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Parent?</label>
                                    <div class="col-sm-10 col-md-9">
                                        <select name="parent">
                                            <option value="0">None</option>
                                            <?php 
                                                $catsAll = getAllTable('*', 'categories', 'WHERE Parent = 0', '', 'ID', 'ASC', '');
                                                foreach($catsAll as $cats){
                                                    echo "<option value='" . $cats['ID'] . "'";
                                                        if($cat['Parent'] == $cats['ID']){ echo "selected"; }
                                                    echo ">" . $cats['Name'] . "</option>"; 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End Categories Type -->
                                <!-- Start Visibility Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Visible</label>
                                    <div class="col-sm-10 col-md-9">
                                        <div>
                                            <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0){echo 'checked';} ?> />
                                            <label for="vis-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1){echo 'checked';} ?> />
                                            <label for="vis-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Visibility Field -->
                                <!-- Start Allow Comments Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Allow Comments</label>
                                    <div class="col-sm-10 col-md-9">
                                        <div>
                                            <input id="com-yes" type="radio" name="comment" value="0" <?php if($cat['Allow_Comment'] == 0){echo 'checked';} ?> />
                                            <label for="com-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="com-no" type="radio" name="comment" value="1" <?php if($cat['Allow_Comment'] == 1){echo 'checked';} ?> />
                                            <label for="com-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Allow Comments Field -->
                                <!-- Start Allow Ads Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Allow Ads</label>
                                    <div class="col-sm-10 col-md-9">
                                        <div>
                                            <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0){echo 'checked';} ?> />
                                            <label for="ads-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1){echo 'checked';} ?> />
                                            <label for="ads-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Allow Ads Field -->
                                <!-- Start Submit -->
                                <div class="mb-2 row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <input type="submit" value="Add Category" class=" btn btn-primary ">
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

        }elseif($do == 'Update'){ // Update Page

            echo '<h1 class="text-center">Update Category</h1>';

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $id          = $_POST['catid'];
                $name        = $_POST['name'];
                $describe    = $_POST['description'];
                $ord         = $_POST['ordering'];
                $parent      = $_POST['parent'];
                $visible     = $_POST['visibility'];
                $comm        = $_POST['comment'];
                $advs        = $_POST['ads'];


                $stmt = $con->prepare("UPDATE
                                            categories 
                                        SET
                                            `Name`          = ?,
                                            `Description`   = ?, 
                                            Ordering        = ?, 
                                            Parent          = ?,
                                            Visibility      = ?, 
                                            Allow_Comment   = ?, 
                                            Allow_Ads       = ? 
                                        WHERE 
                                            ID = ?");

                $stmt->execute(array($name, $describe, $ord, $parent, $visible, $comm, $advs, $id));

                $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                redirectHome($TheMsg, 'back', 5);

            }else{

                $TheMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
                redirectHome($TheMsg);

            }

        }elseif($do == 'Delete'){ // Delete Page

            

                // Check If Get Request userid Is Numeric & Get The Integer Value Of It 
                
                $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

                // Select All Data Depend On This ID

                $chick = chickItem("ID", "categories", $catid);

                // If There's Such ID Show The Form
                

                if($chick > 0 ){ 

                    deleteRecord("categories", "ID", $catid);

                    $TheMsg = "<div class='alert alert-success'>" . $chick . ' Record Deleted</div>';
                    redirectHome($TheMsg, 'back', 5);
                }else{
                    $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
                    redirectHome($TheMsg);
                }

        }
        
        include $tepl . 'footer.php';

    }else{

        header('Location: index.php');
        exit();
    }

    ob_end_flush(); // Release The Output

?>