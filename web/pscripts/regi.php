<?php
include_once("db.php");
$luser = mysqli_real_escape_string($conn, $_POST['username']);
$ldob = mysqli_real_escape_string($conn, $_POST['dob']);
$lpass = mysqli_real_escape_string($conn, $_POST['password']);

if (empty($luser) || empty($ldob) || empty($lpass)) {
    header("Location ../register.php?reg=empty");
    mysqli_close($conn);
    exit();
} else {
    if (preg_match("/[^a-zA-Z0-9]/", $luser) || preg_match("/[^\-0-9]/", $ldob) || preg_match("/[^a-zA-Z0-9]/", $lpass)) {
        header("Location: ../register.php?reg=invalid");
        mysqli_close($conn);
        exit();
    } else {
        $query = "SELECT * FROM client WHERE username='$luser'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            header("Location: ../register.php?reg=usertaken");
            mysqli_close($conn);
            exit();
        } else {
            $passhash = password_hash($lpass, PASSWORD_DEFAULT);
            $cdate = getdate();
            $currentDate = "$cdate[year]-$cdate[mon]-$cdate[mday]";
            $queryClient = "INSERT INTO client (username, cl_pass, dob) VALUES ('$luser', '$passhash', '$ldob');";
            $queryCustomer = "INSERT INTO customer (username, data_account_created) VALUES ('$luser', '$currentDate')";
            $resultClient = mysqli_query($conn, $queryClient);
            $resultCustomer = mysqli_query($conn, $queryCustomer);
            header("Location: ../index.php?reg=success");
            mysqli_close($conn);
            exit();
        }
    }
}