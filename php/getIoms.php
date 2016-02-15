<?php
include 'conn.php';

session_start();

$query= "SELECT im.id, im.employee_id, im.time_stamp, im.name,em.fullname, im.status,im.actualcost,im.substantation ,concat(bt.name,': ',bd.name) as budget_fullname ,".
            " (Select concat(' by ',em.fullname,'|',sc.time_stamp )".
            " From sign_chain as sc".
            " Left Join employee as em on em.id=sc.employee_id".
            " ORDER BY sc.time_stamp".
            " LIMIT 1) as latest_action,".
            "( ".$_SESSION['user']['id']." in (Select employee_id From sign_chain Where status='in progress')) as sign_status".
        " FROM iom as im".
            " Left Join employee as em on im.employee_id=em.id".
            " Left Join budget as bd on im.budget_id=bd.id".
            " Left Join budget_type as bt on bd.type_id=bt.id".
        " Where ".$_SESSION['user']['id']." in (Select employee_id From sign_chain) or im.employee_id=".$_SESSION['user']['id'];

$res = mysqli_query(GetMyConnection(),$query);

$rows = array();
if (mysqli_num_rows($res)) {
    while ($row = mysqli_fetch_assoc($res)) {
        switch ($row['status']){
            case "in progress":
                $row['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$row['status'].'</span>';
                break;
        }
        $time_array = explode('|',$row['latest_action']);
        $row['latest_action']='<h5>'.$time_array[0].' <small>'.time_elapsed_string($time_array[1]).'</small></h5>';
        $rows[] = $row;
    }
}
echo json_encode($rows);




function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}