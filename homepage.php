
<?php session_start();
if(!isset($_SESSION['id'])){
	echo '<script>windows: location="index.php"</script>';

	
	}
		
?>
<?php
$session=$_SESSION['id'];
include 'db.php';
$sql = "SELECT * FROM user where id= '$session'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

  {
  $sessionname=$row['name'];

  }
}
mysqli_close($conn);
 } 
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div>
<h1>WELCOME, <?php echo $sessionname; ?>  TO GRACELAND!</h1>
</div>
<div><a  href="logout.php">Logout</a></div></dir></body>
</html>