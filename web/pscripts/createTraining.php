<?php
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
$equipID = mysqli_real_escape_string($conn, $_REQUEST["arg0"]);
$startDate = mysqli_real_escape_string($conn, $_REQUEST["arg1"]);
$finishDate = mysqli_real_escape_string($conn, $_REQUEST["arg2"]);
$campID = mysqli_real_escape_string($conn, $_REQUEST["arg3"]);
if (strlen($equipID) == 0 || empty($startDate) || empty($finishDate) || empty($campID)) {
    echo "input error";
} elseif (preg_match("/[^a-zA-Z0-9]/", $campID)) {
    echo "camp name must be alphanumeric<br>";
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
                echo "Location does not exsits";
            } else {
                $query1 = "SELECT * FROM training_camp WHERE equip_id='$equipID' AND camp_id='$campID'";
                $result1 = mysqli_query($conn, $query1);
                $numRows1 = mysqli_num_rows($result1);
                if ($numRows1 > 0) {
                    echo "camp already exists<br>";
                } else {
                    $insertQuery = "INSERT INTO training_camp (equip_id, camp_id, start_date, end_date) VALUES ('$equipID','$campID','$startDate','$finishDate')";
                    $insertResult = mysqli_query($conn, $insertQuery);
                }
            }
        }
    }
}
mysqli_close($conn);