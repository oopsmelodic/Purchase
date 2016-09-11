<?php

class Model_Purchase extends Model{

    public function get_user_data($id){

        include_once './php/conn.php';
//        include_once './php/auth_ldap.php';
        $FISH = 'JHENEK';
        if (isset($id)){
            $query=mysqli_query(GetMyConnection(),"SELECT em.fullname as fullname, em.id as user_id, dp.name as department, dp.id as department_id , em.position FROM employee as em Left Join departments as dp on em.department_id=dp.id WHERE em.id='".$id."'");
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
        $query=mysqli_query(GetMyConnection(),"SELECT em.fullname as fullname, em.id as id, dp.name as department, dp.id as department_id , em.position, em.role_id, rs.name as role_name, rs.power as role_power FROM employee as em".
                                                " Left Join departments as dp on em.department_id=dp.id".
                                                " Left Join roles as rs on em.role_id=rs.id Where em.deleted!=1");
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


    public function get_mapping(){

        include_once './php/conn.php';
        $query=mysqli_query(GetMyConnection(),"Select id, name From budget_mapping");
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

    public function get_brand(){

        include_once './php/conn.php';
        $query=mysqli_query(GetMyConnection(),"Select id, name From budget_brand");
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
