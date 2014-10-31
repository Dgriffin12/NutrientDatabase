<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	
	$cookie = $_GET['cookie'];
	
	if($cookie !== "")
	{
		list($large_num, $username) = explode('|', $cookie);
		$result = mysqli_query($con,'INSERT INTO session (large_num, user_name) VALUES (' . $large_num . ', "' . $username . '")');
	}
	
	if($result)
	{
		echo "success";
	}else
	{
		echo "fail";
	}
	

?>