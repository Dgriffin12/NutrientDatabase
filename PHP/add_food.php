<?php

	$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");

	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$desc_in = $_GET['description'];
	$calories_in = $_GET['calories'];
	$fat_in = $_GET['fat'];
	$carbs_in = $_GET['carbs'];
	$sugar_in = $_GET['sugars'];
	$protein_in = $_GET['protein'];
	$amount = $_GET['amount'];
	$serving = $_GET['serving'];
	
	mysqli_select_db($con,"nutrient_database");
	$result_insert3 = false;
	$result_insert2 = false;
	$result_max = mysqli_query($con,'SELECT max(NDB_No) FROM nut_data');
	$max = mysqli_fetch_array($result_max);
	$max = $max['max(NDB_No)'] + 1; //next NDB_No
	$result = mysqli_query($con,'INSERT INTO nut_data (NDB_No, Nutr_No, Nutr_Val, Num_Data_Ptr, Src_Cd) VALUES (' . $max . ', ' . 203 . ', ' . $protein_in .', ' . 0 . ',' . 0 . ') ');
	$result = mysqli_query($con,'INSERT INTO nut_data (NDB_No, Nutr_No, Nutr_Val, Num_Data_Ptr, Src_Cd) VALUES (' . $max . ', ' . 208 . ', ' . $calories_in .', ' . 0 . ',' . 0 . ') ');
	$result = mysqli_query($con,'INSERT INTO nut_data (NDB_No, Nutr_No, Nutr_Val, Num_Data_Ptr, Src_Cd) VALUES (' . $max . ', ' . 204 . ', ' . $fat_in .', ' . 0 . ',' . 0 . ') ');
	$result = mysqli_query($con,'INSERT INTO nut_data (NDB_No, Nutr_No, Nutr_Val, Num_Data_Ptr, Src_Cd) VALUES (' . $max . ', ' . 205 . ', ' . $carbs_in .', ' . 0 . ',' . 0 . ') ');
	$result = mysqli_query($con,'INSERT INTO nut_data (NDB_No, Nutr_No, Nutr_Val, Num_Data_Ptr, Src_Cd) VALUES (' . $max . ', ' . 269 . ', ' . $sugar_in .', ' . 0 . ',' . 0 . ') ');
	$result_insert2 = mysqli_query($con, 'INSERT INTO food_des (NDB_No, Long_Desc, FdGrp_Cd, Shrt_Desc) VALUES (' . $max . ' , "' . $desc_in .'" , ' . 0 . ' , "' . $desc_in . '")');
	//echo "insert1:  " . mysqli_error($con);
	if(!($result_insert2))
	{
		//echo "insert2:  " . mysqli_error($con);
		$result = mysqli_query($con,'DELETE FROM nut_data WHERE NDB_No = ' . $max . '');
		echo false;
	}else
	{
		$result_insert3 = mysqli_query($con, 'INSERT INTO weight (NDB_No, Seq, Amount, Msre_Desc, Gm_Wgt) VALUES (' . $max . ' , ' . 0 . ', ' . $amount . ', "' . $serving . '", ' . 100 . ')');
		if($result_insert3 === true)
		{
			echo $max;
		}else
		{
			//echo "insert3:  " . mysqli_error($con);
			$result = mysqli_query($con,'DELETE FROM nut_data WHERE NDB_No = ' . $max . '');
			$result2 = mysqli_query($con,'DELETE FROM food_des WHERE NDB_No = ' . $max . '');
			echo false;
		}
	}
	echo false;
?>