<?php


session_start();
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());

//parse arguments out of header
$equipid = mysqli_real_escape_string($conn, $_REQUEST["arg0"]);
//username is a superglobal, get and store
$username = $_SESSION['user'];
$start = mysqli_real_escape_string($conn, $_REQUEST["arg1"]);
$finish = mysqli_real_escape_string($conn, $_REQUEST["arg2"]);

$cdate = getdate();
$currentDate = "$cdate[year]-$cdate[mon]-$cdate[mday]";

if (strtotime($start) < strtotime($currentDate)){
    echo "Cannot begin rental prior to todays date";
    mysqli_close($conn);
    exit();
}

if (strtotime($start) >= strtotime($finish)){
    echo "Finish must be after Start";
    mysqli_close($conn);
    exit();
}

//make sure equipid exists
$command = "SELECT * FROM equipment WHERE equip_id = '$equipid'";
$result = $conn->query($command);
if ($result->num_rows == 0){
    echo "Please select an existing equipment ID";
    mysqli_close($conn);
    exit();
}

//Once error checking finished, grab the price per day for this equipment

//if not, calculate price insert into rental table and inform user
$command = "SELECT price_per_day FROM equipment WHERE equip_id = '$equipid'";
$ppd =(double) $conn->query($command)->fetch_assoc()["price_per_day"];
//now holds price per day, calculate the insurance cost and coverage
$numDays = (strtotime($finish) - strtotime($start)) / 86400;
$insurePrice = $ppd*0.05*$numDays;//5% of daily cost times number of days
$insureCoverage = $insurePrice * 100;

$totalPrice = ($ppd * $numDays) + $insurePrice;

//echo result
echo "The total price of this rental is $" . number_format((float)$totalPrice, 2, '.', '');