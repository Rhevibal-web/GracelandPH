<?php
session_start();
if(isset($_SESSION['user_type']) && isset($_SESSION['user_id'])){
    if($_SESSION['user_type'] == 'C'){
        header("location: ../customer/?error=cannotgothere");
    }
}
else{
    header("location: ../?error=cannotgothere");
}

include_once "../includes/db_conn.php";
include_once "../includes/func.inc.php";
include_once "../includes/utilities.inc.php";
$searchkey=NULL;
if (isset($_GET['searchkey'])){
    $searchkey=htmlentities($_GET['searchkey']);  
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title>GRACELAND</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../font/bootstrap-icons.css">

    <link rel="stylesheet" href="../css/custom.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row" id="NavigationPanel">
            <!-- Navigation Bar -->
            <nav class="navbar fixed-top navbar-expand-lg bg-light text-white shadow-sm">
                <div class="container-fluid">
                    <button class="navbar-toggler btn btn-outline-orange" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="bi bi-list"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">
                            
<li class="nav-item" >
    <h3 style="color: black">GRACELAND | </h3>
</li>
                            <li class="nav-item">
                                                   <a  style="margin-left: 20px;background-color: green;color: white" href="control_dashboard.php" class="nav-link btn btn-no-border-orange"><i class="bi bi-house"></i> Home
                    </a></li><li class="nav-item">

                                <!--Navigation button to show the form to add item button-->
                                <a style="margin-left: 20px;background-color: green;color: white"  class="nav-link btn btn-no-border-orange" data-bs-toggle="collapse" href="#addItemForm" role="button" aria-expanded="false" aria-controls="addItemForm">
                                    <i class="bi bi-plus-circle"> </i>Add Item 
                                </a>
                            </li>
                            <li class="nav-item">
                                <!--Navigation button to show the form to add item button-->
                                <a style="margin-left: 20px;background-color: green;color: white"  class="nav-link btn btn-no-border-orange" data-bs-toggle="collapse" href="#addCategory" role="button" aria-expanded="false" aria-controls="addCategory">
                                   <i class="bi bi-plus-circle"></i> Add Category 
                                </a>
                            </li>
                            <li class="nav-item">
                                <!--Navigation button to show the form to add item button-->
                                <a style="margin-left: 20px;background-color: green;color: white" class="nav-link btn btn-no-border-orange" href="SalesDashboard.php">
                                    <i class="bi bi-graph-up"></i> Sales 
                                </a>
                            </li>
                            <li class="nav-item">
                                <!--Navigation button to show the form to add item button-->
                                <a style="margin-left: 20px;background-color: green;color: white"  class="nav-link btn btn-no-border-orange" href="index.php">
                                    <i class="bi bi-person-lines-fill"></i> Orders 
                                </a>
                            </li>
                            
                            <li class="nav-item"></li>
                        </ul>
                        <!--Search Bar-->

                        <form action="index.php" method="GET">
                            <div class="input-group"  style="margin-top: 20px;">
                                <input  id="searchbar" name="searchkey" type="text" class="form-control" placeholder="Search........">
                                <button class="btn btn-outline-primary"> Search <i class="bi bi-search"></i> </button>
                            </div>
                        </form>
                        <!--Search Bar-->
                        <a style="margin-left: 20px;background-color: red;color: white" href="../includes/processlogout.php" class="nav-link btn float-end">
                            <i class="bi bi-power"></i> Logout
                        </a>

                    </div>
                </div>
            </nav>
            <!--end Navigation Bar -->
        </div>

        <div class="row mx-3" id="formsPanel">

            <div class="col-lg-4 col-sm-12 col-md-12">
                <?php if(isset($_GET['error'])){
                    
                    switch($_GET['error']){
                        case 1:
                            if(isset($_GET['itemname'])){
                               echo "<p class='alert alert-danger'>".$_GET['itemname']." Exists.</p>";
                            }
                                break;
                        case 2: echo "<p class='alert alert-danger'>Adding Record Failed.</p>";
                                break;
                        case 3: echo "<p class='alert alert-danger'>Checking Item Failed.</p>";
                                break;
                        case 0:
                            if(isset($_GET['itemname'])){
                               echo "<p class='alert alert-success'>".$_GET['itemname']." has been added.</p>";
                            }
                                break;
                        default: echo "<div class='alert alert-danger'> <h6 class='display-6'>Oops!</h6><br>".$_GET['error']."</div>";
                    }
                  } ?>
<br>
<br>
<br>
                <div id="addItemForm" class="card collapse mt-5 shadow">
                    <div class="card-header">
                        <br>
                        <h3 class="display-6">Add New Item</h3>

                    </div>
                    <form action="additem.php" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="mb-1">
                                <label for="i_ItemName" class="form-label">Item Name</label>
                                <input name="itemname" id="i_ItemName" type="text" class="form-control">
                            </div>
                            <div class="mb-1">
                                <label for="" class="form-label">Item Short Code</label>
                                <input name="itemshortcode" type="text" class="form-control">
                            </div>
                            <div class="mb-1">
                                <label for="" class="form-label">Image</label>
                                <input name="itemimagefile" type="file" class="form-control">
                            </div>
                            <div class="mb-1">
                                <label for="" class="form-label">Item Price</label>
                                <input name="itemprice" type="Number" class="form-control">
                            </div>
                            <div class="mb-1">
                                <label for="SelectCategory" class="form-label">Category</label>
                                <select name="itemcategory" id="" class="form-select">
                                    <?php
                      $sql_cat = "SELECT cat_id, cat_desc FROM category WHERE cat_status = 'A';";
                      $result = mysqli_query($conn, $sql_cat);
                      if(mysqli_num_rows($result) > 0){
                          while($row = mysqli_fetch_assoc($result)){
                              echo "<option value='".$row['cat_id']."'>".$row['cat_desc']."</option>";
                          }
                      }
                    ?>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="" class="form-label">Status</label>
                                <select name="itemstatus" id="" class="form-select">
                                    <option value="A">Active</option>
                                    <option value="D">Discontinued</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-primary" name="additem" type="submit"> <i class="bi bi-save"></i> Save </button>
                        </div>
                    </form>
                </div>


            </div>
<br>
<br>
<br>
                <div id="addCategory" class="card collapse mt-5 shadow">
                    <div class="card-header">
                        <br>
                        <h3 class="display-6">Add Category</h3>

                    </div>
                    <form action="addCategory.php" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="mb-1">
                                <label for="c_cat_desc" class="form-label">Category</label>
                                <input name="cat_desc" id="c_cat_desc" type="text" class="form-control">
                            </div>
                            <div class="mb-1">
                                <label for="" class="form-label">Image</label>
                                <input name="cat_iconfile" type="file" class="form-control">
                            </div>
                            <div class="mb-1">
                            <div class="mb-1">
                                <label for="" class="form-label">Status</label>
                                <select name="cat_status" id="" class="form-select">
                                    <option value="A">Active</option>
                                    <option value="D">Discontinued</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-primary" name="addCategory" type="submit"> <i class="bi bi-save"></i> Save </button>
                        </div>
                    </form>
                </div>


        
            </div>
    <br><br><br><br><br>
    <div class="container-fluid" style="background-color: rgb(0,0,0,0.7);border-radius: 14px" id="item_list">


        <?php
$category_list = getCategories($conn);
if(!isset($searchkey)){
    if(!empty($category_list) || $category_list !== false){
        foreach($category_list as $categ_key => $cat){ ?>
        <div class="row">
            <marker id="cat<?php echo $cat['cat_id']; ?>" class=' mt-5 mb-5'></marker>

            <div class="col-lg-3 col-sm-12 mb-0">
<form action="../includes/updatecategory.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="input-group mt-5">
                        <div class="form-floating">
                                                    <input class="form-control mb-1" type="hidden" name="cat_id" id="cat_id" value="<?php echo $cat['cat_id']; ?>">
    
                            <input type="text" class="form-control" name="cat_desc" id="cat<?php echo $cat['cat_id']; ?>" value="<?php echo $cat['cat_desc']; ?>">
                            <label for="cat<?php echo $cat['cat_id']; ?>" class="form-label">Category Name</label>
                        </div>
                        <button name="updatecategory" type="submit" class="btn btn-outline-success"  style="margin-top: 10px;background-color: green;color: white">Update Category</i> </button>
                    </div>
                </form>
            </div>


        </div>

        <div class="row p-3">
            <?php
             $menu = showMenu($conn, $cat['cat_id']);
             if(!empty($menu) || $menu !== false ){
                foreach($menu as $key => $val){ ?>

            <div class="col-lg-2 col-md-6 col-sm-6">

                <div class="card border border-white">
                    <img src="../images/<?php echo $val['item_img'] == '' ? "200x200.png" : $val['item_img']; ?>" alt="1 x 1" class="card-img-top" style=" height: 220px; width=150px; object-fit: cover">
                    <div class="card-body">

                        <form action="../includes/updateitem.php" method="post">
                            <input class="form-control mb-1" type="hidden" name="item_id" id="item_id" value="<?php echo $val['item_id']; ?>">
                            <div class="form-floating">
                                <input id="itemname<?php echo $val['item_id']; ?>" class="form-control" type="text" name="item_name" value="<?php echo $val['item_name']; ?>">
                                <label class="form-label" for="itemname<?php echo $val['item_id']; ?>">Item Name</label>
                            </div>
                            <div class="form-floating">
                                <input id="itemprice<?php echo $val['item_id']; ?>" class="form-control mb-1" type="number" name="item_price" value="<?php echo $val['item_price']; ?>">
                                <label class="form-label" for="itemprice<?php echo $val['item_id']; ?>">Item Price</label>
                            </div>
                            <div class="form-floating">
                                <input id="itemsc<?php echo $val['item_id']; ?>" class="form-control mb-1" type="text" name="item_short_code" value="<?php echo $val['item_short_code']; ?>">
                                <label class="form-label" for="itemsc<?php echo $val['item_id']; ?>">Item Code</label>
                            </div>
                            <button type="submit" name="updateitem"  style="margin-top: 10px; background-color: green;color: white" class="btn btn-sm btn-outline-success" title="Update <?php echo $val['item_name']; ?>"> Update</i> </button>
                            <button type="submit" name="deleteitem"  style="margin-top: 10px; background-color: red;color: white" class="btn btn-sm btn-outline-success" > Delete</i> </button>
                        </form>


                    </div>

                </div>
            </div>

            <?php }
             }
             else{
                 echo "<h4> No Records Found.</h4>";
             }   ?>
        </div>
        <?php }
    }
} else{  ?>
        <div class="row mt-3" id="resultSetSearch">
            <?php
            echo "<p class='lead'>Result for {$searchkey}:</p><hr>";
             $menu = showMenu($conn, null, $searchkey);
             if(!empty($menu) || $menu !== false ){
                foreach($menu as $key => $val){ ?>
                    <br><br><br><center>
            <div class="col-lg-2 col-md-6 col-sm-6" style="margin-bottom: 20px">

                <div class="card" align="center">
                    <img src="../images/<?php echo $val['item_img'] == '' ? "200x200.png" : $val['item_img']; ?>" alt="1 x 1" class="card-img-top" style=" height: 200px; width=300px; object-fit: cover">
                    <div class="card-body">

                        <form action="../includes/deleteitem.php" method="post">
                            <input class="form-control mb-1" type="hidden" name="item_id" id="item_id" value="<?php echo $val['item_id']; ?>">
                            <div class="form-floating">
                                <input id="itemname<?php echo $val['item_id']; ?>" class="form-control" type="text" name="item_id" value="<?php echo $val['item_name']; ?>">
                                <label class="form-label" for="itemname<?php echo $val['item_id']; ?>">Item Name</label>
                            </div>
                            <div class="form-floating">
                                <input id="itemprice<?php echo $val['item_id']; ?>" class="form-control mb-1" type="number" name="item_price" value="<?php echo $val['item_price']; ?>">
                                <label class="form-label" for="itemprice<?php echo $val['item_id']; ?>">Item Price</label>
                            </div>
                            <div class="form-floating">
                                <input id="itemsc<?php echo $val['item_id']; ?>" class="form-control mb-1" type="text" name="item_short_code" value="<?php echo $val['item_short_code']; ?>">
                                <label class="form-label" for="itemsc<?php echo $val['item_id']; ?>">Item Short Code</label>
                            </div>
<button type="submit"  style="margin-top: 10px; background-color: green;color: white" class="btn btn-sm btn-outline-success" title="Update <?php echo $val['item_name']; ?>"> Update</i> </button>
                            <a  style="margin-top: 10px;margin-left: 10px;background-color: red;color: white" href="?archiveitem=<?php echo $val['item_id']; ?>" class="btn btn-sm btn-outline-danger" title="Archive <?php echo $val['item_name']; ?>">Delete </a>
                        </form>


                        </form>
                    </div>
                </div>
            </div>

            <?php }
             }
             else{
                 echo "<h4> No Records Found.</h4>";
             }   ?>
        </div>
        <?php } ?>

    </div>
    </div>

</body>
<?php mysqli_close($conn);?>
<script src="../js/bootstrap.min.js"></script>

</html>
