<?php

include 'conn.php';
if (!empty($_POST)) {
    $pass=$_POST['password'];
    $FISH = 'JHENEK';
    $password = md5($FISH . md5(trim($pass)));
    $query = "INSERT INTO `employee`(`fullname`, `position`, `role_id`, `department_id`, `username`, `password`,`email`)"
            . "VALUES ('" . $_POST["fullname"] . "','"
            . $_POST["position"] . "',"
            . $_POST["role"] . ","
            . $_POST["department"] . ",'"
            . $_POST["username"] . "','"
            . $password . "','"
            . $_POST["email"] . "')";

    $res = mysqli_query(GetMyConnection(),$query);
    echo "success";
    if (!$res) {
        die("Couldn't add user: " . mysql_error());
    }
}