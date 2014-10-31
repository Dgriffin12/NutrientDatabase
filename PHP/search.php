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
$result = mysqli_query($con,'SELECT NDB_No, Long_Desc FROM FOOD_DES WHERE Long_Desc LIKE "%' . $q . '%"');

if($row = mysqli_fetch_array($result))
{
	echo "<table border = '1'>
	<tr>
	<th>Foods</th>
	</tr>";

	 do{
	  echo "<tr>";
	  if($logged_in === "true")
	  {
	  	echo "<td>" . $row['Long_Desc'] . "</td><td><button onclick = " . '"info(\'' . $row['NDB_No'] . '\', 0)">' . "Nutrition</button></td><td><button onclick = " . '"add_entry(\'' . $row['NDB_No'] . '\')"> Quick Add </button></td>';
	  }else
	  {
	  	echo "<td>" . $row['Long_Desc'] . "</td><td><button onclick = " . '"info(\'' . $row['NDB_No'] . '\', 0)">' . "Nutrition</button></td>";	
	  }       
	  echo "</tr>";
	}while($row = mysqli_fetch_array($result));
	echo "</table>";
}else
{
	echo "No matches found.";
}
mysqli_close($con);
?>