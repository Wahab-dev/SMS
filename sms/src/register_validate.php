<?php
	class Register
	{
		public $db = '';
		public function __construct() 
		{	
			//connecting to db - sms_wizara
			$this->db = new PDO("mysql:host=localhost;dbname=sms_wizara","ashi", "ashikajahir");
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->register_user();
		}
		public function register_user() 
		{
			
			$template = '';
			if (!empty($_POST['username']) && !empty($_POST['password']))
			 {
				$username = $_POST['username'];
				$password = $_POST['password'];
			 }		
			try 
			{
				$query = $this->db->prepare("INSERT INTO user_login (username, password)VALUES ('$username', '$password')"); 
				$query->execute();
				echo "New User.....Successfully Registered";
				
			} 
			catch (PDOException $e) 
			{
				echo $e->getMessage();
			}

			$query->closeCursor(); //frees up the connection to the server so that other SQL statements may be issued, 
			$db = null;
			
		}
	}

	$new_user = new Register();

?>