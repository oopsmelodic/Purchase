<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 18.02.2016
 * Time: 13:25
 */

require_once 'Iom.php';

$iom = new Iom();

if (isset($_GET['method'])){
    $method = $_GET['method'];

    echo json_encode($iom->$method(extract($_POST)));

//    echo '<pre>';
//    print_r($iom->$method(extract($_POST)));
//    echo '</pre>';
}