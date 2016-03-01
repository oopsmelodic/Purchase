<?php


require_once 'conn.php';

echo sendQuery('Update sign_chain Set iom_id=7 Where iom_id=7');

print_r(sendQuery('Select * From sign_chain  Where iom_id=7'));
$query= "SELECT sc.id,em.fullname,sc.time_stamp,sc.status".
    " From sign_chain as sc".
    " Left Join employee as em on em.id=sc.employee_id".
    " Where sc.iom_id=7";
$query_results =  sendQuery($query);

foreach($query_results as $key => $value){
    switch ($value['status']){
        case "in progress":
            $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
            break;
        case "Approved":
            $query_results[$key]['status']='<span class="label label-success"><i class="fa fa-check"></i>&nbsp;'.$value['status'].'</span>';
            break;
        case "Canceled":
            $query_results[$key]['status']='<span class="label label-danger"><i class="fa fa-close"></i>&nbsp;'.$value['status'].'</span>';
            break;
    }
//    $time_array = explode('|',$value['latest_action']);
//    $query_results[$key]['latest_action']='<h5>'.$time_array[0].' <small>'.$this->time_elapsed_string($time_array[1]).'</small></h5>';
}

//print_r($query_results);

function sendQuery($query){
    $result = mysqli_query(GetMyConnection(),$query);

    $rows = array();
    if (!is_bool($result)) {
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            mysqli_free_result($result);
            return $rows;
        } else {
//            mysqli_free_result($result);
            return mysqli_error(GetMyConnection());
        }
    }else {
//        mysqli_free_result($result);
//        return mysqli_error(GetMyConnection());
        return $result;
    }
}