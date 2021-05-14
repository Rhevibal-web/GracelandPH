<?php  

include 'db.php';
$username=$_POST['username'];
$password=$_POST['password'];

$sql="SELECT * FROM user WHERE (username = '" .($_POST['username']) . "') and (password = '" .($_POST['password']) . "')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
	{
		$id =$row["id"];
		$username = $row["username"];
		session_start();
		$_SESSION['id'] = $id;
		$_SESSION['username'] = $username;

	}

	header("Location: homepage.php");
}
else
{
	echo "<script>alert('username or password incorrect!')</script>";
echo "<script>location.href='index.php'</script>";
}


?> 