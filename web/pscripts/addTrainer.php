<?php
session_start();
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
$equipId = mysqli_real_escape_string($conn, $_REQUEST['arg0']);
$campId = mysqli_real_escape_string($conn, $_REQUEST['arg1']);
$empName = mysqli_real_escape_string($conn, $_REQUEST['arg2']);
if (strlen($equipId) == 0 || strlen($campId) == 0 || strlen($empName) == 0) {
    echo "Fields can not be empty<br>";
} elseif (preg_match("/[^a-zA-Z0-9]/", $empName) || preg_match("/[^a-zA-Z0-9]/", $campId)) {
    echo "Username and camp must be alphanumeric<br>";
} else {
    $campQ = "SELECT * FROM training_camp WHERE equip_id=$equipId AND camp_id='$campId'";
    $campRes = mysqli_query($conn, $campQ);
    $numCamp = mysqli_num_rows($campRes);
    if ($numCamp < 1) {
        echo "Camp does not exist<br>";
    } else {
        $empQ = "SELECT * FROM employee WHERE username='$empName'";
        $empResult = mysqli_query($conn, $empQ);
        $numEmp = mysqli_num_rows($empResult);
        if ($numEmp < 1) {
            echo "Employee does not exist<br>";
        } else {
            $alreadyTrain = "SELECT * FROM trainer WHERE equip_id=$equipId AND camp_id='$campId' AND emp_username='$empName'";
            $atResult = mysqli_query($conn, $alreadyTrain);
            $atNumRos = mysqli_num_rows($atResult);
            if ($atNumRos > 0) {
                echo "$empName already registered as a trainer for selected camp<br>";
            } else {
                if ($campRow = mysqli_fetch_assoc($campRes)) {
                    if ($empRow = mysqli_fetch_assoc($empResult)) {
                        if ($empRow['can_train'] == 1) {
                            $trainQ = "INSERT INTO trainer (equip_id, camp_id, emp_username) VALUES ($equipId,'$campId','$empName')";
                            if (mysqli_query($conn, $trainQ)) {
                                echo "Added $empName to training camp<br>";
                            }
                        } else {
                            echo "Employee can not train<br>";
                        }
                    } else {
                    echo "Camp not found<br>";
                    }
                } else {
                    echo "Camp not found<br>";
                }
            }
        }
    }
}
mysqli_close($conn);