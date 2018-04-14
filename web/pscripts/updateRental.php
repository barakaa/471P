<?php

session_start();
include_once('db.php');
if (!$conn) die('Connection failed: ' . mysqli_connection_error());

// Parse args.
$equip_id = mysqli_real_escape_string($conn, $_REQUEST['arg0']);

// Remove the username portion and fix arg values later.
$username = $_SESSION['user'];
$start_date = mysqli_real_escape_string($conn, $_REQUEST['arg1']);
$final_date = mysqli_real_escape_string($conn, $_REQUEST['arg2']);

$date = getdate();
$current_date = "$date[year]-$date[mon]-$date[mday]";

$user_query = "SELECT username FROM customer WHERE username='$username'";
if (mysqli_num_rows($user_response = mysqli_query($conn, $user_query)) != 1) {
    $username = mysqli_real_escape_string($conn, $_REQUEST['arg3']);
}

if (!preg_match("/^[0-9]{1,7}$/", $equip_id)) {
	echo '<b>Invalid equipment ID format, ID should be a 7 digit number</b><br>';
	mysqli_close($conn);
	exit();
}

$current_fmt = strtotime($current_date);
$start_fmt = strtotime($start_date);
$final_fmt = strtotime($final_date);

// Might need to check if final date is before current date.
// May not be needed since there is a check for start date <= final date.
if ($start_fmt < $current_fmt){
	echo '<b>Cannot set rental start date prior to todays date.</b><br>';
	mysqli_close($conn);
	exit();
}elseif ($start_fmt >= $final_fmt){
	echo '<b>Finish date should be after the start date.</b><br>';
	mysqli_close($conn);
	exit();
}

// Query for the previous rentals.
$equipment_query = "SELECT start_date, return_date FROM rental WHERE equip_id='$equip_id' AND cust_username<>'$username'";

if (mysqli_num_rows($rental_date_query = mysqli_query($conn, $equipment_query)) != 0){
	while ($row = mysqli_fetch_array($rental_date_query)){
		$prev_srt_fmt = strtotime($row['start_date']);
		$prev_fnl_fmt = strtotime($row['return_date']);

		// Check for conflicting rental dates.
		if ($start_fmt <= $prev_fnl_fmt && $start_fmt >= $prev_srt_fmt){
			echo '<b>Start date conflicts with another renter.</b><br>';
			mysqli_close($conn);
			exit();
		}elseif ($final_fmt <= $prev_fnl_fmt && $final_fmt >= $prev_srt_fmt){
			echo '<b>Final date conflicts with another renter.</b><br>';
			mysqli_close($conn);
			exit();
		}
	}
}else{
	echo '<b>Check your equipment ID is valid.</b><br>';
	mysqli_close($conn);
	exit();
}

$update_query = "UPDATE rental SET start_date='$start_date', return_date='$final_date'
	WHERE cust_username='$username' AND equip_id='$equip_id'";
if (mysqli_query($conn, $update_query)){
    echo '<b>Successfully updated rental:</b><br>';
    echo "<b>Equipment ID: '$equip_id'</b><br>";
    echo "<b>Start date: '$start_date'</b><br>";
    echo "<b>Return date: '$final_date'</b><br>";
}else{
    echo '<b>There was an error updating the rental.<b><br>';
}


mysqli_close($conn);
?>
