<?php
//parse arguments out of header
$price_per_day = $_REQUEST["arg0"];
$weight = $_REQUEST["arg1"];
$status = $_REQUEST["arg2"];
$location = $_REQUEST["arg3"];
$id = $_REQUEST["arg4"];

//Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "471_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully <br>";

$result = "INSERT INTO equipment (equip_id, price_per_day, weight, status, loc_name) 
VALUES ('$id', '$price_per_day', '$weight', '$status', '$location')";

if ($conn->query($result) === TRUE) {
    echo "Record created";
} else {
    echo "Error creating record: " . $result . "<br>" . $conn->error;
}

$conn->close();
/*
$toReturn = "hello world!";

echo $toReturn;*/

echo "<br> <ul> <li> line 1 </li>";
echo "<li>line 2</li> ";
echo "<li>line 3</li></ul>";
?>