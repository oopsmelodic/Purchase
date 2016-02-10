<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 09.02.2016
 * Time: 17:55
 */

include 'conn.php';
if (!empty($_POST)) {
    $query = "INSERT INTO iom(employee_id, budget_id, name,power,costsize,actualcost,substantation) "
        . "VALUES (" . $_POST["employee_id"] . ","
        . implode('',$_POST["budget_id"]) . ",'"
        . $_POST["purchase_text"]. "',0,0,0,'Some Text')";

    $res = mysqli_query(GetMyConnection(),$query);
    echo $query;
}