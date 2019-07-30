
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
*  Class    		: Register (Extended Class)
*  Description 		: It creates an object every time a user register and do the page functionality
*  
*/

	//INCLUDE FILES

	//Including logger files and configuring it

	include('log4php/Logger.php');
	Logger::configure('config.xml');

	//include database connection

	include('db_connect.php');


class Register EXTENDS Database
	

	{

		public $db = '';//for accessing PDO object
		private $log; //for accessing logger

		public $name;
		public $gender;
		public $age;
		public $email;
		public $place;
		public $contact;
		public $college;
		public $whatsappno;

		

		public function __construct($name,$gender,$age,$email,$place,$contact,$college,$whatsappno) 
		{	
			

			parent::__construct();

			$this->log = Logger::getLogger(__cLASS__);

			if($this->db_access === true)
			{
				$this->name = $name;
				$this->gender = $gender;
				$this->age = $age;
				$this->email = $email;
				$this->place = $place;
				$this->contact = $contact;
				$this->college = $college;
				$this->whatsappno = $whatsappno;

				$this->register_user();
			}
			else
			{
				echo "Database is not connected";
			}	

			
			
		}

		//This function registers the user and send them a mail.

		public function register_user() 
		{		
				$subject = '';
				$message = '';			 

			 try 
			{
				//creates the PDO statement
				$queryStr = $this->db->prepare("INSERT INTO register_details (name,gender,age,email,place,contact,college,whatsappno)VALUES (:name,:gender,:age,:email,:place,:contact,:college,:whatsappno)"); 

				//executes the insert query
				$queryStr->execute(array('name'=>$this->name,'gender'=>$this->gender,'age' => $this->age, 'email' => $this->email,'place' => $this->place, 'contact' => $this->contact, 'college'=>$this->college, 'whatsappno' => $this->whatsappno
					));

				$queryStr = $this->db->prepare("SELECT id FROM register_details WHERE email = :email");

				$queryStr->execute(array('email' => $this->email));
				$row = $queryStr->fetch(PDO::FETCH_ASSOC);
				$id = $row['id'];


				//Message to be sent in mail

				$message = "Dear ".$this->name. ",You have been Successfully registered in MUSLIM STUDENTS MEET 2018. Your id " .$id ;

				
				//Code to send email using send grid is given here

				if (filter_var($this->email, FILTER_VALIDATE_EMAIL))
				{
					
					//email send grid code starts here

					require_once ('SendGrid-API/vendor/autoload.php');

					/*Post Data*/

					/*Content*/
					$from = new SendGrid\Email("Admin-MSM", "admin@muslimstudentsmeet.in");
		
					$subject = "Registration Confirm - MUSLIM STUDENTS MEET - 2018";
					$to = new SendGrid\Email($this->name, $this->email);
					$content = new SendGrid\Content("text/html", $message);

					/*Send the mail*/
					$mail = new SendGrid\Mail($from, $subject, $to, $content);
					$apiKey = ('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');
					$sg = new \SendGrid($apiKey);

					/*Response*/
					$response = $sg->client->mail()->send()->post($mail);
					//var_dump($response);

					//Mail code to Admin starts here
					$from = new SendGrid\Email("Admin-MSM", "admin@muslimstudentsmeet.in");
					$subject = "New student has registered";
					$to = new SendGrid\Email("Admin-MSM", "admin@muslimstudentsmeet.in");
					$content = new SendGrid\Content("text/html", $message);

					/*Send the mail*/
					$mail = new SendGrid\Mail($from, $subject, $to, $content);
					$apiKey = ('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');
					$sg = new \SendGrid($apiKey);

					/*Response*/
					$response = $sg->client->mail()->send()->post($mail);


					//Mail code to admin code ends here

					//Code to send email using send grid ends here
					echo json_encode($message);

					$this->log->info("A user got registered with id.." .$id);
				}

				else
					{
						echo "Enter valid email";

					} 

				
			} 
			catch (PDOException $e) 
			{
				$error_message = $e->getMessage();

				//it checks whether the error is the integrity constraint on the database.

				if(strpos($error_message, "SQLSTATE[23000]") !== false)
				{
					echo "Email already regsitered... Please enter new email id";
				}
				else
				{
					echo $e->getMessage();
					$this->log->info($e->getMessage());
				}
			}
			finally
			{
				echo "Have a happy day";
			}



		}
	}



?>