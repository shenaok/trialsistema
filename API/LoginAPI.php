<?php
header('Access-Control-Allow-Origin: *');  
header('Content-Type: text/javascript; charset=utf8');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

ob_start();

//SET CONNECTION
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password=""; // Mysql password 
$db_name="trialsistema_db"; // Database name 
$tbl_name="karyawan"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password") or die(mysql_error());
//echo "Connected to MySQL<br />";
mysql_select_db("$db_name") or die(mysql_error());
//echo "Connected to Database<br />";

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//END OF SET CONNECTION

$postdata = file_get_contents("php://input");

if(isset($postdata)){
	$uname ="";
	$pwd = "";

	$decodedpostdata = json_decode($postdata,true); //JSON decode
	
	$uname = $decodedpostdata['username']; //fetching username
	$pwd = $decodedpostdata['password'];// fetching password
  
	// echo $uname;
	// echo $pwd;
  
	$sql="SELECT * FROM $tbl_name WHERE username='$uname' and password='$pwd' and isactive = 1";
	$result=mysql_query($sql);

	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);
	
	// If result matched $uname and $pwd, table row must be 1 row
	if ($count==1) {
	{
		echo '1';
	}
	} else {
		echo '0';
	}	
}
else
	echo "Invalid parameter";

ob_end_flush();
?>