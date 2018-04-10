<?php

include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());


//select and display all rentals

$command = "SELECT * FROM rental";
$result = $conn->query($command);

echo "<table>";
echo "<tr>";
echo "<th> Equipment ID </th>";
echo "<th> Renter </th>";
echo "<th> Start Date </th>";
echo "<th> Finish Date </th>";
echo "</tr>";

$cdate = getdate();
$currentDate = "$cdate[year]-$cdate[mon]-$cdate[mday]";

//display each row
while($tuple = $result->fetch_assoc()){
    $rentalEndDate = $tuple["return_date"];
    if (strtotime($rentalEndDate) >= strtotime($currentDate)) {
        echo "<tr>";
        echo "<td>" . $tuple["equip_id"] . "</td>";
        echo "<td>" . $tuple["cust_username"] . "</td>";
        echo "<td>" . $tuple["start_date"] . "</td>";
        echo "<td>" . $tuple["return_date"] . "</td>";
        echo "</tr>";
    }
}
$conn->close();


