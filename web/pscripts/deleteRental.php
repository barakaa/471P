<?php

session_start();
include_once('db.php');
if (!$conn) die('Connection failed: ' . mysqli_connection_error());

// Parse args.
$equip_id = mysqli_real_escape_string($conn, $_REQUEST['arg0']);

// Remove the username portion and fix arg values later.
$username = $_SESSION['user'];
$start_date = mysqli_real_escape_string($conn, $_REQUEST['arg2']);
$final_date = mysqli_real_escape_string($conn, $_REQUEST['arg3']);

if (!preg_match("/^[0-9]{1,7}$/", $equip_id)) {
    echo '<b>Invalid equipment ID format, ID should be a 7 digit number</b><br>';
    mysqli_close($conn);
    exit();
}

$start_fmt = strtotime($start_date);
$final_fmt = strtotime($final_date);

// Check input.
if ($start_fmt >= $final_fmt){
    echo '<b>Finish date should be after the start date.</b><br>';
    mysqli_close($conn);
    exit();
}

// Add check if rental and dates exist.

// Query for the previous rentals.
$equipment_query = "SELECT start_date, return_date FROM rental WHERE equip_id='$equip_id' AND cust_username='$username'";

if (mysqli_num_rows($rental_date_query = mysqli_query($conn, $equipment_query)) != 0){
	$remove_rental = "DELETE FROM rental WHERE equip_id='$equip_id' AND cust_username='$username' AND start_date='$start_date' AND return_date='$final_date'";

	if (mysqli_query($conn, $remove_rental)) {
	    echo '<b>Successfully cancelled rental:</b><br>';
    	echo "<b>Equipment ID: '$equip_id'</b><br>";
	    echo "<b>Start date: '$start_date'</b><br>";
    	echo "<b>Return date: '$final_date'</b><br>";
	}else{
    	echo '<b>There was an error updating the rental.<b><br>';
	}
}else{
    echo '<b>Check your equipment ID is valid.</b><br>';
}

mysqli_close($conn);
?>
