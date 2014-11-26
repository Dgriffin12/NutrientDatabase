<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	date_default_timezone_set('America/Los_Angeles');
	
	$username = $_GET['username'];
	$food_NDB_No = $_GET['NDB_No'];
	$weight = $_GET['weight'];
	if($weight === '0')
	{
		$result_default_weight = $amount_res = mysqli_query($con, 'SELECT amount, msre_desc, gm_wgt FROM weight WHERE NDB_No LIKE "' . $food_NDB_No .'"');
		$weights = mysqli_fetch_array($result_default_weight);
		$weight = $weights['gm_wgt'];
	}
	
	$day = $_GET['day'];
	if($day != 0)
	{
		$date = new DateTime;
		date_add($date, date_interval_create_from_date_string('' . $day . 'days'));
		$date_string = $date->format('Y-m-d');
	}else
	{
		$date = new DateTime('now');
		$date_string = $date->format('Y-m-d');
	}
	
	$result = mysqli_query($con, "INSERT INTO diary_entry (username, NDB_No, date, weight) VALUES ('" . $username . "','" . $food_NDB_No ."', '" . $date_string . "', '" . $weight . "')");
	$get_hits_result = mysqli_query($con, 'SELECT Number_of_hits FROM food_des WHERE NDB_No LIKE' . $food_NDB_No . '');
	$number_of_hits_result = mysqli_fetch_array($get_hits_result);
	$number_of_hits_orig = $number_of_hits_result['Number_of_hits'];
	$result_add_hits = mysqli_query($con, "UPDATE food_des SET Number_of_hits = " . ($number_of_hits_orig + 1) . " WHERE NDB_No LIKE " . $food_NDB_No . "");
	if($result)
	{
		echo true;
	}else
	{
		echo false;
	}
	mysqli_close($con);
?>