<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	
	$long_num = $_GET['long_num'];
	$username = $_GET['username'];
	
	$result = mysqli_query($con,'DELETE FROM session WHERE large_num LIKE ' . $long_num . ' AND user_name LIKE "' . $username . '"');
	
	if($result)
	{
		echo "success";
	}else
	{
		echo "failure";
	}
		
?>