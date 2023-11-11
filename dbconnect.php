<?php
class DbConnect{
	
	public function db_connection()
    {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "db_medical";

		// Create My-SQL connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);

		// Check connection
		if (!$conn) {
		  die("Connection failed: " . mysqli_connect_error());
		}
		return $conn;		
    } 
}

?>