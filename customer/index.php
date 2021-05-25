<?php
session_start();
if(isset($_SESSION['user_type']) && isset($_SESSION['user_id'])){
    if($_SESSION['user_type'] == 'A'){
        header("location: ../admin/?error=cannotgothere");
    }
}
else{
    header("location: ../?error=cannotgothere");
}

include_once "../includes/db_conn.php";
include_once "../includes/func.inc.php";
$page='index';
$searchkey=NULL;
if (isset($_GET['searchkey'])){
    $searchkey=htmlentities($_GET['searchkey']);  
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title>Graceland</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/custom.css">
</head>

<body>
<center>
    <div class="container-fluid">
        <div class="row pt-5" id="NavigationPanel">
            <?php include_once "cust_nav.php"; ?>

        </div>

            <div class="col-10" align="center">
                <div class="container-fluid">
                   
                    <?php
$category_list = getCategories($conn);
if(!isset($searchkey)){
    if(!empty($category_list) || $category_list !== false){
        foreach($category_list as $categ_key => $cat){ ?>
                    <div class="row px-3 mb-3">
                        <?php echo "<marker id='cat".$cat['cat_id']."' class='mt-5 mb-5'></marker>"; ?>

                        <div class="col-12">

                            <h3 style="background-color:blue;color: white;padding: 0px 100px;border-radius: 50px" class='display-6 d-inline'> <b><?php echo $cat['cat_desc']; ?></b></h3>
                        </div>
                   <br><br><br>
                        <div class="col-12 mt-3">
                            <div class="container-fluid">
                                <div class="row">

                                    <?php
             $menu = showMenu($conn, $cat['cat_id']);
             if(!empty($menu) || $menu !== false ){
                foreach($menu as $key => $val){ ?>
                                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">

                                        <div class="card">
                                            <a href="../images/<?php echo $val['item_img'] == '' ? "200x200.png" : $val['item_img']; ?>"><img src="../images/<?php echo $val['item_img'] == '' ? "200x200.png" : $val['item_img']; ?>" alt="1 x 1" class="card-img-top" style="object-fit: cover;height: 200px;height: 200px"></a>

                                            <div class="card-body">
                                                <form action="../includes/processorder.php" method="get">
                                                    <input type="hidden" name="item_id" value="<?php echo $val['item_id']; ?>">
                                                    <div class="input-group">
                                                        <input style="text-align: center" class="form-control form-control-sm" type="number" name="item_qty" id="qty_<?php echo $val['item_id']; ?>" value="<?php echo $val['minimum_qty']; ?>">                      
                                                    </div><br>
                                                <h5 class="card-title"><?php echo $val['item_name']?></h5>
                                                <em class="card-text" style="color: blue"> <b>Php <?php echo number_format($val['item_price'],2); ?></b> </em><br>
                                                                                                    <button style="background-color: green;border-radius: 50px;font-size: 14px;margin-top: 10px" type="submit" class="border-4  btn btn-lg btn-outline-light "> <i class="bi bi-cart-plus"></i> Add to Cart </button></form>
                                            </div>
                                        </div>
                                    </div>

                                    <?php }
             }
             else{
                 echo "<h4> No Records Found.</h4>";
             }   ?>
                                </div>
                            </div>
                        </div>
                        <?php }
    }
} else{  ?>
                        <div class="col-12" id="resultSetSearch">
                            <?php
            echo "<p class='lead'>Result for {$searchkey}:</p><hr>";
             $menu = showMenu($conn, null, $searchkey);
             if(!empty($menu) || $menu !== false ){
                foreach($menu as $key => $val){ ?>
                            <div class="col-lg-2 col-md-6 col-sm-6">

                                <div class="card">
                                    <img src="../images/<?php echo $val['item_img'] == '' ? "200x200.png" : $val['item_img']; ?>" alt="1 x 1" class="card-img-top" style="object-fit: cover;height: 200px">

                                    <div class="card-body">
                                        <form action="../includes/processorder.php" method="get">
                                            <input type="hidden" name="item_id" value="<?php echo $val['item_id']; ?>">
                                            <div class="input-group">
                                                <input class="form-control form-control-sm" type="number" name="item_qty" id="qty_<?php echo $val['item_id']; ?>" value="1">
                                            </div>
                                            <button type="submit" class="border-4 btn btn-lg btn-outline-light position-absolute top-50 start-50 translate-middle "> <i class="bi bi-cart-plus"></i> </button>
                                        </form>
                                        <h5 class="card-title"><?php echo $val['item_name']?></h5>
                                        <em class="card-text"> Php <?php echo number_format($val['item_price'],2); ?> </em>
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
            </div>

        </div>

        </div>
</body>
<?php mysqli_close($conn);?>
<script src="../js/bootstrap.min.js"></script>

</html>
