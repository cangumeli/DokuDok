<?php

include_once('config.php');

class User
{
	private $password;

	
	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword()
	{
	
		$this->password = $this->randomPassword(8);
	}


	public function setLogPassword($logPass)
	{
	
		$this->password = $logPass;
	}



	public function randomPassword($size) {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    
	    for ($i = 0; $i < $size; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    	return implode($pass); //turn the array into a string
	}




	public function save()
	{
		$config = new Config();
		$conn = $config->getConnection();
		$query = "INSERT INTO users (password)
				VALUES ('$this->password')";

		if ($conn->query($query) !== TRUE)
			echo 'user cannot add to databse';
		
	}

	public function userInfo()
	{
		$givenpass = $this->getPassword();
		return $givenpass;
	}


	public static function deleteUser($passwd)
	{
		
		$config = new Config();
		$conn = $config->getConnection();
		
		// sql to delete a record
		$sql = "DELETE FROM users WHERE password='$passwd'";
		
		if (mysqli_query($conn, $sql)) {
		   // echo "Record deleted successfully";
		   
		} else {
		    echo "Error deleting record: " . mysqli_error($conn);
		}

	}


	public static function searchUser($passwd)
	{
		$config = new Config();
		$conn = $config->getConnection();

		$sql = "SELECT id, password FROM users";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		       // echo "id: " . $row["id"]. " - Name: " . $row["password"]. "<br>";
		   		if($passwd == $row["password"] ){
		   			return true;
		   		}
		    }
		} 
		return false;


	}

}

?>