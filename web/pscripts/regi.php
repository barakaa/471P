<?php
require('db.php');
$luser = mysqli_real_escape_string($link, $_POST['username']);
$ldob = mysqli_real_escape_string($link, $_POST['dob']);
$lpass = mysqli_real_escape_string($link, $_POST['password']);

if (empty($luser) || empty($lpass) || empty($ldob)) {
    header("Location register.php?reg=empty");
    mysqli_close($link);
    exit();
} else {
    if (!preg_match("/[a-zA-Z0-9]+/", $luser) || !preg_match("/[a-zA-Z0-9]+/", $lpass)) {
        header("Location: register.php?reg=invalid");
        mysqli_close($link);
        exit();
    } else {
        $query = "SELECT * FROM client WHERE username='$luser'";
        $result = mysqli_query($link, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            header("Location: register.php?reg=usertaken");
            mysqli_close($link);
            exit();
        } else {
            $passhash = password_hash($lpass, PASSWORD_DEFAULT);
            $cdate = getdate();
            $currentDate = "$cdate[year]-$cdate[mon]-$cdate[mday]";
            $queryClient = "INSERT INTO client (username, cl_pass, dob) VALUES ('$luser', '$passhash', '$ldob');";
            $queryCustomer = "INSERT INTO customer (username, data_account_created) VALUES ('$luser', '$currentDate')";
            $resultClient = mysqli_query($link, $queryClient);
            $resultCustomer = mysqli_query($link, $queryCustomer);
            header("Location: index.php?reg=success");
            mysqli_close($link);
            exit();
        }
    }
}
