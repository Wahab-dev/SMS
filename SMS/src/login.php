<?php
	
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	//echo $username;
	//echo $password;
		

		try
		{
			$db = new PDO("mysql:host=localhost;dbname=login","loginuser", "loginuser");
			$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			
			echo '<script type="text/javascript"> window.location = "dashboard.html"</script>';	
			
			$queryStr = $db->prepare("INSERT INTO loginusers (username,password)VALUES (:username,:password)"); 

			//executes the insert query
			$queryStr->execute(array('username' => $username,'password' => $password));



		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			echo '<script type="text/javascript"> window.location = "error.html"</script>';
		}
			
//	$connection = mysql_connect("localhost", "registerform","registerform"); // Establishing connection with server..
	
	//$db = mysql_select_db("college", $connection); // Selecting Database.
	
	

?>