<!-- 
	Author  : Ashika Jahir
	Project :School Management System
	Version : 1

	Module / Page  : Student Detsils Page
	Description	   : This Page fetch the details of the student from the db and convert it into jason object and send

-->

<?php
	/*
*
*  Class    		: Student_Details
*  Description 		: It creates an object every time the user login and do the page functionality
*  
*/
	class Student_Details 
	{
		
		public $db = '';
		

		//Constructor that performs db connectivity 
		
		public function __construct()
		{
			//connecting to db - crud
			$this->db = new PDO("mysql:host=localhost;dbname=crud","ashi", "ashikajahir");
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		}


		//This function fetch the details of the student and then returns a jason object
		public function fetch_student_details()
		{
			$studentDetails = array();
			try
			{
				$queryStr = $this->db->prepare("select id,first_name,last_name,email_id,gender,age from crud_table");
				$queryStr -> execute();


				for($i=0; $row = $queryStr->fetch(PDO::FETCH_ASSOC) ;$i++)
				{
					$studentDetails[] = $row;

				}

				//converting the array of rows to jason

				echo json_encode($studentDetails); 

				return json_encode($studentDetails);
			} 
			catch (PDOException $e) 
				{
				echo $e->getMessage();
				}
		}

		//This function edit the student details 
		public function edit_student_details()
		{
			if(isset($_GET['id']))
				{
					$id=$_GET['id'];
				}
			try 
			{
				$queryStr = $this->db->prepare("update crud_table set first_name =:first_name,last_name =:second_name ,email_id = :email_id,gender= :gender,age=:age where id=$id");

				$queryStr->execute(array('first_name'=>$first_name, 'second_name' => $second_name, 'email_id' => $email_id, 'gender' => $gender, 'age' => $age ));

			} 

			catch (PDOException $e) 
			{
				echo $e->getMessage();
			}

			//echo $this->fetch_student_details();
		}

		//This function add the student details
		public function add_student_details()
		{
			try 
			{
				if(isset($_POST) && !empty($_POST))
				{
					$first_name = $_POST['firstname'];
					$second_name = $_POST['secondname'];
					$email_id = $_POST['email'];
					$gender = $_POST['gender'];
					$age = $_POST['age'];

				}

				$queryStr=$this->db->prepare("insert into crud_table(first_name,last_name,email_id,gender,age) values(:first_name,:second_name,:email_id,:gender,:age)");

				$queryStr->execute(array('first_name'=>$first_name, 'second_name' => $second_name, 'email_id' => $email_id, 'gender' => $gender, 'age' => $age ));

			} 

			catch (PDOException $e) 
			{
				echo $e->getMessage();
			}

		}

		//This function delete the student details
		public function delete_student_details()
		{
			if(isset($_GET['id']))
			{
				$id=$_GET['id'];
			}
			try 
			{
				$queryStr = $this->db->prepare("delete from crud_table where id=$id");
				$queryStr->execute();
			} 

			catch (PDOException $e) 
			{
				echo $e->getMessage();
			}
		}

	}

		$studentdetail = new Student_Details();
		$studentdetail->fetch_student_details();

	
?>