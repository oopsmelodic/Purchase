<?php

include 'conn.php';
if (!empty($_POST)) {
    $username = $_POST['username'];

    $query = "SELECT username FROM employee WHERE username='" . $username . "';";

    $res = mysqli_query(GetMyConnection(), $query);

    if (!$res) {
        die("Couldn't check user: " . mysql_error());
    }
    if (mysqli_num_rows($res) == 1) {
        echo "exists";
    } else {
        return "nonexists";
    }
}