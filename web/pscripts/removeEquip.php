<?php
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());

//parse arguments out of header
$equipID = mysqli_real_escape_string($conn, $_REQUEST["arg0"]);

$sql = "DELETE FROM equipment WHERE equip_id = '$equipID'";

if ($conn->query($sql) === TRUE){
    echo "Equipment deleted";
} else {
    echo "Error deleting record: " . $conn->error;
}
$conn->close();
?>