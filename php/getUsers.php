<?php
include 'conn.php';

$query="SELECT em.fullname as fullname,em.username as username, em.id as id, dp.name as department,rl.name as role, em.position FROM employee as em"
            ." Left Join departments as dp on em.department_id=dp.id"
            ." Left Join roles as rl on em.role_id=rl.id"
        ." ORDER BY em.department_id ASC, em.role_id ASC";

$res = mysqli_query(GetMyConnection(),$query);

$rows = array();
if (mysqli_num_rows($res)) {
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
}
echo json_encode($rows);