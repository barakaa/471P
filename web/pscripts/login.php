<?php
session_start();
include_once('db.php');
$luser = mysqli_real_escape_string($conn, $_POST['username']);
$lpass = mysqli_real_escape_string($conn, $_POST['password']);
$sel_table = "client";
if (empty($luser) || empty($lpass)) {
    header("Location: ../index.php?login=empty");
    mysqli_close($conn);
    exit();
}elseif (strlen($luser) < 4 || strlen($lpass) < 4 || strlen($luser) > 30 || strlen($lpass) > 30) {
    header("Location: ../index.php?login=invalid");
    mysqli_close($conn);
    exit();
} else {
    if (!preg_match("/[a-zA-Z0-9]+/", $luser) || !preg_match("/[a-zA-Z0-9]+/", $lpass)) {
        header("Location: ../index.php?login=invalid");
        mysqli_close($conn);
        exit();
    } else {
        $sql = "SELECT * FROM client WHERE username = '$luser'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        if ($numRows < 1) {
            header("Location: ../index.php?login=error");
            mysqli_close($conn);
            exit();
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                $hashedPassCheck = password_verify($lpass, $row['cl_pass']);
                if ($hashedPassCheck == false) {
                    header("Location: ../index.php?login=error");
                    mysqli_close($conn);
                    exit();
                } elseif ($hashedPassCheck == true) {
                    $_SESSION['user'] = $row['username'];
                    // add other variables here
                    $sqlEmp = "SELECT * FROM employee WHERE username = '$luser'";
                    $resultEmp = mysqli_query($conn, $sqlEmp);
                    $numRowsEmp = mysqli_num_rows($resultEmp);
                    $sqlCust = "SELECT * FROM customer WHERE username = '$luser'";
                    $resultCust = mysqli_query($conn, $sqlCust);
                    $numRowsCust = mysqli_num_rows($resultCust);
                    if ($numRowsEmp == 1) {
                        header("Location: ../employee.php");
                        mysqli_close($conn);
                        exit();
                    } elseif ($numRowsCust == 1) {
                        header("Location: ../customer.php");
                        mysqli_close($conn);
                        exit();
                    } else {
                        header("Location: ../index.php?login=errordne");
                        mysqli_close($conn);
                        exit();
                    }
                }
            }
        }
    }
}