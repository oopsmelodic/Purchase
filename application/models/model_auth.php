<?php

class Model_Auth extends Model{
    
    public function get_login_data($login,$password){
        
        include_once './php/conn.php';
//        include_once './php/auth_ldap.php';
        $FISH = 'JHENEK';
        if (isset($login)&&isset($password)){
            $query=mysqli_query(GetMyConnection(),"SELECT em.username, em.fullname, em.id, em.position, em.role_id, em.department_id, em.email, em.deleted, rl.power FROM employee as em Left Join roles as rl on rl.id=em.role_id WHERE em.username='".$login."' AND  em.password='".md5($FISH.md5(trim($password)))."' LIMIT 1");
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
}
