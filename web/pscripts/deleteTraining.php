<?php
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
$equipID = mysqli_real_escape_string($conn, $_REQUEST["arg0"]);
$campID = mysqli_real_escape_string($conn, $_REQUEST["arg1"]);
if (strlen($equipID) == 0 || strlen($equipID) == 0) {
    echo "input error";
} else {
    $query = "SELECT * FROM training_camp WHERE equip_id=$equipID AND camp_id='$campID'";
    $result = mysqli_query($conn, $query);
    $numRows = mysqli_num_rows($result);
    if ($numRows < 1) {
        echo "training camp does not exist<br>";
    } else {
        $delQuery = "DELETE FROM training_camp WHERE equip_id=$equipID AND camp_id='$campID'";
        $delResult = mysqli_query($conn, $delQuery);
        if ($delResult) {
            echo "removed training camp<br>";
        }
    }
}
mysqli_close($conn);