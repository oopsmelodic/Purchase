<?php

class Model_Profile extends Model{

    public function get_profile_data($id){
        include_once './php/conn.php';
        $query=mysqli_query(GetMyConnection(),"SELECT em.fullname as fullname, em.id as id, em.email as email, dp.name as department, em.position as position, rs.name as role_name FROM employee as em".
            " Left Join departments as dp on em.department_id=dp.id".
            " Left Join roles as rs on em.role_id=rs.id".
            " Where em.id = ".$id.";");
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
    
     public function get_profile_statistics($id){
        include_once './php/conn.php';
        $query=mysqli_query(GetMyConnection(),"SELECT em.fullname as fullname, em.id as id, em.email as email, dp.name as department, em.position as position, rs.name as role_name FROM employee as em".
            " Left Join departments as dp on em.department_id=dp.id".
            " Left Join roles as rs on em.role_id=rs.id".
            " Where em.id = ".$id.";");
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
    public function get_employee_settings($employee_id) {
        include_once './php/conn.php';
        $query = mysqli_query(GetMyConnection(), "SELECT `id`, `name`, `value` FROM `settings` WHERE `employee_id`=" . $employee_id . ";");
        if ($query) {
            if (mysqli_num_rows($query)) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $data[$row['name']] = $row['value'];
                    
                }

                return $data;
            } else {
                //Any auth
            }
        } else {
            print_r(mysqli_error(GetMyConnection()));
        }
    }
}
