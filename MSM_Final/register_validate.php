<?php 

/*
*	Author  : Ashika Jahir
*	Project : Muslim Students Meet
*	
*
*	Module / Page  : Register validation Page
*	Description	   : This Page gets the user details and validates them
*
*
*  
*/
	if(isset($_POST['name']) && isset($_POST['age']) && isset($_POST['college']) && isset($_POST['place']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['gender']) && isset($_POST['whatsapp_number']))
		{
				$name = $_POST['name'];
				$gender = $_POST['gender'];
				$age = $_POST['age'];
				$email = $_POST['email'];
				$place = $_POST['place'];
				$contact = $_POST['contact'];
				$college = $_POST['college'];
				$whatsappno = $_POST['whatsapp_number'];

				

				include("registration.php");
				$user = new Register($name,$gender,$age,$email,$place,$contact,$college,$whatsappno);
		}
		else
		{
			echo "Enter all data and submit the form";
		}
	


?>