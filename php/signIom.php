<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 16.02.2016
 * Time: 12:01
 */

//ini_set('display_errors', 1);
session_start();

include 'conn.php';
if (!empty($_POST)) {
//    $chain = json_decode($_POST['sign_chain']);
    $type='Error';
    if ($_POST['type']=='Confirm'){
        $type='Approved';
    }else{
        $type='Canceled';
    }
    $query = "Update sign_chain Set status='".$type."' Where iom_id=".$_POST['id']." and employee_id=".$_SESSION['user']['id'];

    $res = mysqli_query(GetMyConnection(),$query);
    echo json_encode($query);
}