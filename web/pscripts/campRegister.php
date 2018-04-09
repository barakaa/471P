<?php
session_start();
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
$username = $_SESSION['user'];
$equipId = $_REQUEST['arg0'];
$campID = $_REQUEST['arg1'];
if (strlen($equipId) == 0 || strlen($campID) == 0) {
    echo "Fill all fields<br>";
} elseif (preg_match("[^0-9]", $equipId)) {
    echo "Equipment ID must be a number<br>";
} elseif (preg_match("[^a-zA-Z0-9]", $campID)) {
    echo "Camp ID must be alphanumeric";
} else {
    $campQ = "SELECT * FROM training_camp WHERE equip_id=$equipId AND camp_id='$campID'";
    $campR = mysqli_query($conn, $campQ);
    $numCamp = mysqli_num_rows($campR);
    if ($numCamp < 1) {
        echo "Camp does not exist<br>";
    } else {
        $checkQuery = "SELECT * FROM participant WHERE equip_id=$equipId AND camp_id='$campID' AND cust_username='$username'";
        if (mysqli_num_rows(mysqli_query($conn, $checkQuery)) > 0) {
            echo "Already registered in this camp<br>";
        } else {
            $insertQueey = "INSERT into participant (equip_id, camp_id, cust_username) VALUES ($equipId,'$campID','$username')";
            if (mysqli_query($conn, $insertQueey)) {
                echo "User: $username joined the camp<br>";
            }
        }
    }
}
mysqli_close($conn);