<?php 


if (!empty($_POST['submit']))
			 {
				$name = $_POST['name'];
				$gender = $_POST['gender'];
				$age = $_POST['age'];
				$email = $_POST['email'];
				$place = $_POST['place'];
				$contact = $_POST['contact'];
				$college = $_POST['college'];
			}


			echo $name;
			echo $gender;
			echo $age;
			echo $email;
			echo $place;
			echo $contact;
			echo $college;






?>