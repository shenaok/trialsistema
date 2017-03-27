<?php
   header('Access-Control-Allow-Origin: *');

   // Define database connection parameters
	$host="localhost"; // Host name 
	$username="root"; // Mysql username 
	$password=""; // Mysql password 
	$db_name="trialsistema_db"; // Database name 
	$tbl_name="karyawan"; // Table name
	$cs = 'utf8';

   // Set up the PDO parameters
   $dsn 	= "mysql:host=" . $host . ";port=3306;dbname=" . $db_name . ";charset=" . $cs;
   $opt 	= array(
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                       );
   // Create a PDO instance (connect to the database)
   $pdo 	= new PDO($dsn, $username, $password, $opt);

   // Retrieve specific parameter from supplied URL
   $key 	= strip_tags($_REQUEST['key']);
   $data 	= array();


   // Determine which mode is being requested
   switch($key)
   {

      // Add a new record to the technologies table
      case "create":

         // Sanitise URL supplied values
         $firstname = filter_var($_REQUEST['FirstName'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
		 $lastname 	= filter_var($_REQUEST['LastName'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $username	= filter_var($_REQUEST['Username'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
		 $pwd	= filter_var($_REQUEST['Password'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);

         // Attempt to run PDO prepared statement
         try {
            $sql 	= "INSERT INTO karyawan(firstname, lastname, username, password, isactive) VALUES(:firstname, :lastname, :username, :password,1)";
            $stmt 	= $pdo->prepare($sql);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':password', $pwd, PDO::PARAM_STR);
            $stmt->execute();

            echo '1';
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;



      // Update an existing record in the technologies table
      case "update":

         // Sanitise URL supplied values
         $firstname 		= filter_var($_REQUEST['FirstName'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $lastname	= filter_var($_REQUEST['LastName'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
		 $username	= filter_var($_REQUEST['Username'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
		 $pwd	= filter_var($_REQUEST['Password'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $employeeid	= filter_var($_REQUEST['EmployeeID'], FILTER_SANITIZE_NUMBER_INT);

         // Attempt to run PDO prepared statement
         try {
            $sql 	= "UPDATE karyawan SET firstname = :firstname, lastname = :lastname, username =:username, password=:password WHERE employeeid = :employeeid";
            $stmt 	=	$pdo->prepare($sql);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':password', $pwd, PDO::PARAM_STR);
			$stmt->bindParam(':employeeid', $employeeid, PDO::PARAM_INT);
            $stmt->execute();

            echo '1';
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;



      // Remove an existing record in the technologies table
      case "delete":

         // Sanitise supplied record ID for matching to table record
         $employeeid	=	filter_var($_REQUEST['EmployeeID'], FILTER_SANITIZE_NUMBER_INT);

         // Attempt to run PDO prepared statement
         try {
            $pdo 	= new PDO($dsn, $un, $pwd);
            $sql 	= "DELETE FROM karyawan WHERE employeeid = :employeeid";
            $stmt 	= $pdo->prepare($sql);
            $stmt->bindParam(':employeeid', $employeeid, PDO::PARAM_INT);
            $stmt->execute();

            echo '1';
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;
   }

?>