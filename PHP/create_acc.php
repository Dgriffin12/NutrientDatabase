<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	
	$username = $_GET['username'];
	$password = $_GET['password'];
	
	if($username !== 'username' && $password !== 'password')
	{
		$result = mysqli_query($con,'INSERT INTO users (username, password) VALUES ("' . $username . '", "' . $password . '")');
		if($result)
		{
			$responseText = array('status' => "good", 'text' =>'Account Creation Successful!');
			echo json_encode($responseText);
		}else
		{
			$responseText = array('status' => "bad", 'text' => 'Could not create account, the username may be taken.');
			echo json_encode($responseText);
		}
	}else
	{
		$responseText = array('status' => "bad", 'text' => 'Please enter a username and password');
	}
	
	mysqli_close($con);
?>