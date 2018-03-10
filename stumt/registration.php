
<?php 
/*
*	Author  : Ashika Jahir
*	Project :Muslim Students Meet
*	
*
*	Module / Page  : Register Page
*	Description	   : This Page gets the user details and insert in to db and send a mail to the registered user.
*
*
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
			
			try 
			{
				//connecting to db - sms_wizara
				$this->db = new PDO("mysql:host=localhost;dbname=muslim_students_meet","ashi", "ashikajahir");
				$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$this->register_user();
			} 
			catch (Exception $e) 
			{
				$error_message = $e->getMessage();

				if (strpos($error_message, "SQLSTATE[HY000]") !== false) 
				{
					echo "Warning: Databse Access Denied.Please provide correct credentials";
				}
				else
				{
					echo $e->getMessage();
				}
			}

			
			
		}

		//This function registers the user and send them a mail.

		public function register_user() 
		{

			
				$name = $_POST['name'];
				$gender = "Female";
				$age = $_POST['age'];
				$email = $_POST['email'];
				$place = $_POST['place'];
				$contact = $_POST['contact'];
				$college = $_POST['college'];

				if(isset($_POST['gender']))
				{
					$gender = "Male";
				}

	
				$subject = '';
				$message = '';


			 

			 try 
			{
				//creates the PDO statement
				$queryStr = $this->db->prepare("INSERT INTO register_details (name,gender,age,email,place,contact,college)VALUES (:name,:gender,:age,:email,:place,:contact,:college)"); 

				//executes the insert query
				$queryStr->execute(array('name' => $name,'gender' => $gender,'age' => $age, 'email' => $email,'place' => $place, 'contact' => $contact, 'college'=>$college));

				$queryStr = $this->db->prepare("SELECT id FROM register_details WHERE email = :email");

				$queryStr->execute(array('email' => $email));
				$row = $queryStr->fetch(PDO::FETCH_ASSOC);
				$id = $row['id'];


				//Message to be sent in mail

				$message = "Dear ".$name. ",You have been Successfully registered in MUSLIM STUDENTS MEET 2018. Your id " .$id ;

				
				//Code to send email using send grid is given here

				if (filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					
					//email send grid code starts here

					require_once ('SendGrid-API/vendor/autoload.php');

					/*Post Data*/

					/*Content*/
					$from = new SendGrid\Email("Admin-Wizara", "admin@muslimstudentsmeet.in");
					$subject = "Registration Confirm - MUSLIM STUDENTS MEET - 2018";
					$to = new SendGrid\Email($name, $email);
					$content = new SendGrid\Content("text/html", $message);

					/*Send the mail*/
					$mail = new SendGrid\Mail($from, $subject, $to, $content);
					$apiKey = ('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');
					$sg = new \SendGrid($apiKey);

					/*Response*/
					$response = $sg->client->mail()->send()->post($mail);
					//var_dump($response);

					//ends here
					echo $message;
				}

				else
					{
						echo "Enter valid email";

					} 

				
			} 
			catch (PDOException $e) 
			{
				$error_message = $e->getMessage();

				if(strpos($error_message, "SQLSTATE[23000]") !== false)
				{
					echo "Email already regsitered... Please enter new email id";
				}
				else
				{
					echo $e->getMessage();
				}
			}



		}
	}

	$new_user = new Register();//Creates an object of class Register everytime a new user register.*/
	//$new_user->register_user();//either call here are call in constructor

	
	
	






?>