<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");

	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$NDB_No = $_GET['NDB_No'];

	mysqli_select_db($con,"nutrient_database");
	
	//Calories and Nutrition Facts opener
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "208"');
	$row = mysqli_fetch_array($result);	
	
	//Nutrition Data Table Start
	$results_array = array();
	$results_array['calories'] = $row['Nutr_Val'];
  	
	//Total Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "204"');
	$row = mysqli_fetch_array($result);	
	$results_array['total_fat'] = $row['Nutr_Val'];
	
	//Saturated Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "606"');	
	$row = mysqli_fetch_array($result);	
	$results_array['sat_fat'] = $row['Nutr_Val'];
	
	//Trans Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "605"');	
	$row = mysqli_fetch_array($result);	
	$results_array['trans_fat'] = $row['Nutr_Val'];

	//Monounsaturated Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "645"');	
	$row = mysqli_fetch_array($result);	
	$results_array['mono_fat'] = $row['Nutr_Val'];
	
	//Polyunsaturated Fat
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "646"');	
	$row = mysqli_fetch_array($result);	
	$results_array['poly_fat'] = $row['Nutr_Val'];
	
	//Cholesterol
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "601"');	
	$row = mysqli_fetch_array($result);
	$results_array['cholesterol'] = $row['Nutr_Val'];
	
	//Sodium
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "307"');	
	$row = mysqli_fetch_array($result);
	$results_array['sodium'] = $row['Nutr_Val'];
		
	//Carbohydrates
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "205"');	
	$row = mysqli_fetch_array($result);
	$results_array['carbs'] = $row['Nutr_Val'];
	
	//Fiber
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "291"');	
	$row = mysqli_fetch_array($result);	
	$results_array['fiber'] = $row['Nutr_Val'];

	//Sugars
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "269"');	
	$row = mysqli_fetch_array($result);	
	$results_array['sugar'] = $row['Nutr_Val'];
	
	//Protein	
	$result = mysqli_query($con,'SELECT Nutr_Val FROM nut_data WHERE NDB_No LIKE "' . $NDB_No . '" AND Nutr_No LIKE "203"');	
	$row = mysqli_fetch_array($result);	
	$results_array['protein'] = $row['Nutr_Val'];
	
	
	echo json_encode($results_array);
	
	mysqli_close($con);

?>