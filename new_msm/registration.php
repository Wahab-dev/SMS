<!-- 
	Author  : Ashika Jahir
	Project :Muslim Students Meet
	

	Module / Page  : Register Page
	Description	   : This Page gets the user details and insert in to db and send a mail to the registered user.
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
			
		}

		//This function registers the user and send them a mail.

		public function register_user() 
		{

			
				$name = $_POST['name'];
				//$gender = $_POST['gender'];
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

				$sender = '';
				$receiver = $email;
				$subject = '';
				$message = '';
				$res = false;


			 

			 try 
			{
				//creates the PDO statement
				$queryStr = $this->db->prepare("INSERT INTO register_details (name,gender,age,email,place,contact,college)VALUES (:name,:gender,:age,:email,:place,:contact,:college)"); 

				//executes the insert query
				$queryStr->execute(array('name' => $name,'gender' => $gender,'age' => $age, 'email' => $email,'place' => $place, 'contact' => $contact, 'college'=>$college));

				$queryStr = $this->db->prepare("SELECT id FROM register_details WHERE name = :name");

				$queryStr->execute(array('name' => $name));
				$row = $queryStr->fetch(PDO::FETCH_ASSOC);
				$id = $row['id'];


				$sender = 'From : ashi.jahir@gmail.com';
				$receiver = $email;
				$subject = "Registered - Muslim Students meet 2018";
				$message = "Dear ".$name. ",You have been Successfully registered in MUSLIM STUDENTS MEET 2018 with the id..." .$id ;

				$res = mail($receiver,$subject,$message,$sender);

				if($res)
					{
						$res = $message;
					}
				else
					{
						$res = "Mail not sent";
					}

				//echo "New User.....Successfully Registered with id...." .$id;

				print_r(json_encode($res));

				
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
	$new_user->register_user();

	
	//header("Location:studentform.html");
	






?>