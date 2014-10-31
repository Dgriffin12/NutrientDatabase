<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	
	$id = $_GET['id'];
	
	$result = mysqli_query($con, "DELETE FROM diary_entry WHERE iddiary_entry = '" . $id . "'");
	if($result)
	{
		echo true;
	}else
	{
		echo false;
	}
	mysqli_close($con);
?>