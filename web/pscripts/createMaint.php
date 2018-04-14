<?php

session_start();
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
$start_date = mysqli_real_escape_string($conn, $_REQUEST["arg0"]);
$finish_date = mysqli_real_escape_string($conn, $_REQUEST["arg1"]);
$equipment_id = mysqli_real_escape_string($conn, $_REQUEST["arg2"]);
$cost = mysqli_real_escape_string($conn, $_REQUEST["arg3"]);

// Validate inputs.
$date = getdate();
$current_date = "$date[year]-&date[mon]-$date[mday]";
$set_start = strtotime($start_date);
$set_final = strtotime($finish_date);
if ($set_start < strtotime($current_date)){
	echo '<b>The start date cannot be set to a date prior to todays date.</b><br>';
}elseif ($set_start >= $set_final){
	echo "<b>The final date must later then the start date.</b><br>";
}elseif(!preg_match("/^[0-9]{1,10}?$/", $equipment_id)) {
	echo '<b>Equipment ID must be a valid 10 digit integer.</b><br>';
}elseif(!preg_match("/^[0-9]{1,10}?$/", $cost)){
	echo '<b>Cost must be a valid 10 digit integer.</b><br>';
}else{
	$maint_query_sel = "SELECT start_date, finish_date FROM maintenance WHERE equip_id='$equipment_id'";
	if (mysqli_num_rows($maint_query_response = mysqli_query($conn, $maint_query_sel)) != 0){
		while ($row = mysqli_fetch_array($rental_date_query)){
			$prev_start = strtotime($row['start_date']);
			$prev_final = strtotime($row['final_date']);

			// Check for conflicting maintenance dates.
			if ($set_start <= $prev_final && $set_start >= $prev_start){
				echo '<b>Start date conflicts with another maintenance schedule.</b><br>';
				mysqli_close($conn);
				exit();
			}elseif ($set_final <= $prev_final && $set_final >= $prev_start){
				echo '<b>Final date conflicts with another maintenace schedul.</b><br>';
				mysqli_close($conn);
				exit();
			}
		}
	}

// Bug here **********
	$maint_insert = "INSERT INTO maintenance (start_date,equip_id,finish_date,cost) VALUES ('$start_date','$equipment_id','$finish_date','$cost')";
	if (mysqli_query($conn, $maint_insert)){
		echo '<b>Successfully created new maintenance.</b><br>';
	}else{
		echo '<b>An error occurred when creating new maintenance.</b><br>';
	}
}

mysqli_close($conn);
?>