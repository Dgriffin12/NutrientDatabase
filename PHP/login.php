<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	
	$username = $_GET['username'];
	$password = $_GET['password'];
	
	$delete_result = mysqli_query($con,'DELETE FROM session WHERE user_name LIKE "' . $username . '"');
	$result = mysqli_query($con,'SELECT * FROM users WHERE (username LIKE "' . $username . '" AND password LIKE "' . $password . '")');
	
	if($username !== 'username' && $password !== 'password' && $username !== '' && $password !== '')
	{
		if($result && $row = mysqli_fetch_array($result))
		{
			$responseText = array('status' => "good", 'text' =>'Successful Login with ' . $username . '', 'username' => $username);
			echo json_encode($responseText);
		}else
		{
			$responseText = array('status' => "bad", 'text' =>'No username / password combo found.');
			echo json_encode($responseText);
		}
	}else{		
		$responseText = array('status' => "bad", 'text' =>'Please enter a username and password');
		echo json_encode($responseText);
	}

?>