<?php

include 'conn.php';
if (!empty($_POST)) {
    $pass=$_POST['password'];
    $FISH = 'JHENEK';
    $password = md5($FISH . md5(trim($pass)));
    $query = mysqli_query(GetMyConnection(), "SELECT id FROM roles WHERE name='" . $_POST["role"] . "'"); //
    $row = mysqli_fetch_assoc($query);
    $role_id = $row["id"];
    $query = mysqli_query(GetMyConnection(), "SELECT id FROM departments WHERE name='" . $_POST["department"] . "'"); //
    $row = mysqli_fetch_assoc($query);
    $department_id = $row["id"];
    $query = "INSERT INTO `employee`(`fullname`, `position`, `role_id`, `department_id`, `username`, `password`,`email`)"
            . "VALUES ('" . $_POST["fullname"] . "','"
            . $_POST["position"] . "',"
            . $role_id . ","
            . $department_id . ",'"
            . $_POST["username"] . "','"
            . $password . "','"
            . $_POST["email"] . "')";

    $res = mysqli_query(GetMyConnection(),$query);
    echo "success";
    if (!$res) {
        die("Couldn't add user: " . mysql_error());
    }
}