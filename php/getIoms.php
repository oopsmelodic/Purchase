<?php
include 'conn.php';



$query= "SELECT im.id, im.employee_id, im.time_stamp, im.name,em.fullname, im.status,im.actualcost,im.substantation ,concat(bt.name,': ',bd.name) as budget_fullname ,".
    " (Select concat(sc.status,' by ',em.fullname )".
    " From sign_chain as sc".
    " Left Join employee as em on em.id=sc.employee_id".
    " ORDER BY sc.time_stamp".
    " LIMIT 1) as latest_action".
    " FROM iom as im".
    " Left Join employee as em on im.employee_id=em.id".
    " Left Join budget as bd on im.budget_id=bd.id".
    " Left Join budget_type as bt on bd.type_id=bt.id";

$res = mysqli_query(GetMyConnection(),$query);

$rows = array();
if (mysqli_num_rows($res)) {
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
}
echo json_encode($rows);