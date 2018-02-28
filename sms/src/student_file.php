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

				//echo json_encode($studentDetails); 

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
			echo $this->fetch_student_details();
		}

		//This function add the student details
		public function add_student_details()
		{

		}

		//This function delete the student details
		public function delete_student_details()
		{

		}

	}

		$studentdetail = new Student_Details();
		$studentdetail->edit_student_details();

	
?>