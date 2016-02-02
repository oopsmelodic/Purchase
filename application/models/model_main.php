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
asdfsd
        }else{
            return null;
        }
    }
}
