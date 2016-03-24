<?php

class Model_Iom extends Model {

    public function get_iom_data($user_id, $iom_id) {
        include_once './php/conn.php';

        $query = "SELECT im.id, im.employee_id, im.time_stamp, im.name,em.fullname , dp.name as department,dp.id as department_id, im.status,im.actualcost,im.substantation," .
                "( " . $user_id . " in (Select employee_id From sign_chain Where status='in progress' and iom_id=" . $iom_id . ")) as sign_status," . // Активна ли для пользователя заявка
                "( Select sc.status From sign_chain as sc Where sc.employee_id=" . $user_id . " and iom_id=im.id) as user_last_status" . // Что сделал текущий пользователь?
                " FROM iom as im" .
                " Left Join employee as em on im.employee_id=em.id" .
                " Left Join department as dp on em.department_id=dp.id" . //тащим название отдела  
                " Where " . $user_id . " in (Select employee_id From sign_chain Where iom_id=" . $iom_id . ") or im.employee_id=" . $user_id .
                " Limit 1;"; // есть ли пользователь в создании заявки или как участник
        $query_results = $this->sendQuery($query);
        $query_results = $query_results[0];
        switch ($query_results['status']) {
            case "in progress":
                $query_results['status'] = '<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;' . $query_results['status'] . '</span>';
                break;
            case "Approved":
                $query_results['status'] = '<span class="label label-success"><i class="fa fa-check"></i>&nbsp;' . $query_results['status'] . '</span>';
                break;
            case "Canceled":
                $query_results['status'] = '<span class="label label-danger"><i class="fa fa-close"></i>&nbsp;' . $query_results['status'] . '</span>';
                break;
        }
        return $query_results;
    }
}