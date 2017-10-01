<?php

include "conn.php";


$date = new DateTime();
$fyStart = '-04-01';
$fyEnd = '-03-30';
echo $date->format('Y').$fyStart.' '.($date->format('Y')+1).$fyEnd;

//$query_results = sendQuery('Select id,planed_cost,budget_date,date_time From budget');
//
//$new = 'Insert Into budget_sum (budget_id,cost,date_time) VALUES ';
//
//foreach($query_results as $res){
//    if ($res['budget_date']=='') {
//        $new .= '(' . $res['id'] . ',' . $res['planed_cost'] . ',"' . $res['date_time'] . '"), ';
//    }else{
//        $new .= '(' . $res['id'] . ',' . $res['planed_cost'] . ',"' . $res['budget_date'] . '"), ';
//    }
//}
//
//$new = trim($new,', ');
//
//echo $new;
//
////SEND QUERY
//
////sendQuery($new);
//
//echo '<pre>';
//print_r($query_results);
//echo '</pre>';
//
//
//function sendQuery($query){
//    $result = mysqli_query(GetMyConnection(),$query);
//    $rows = array();
//    if (!is_bool($result)) {
//        if (mysqli_num_rows($result)) {
//            while ($row = mysqli_fetch_assoc($result)) {
//                $rows[] = $row;
//            }
//            mysqli_free_result($result);
//            return $rows;
//        } else {
//            return mysqli_error(GetMyConnection());
//        }
//    }else {
//        return true;
//    }
//}

//$password = '123';
//
//$fish = 'JHENEK';
//
//echo md5($fish.md5(trim($password)));