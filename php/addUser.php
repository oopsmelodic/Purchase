<?php

include 'conn.php';
if (!empty($_POST)) {
    $password = $_POST['password'];

    $p_salt = rand_string(20); /* http://subinsb.com/php-generate-random-string */
    $site_salt = "subinsblogsalt"; /* Common Salt used for password storing on site. */
    $salted_hash = hash('sha256', $password . $site_salt . $p_salt);

    $query = "INSERT INTO `employee`(`fullname`, `position`, `role`, `department`, `deprole`, `username`, `password`,`salt`, `email`)"
            . "VALUES ('" . $_POST["fullname"] . "','"
            . $_POST["position"] . "',"
            . $_POST["role"] . ",'"
            . $_POST["department"] . "','"
            . $_POST["deprole"] . "','"
            . $_POST["username"] . "','"
            . $salted_hash . "','"
            . $p_salt . "','"
            . $_POST["email"] . "')";

    $res = mysql_query($query, GetMyConnection());
    if (!$res) {
        die("Couldn't add user: " . mysql_error());
    }
}

function rand_string($length) {
    $str = "";
    $chars = "subinsblogabcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $size = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[rand(0, $size - 1)];
    }
    return $str; /* http://subinsb.com/php-generate-random-string */
}
