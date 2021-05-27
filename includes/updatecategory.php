<?php
if(isset($_POST['updatecategory'])){
        include "db_conn.php";
        $cat_id = ($_POST['cat_id']);
        $cat_desc = htmlentities($_POST['cat_desc']);
         $sql_upd = "UPDATE `category`
                        SET cat_desc = ?
                    WHERE cat_id = $cat_id";
        $stmt_upd = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt_upd, $sql_upd)){
        header("location: ../admin/control_dashboard.php?error=8"); //update failed
        exit();
        }
        mysqli_stmt_bind_param($stmt_upd,"s",$cat_desc);
        mysqli_stmt_execute($stmt_upd);
        header("location: ../admin/control_dashboard.php?success_update=$cat_desc");
        
    }