<?php
	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	
	$user = $_GET['user'];
	$amount = $_GET['goal'];
	$type = $_GET['type'];
	$result = array('status' => "bad", 'percentage' => false, 'updated_goal' => 0);
	
	if(strpos($amount, '%', 0) !== false)
	{
		$result['percentage'] = true;
		$percentage = ".";
		for($inc = 0; $inc != strpos($amount, '%', 0); $inc++)
		{
			$percentage .= $amount[$inc];
		}
		$query_result = mysqli_query($con, 'SELECT goal_calories FROM users WHERE username LIKE "' . $user . '"');
		if($row = mysqli_fetch_array($query_result))
		{
			if($type === "fat")
			{
				$amount = ($row['goal_calories'] * $percentage) / 9;
				$result['updated_goal'] = round($amount, 0);
			}else if($type === "carbs" || $type === "protein")
			{
				$amount = ($row['goal_calories'] * $percentage) / 4;
				$result['updated_goal'] = round($amount, 0);
			}
		
		}
		
	}
	if($type === "protein")
	{
		if(mysqli_query($con,'UPDATE users SET goal_protein = "' . $amount .'" WHERE username LIKE "' . $user .'"'))
		{
			$result['status'] = "good";
		}	
	}else if($type === "fat")
	{
		if(mysqli_query($con,'UPDATE users SET goal_fat = "' . $amount .'" WHERE username LIKE "' . $user .'"'))
		{
			$result['status'] = "good";
		}		
	}else if($type === "carbs")
	{
		if(mysqli_query($con,'UPDATE users SET goal_carbs = "' . $amount .'" WHERE username LIKE "' . $user .'"'))
		{
			$result['status'] = "good";
		}		
	}else if($type === "calories")
	{
		if(mysqli_query($con,'UPDATE users SET goal_calories = "' . $amount .'" WHERE username LIKE "' . $user .'"'))
		{
			$result['status'] = "good";
		}	
	}
	echo json_encode($result);


?>