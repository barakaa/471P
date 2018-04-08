<?php
include_once('db.php');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
$username = mysqli_real_escape_string($conn, $_REQUEST["arg0"]);
$oldPass = mysqli_real_escape_string($conn, $_REQUEST["arg1"]);
$newPass = mysqli_real_escape_string($conn, $_REQUEST["arg2"]);
if (empty($username) || empty($oldPass) || empty($newPass)) {
    echo "fill all fields<br>";
} elseif (preg_match("/[^a-zA-Z0-9]/", $username) || preg_match("/[^a-zA-Z0-9]/", $oldPass) || preg_match("/[^a-zA-Z0-9]/", $newPass)) {
    echo "username and password must be alphanumeric only<br>";
} else {
    $userQ = "SELECT * FROM client WHERE username='$username'";
    $userR = mysqli_query($conn, $userQ);
    $numUserRows = (mysqli_num_rows($userR));
    if ($numUserRows < 1) {
        echo "user does not exist<br>";
    } else {
        if ($row = mysqli_fetch_assoc($userR)) {
            $hashedPassCheck = password_verify($oldPass, $row['cl_pass']);
            if (!$hashedPassCheck) {
                echo "could not change password<br>";
            } else {
                $passhash = password_hash($newPass, PASSWORD_DEFAULT);
                $updateQ = "UPDATE client SET cl_pass='$passhash' WHERE username='$username'";
                if (mysqli_query($conn, $updateQ)) {
                    echo "updated password for user: $username<br>";
                }
            }
        }
    }
}
mysqli_close($conn);