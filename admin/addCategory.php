<?php
if(isset($_POST['addCategory'])){
include_once "../includes/db_conn.php";
include_once "../includes/func.inc.php";
    
    $cat_desc = htmlentities($_POST['cat_desc']);
    $cat_stat = htmlentities($_POST['cat_status']);
    
    
    //file upload initialization------------------
    $filecheckstat = true;
    $image_temp_file = $_FILES["cat_iconfile"]["tmp_name"];
    $baseitem_img = basename($_FILES["cat_iconfile"]["name"]);
    $ext = strtolower(pathinfo($baseitem_img,PATHINFO_EXTENSION));
    $target_dir = '../images';
    $target_filename = strtolower($cat_desc). "." .$ext; 
    
  
  $check = getimagesize($image_temp_file);
    

  $filecheckstat = $check !== false ? true : false;
    
   $file_stat = checkImage($_FILES["cat_iconfile"], $target_dir, $target_filename);
    $file_err_count=0;
    
    $error_msg = null;
    
    foreach($file_stat as $key => $stat){
        if($stat != ''){
            $error_msg .= ($file_err_count+1). ": ". $stat ."<br>";
            $file_err_count++;
        }
    }
    if($error_msg !== null){
        header("location: control_dashboard.php?error={$error_msg}");
        exit();
    }
    //file upload initialization------------------
    $sql_check = "SELECT cat_id 
                    FROM category
                   WHERE cat_desc = ?;";
    $stmt_chk = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt_chk, $sql_check)){
 echo '<script>alert("Not recordeds")</script>';        exit();
    }
    mysqli_stmt_bind_param($stmt_chk,"s",$cat_desc);
    mysqli_stmt_execute($stmt_chk);
    $chk_result=mysqli_stmt_get_result($stmt_chk);
    $arr=array();
    while($row = mysqli_fetch_assoc($chk_result)){
        array_push($arr,$row);
    }
    if(!empty($arr)){
        header("location: control_dashboard.php?error=1&cat_desc={$cat_desc}"); //item exist
        exit();
    }
    else{
        $sql_ins = "INSERT INTO `category`
                  (`cat_desc`,`cat_status`,`cat_icon`) 
                   VALUES (?,?,?);";
        $stmt_ins = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt_ins, $sql_ins)){
   echo '<script>alert("Not recorded")</script>';      exit();
        }
        mysqli_stmt_bind_param($stmt_ins,"sss",$cat_desc,$cat_stat,$target_filename);
        mysqli_stmt_execute($stmt_ins);
                
        if(!$file_err_count){
             //upload file.
            if (move_uploaded_file($image_temp_file, $target_dir."/".$target_filename) ) {
                echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
              } else {
                 echo '<script>alert("Not recordedes")</script>'; //file upload failed
                exit();
              }
            
             header("location: control_dashboard.php?error=0&cat_desc={$cat_desc}"); 
        }
        
        exit();
    }
}
