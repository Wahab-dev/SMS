<?php 

/*
*Author  : Ashika Jahir
*Project : Muslim Students Meet
*
*Page 	 :Database connection Page
*
*Description : This page connects to the required database
*
*/


/*
*Class       : Database
*
*Description : It contains only construtor, whichever extends this class, need to execute the constructor manually.
*
*/



class Database
{
	private $log;//for accessing logs
	
	public $db; //for PDO object

	public $db_access=false;//changes to true if the db gets connected


	//Constructor connects to database
	public function __construct()
	{

		try 
		{
			//returns a PDO object, that access the database for gurther quering
			$this->db = new PDO("mysql:host=localhost;dbname=muslim_students_meet","user", "user");
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

			//creates a logger object with class name
			$this->log = Logger::getLogger(__CLASS__);

			//Logs in the file
			$this->log->info("Database access is given.");

			$this->db_access=true;

		} 
		catch (Exception $e) 
		{
			
			$error_message = $e->getMessage();

				//Checks if the error message contains, the integrity constraint error
				if (strpos($error_message, "SQLSTATE[HY000]") !== false) 
				{
					echo "Warning: Databse Access Denied.Please provide correct credentials";
					$this->log->info("Database Access got denied because of invalid credentials.");
					exit;//exits on not connecting to db
				}
				else
				{
					echo $e->getMessage();
					$this->log->info($e->getMessage());
				}
		}
		finally
		{
			//echo "Crossed db_connect page";
		}
	}


}

?>