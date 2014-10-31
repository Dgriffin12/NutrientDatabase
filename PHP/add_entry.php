<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	
	$username = $_GET['username'];
	$food_NDB_No = $_GET['NDB_No'];
	$weight = $_GET['weight'];
	if($weight === '0')
	{
		$result_default_weight = $amount_res = mysqli_query($con, 'SELECT amount, msre_desc, gm_wgt FROM weight WHERE NDB_No LIKE "' . $food_NDB_No .'"');
		$weights = mysqli_fetch_array($result_default_weight);
		$weight = $weights['gm_wgt'];
	}
	date_default_timezone_set('America/Los_Angeles');
	$date = date('Y') . '-' . date('m') . '-' . date('d');
	$result = mysqli_query($con, "INSERT INTO diary_entry (username, NDB_No, date, weight) VALUES ('" . $username . "','" . $food_NDB_No ."', '" . $date . "', '" . $weight . "')");
	if($result)
	{
		echo true;
	}else
	{
		echo false;
	}
	mysqli_close($con);
?>