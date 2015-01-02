<?php
	//echo $_POST['search_string'];

// Create connection
$con=mysqli_connect("localhost","dougyfresh","Football12#$","nutrient_database");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_select_db($con,"nutrient_database");

$q = $_GET['q'];
$logged_in = $_GET['k'];
$result = mysqli_query($con,'SELECT NDB_No, Long_Desc, Number_of_hits FROM FOOD_DES WHERE Long_Desc LIKE "%' . $q . '%" ORDER BY Number_of_hits desc, CHAR_LENGTH(Long_Desc)');

if($row = mysqli_fetch_array($result))
{
	echo '<table id = "search_table" border = "1">
	<thead border = "1">
		<tr>
			<th>Foods</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody border = "1">';
	$inte = 0;
	 do{
	  echo "<tr>";
	  if($logged_in === "true")
	  {
	  	if($inte % 2 == 0)
		{
	  		echo "<td width = '550' style = 'background-color: #DDDDDD' class = 'long_desc_data'>" . $row['Long_Desc'] . "</td><td><button onclick = " . '"info(\'' . $row['NDB_No'] . '\', 0)">' . "Nutrition</button></td><td><button onclick = " . '"add_entry(\'' . $row['NDB_No'] . '\')"> Quick Add </button></td>';			
		}else 
		{
			echo "<td width = '550'class = 'long_desc_data'>" . $row['Long_Desc'] . "</td><td><button onclick = " . '"info(\'' . $row['NDB_No'] . '\', 0)">' . "Nutrition</button></td><td><button onclick = " . '"add_entry(\'' . $row['NDB_No'] . '\')"> Quick Add </button></td>';				
		}
	  }else
	  {
	  	
		if($inte % 2 == 0)
		{
			echo "<td width = '650' style = 'background-color: #DDDDDD'>" . $row['Long_Desc'] . "</td><td><button onclick = " . '"info(\'' . $row['NDB_No'] . '\', 0)">' . "Nutrition</button></td>";	
		}else
		{
			echo "<td width = '650'>" . $row['Long_Desc'] . "</td><td><button onclick = " . '"info(\'' . $row['NDB_No'] . '\', 0)">' . "Nutrition</button></td>";	
		}
	  }       
	  echo "</tr>";	 
	  $inte++;
	}while($row = mysqli_fetch_array($result));
	echo "</tbody></table>";
}else
{
	echo "No matches found.";
}
mysqli_close($con);
?>