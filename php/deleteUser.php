<?php
include 'conn.php';
if (!empty($_POST)) {
    
    $query = "UPDATE employee SET status=2".
            "' WHERE id=".$_POST['id'].";";

    $res = mysqli_query(GetMyConnection(), $query);

    if (!$res) {
        die("Couldn't delete user: " . mysql_error());
    }
    else echo "success";
}