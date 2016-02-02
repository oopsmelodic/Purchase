<?php

include 'conn.php';
$username = $_POST['$username'];
$password = $_POST['pass'];
if (isset($_POST) && $username != '' && $password != '') {
    $query = "SELECT username,password,salt FROM employee WHERE username='".$username."'";
    $res = mysqli_query($query, GetMyConnection());
    while ($row = mysqli_fetch_assoc($res)) {
        $p = $row['password'];
        $p_salt = $row['salt'];
    }
    $site_salt = "subinsblogsalt"; /* Common Salt used for password storing on site. You can't change it. If you want to change it, change it when you register a user. */
    $salted_hash = hash('sha256', $password . $site_salt . $p_salt);
    if ($p == $salted_hash) {
        session_start();
        $_SESSION['user'] = $username;
        echo "Location:tables.php";
    } else {
        echo "incorrect";
    }
} else
   echo "incorrect";