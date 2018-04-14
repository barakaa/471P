<?php

include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());

//parse arguments out of header
$price_per_day = mysqli_real_escape_string($conn, $_REQUEST["arg0"]);
$weight = mysqli_real_escape_string($conn, $_REQUEST["arg1"]);
$status = mysqli_real_escape_string($conn, $_REQUEST["arg2"]);
$location = mysqli_real_escape_string($conn, $_REQUEST["arg3"]);


$result = "INSERT INTO equipment (price_per_day, weight, status, loc_name) 
VALUES ('$price_per_day', '$weight', '$status', '$location')";

if ($conn->query($result) === TRUE) {
    //echo "Record created";
} else {
    echo "Error creating record: " . $result . "<br>" . $conn->error;
}

$id = $conn->insert_id;


$type = mysqli_real_escape_string($conn, $_REQUEST["arg4"]);
if ($type == "power"){
    $ftype = mysqli_real_escape_string($conn, $_REQUEST["arg5"]);
    $fecon = mysqli_real_escape_string($conn, $_REQUEST["arg6"]);
    $cargo = mysqli_real_escape_string($conn, $_REQUEST["arg7"]);
    $passenger =  mysqli_real_escape_string($conn, $_REQUEST["arg8"]);

    $command = "INSERT INTO powered (equip_id, fuel_type, fuel_economy, cargo_capacity, occupant_capacity) VALUES ('$id', '$ftype', '$fecon', '$cargo', '$passenger')";

    if ($conn->query($command) === TRUE) {
        echo "Record created";
    } else {
        echo "Error creating record: " . $command . "<br>" . $conn->error;
    }

} else if ($type == "other"){
    $intended = mysqli_real_escape_string($conn, $_REQUEST["arg5"]);
    $insure = mysqli_real_escape_string($conn, $_REQUEST["arg6"]);

    $command = "INSERT INTO unpowered (equip_id, intended_use, insurance_required) VALUES ('$id', '$intended', '$insure')";

    if ($conn->query($command) === TRUE) {
        echo "Record created";
    } else {
        echo "Error creating record: " . $command . "<br>" . $conn->error;
    }
}



$conn->close();
