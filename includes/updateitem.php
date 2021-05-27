<?php
if(isset($_POST['updateitem'])){
        include "db_conn.php";
        $item_id = ($_POST['item_id']);
        $item_name = htmlentities($_POST['item_name']);
        $item_price = htmlentities($_POST['item_price']);
        $item_short_code = htmlentities($_POST['item_short_code']);
         $sql_upd = "UPDATE `items`
                        SET item_name = ?,
                        item_price = ?,
                        item_short_code = ?
                    WHERE item_id = $item_id";
        $stmt_upd = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt_upd, $sql_upd)){
        header("location: ../admin/control_dashboard.php?error=8"); //update failed
        exit();
        }
        mysqli_stmt_bind_param($stmt_upd,"sss",$item_name,$item_price,$item_short_code);
        mysqli_stmt_execute($stmt_upd);
        header("location: ../admin/control_dashboard.php?success_update=$item_id");
        
    }


    ?>
    <?php
if(isset($_POST['deleteitem'])){
        include "db_conn.php";
        $item_id = ($_POST['item_id']);
         $sql = "delete from `items`
                    WHERE item_id = $item_id";

 mysqli_query($conn,$sql);
        header("location: ../admin/control_dashboard.php?success_delete=$item_id");


}
        ?>