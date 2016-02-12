<?php
include 'conn.php';
if (!empty($_POST)) {
    $pass=$_POST['password'];
    if($pass!=="")
    {
       $FISH = 'JHENEK';
        $password = md5($FISH . md5(trim($pass)));
        $passstring="',password='".$password;
    }
    else $passstring="";
    
    $query = "UPDATE employee SET fullname='".$_POST['fullname'].
            "',position='".$_POST['position'].
            "',role_id=".$_POST['role'].
            ",department_id=".$_POST['department'].
            ",username='".$_POST['username'].
            "',password='".$password.
            "',email='".$_POST['email'].
            "' WHERE id=".$_POST['id'].";";

    $res = mysqli_query(GetMyConnection(), $query);

    if (!$res) {
        die("Couldn't update user: " . mysql_error());
    }
    else echo "success";
}