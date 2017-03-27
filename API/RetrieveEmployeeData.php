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
$cs = 'utf8';
$dsn = "mysql:host=" . $host . ";port=3306;dbname=" . $db_name . ";charset=" . $cs;

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password") or die(mysql_error());
//echo "Connected to MySQL<br />";
mysql_select_db("$db_name") or die(mysql_error());
//echo "Connected to Database<br />";

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//END OF SET CONNECTION

// Set up the PDO parameters

$opt 	= array(
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			PDO::ATTR_EMULATE_PREPARES   => false,
		   );
		   
// Create a PDO instance (connect to the database)
$pdo 	= new PDO($dsn, $username, $password, $opt);
$data        = array();

// Attempt to query database table and retrieve data
   try {
      $stmt 	= $pdo->query('SELECT * FROM karyawan ORDER BY FirstName ASC');
      while($row  = $stmt->fetch(PDO::FETCH_OBJ))
      {
         // Assign each row of data to associative array
         $data[] = $row;
      }

      // Return data as JSON
      echo json_encode($data);
   }
   catch(PDOException $e)
   {
      echo $e->getMessage();
   }


ob_end_flush();
?>