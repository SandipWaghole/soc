<?php
include 'dbconnect.php';

class Modeller{
	
	public function checkSecurityToken($token)
    {	

	$obj = new DbConnect();
	$conn=$obj->db_connection();
	
	$sql = "SELECT * FROM tbl_consumers_token WHERE token = '$token'";

	$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
		 return 200;
		} else {
		  return 401;
		}

    }
	
	public function getConsumerData($user_id)
    {	

	$obj = new DbConnect();
	$conn=$obj->db_connection();
	
	$sql = "SELECT * FROM tbl_consumer";
	if($user_id <> 0 )
	{
		$sql=$sql." WHERE id = $user_id";
	}

	
	$result = mysqli_query($conn, $sql);
	$dbdata = [];

		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
		  while($row = mysqli_fetch_assoc($result)) {
			$dbdata[] = $row;		
		  }
		} else {
		  echo "No Data";
		}
	return json_encode($dbdata);	
    }
	
	// Add Consumer into system
	public function createConsumer($data)
    {	

	$obj = new DbConnect();
	$conn=$obj->db_connection();
	$sql = "INSERT INTO `tbl_consumer` (`id`, `name`, `address`, `contact`, `active_status`, `birthdate`, `city`, `state`) VALUES ";
	
	$count = count($data);
	
	for($i=0;$i<$count;$i++)
	{
		if($count >1 AND $i!=0)
			$sql=$sql.",";
			
			$sql=$sql."('".$data[$i]['id']."','".$data[$i]['name']."','".$data[$i]['address']."','".$data[$i]['contact']."','".$data[$i]['active_status']."','".$data[$i]['birthdate']."','".$data[$i]['city']."','".$data[$i]['state']."')";		
	}	
	
	mysqli_query($conn, $sql);
	
	return $sql;
    }
	
	// Remove Consumer into system
	public function removeConsumer($data)
    {	

	$obj = new DbConnect();
	$conn=$obj->db_connection();
	$sql = "DELETE FROM `tbl_consumer` WHERE `id` IN (";
	
	$count = count($data);
	
	for($i=0;$i<$count;$i++)
	{
		if($count >1 AND $i!=0)
			$sql=$sql.",";
			
			$sql=$sql."'".$data[$i]['id']."'"; 
	}	
	$sql=$sql.")";
	mysqli_query($conn, $sql);
	
	return $sql;
    }
	
	// Modify Consumer into system
	public function modifyConsumer($data)
    {	

	$obj = new DbConnect();
	$conn=$obj->db_connection();
		
	$record=$data[0];
	$keys = array_keys($record);
	
	$count=count($keys);
	
	$sql = "UPDATE `tbl_consumer` SET ";
	
	// Formation of dynamic query - Modify only shared values and not all values
	for($i=0;$i<$count;$i++)
	{ 
		$key=$keys[$i];
		
		if($key!="id")
		{
			if($count >1 AND $i!=0 AND $keys[$i-1]!="id" ) // Manage issue of last field and , seperated
				$sql=$sql.",";
			
			$sql=$sql.$key."='".$record[$key]."'"; 
			
		}
	}	
	
	$sql=$sql." WHERE id='".$record['id']."'"; 
	
	mysqli_query($conn, $sql);
	
	return $sql;
    }
}


?>