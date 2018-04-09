<?php
session_start();
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
$username = mysqli_real_escape_string($conn, $_REQUEST["arg0"]);
$query = "SELECT * FROM customer WHERE username='$username'";
$result = mysqli_query($conn, $query);
$numAccounts = mysqli_num_rows($result);
if ($numAccounts == 1) {
    $cdate = getdate();
    $currentDate = "$cdate[year]-$cdate[mon]-$cdate[mday]";
    $insertQuery = "INSERT INTO employee (username,can_train,can_repair,salary,date_hired) VALUES ('$username',0,0,0,'$currentDate')";
    $removeQuery = "DELETE FROM customer WHERE username='$username'";
    if (mysqli_query($conn, $insertQuery)) {
        if (mysqli_query($conn, $removeQuery)) {
            echo "Customer $username is now an employee";
        }
    }
} else {
    echo "Customer not found";
}
mysqli_close($conn);