<?php
include 'conn.php';



$query= "SELECT sc.id,em.fullname,sc.status".
        " From sign_chain as sc".
        " Left Join employee as em on em.id=sc.employee_id".
        " Where sc.iom_id=".$_GET['iom_id'];
$res = mysqli_query(GetMyConnection(),$query);

$rows = array();
if (mysqli_num_rows($res)) {
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
}
echo json_encode($rows);