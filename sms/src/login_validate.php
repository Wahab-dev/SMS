<!-- 
	Author  : Ashika Jahir
	Project :School Management System
	Version : 1

	Module / Page  : Login Module/Validation Page(Server Side Script)
	Description	   : This Page takes the username and password from the user, validates and navigate to dashboard if they are authenticated as valid user,else 					stays in same page .


-->


<?php

/*
*
*  Class    		: Login (Base Class)
*  Description 		: It creates an object every time the user login and do the page functionality
*  
*/
	class Login 
	{
		public $db = ''; 
		

		//Constructor that performs db connectivity 

		public function __construct() 
		{	
			//connecting to db - sms_wizara
			$this->db = new PDO("mysql:host=localhost;dbname=sms_wizara","ashi", "ashikajahir");
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

			//calls the main function of class
			$this->user_login();
		}

		//This function takes two inputs (username and password), validates and navigate accordingly.
		public function user_login() 
		{
			
			$template = '';
			if (!empty($_POST['uname']) && !empty($_POST['pass']))
			 {
				$username = $_POST['uname'];
				$password = $_POST['pass'];
			 }		
			try 
			{
				//creates a PDO statement
				$query = $this->db->prepare("SELECT * FROM user_login WHERE username = '$username' and password = '$password'"); //checking the table - user_login

				//Executing the query
				$query->execute();

				//fetching the row(if it is valid user or else it does not fetch anything)
				$row = $query->fetch();				
			} 
			catch (PDOException $e) 
			{
				echo $e->getMessage();
			}
			$query->closeCursor(); //frees up the connection to the server so that other SQL statements may be issued
			$db = null; //unsetting the db value

			//if else condition checks the validity and navigate
			if(!empty($row))
			{
				//echo "Access Granted";
				session_start();
				$_session['username'] = $username;
				$template ='dashboard.html';
			}
			else
			{
				//echo "Access Denied";
				$template = 'login.html';

			}
			require_once($template); //Moves to/Loads the corresponding page
		}
	}

	$user = new Login();//Creates an object of class login everytime the user logs in.

?>