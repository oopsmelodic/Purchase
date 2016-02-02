<?php
include 'conn.php';

$query="SELECT `username` , `fullname`, `position`, `role`, `department` 
FROM `employee`
ORDER BY `employee`.`department` ASC, `employee`.`role` ASC";

$res = mysql_query($query, GetMyConnection());
$rows = array();
while($row = mysql_fetch_assoc($res)) {
    $rows[] = $row;
}
echo json_encode($rows);