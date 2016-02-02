<?php

$g_link = false;

function GetMyConnection() {
    global $g_link;
    if ($g_link)
        return $g_link;
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "presail";
    $g_link = mysqli_connect($host, $user, $password) or die('Could not connect to server.');
    mysqli_select_db($g_link,$db) or die('Could not select database.');
    return $g_link;
}

function CleanUpDB() {
    global $g_link;
    if ($g_link != false)
        mysqli_close($g_link);
    $g_link = false;
}

function getUserName($name) {
    $query = "SELECT fullname FROM employee WHERE username='" . $name . "'";
    $res = mysqli_query( GetMyConnection(),$query);
    while ($row = mysqli_fetch_assoc($res)) {
        return $row["fullname"];
    }
}

function getDepartment($name) {
    $query = "SELECT department FROM employee WHERE username='" . $name . "'";
    $res = mysqli_query(GetMyConnection(),$query);
    while ($row = mysqli_fetch_assoc($res)) {
        return $row["department"];
    }
}

function getRoleUsers($roleId) {
//    $roles=array("General director", "Financial director", "Financial controller", "Financial", "Department leader", "Initiator");
    $names ="";
    $query = "SELECT fullname FROM employee WHERE role=" . $roleId . "";
    $res = mysqli_query(GetMyConnection(),$query);
    while ($row = mysqli_fetch_assoc($res)) {
        $names.= "<option>".$row["fullname"]."</option>";
    }
    return $names;
}
?>