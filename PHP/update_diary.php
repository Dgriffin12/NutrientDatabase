<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	date_default_timezone_set('America/Los_Angeles');
	mysqli_select_db($con,"nutrient_database");
	$username = $_GET['username'];
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
	
	
	$result_first = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $date_string ."'");
	$result_goals = mysqli_query($con, "SELECT goal_calories, goal_protein, goal_fat, goal_carbs FROM users WHERE username LIKE '" . $username . "'");
	
	echo "<button id = 'subtract_day' onclick = 'subtract_day()' >Previous Day</button>
	" . " " . $date->format('F j, Y') . " " . "
	<button id = 'add_day' onclick = 'add_day()'>Next Day</button>";
	
	$total_fat = 0;
	$total_protein = 0;
	$total_calories = 0;
	$total_carbs = 0;
	$protein_goal = 0;
	$carb_goal = 0;
	$fat_goal = 0;
	$calories_goal = 0;
	$calories_less_goal = 0;
	$fat_less_goal = 0;
	$protein_less_goal = 0;
	$carbs_less_goal = 0;
	while($result_first && $row = mysqli_fetch_array($result_first)) 
	{
 	 	/*echo "<tr>";
		$result = mysqli_query($con,'SELECT Long_Desc FROM food_des WHERE NDB_No LIKE "' . $row['NDB_No'] . '"');
		$row2 = mysqli_fetch_array($result);
  		echo "<td>" . $row2['Long_Desc'] . " </td><td><button onclick = " . '"remove_entry(' . $row['iddiary_entry'] . ')"> Remove Entry </></td>';
  		echo "</tr>";*/
		$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $row['NDB_No'] . '" AND Nutr_No LIKE "204"');
		$row2 = mysqli_fetch_array($result);	
		if($row2)
			$total_fat += $row2['Nutr_Val'] * ($row['weight'] / 100);
		$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $row['NDB_No'] . '" AND Nutr_No LIKE "205"');	
		$row2 = mysqli_fetch_array($result);
		if($row2)
			$total_carbs += $row2['Nutr_Val'] * ($row['weight'] / 100);
		$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $row['NDB_No'] . '" AND Nutr_No LIKE "203"');	
		$row2 = mysqli_fetch_array($result);
		if($row2)
			$total_protein += $row2['Nutr_Val'] * ($row['weight'] / 100);
		$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $row['NDB_No'] . '" AND Nutr_No LIKE "208"');
		$row2 = mysqli_fetch_array($result);
		if($row2)
			$total_calories += $row2['Nutr_Val'] * ($row['weight'] / 100);
	}

	if($result_goals && $row_goal = mysqli_fetch_array($result_goals))
	{
		if($row_goal['goal_calories'] !== NULL)
		{
			$calories_goal = $row_goal['goal_calories'];
		}
		if($row_goal['goal_protein'] !== NULL)
		{
			$protein_goal = $row_goal['goal_protein'];
		}
		if($row_goal['goal_carbs'] !== NULL)
		{
			$carb_goal = $row_goal['goal_carbs'];	
		}
		if($row_goal['goal_fat'] !== NULL)
		{
			$fat_goal = $row_goal['goal_fat'];
		}
	}

	//Calculate Totals, less already consumed.
	$calories_less_goal = $calories_goal - $total_calories;
	$fat_less_goal = $fat_goal - $total_fat;
	$protein_less_goal = $protein_goal - $total_protein;
	$carbs_less_goal = $carb_goal - $total_carbs;
	//Calculate % of Daily Calories
	$fat_percent;
	$carbs_percent;
	$protein_percent;
	
	//echo "</table>";
	//echo "<br>";
	echo "<table id = 'Daily_Intake_Table' border = '2'><tr><th>Nutrients</th><th>Daily Totals</th><th> Daily Goal</th><th>Amount Left</th></tr>";
	echo "<tr><td>Calories </td><td> " . number_format($total_calories, 0) . "  </td><td> " . $calories_goal . " </td>";
	if($calories_less_goal >= 0)
	{
		echo "<td style = 'color:green'> " .  number_format($calories_less_goal, 0) . " </td></tr>";
	}else
	{
		echo "<td style = 'color:orange'> " .  number_format($calories_less_goal, 0) . " </td></tr>";
	}
	echo "<tr><td>Fat </td><td> " . number_format($total_fat, 0) . "g  </td><td> " . $fat_goal . "g </td>";
	
	if($fat_less_goal >= 0)
	{
		echo "<td style = 'color:green'> " . number_format($fat_less_goal, 0) . " </td></tr>";
	}else
	{
		echo "<td style = 'color:orange'> " . number_format($fat_less_goal, 0) . " </td></tr>";
	}
	
	echo "<tr><td>Carbs</td><td> " . number_format($total_carbs, 0) . "g  </td><td> " . $carb_goal . "g </td>";
	if($carbs_less_goal >= 0)
	{
		echo "<td style = 'color:green'> " . number_format($carbs_less_goal, 0) . " </td></tr>";
	}else
	{
		echo "<td style = 'color:orange'> " . number_format($carbs_less_goal, 0) . " </td></tr>";
	}
	
	echo "<tr><td>Protein </td><td> " . number_format($total_protein, 0) . "g  </td><td> " . $protein_goal . "g </td>";
	if($protein_less_goal >= 0)
	{
		echo "<td style = 'color:green'>  " . number_format($protein_less_goal, 0) . " </td></tr>";
	}else
	{
		echo "<td style = 'color:orange'>  " . number_format($protein_less_goal, 0) . " </td></tr>";
	}
	
	
	
	
	echo "</table>";
	mysqli_close($con);
?>