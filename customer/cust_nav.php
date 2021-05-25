    <!-- Navigation Bar -->
    <nav class="navbar bg-light navbar-expand-lg text-white shadow fixed-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <button class="navbar-toggler btn btn-outline-orange" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="bi bi-list"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        

                        <a href="#userprofile" class="nav-link btn float-end" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="userprofile">
                            <h5>Welcome to Graceland | <?php echo getUserFullName($conn,$_SESSION['user_id']); ?></h5>
                        </a>
                        <a class="nav-link btn float-end" href="index.php" style="margin-left: 10px;background-color: green;color: white"><i class="bi bi-house"></i> Home</a>
                        <a style="margin-left: 10px;background-color: green;color: white" href="checkout.php" class="nav-link btn float-end" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="cartList">
                            <i class="bi bi-cart"></i>
                            <span class="badge bg-danger">
                                <?php echo getCartCount($conn,$_SESSION['user_id']);?>
                            </span>

                        </a>
                        <form action="index.php" method="GET">
                            <div class="input-group inline">
                                <input style="margin-left: 10px;margin-top: 10px;width: 200px" id="searchbar" name="searchkey" type="text" class="form-control" placeholder="Search............">
                                <button class="btn btn-outline-primary" style="margin-top: 10px"> Search <i class="bi bi-search"></i> </button>
                            </div>
                        </form>



                        <a href="../includes/processlogout.php" class="nav-link btn float-right" style="margin-left: 10px;margin-right: 50px;background-color: red;color: white">
                            <i class="bi bi-power" align></i> Logout
                        </a>
                        <?php
                     if(isset($_GET['deletecartitem'])){
                         if(deleteCartItem($conn,htmlentities($_GET['deletecartitem']),$_SESSION['user_id']) !== false){ ?>
                        <div class="badge bg-warning">Cart Item Removed.</div>
                        <?php }
                     }
                     if(isset($_GET['confirmcartitem'])){
                         if(confirmCartItem($conn,htmlentities($_GET['confirmcartitem']),$_SESSION['user_id']) !== false){ ?>
                        <div class="badge bg-success">Cart Item Confirmed <i class="bi bi-check"></i> </div>
                        <?php }
                     }
                     if(isset($_GET['unconfirmcartitem'])){
                         if(unconfirmCartItem($conn,htmlentities($_GET['unconfirmcartitem']),$_SESSION['user_id']) !== false){ ?>
                        <div class="badge bg-success">Cart Item Unconfirmed<i class="bi bi-check"></i> </div>
                        <?php }
                     }
                       
                     if($page == 'index'){
                     ?>

                        <?php } ?>
                                         </div>
                </div>
                <?php  if($page == 'index'){ ?>

                        <?php $summary = getCartSummary($conn, $_SESSION['user_id']); 
                                    if(!empty($summary)){
                                        foreach($summary as $key => $nval){
                                           echo "<hr style=\"border:1px solid black;margin-top:10px;margin-bottom:0px\"><p style=\"color:black;margin-bottom:0px;margin-top:10px\">Cart: ". $nval['total_qty'] . " pcs (Php ". number_format($nval['total_price'],2) . ")</p>";  
                                             ?>
                        <a href="checkout.php" class="btn btn-outline-light border-1 text-danger"> Checkout <i class="bi bi-chevron-right"></i> </a>
                        <?php 
                                        }
                                    }
                                    ?>
                    </span>
                </div>
                <?php } ?>
            </div>

        </div>
        <br>


    </nav>
