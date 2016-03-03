<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 18.02.2016
 * Time: 13:25
 */

require_once 'Iom.php';

session_start();

$iom = new Iom();

if (isset($_GET['method'])){
    $method = $_GET['method'];

    if (method_exists($iom,$method)){
        $_POST['user_session_id'] = $_SESSION['user']['id'];
        echo json_encode($iom->$method($_POST));
    }else{
        echo json_encode(Array('error'=>'[ERROR]: Method {'.$method.'} not Found!'));
    }
}