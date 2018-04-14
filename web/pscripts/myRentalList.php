<?php
session_start();
include_once('db.php');
if (!$conn) die('Connection failed: ' . mysqli_connect_error());
$username = $_SESSION['user'];

if (empty($username) || !preg_match("/^[a-zA-Z0-9]{4,30}$/", $username)){
	echo '<b>An error has occurred.</b><br>';
}else{
	$rental_list_query = "SELECT * FROM rental WHERE cust_username='$username'";
	if ($rental_list_res = mysqli_query($conn, $rental_list_query)){
	    if ($row = mysqli_fetch_array($rental_list_res)){
		    echo '<table>
		    <tr><td><b>Equipment ID</b></td>
		    <td><b>Username</b></td>
		    <td><b>Start Date</b></td>
		    <td><b>Return Date</b></td>
		    <td><b>Insurance Payment</b></td>
		    <td><b>Insurance Coverage</b></td></tr>';

		    while ($row){ // = mysqli_fetch_array($rental_list_res)){
			    echo '<tr><td>' .
			    $row['equip_id'] . '</td><td>' .
			    $row['cust_username'] . '</td><td>' .
			    $row['start_date'] . '</td><td>' .
			    $row['return_date'] . '</td><td>' .
			    $row['insurance_payment'] . '</td><td>' .
			    $row['insurance_coverage'] . '</td></tr>';
			
			    $row = mysqli_fetch_array($rental_list_res);
		    }
		    
		    echo '</table>';
	    }else{
	        echo '<b>You have no rentals.</b><br>';
	    }
	}else{
		echo '<b>An error has occurred retreiving information.</b><br>';
	}
}
mysqli_close($conn);
?>