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
//retrieve all rentals for this rental
$command = "SELECT start_date, return_date FROM rental WHERE equip_id = '$equipid'";
$result = $conn->query($command);
//check for each existing rental that none overlap
    //check if newStart < existStart and existEnd < newEnd
while($rental = $result->fetch_assoc()){
    //for each rental, retrieve its start and return date and store in variables
    $oldStart = $rental["start_date"];
    $oldEnd = $rental["return_date"];
    //if NOT new start and finish both less than old start or new start and finish both more than old end
    if (!((strtotime($finish) < strtotime($oldStart)) || (strtotime($start) > strtotime($oldEnd)))){
        echo "Equipment is currently booked for this time slot, please try again";
        mysqli_close($conn);
        exit();
    }
}
//if not, calculate price insert into rental table and inform user
$command = "SELECT price_per_day FROM equipment WHERE equip_id = '$equipid'";
$ppd =(double) $conn->query($command)->fetch_assoc()["price_per_day"];
//now holds price per day, calculate the insurance cost and coverage
$numDays = (strtotime($finish) - strtotime($start)) / 86400;
$insurePrice = $ppd*0.05*$numDays;//5% of daily cost times number of days
$insureCoverage = $insurePrice * 100;

//insert into table
$command = "INSERT INTO rental (equip_id, cust_username, start_date, return_date, insurance_payment, insurance_coverage) VALUES ('$equipid', '$username', '$start', '$finish', '$insurePrice', '$insureCoverage')";
if ($conn->query($command) === TRUE) {
    echo "Rental successfully created!";
} else {
    echo "Error placing rental: " . $command . "<br>" . $conn->error;
}




