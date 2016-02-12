<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 09.02.2016
 * Time: 17:55
 */

ini_set('display_errors', 1);
include 'conn.php';
if (!empty($_POST)) {
    $chain = json_decode($_POST['sign_chain']);
    $query = "INSERT INTO iom(employee_id, budget_id, name,power,costsize,actualcost,substantation) "
        . "VALUES (" . $_POST["employee_id"] . ","
        . implode('',$_POST["budget_id"]) . ",'"
        . $_POST["purchase_text"]. "',0,0,0,'".$_POST["substantiation_text"]."')";

    $res = mysqli_query(GetMyConnection(),$query);
    $iom_num = mysqli_insert_id(GetMyConnection());
    $query = "INSERT INTO sign_chain(iom_id,employee_id,status) Values ";
    foreach($chain as $key=>$value){
        if (!is_null($value)) {
            foreach ($value as $v) {
                $query .= "(".$iom_num.",".$v.",'in progress'),";
            }
        }
    }

    $res = mysqli_query(GetMyConnection(),$query);

    echo $query;
}