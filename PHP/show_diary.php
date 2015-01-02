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
	
	
	$result = mysqli_query($con, "SELECT * FROM diary_entry WHERE username LIKE '" . $username . "' AND date LIKE '" . $date_string ."'");
	
	echo "<table id = 'Diary_Entries_Table' border = '1'>";
	
	
	if($result->num_rows === 0)
	{
		echo "
		<tr> <td>No Entries Today</td> </tr>";
	}else
	{
		echo "<tr>
			<th>Calories</th><th>Fat</th><th>Carbs</th><th>Protein</th><th>Food Name</th><th></th>
		</tr>";
	}
	while($result && $row = mysqli_fetch_array($result)) 
	{
 	 	echo "<tr>";
		$result2 = mysqli_query($con,'SELECT Long_Desc FROM food_des WHERE NDB_No LIKE "' . $row['NDB_No'] . '"');
		$row2 = mysqli_fetch_array($result2);
		//Calories
		$result_nut = mysqli_query($con, 'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE ' . $row['NDB_No'] . ' AND Nutr_No LIKE "208"');
		if($result_nut)
		{
			$row_nut = mysqli_fetch_array($result_nut);
			echo "<td>" . number_format(($row['weight']/100)*$row_nut['Nutr_Val'], 0) . " </td>";
		}else
		{
			echo "<td>0</td>";
		}
		
		//Fat
		$result_nut = mysqli_query($con, 'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE ' . $row['NDB_No'] . ' AND Nutr_No LIKE "204"');
		if($result_nut)
		{
			$row_nut = mysqli_fetch_array($result_nut);
			echo "<td>" . number_format(($row['weight']/100)*$row_nut['Nutr_Val'], 0) . "g </td>";
		}else
		{
			echo "<td>0</td>";
		}

		//Carbs
		$result_nut = mysqli_query($con, 'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE ' . $row['NDB_No'] . ' AND Nutr_No LIKE "205"');
		if($result_nut)
		{
			$row_nut = mysqli_fetch_array($result_nut);
			echo "<td>" . number_format(($row['weight']/100)*$row_nut['Nutr_Val'], 0) . "g </td>";
		}else
		{
			echo "<td>0</td>";
		}
		//Protein
		$result_nut = mysqli_query($con, 'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE ' . $row['NDB_No'] . ' AND Nutr_No LIKE "203"');
		if($result_nut)
		{
			$row_nut = mysqli_fetch_array($result_nut);
			echo "<td>" . number_format(($row['weight']/100)*$row_nut['Nutr_Val'], 0) . "g </td>";
		}else
		{
			echo "<td>0</td>";
		}
		//Food Description and Button
  		echo "<td>" . $row2['Long_Desc'] . " </td><td><button onclick = " . '"remove_entry(' . $row['iddiary_entry'] . ')"> Remove Entry </></td>';
  		echo "</tr>";
	}

	echo "</table>";
	
	
	
?>