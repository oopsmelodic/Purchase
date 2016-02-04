<?php


$input = array(1 => Array('name'=>'a','role'=>123), 2=>Array('name'=>'b','role'=>333), 3 => Array('name'=>'c','role'=>222) ,4=>Array('name'=>'a','role'=>345));
$mass = Array();

foreach ($input as $value){
    $mass[$value['name']][] =$value;
}

echo '<pre>';
print_r($mass);
echo '</pre>';