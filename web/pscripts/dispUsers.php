<?php

include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());


//select and display all employees

$command = "SELECT username FROM employee";
$result = $conn->query($command);

echo "<table>";
echo "<tr>";
echo "<th> Username </th>";
echo "<th> Account Type </th>";
echo "</tr>";


//display each row
while($tuple = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td>" . $tuple["username"] . "</td>";
    echo "<td> Employee </td>";
    echo "</tr>";
}

$command = "SELECT username FROM customer";
$result = $conn->query($command);

while($tuple = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td>" . $tuple["username"] . "</td>";
    echo "<td> Customer </td>";
    echo "</tr>";
}
$conn->close();



