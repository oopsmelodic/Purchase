<?php

class Model_Main extends Model{

    public function get_user_data($id){

        include_once './php/conn.php';
//        include_once './php/auth_ldap.php';
        $FISH = 'JHENEK';
        if (isset($id)){
            $query=mysqli_query(GetMyConnection(),"SELECT em.fullname as fullname, em.id as id, dp.name as department, em.position FROM employee as em Left Join departments as dp on em.department_id=dp.id WHERE em.id='".$id."'");
            if (mysqli_num_rows($query)){
                $row=mysqli_fetch_assoc($query);
                return $row;
            }else{
                //Any auth
            }

        }else{
            return null;
        }
    }


    public function get_roles_data(){

        include_once './php/conn.php';
        $query=mysqli_query(GetMyConnection(),"SELECT em.fullname as fullname, em.id as id, dp.name as department, em.position, em.role_id, rs.name as role_name, rs.power as role_power FROM employee as em".
                                                " Left Join departments as dp on em.department_id=dp.id".
                                                " Left Join roles as rs on em.role_id=rs.id");
        if ($query){
            if (mysqli_num_rows($query)){
                while ($row = mysqli_fetch_assoc($query)) {
                    $rows[] = $row;
                }
                return $rows;
            }else{
                return null;
            }
        }else{
            print_r(mysqli_error(GetMyConnection()));
        }
    }

    public function get_budgets(){

        include_once './php/conn.php';
        $query=mysqli_query(GetMyConnection(),"Select bt.name as budget_name,bt.date_time,bt.planed_cost, btt.name as budget_type_name  From budget as bt Left Join budget_type as btt on bt.type_id=btt.id");
        if ($query){
            if (mysqli_num_rows($query)){
                while ($row = mysqli_fetch_assoc($query)) {
                    $rows[] = $row;
                }
                return $rows;
            }else{
                return null;
            }
        }else{
            print_r(mysqli_error(GetMyConnection()));
        }
    }

}
