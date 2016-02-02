<?php
include 'conn.php';

$query="SELECT `username` , `fullname`, `position`, `role`, `department` 
FROM `employee`
ORDER BY `employee`.`department` ASC, `employee`.`role` ASC";

$res = mysqli_query(GetMyConnection(),$query);
$rows = array();
while($row = mysqli_fetch_assoc($res)) {
    $rows[] = $row;
}
echo json_encode($rows);