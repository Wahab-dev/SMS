<!-- 
	Author  : Ashika Jahir
	Project :School Management System
	Version : 1

	Module / Page  : Login Module/Register Validation Page(Server Side Script)
	Description	   : This Page takes the username and password from the user and enetrs it into the database and echos a messsage in the browser.

-->

<?php

/*
*
*  Class    		: Register (Base Class)
*  Description 		: It creates an object every time a user register and do the page functionality
*  
*/
	class Register
	{
		public $db = '';

		//Constructor that performs db connectivity 

		public function __construct() 
		{	
			//connecting to db - sms_wizara
			$this->db = new PDO("mysql:host=localhost;dbname=sms_wizara","ashi", "ashikajahir");
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

			//calls the main function of class
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
				//creates the PDO statement
				$query = $this->db->prepare("INSERT INTO user_login (username, password)VALUES ('$username', '$password')"); 

				//executes the query
				$query->execute();

				//Display the message
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

	$new_user = new Register();//Creates an object of class Register everytime a new user register.


?>