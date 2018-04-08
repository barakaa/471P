<?php
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
$equipId = mysqli_real_escape_string($conn, $_REQUEST['arg0']);
$campId = mysqli_real_escape_string($conn, $_REQUEST['arg1']);
$empName = mysqli_real_escape_string($conn, $_REQUEST['arg2']);
echo "$equipId $campId $empName<br>";
if (strlen($equipId) == 0 || strlen($campId) == 0 || strlen($empName) == 0) {
    echo "fields can not be empty<br>";
} elseif (preg_match("/[^a-zA-Z0-9]/", $empName) || preg_match("", $campId)) {
    echo "username must be alphanumeric<br>";
} else {
    $campQ = "SELECT * FROM training_camp WHERE equip_id=$equipId AND camp_id='$campId'";
    $campRes = mysqli_query($conn, $campQ);
    $numCamp = mysqli_num_rows($campRes);
    if ($numCamp < 1) {
        echo "camp does not exist<br>";
    } else {
        $empQ = "SELECT * FROM employee WHERE username='$empName'";
        $empResult = mysqli_query($conn, $empQ);
        $numEmp = mysqli_num_rows($empResult);
        if ($numEmp < 1) {
            echo "employee does not exist<br>";
        } else {
            $alreadyTrain = "SELECT * FROM trainer WHERE equip_id=$equipId AND camp_id='$campId' AND emp_username='$empName'";
            $atResult = mysqli_query($conn, $alreadyTrain);
            $atNumRos = mysqli_num_rows($atResult);
            if ($atNumRos < 1) {
                echo "$empName is not training at this camp";
            } else {
                $removeQuery = "DELETE FROM trainer WHERE equip_id=$equipId AND camp_id='$campId' AND emp_username='$empName'";
                if (mysqli_query($conn,$removeQuery)) {
                    echo "remove $empName from the training camp<br>";
                }
            }
        }
    }
}
mysqli_close($conn);