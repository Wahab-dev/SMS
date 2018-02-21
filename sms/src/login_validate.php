<?php
	class Login 
	{
		public $db = '';
		public function __construct() 
		{	
			//connecting to db - sms_wizara
			$this->db = new PDO("mysql:host=localhost;dbname=sms_wizara","ashi", "ashikajahir");
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->user_login();
		}
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
				$query = $this->db->prepare("SELECT * FROM user_login WHERE username = '$username' and password = '$password'"); //checking the table - user_login
				$query->execute();
				$row = $query->fetch();				
			} 
			catch (PDOException $e) 
			{
				echo $e->getMessage();
			}
			$query->closeCursor();
			$db = null;
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
			require_once($template);
		}
	}

	$user = new Login();

?>