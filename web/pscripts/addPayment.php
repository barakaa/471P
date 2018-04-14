<?php

session_start();
include_once('db.php');
if (!$conn) die('Connection failed: ' . mysqli_connection_error());

// Parse args
$payment_type = mysqli_real_escape_string($conn, $_REQUEST['arg0']);
$emp_username = $_SESSION['user'];
$cust_username = mysqli_real_escape_string($conn, $_REQUEST['arg2']);
$available_balance = mysqli_real_escape_string($conn, $_REQUEST['arg3']);

if (!preg_match("/^[a-zA-Z]{2,5}?/", $payment_type)){
	echo '<b>Invalid payment type.</b><br>';
	mysqli_close($conn);
	exit();
}elseif (!preg_match("/^[a-zA-Z0-9]{4,30}?/", $cust_username)){
	echo '<b>Invalid customer username format.</b><br>';
	mysqli_close($conn);
	exit();
} elseif (!preg_match("/^[0-9]{1,10}?/", $available_balance)){
	echo '<b>Invalid balance. Balance should be an integer.</b><br>';
	mysqli_close($conn);
	exit();
} else {
	$payment_insert = "INSERT INTO payment_method (payment_type,emp_username,cust_username,available_balance) VALUES ('$payment_type','$emp_username','$cust_username','$available_balance')";
	$payment_responce = mysqli_query($conn, $payment_insert);
	if ($payment_responce){
		echo '<b>Created new payment method successfully.</b><br>';
	}else{
	    $payment_select = "SELECT * FROM payment_method WHERE payment_type='$payment_type' AND emp_username='$emp_username' AND cust_username='$cust_username' AND available_balance='$available_balance'";
	    $payment_response_sel = mysqli_query($conn, $payment_select);
	    if (mysqli_num_rows($payment_response_sel) == 1){
	        echo '<b>The payment method has already been added.</b><br>';
	    }else{
		    echo '<b>There was an error creating payment method. Check values</b><br>';
	    }
	}
}

mysqli_close($conn);
?>
