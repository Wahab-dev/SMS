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


		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$gender = $_POST['gender'];
		$dateOfBirth = $_POST['dateOfBirth'];
		$maritalStatus = $_POST['maritalStatus'];

		$qualification = $_POST['qualification'];
		$university = $_POST['university'];

		$address = $_POST['address'];
		$pinCode = $_POST['pinCode'];
		$city = $_POST['city'];
		$nationality = $_POST['nationality'];
		$contactNo = $_POST['contactNo'];

		$file = $_POST['file'];

		$email = $_POST['email'];
		$password = $_POST['password'];



		echo $firstName;echo '<br>';
		echo $lastName;echo '<br>';
		echo $gender;echo '<br>';
		echo $dateOfBirth;echo '<br>';
		echo $maritalStatus;echo '<br>';
		echo $qualification;echo '<br>';
		echo $university;echo '<br>';
		echo $address;echo '<br>';
		echo $pinCode;echo '<br>';
		echo $city;echo '<br>';
		echo $nationality;echo '<br>';
		echo $contactNo;echo '<br>';
		echo $file;echo '<br>';
		echo $email;echo '<br>';
		echo $password;echo '<br>'; 

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
			
		}
		public function register_user() 
		{
			
			if (!empty($_POST['submit']))
			 {
				$firstName = $_POST['firstName'];
				$lastName = $_POST['lastName'];
				$gender = $_POST['gender'];
				$dateOfBirth = $_POST['dateOfBirth'];
				$maritalStatus = $_POST['maritalStatus'];

				$qualification = $_POST['qualification'];
				$university = $_POST['university'];

				$address = $_POST['address'];
				$pinCode = $_POST['pinCode'];
				$city = $_POST['city'];
				$nationality = $_POST['nationality'];
				$contactNo = $_POST['contactNo'];

				$file = $_POST['file'];

				$email = $_POST['email'];
				//$password = $_POST['password'];
				$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
			 }		
			try 
			{
				//creates the PDO statement
				$queryStr = $this->db->prepare("INSERT INTO register_user (firstname,lastname,gender,dateofbirth,maritalstatus,qualification,university,address,pinCode,city,nationality,contactnumber,filename,email,password)VALUES (:firstname,:lastname,:gender,:dateofbirth,:maritalstatus,:qualification,:university,:address,:pinCode,:city,:nationality,:contactnumber,:filename,:email,:password)"); 

				//executes the query
				$queryStr->execute(array('firstname' => $firstName,'lastname' => $lastName,'gender' => $gender,'dateofbirth' => $dateOfBirth,'maritalstatus'=>$maritalStatus,'qualification'=>$qualification,'university'=>$university,'address'=>$address,'pinCode'=>$pinCode,'city'=>$city,'nationality'=>$nationality,'contactnumber'=>$contactNo,'filename'=>$file,'email'=>$email,'password'=>$password));

				//Display the message
				//echo "New User.....Successfully Registered";
				
			} 
			catch (PDOException $e) 
			{
				echo $e->getMessage();
			}

			//$query->closeCursor(); //frees up the connection to the server so that other SQL statements may be issued, 
			//$db = null;			
		}

		public function fetch_detail()
		{
			$details = array();//list that contains db data.
			
			$total=0; //total no of pages required to display all records.
			$records=0; //total no of records present in db
			$page=1; //current page
			try
			{
				//counting the total no of records
				$queryStr = $this->db->prepare("select count(*) from register_user");
				$queryStr -> execute();
				$row = $queryStr->fetch();
				$records = $row[0];

				//Displaying fewer records per page
				$queryStr = $this->db->prepare("select firstname,lastname,gender,dateofbirth,maritalstatus,qualification,university,address,pinCode,city,nationality,contactnumber,filename,email,password from register_user");
				$queryStr -> execute();

				$row_retrieved = 0; //contains how many rows has to be diaplayed perpage.

				for($i=0; $row = $queryStr->fetch(PDO::FETCH_ASSOC) ;$i++)
				{
					$details[] = $row;
					$row_retrieved +=1;

				}

				$total = round($records/5); //calculate the total page required.


				//Converting the array of rows into json object
				$details = json_encode($details);

				//Appending in front with additional information 
				$details ='{"total":'.$total.',"page":1,"records":'.$records.',"rows":'. $details;

				echo $details;
				//return $details;				
			} 
			catch (PDOException $e) 
			{
				echo $e->getMessage();
			}

		}

	}

	$new_user = new Register();//Creates an object of class Register everytime a new user register.*/
	$new_user->register_user();
	$new_user->fetch_detail();




?>