<?php
session_start();
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());


//select and display all maintenance
$command = "SELECT * FROM maintenance";
$result = $conn->query($command);

echo "<table>";
echo "<tr>";
echo "<th> Equipment ID </th>";
echo "<th> Cost </th>";
echo "<th> Start Date </th>";
echo "<th> Finish Date </th>";
echo "</tr>";

$cdate = getdate();
$currentDate = "$cdate[year]-$cdate[mon]-$cdate[mday]";

//display each row
while($tuple = $result->fetch_assoc()){
    $maintEndDate = $tuple["finish_date"];
    if (strtotime($maintEndDate) >= strtotime($currentDate)) {
        echo "<tr>";
        echo "<td>" . $tuple["equip_id"] . "</td>";
        echo "<td>" . $tuple["cost"] . "</td>";
        echo "<td>" . $tuple["start_date"] . "</td>";
        echo "<td>" . $tuple["finish_date"] . "</td>";
        echo "</tr>";
    }
}
echo "</table>";
$conn->close();
