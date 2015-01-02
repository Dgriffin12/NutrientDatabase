<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");

	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$NDB_No = $_GET['NDB_No'];
	$logged_in = $_GET['logged_in'];
	$weight = $_GET['weight'];
	$multiplier = 1.000;
	$iter = 0;
		
	mysqli_select_db($con,"nutrient_database");
	
	//Calories and Nutrition Facts opener
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "208"');
	$result2 = mysqli_query($con,'SELECT Long_Desc FROM food_des WHERE NDB_No LIKE "' . $NDB_No . '"');
	$row = mysqli_fetch_array($result);	
	$row2 = mysqli_fetch_array($result2);
	
	//Get amount of food
	$amount_res = mysqli_query($con, 'SELECT amount, msre_desc, gm_wgt FROM weight WHERE NDB_No LIKE "' . $NDB_No .'"');	//"info('NDB_No',$("#Food_Amount").val());")
	$amount_row = mysqli_fetch_array($amount_res);
	if($amount_res && $weight == '0')
	{
		$multiplier = ($amount_row['gm_wgt']/100);
		$amount_res->data_seek(0);
	}
	
	
	//Nutrition Data Table Start
	echo "<table  id = " . '"Nutrition_Facts"' . " border = '1'>
	<tr>
	<th>Nutrition Facts for " . $row2['Long_Desc'] . "</th>
	</tr>
	<tr>
	<td>Calories </td><td id = " . '"calories"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . " </td>
  	</tr>";
	
	//Total Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "204"');
	$row = mysqli_fetch_array($result);	
	echo"<tr>
	<td>Total Fat </td><td id = " . '"total_fat"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "g </td>
  	</tr>";
	
	/*
	//Saturated Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "606"');	
	$row = mysqli_fetch_array($result);	
	echo"<tr>
	<td>Saturated Fat </td><td id = " . '"sat_fat"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "g </td>
  	</tr>";
	
	//Trans Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "605"');	
	$row = mysqli_fetch_array($result);	
	echo"<tr>
	<td>Trans Fat </td><td id = " . '"trans_fat"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "g </td>
  	</tr>";
	
	//Monounsaturated Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "645"');	
	$row = mysqli_fetch_array($result);	
	echo"<tr>
	<td>Monounsaturated Fat </td><td id = " . '"mono_fat"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "g </td>
  	</tr>";
	
	//Polyunsaturated Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "646"');	
	$row = mysqli_fetch_array($result);	
	echo"<tr>
	<td>Polyunsaturated Fat </td><td id = " . '"poly_fat"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "g </td>
  	</tr>";
	
	//Cholesterol
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "601"');	
	$row = mysqli_fetch_array($result);
	echo"<tr>
	<td>Cholesterol </td><td id = " . '"cholesterol"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "mg </td>
  	</tr>";
	
	//Sodium
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "307"');	
	$row = mysqli_fetch_array($result);
	echo"<tr>
	<td>Sodium </td><td id = " . '"sodium"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "mg </td>
  	</tr>";
	*/
	//Carbohydrates
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "205"');	
	$row = mysqli_fetch_array($result);
	echo"<tr>
	<td>Carbohydrates </td><td id = " . '"carbs"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "g </td>
  	</tr>";
	
	//Fiber
	/*
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "291"');	
	$row = mysqli_fetch_array($result);	
	echo"<tr>
	<td>Fiber </td><td id = " . '"fiber"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "g </td>
  	</tr>";
	*/
	//Sugars
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "269"');	
	$row = mysqli_fetch_array($result);	
	echo"<tr>
	<td>Sugars </td><td id = " . '"sugar"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "g </td>
  	</tr>";
	
	//Protein	
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "203"');	
	$row = mysqli_fetch_array($result);	
	echo"<tr>
	<td>Protein </td><td id = " . '"protein"' . "> " . number_format($row['Nutr_Val']*$multiplier, 2) . "g </td>
  	</tr>
	</table>";
	
	if($logged_in === "true")
	{
		echo"<button onclick = " . '"add_entry(\'' . $NDB_No . '\');"> Add Food </button>';
	}	
	echo " <p id = 'amount'>Amount of Food: <p><select id = " . '"Food_Amount">';
	
	while($amount_res && $amount_row = mysqli_fetch_array($amount_res))
	{
		if($weight === '0' && $iter === 0)
		{
			$multiplier = $amount_row['gm_wgt'] / 100;		
		}else if($weight != '0')
		{
			$multiplier = $weight / 100.000;
		}		
		echo '<option id = "' . $iter . '" value = '. $amount_row['gm_wgt'] . ">" . $amount_row['amount'] . " " . $amount_row['msre_desc'] . "</option>";
		$iter++;
	}
	
	echo "</select><br>";
	mysqli_close($con);

?>