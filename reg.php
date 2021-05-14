
				<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "graceland";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id= $_POST['id'] ;					

$username= $_POST['username'] ;					
					$password=$_POST['password'] ;
					$name=$_POST['name'] ;
					$contact=$_POST['contact'] ;
					$address=$_POST['address'] ;
					
$sql = ("INSERT INTO  user (id,username,password,name,contact,address) 
		 VALUES ('$id','$username','$password','$name','$contact','$address')"); 
				
if ($conn->query($sql) === TRUE) {
   		echo '<script>alert("success")</script>';
				echo '<script>windows: location="index.php"</script>';
		
} else {
   echo '<script>alert("Not recorded")</script>';
}

$conn->close();
?>