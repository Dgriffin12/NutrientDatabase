<?php
	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	
	$user = $_GET['user'];
	$amount = $_GET['goal'];
	$type = $_GET['type'];
	$result = false;
	if($type === "protein")
	{
		$result = mysqli_query($con,'UPDATE users SET goal_protein = "' . $amount .'" WHERE username LIKE "' . $user .'"');
	}else if($type === "fat")
	{
		$result = mysqli_query($con,'UPDATE users SET goal_carbs = "' . $amount .'" WHERE username LIKE "' . $user .'"');
	}else if($type === "carbs")
	{
		$result = mysqli_query($con,'UPDATE users SET goal_fat = "' . $amount .'" WHERE username LIKE "' . $user .'"');
	}else if($type === "calories")
	{
		$result = mysqli_query($con,'UPDATE users SET goal_calories = "' . $amount .'" WHERE username LIKE "' . $user .'"');
	}
	echo $result;


?>