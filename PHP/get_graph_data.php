<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$username = $_GET['username'];
	$nutrient = $_GET['nutrient'];
	$time_scale = $_GET['time_scale'];
	$date = new DateTime('now');
	$date_day = $date->format('l');
	$date_month = $date->format('m');
	$date_year = $date->format('Y');
	$offset_to_Monday = 0;
	//Get nutrient for query.
	if($nutrient === "calories")
	{
		$Nutr_No = 208;
	}else if($nutrient === "fat")
	{
		$Nutr_No = 204;
	}else if($nutrient === "carbs")
	{
		$Nutr_No = 205;
	}else if($nutrient === "protein")
	{
		$Nutr_No = 203;
	}
	if($date_day === "Monday")
	{
		$offset_to_Monday = 0;
	}else if($date_day === "Tuesday")
	{
		$offset_to_Monday = 1;
	}else if($date_day === "Wednesday")
	{
		$offset_to_Monday = 2;
	}else if($date_day === "Thursday")
	{
		$offset_to_Monday = 3;
	}else if($date_day === "Friday")
	{
		$offset_to_Monday = 4;
	}else if($date_day === "Saturday")
	{
		$offset_to_Monday = 5;
	}else if($date_day === "Sunday")
	{
		$offset_to_Monday = 6;
	}
	//Calculate Dates by subtracting distance from Monday, then adding one day up to a full week.
	date_sub($date, date_interval_create_from_date_string($offset_to_Monday . " days"));
	$first_date = $date->format('Y-m-d');
	date_add($date, date_interval_create_from_date_string("1 day"));
	$second_date = $date->format('Y-m-d');
	date_add($date, date_interval_create_from_date_string("1 day"));
	$third_date = $date->format('Y-m-d');
	date_add($date, date_interval_create_from_date_string("1 day"));
	$fourth_date = $date->format('Y-m-d');
	date_add($date, date_interval_create_from_date_string("1 day"));
	$fifth_date = $date->format('Y-m-d');
	date_add($date, date_interval_create_from_date_string("1 day"));
	$sixth_date = $date->format('Y-m-d');
	date_add($date, date_interval_create_from_date_string("1 day"));
	$seventh_date = $date->format('Y-m-d');
	if($time_scale === "weekly")
	{
		//Monday
		$result_Monday = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $first_date ."'");
		$Monday_total = 0;
		while($row = mysqli_fetch_array($result_Monday))
		{
			$result = mysqli_query($con, "SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE '" . $row['NDB_No'] . "' AND Nutr_No LIKE '" . $Nutr_No ."'");
			$row2 = mysqli_fetch_array($result);
			$Monday_total += $row2['Nutr_Val']*($row['weight'] / 100);
		}

		//Tuesday
		$result_Tuesday = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $second_date ."'");
		$Tuesday_total = 0;
		while($row = mysqli_fetch_array($result_Tuesday))
		{
			$result = mysqli_query($con, "SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE '" . $row['NDB_No'] . "' AND Nutr_No LIKE '" . $Nutr_No ."'");
			$row2 = mysqli_fetch_array($result);
			$Tuesday_total += $row2['Nutr_Val']*$row['weight'] / 100;
		}
		
		//Wednesday
		$result_Wednesday = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $third_date ."'");
		$Wednesday_total = 0;
		while($row = mysqli_fetch_array($result_Wednesday))
		{
			$result = mysqli_query($con, "SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE '" . $row['NDB_No'] . "' AND Nutr_No LIKE '" . $Nutr_No ."'");
			$row2 = mysqli_fetch_array($result);
			$Wednesday_total += $row2['Nutr_Val']*$row['weight'] / 100;
		}
		
		//Thursday
		$result_Thursday = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $fourth_date ."'");
		$Thursday_total = 0;
		while($row = mysqli_fetch_array($result_Thursday))
		{
			$result = mysqli_query($con, "SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE '" . $row['NDB_No'] . "' AND Nutr_No LIKE '" . $Nutr_No ."'");
			$row2 = mysqli_fetch_array($result);
			$Thursday_total += $row2['Nutr_Val']*$row['weight'] / 100;
		}
		
		//Friday
		$result_Friday = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $fifth_date ."'");
		$Friday_total = 0;
		while($row = mysqli_fetch_array($result_Friday))
		{
			$result = mysqli_query($con, "SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE '" . $row['NDB_No'] . "' AND Nutr_No LIKE '" . $Nutr_No ."'");
			$row2 = mysqli_fetch_array($result);
			$Friday_total += $row2['Nutr_Val']*$row['weight'] / 100;
		}
		//Saturday
		$result_Saturday = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $fourth_date ."'");
		$Saturday_total = 0;
		while($row = mysqli_fetch_array($result_Saturday))
		{
			$result = mysqli_query($con, "SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE '" . $row['NDB_No'] . "' AND Nutr_No LIKE '" . $Nutr_No ."'");
			$row2 = mysqli_fetch_array($result);
			$Saturday_total += $row2['Nutr_Val']*$row['weight'] / 100;
		}
		
		//Sunday
		$result_Sunday = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $fourth_date ."'");
		$Sunday_total = 0;
		while($row = mysqli_fetch_array($result_Sunday))
		{
			$result = mysqli_query($con, "SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE '" . $row['NDB_No'] . "' AND Nutr_No LIKE '" . $Nutr_No ."'");
			$row2 = mysqli_fetch_array($result);
			$Sunday_total += $row2['Nutr_Val']*$row['weight'] / 100;
		}
		
		//RESPONSE
		$response = array('Monday' => $Monday_total, 'Tuesday' => $Tuesday_total, 'Wednesday' => $Wednesday_total,
		 'Thursday' => $Thursday_total, 'Friday' => $Friday_total, 'Saturday' => $Saturday_total, 'Sunday' => $Sunday_total);
		 
	}else if($time_scale === "monthly")
	{
		$response = array(32 => 0);
		$i = 0;
		for($i = 0; $i < 31; $i++)
		{
			if($i < 9)
			{
				$leading_num = "0";
			}else
			{
				$leading_num = "";
			}
			$result = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $date_year . '-' . $date_month . '-' . $leading_num . ($i+1) ."'");
			$Sum = 0;
			while($row = mysqli_fetch_array($result))
			{
				$result_summer = mysqli_query($con, "SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE '" . $row['NDB_No'] . "' AND Nutr_No LIKE '" . $Nutr_No ."'");
				$row2 = mysqli_fetch_array($result_summer);
				$Sum += $row2['Nutr_Val']*($row['weight'] / 100);
			}
			$response[$i] = $Sum;
		}
	}
	echo json_encode($response);
	mysqli_close($con);
?>