<?php
	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");
	
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"nutrient_database");
	
	$user = $_GET['cur_user'];
	
	$result = mysqli_query($con,'SELECT goal_calories, goal_protein, goal_carbs, goal_fat FROM users WHERE username LIKE "' . $user . '"');
	
	echo "<table border = '1'>";
	
	if($result && $row = mysqli_fetch_array($result))
	{
		if($row['goal_calories'] == NULL)
		{
			echo "<tr><td>Calorie Goal: </td><td><input id = 'goal_calories' value = \"No Goal Set.\"/><button id = 'set_calories' onclick = 'set_cal_goal($(\"#goal_calories\").val())'>Set</button></td></tr>";
		}else
		{
			echo "<tr><td>Calorie Goal: </td><td><input id = 'goal_calories' value = " . $row['goal_calories'] . " /><button id = 'set_calories' onclick = 'set_cal_goal($(\"#goal_calories\").val())'>Set</button></td></tr>";
		}
		if($row['goal_protein'] == NULL)
		{
			echo "<tr><td>Protein Goal(grams or %): </td><td><input id = 'goal_protein' value = \"No Goal Set.\"/><button id = 'set_protein' onclick = 'set_protein_goal($(\"#goal_protein\").val())'>Set</button></td></tr>";
			
		}else
		{
			echo "<tr><td>Protein Goal(grams or %): </td><td><input id = 'goal_protein' value = " . $row['goal_protein'] . " /><button id = 'set_protein' onclick = 'set_protein_goal($(\"#goal_protein\").val())'>Set</button></td></tr>";
		}
		if($row['goal_carbs'] == NULL)
		{
			echo "<tr><td>Carbohydrate Goal(grams or %): </td><td><input id = 'goal_carbs' value = \"No Goal Set.\"/><button id = 'set_carbs' onclick = 'set_carb_goal($(\"#goal_carbs\").val())'>Set</button></td></tr>";
		}else
		{
			echo "<tr><td>Carbohydrate Goal(grams or %): </td><td><input id = 'goal_carbs' value = " . $row['goal_carbs'] . " /><button id = 'set_carbs' onclick = 'set_carb_goal($(\"#goal_carbs\").val())'>Set</button></td></tr>";
			
		}
		if($row['goal_fat'] == NULL)
		{
			echo "<tr><td>Fat Goal(grams or %): </td><td><input id = 'goal_fat' value = \"No Goal Set.\"/><button id = 'set_fat' onclick = 'set_fat_goal($(\"#goal_fat\").val())'>Set</button></td></tr>";
		}else
		{
			echo "<tr><td>Fat Goal(grams or %): </td><td><input id = 'goal_fat' value = " . $row['goal_fat'] . " /><button id = 'set_fat' onclick = 'set_fat_goal($(\"#goal_fat\").val())'>Set</button></td></tr>";
			
		}
		
	}else
	{
		echo "NO SQL RESULT ERROR";
	}

?>