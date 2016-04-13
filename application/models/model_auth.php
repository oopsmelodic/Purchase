<?php

class Model_Auth extends Model{
    
    public function get_login_data($login,$password){
        
        include_once './php/conn.php';
//        include_once './php/auth_ldap.php';
        $FISH = 'JHENEK';
        if (isset($login)&&isset($password)){
            $query=mysqli_query(GetMyConnection(),"SELECT * FROM employee WHERE username='".$login."' AND  password='".md5($FISH.md5(trim($password)))."' LIMIT 1");
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
    public function get_employee_settings($employee_id) {
        include_once '/conn.php';
        $query = mysqli_query(GetMyConnection(), "SELECT settings FROM employee WHERE id=" . $employee_id . ";");
        if ($query) {
            if (mysqli_num_rows($query)) {
                $row = mysqli_fetch_assoc($query);
                $settings = $row['settings'];
                $arr = explode(',', $settings);
                $query = mysqli_query(GetMyConnection(), "SELECT id, name FROM settings;");
                if (mysqli_num_rows($query)) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        if (in_array($row['id'], $arr)) {
                            $settings_data[$row['name']] = true;
                        } else
                            $settings_data[$row['name']] = false;
                    }
                    return $settings_data;
                }
            } else {

            }
        } else {
            print_r(mysqli_error(GetMyConnection()));
        }
    }
}
