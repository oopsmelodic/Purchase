<?php

class Model_Admin extends Model {

    public function get_users_privilege() {

        include_once './php/conn.php';
//        include_once './php/auth_ldap.php';
        $FISH = 'JHENEK';
        if (isset($login) && isset($password)) {
            $query = mysqli_query(GetMyConnection(), "SELECT * FROM employee WHERE username='" . $login . "' AND  password='" . md5($FISH . md5(trim($password))) . "' LIMIT 1");
            if (mysqli_num_rows($query)) {
                $row = mysqli_fetch_assoc($query);
                return $row;
            } else {
                //Any auth
            }
        } else {
            return null;
        }
    }

    public function get_departments() {
        include_once './php/conn.php';
//        include_once './php/auth_ldap.php';

        $query = mysqli_query(GetMyConnection(), "SELECT `id`, `name` FROM `departments`");
        if (mysqli_num_rows($query)) {
            $options = "";
            while ($row = mysqli_fetch_assoc($query)) {
                $options.="<option>" . $row["name"] . "</option>";
            }
            return $options;
        } else {
            //Any auth
        }
    }

}
