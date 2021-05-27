<?php
session_start();
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
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../font/bootstrap-icons.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../font/bootstrap-icons.css">

    <link rel="stylesheet" href="../css/custom.css">

</head>

<body>
                        

            <nav class="navbar fixed-top navbar-expand-lg bg-light text-white shadow-sm">
                <div class="container-fluid">
                    <button class="navbar-toggler btn btn-outline-orange" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="bi bi-list"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">
                            
<li class="nav-item" >
    <h3 style="color: black;margin-left: 30px">GRACELAND | </h3>
</li>
                            <li class="nav-item">
                                                   <a  style="margin-left: 20px;background-color: green;color: white" href="control_dashboard.php" class="nav-link btn btn-no-border-orange"><i class="bi bi-house"></i> Home
                    </a></li>
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
                                <input  id="searchbar"   name="searchkey" type="text" class="form-control" placeholder="Search........">
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
    
<br><br><br>
    <div class="container-fluid">
            <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
<br><br><br>
                <div class="list-group">
                    <a href="?cat=all&cat_n=All Category" class="list-group-item list-group-item-action">All</a>
 </div>               <div class="card bg-light">
                    <div class="card-body">
                    </div>


                </div>

            </div>
       <br><br>
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php 
                 if(isset($_GET['f'])){ //this means the filter button has been triggered
                        $item=null;
                        $item_info = query($conn, "SELECT * FROM `items`");
                        $where=null;
                        if(isset($_GET['f_item'])){
                            $item = htmlentities($_GET['f_item']);
                            $s = "%{$item}%";
                            $item_info = query($conn, "SELECT * FROM `items` WHERE item_name LIKE ? ;" , array($s));
                        }
                        $start_date = htmlentities($_GET['f_date1']);
                        $end_date = htmlentities($_GET['f_date2']); ?>

                <p class="lead">Results for <?php echo $start_date;?> to <?php echo $end_date; echo $item == NULL ? '' : " and items similar to `{$item}`"; ?></p>
                <?php foreach($item_info as $k => $item){ 
                   $sales_info = getSalesPerfItem($conn, $item['item_id'], array($start_date, $end_date)); 
                ?>
                <h3 class="display-6"><?php echo $item['item_name'];?> </h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>Transaction Date</th>
                            <th>Net Sales</th>
                            <th>Total Count Ordered</th>
                        </thead>
                        <?php  if(!empty($sales_info)){  ?>
                        <tbody>
                            <?php foreach($sales_info as $s => $sale){ ?>
                            <tr class="text-success">
                                <td><?php echo $sale['date_ordered'];?></td>
                                <td><?php echo $sale['total_net_sale'];?></td>
                                <td><?php echo $sale['total_item_ordered'];?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <?php } else{ ?>
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <p class="text-danger">No Sales Available</p>
                                </td>

                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>

                <?php
                 }
            } //end filter result
                
                
            if(isset($_GET['cat'])){ //sales for category
                $catid=htmlentities($_GET['cat']);
                if($catid !== 'all'){ ?>

                <h3><?php echo htmlentities($_GET['cat_n'] === NULL ? '' : $_GET['cat_n']);?></h3>

                <?php $catSales = getSalesPerfCat($conn, $catid); 
                    if(!empty($catSales)){ //sales not empty
                ?>
                <table class="table table-responsive">
                    <thead>
                        <th>Transction Date</th>
                        <th>Net Sales</th>
                        <th>Order Qty</th>
                    </thead>
                    <?php foreach($catSales as $k => $cs){
                        
                        
                    } ?>
                </table>
                <?php
                    } //sales not empty
                    else{ ?>
                <p class="lead">No Sales</p>
                <?php }
                }
                else{ ?>
                <h3><?php echo htmlentities($_GET['cat_n'] === NULL ? '' : $_GET['cat_n']);?>
                    <span class="lead">( Sales performance from Day -30)</span>
                </h3>
                <?php $categ = query($conn, "SELECT * FROM `category`; "); ?>
                <div class="container-fluid">
                    <div class="row align-items-start">

                        <?php foreach($categ as $k => $c){
                        $tot_cat_sale = 0.00;?>

                        <div class="col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $c['cat_desc'];?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <?php $item_categ = query($conn, "SELECT * FROM `items` WHERE cat_id = ?; ", array($c['cat_id']));
                                    foreach($item_categ as $x => $ic){ ?>
                                        <span class="list-group-item">
                                            <?php
                                    $item_sale =  query($conn, "SELECT sum(i.item_price * c.item_qty) total_net_sales, sum(c.item_qty) total_ordered  FROM `cart` c JOIN `items` i on (i.item_id = c.item_id) WHERE i.item_id = ? and c.status in ('C','X') and confirm = 'Y' and date_ordered >= CURRENT_DATE - 30; ", array($ic['item_id'])); 
                                    
                                    foreach($item_sale as $s => $sale){    ?>
                                            <span class="badge badge-pill <?php echo $sale['total_ordered'] <= 0.00 ? 'bg-secondary' : 'bg-danger';?> float-start"><?php echo $sale['total_ordered']; ?></span>
                                            <?php echo $ic['item_name'];?>
                                            <span class="float-end <?php echo $sale['total_net_sales'] <= 0.00 ? 'text-danger' : 'text-success';?>"><?php echo nf2( $sale['total_net_sales'] ); ?></span>
                                            <?php
                                                                       $tot_cat_sale += $sale['total_net_sales'];
                                                                      } ?>
                                        </span>
                                        <?php }
                                                                      
                                    ?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <span class="lead">Total: <?php echo nf2($tot_cat_sale); ?></span>

                                </div>


                            </div>
                        </div>

                        <?php } ?>
                    </div>
                </div>

                <?php }
                
                
                
            }
                ?>

            </div>
        </div>

    </div>



</body>
<?php mysqli_close($conn);?>
<script src="../js/bootstrap.min.js"></script>

</html>
