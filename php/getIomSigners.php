<?php
include 'conn.php';



$query= "SELECT sc.id,em.fullname,sc.time_stamp,sc.status".
        " From sign_chain as sc".
        " Left Join employee as em on em.id=sc.employee_id".
        " Where sc.iom_id=".$_GET['iom_id'];

$res = mysqli_query(GetMyConnection(),$query);

$rows = array();
if (mysqli_num_rows($res)) {
    while ($row = mysqli_fetch_assoc($res)) {
        switch ($row['status']){
            case "in progress":
                $row['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$row['status'].'</span>';
                break;
            case "Approved":
                $row['status']='<span class="label label-success"><i class="fa fa-check"></i>&nbsp;'.$row['status'].'</span>';
                break;
            case "Canceled":
                $row['status']='<span class="label label-danger"><i class="fa fa-close"></i>&nbsp;'.$row['status'].'</span>';
                break;
        }
        $rows[] = $row;
    }
}
echo json_encode($rows);