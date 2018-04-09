<?php
session_start();
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
$equipID = mysqli_real_escape_string($conn, $_REQUEST["arg0"]);
$startDate = mysqli_real_escape_string($conn, $_REQUEST["arg1"]);
$finishDate = mysqli_real_escape_string($conn, $_REQUEST["arg2"]);
$campID = mysqli_real_escape_string($conn, $_REQUEST["arg3"]);
if (strlen($equipID) == 0 || empty($startDate) || empty($finishDate) || empty($campID)) {
    echo "Fill all fields";
} elseif (preg_match("/[^a-zA-Z0-9]/", $campID)) {
    echo "Camp name must be alphanumeric<br>";
} elseif (preg_match("/[^0-9]/", $equipID)) {
    echo "Equipment ID must be a number<br>";
} else {
    if (strtotime($finishDate) < strtotime($startDate)) {
        echo "Finish date must be after start date<br>";
    } else {
        $query0 = "SELECT * FROM equipment WHERE equip_id=$equipID";
        $result0 = mysqli_query($conn, $query0);
        $numRows0 = mysqli_num_rows($result0);
        mysqli_free_result($result0);
        if ($numRows0 < 1) {
            echo "Equipment does not exist<br>";
        } else {
            $locQuery = "SELECT * FROM location WHERE name='$campID'";
            $locResult = mysqli_query($conn, $locQuery);
            $numLoc = mysqli_num_rows($locResult);
            if ($numLoc < 1) {
                echo "Location does not exist<br>";
            } else {
                $query1 = "SELECT * FROM training_camp WHERE equip_id='$equipID' AND camp_id='$campID'";
                $result1 = mysqli_query($conn, $query1);
                $numRows1 = mysqli_num_rows($result1);
                if ($numRows1 < 0) {
                    echo "Camp does not exists<br>";
                } else {
                    $updateQuery = "UPDATE training_camp SET start_date='$startDate', end_date='$finishDate' WHERE equip_id=$equipID AND camp_id='$campID'";
                    if (mysqli_query($conn, $updateQuery)) {
                        echo "Updated camp<br>";
                    }
                }
            }
        }
    }
}
mysqli_close($conn);