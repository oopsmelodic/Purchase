<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 01.04.2016
 * Time: 15:42
 */

class Model_Show extends Model {
    public function get_iom_data($user_id, $iom_id) {
        include_once './php/conn.php';
        $query = "SELECT im.id, im.employee_id, im.time_stamp, im.name,em.fullname,im.substantation , dp.name as department,dp.id as department_id, im.status,im.actualcost,im.substantation" .
            " FROM iom as im" .
            " Left Join ( employee as em, departments as dp ) on (im.employee_id=em.id AND em.department_id=dp.id )" .
            " Where " . $user_id . " in (Select employee_id From sign_chain Where iom_id=" . $iom_id . ") or (im.employee_id=" . $user_id . " AND im.id=" . $iom_id . ")" .
            " Limit 1;"; // есть ли пользователь в создании заявки или как участник
        $query_results = mysqli_query(GetMyConnection(), $query);
        if ($query_results) {
            if (mysqli_num_rows($query_results)) {
                $query_results = $query_results->fetch_assoc();
                return $query_results;
            } else {
                return null;
            }
        } else {
            print_r(mysqli_error(GetMyConnection()));
        }
    }
}