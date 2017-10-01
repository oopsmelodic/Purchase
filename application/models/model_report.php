<?php

class Model_Report extends Model{

    public function get_departments(){

        include_once './php/conn.php';
        $query=mysqli_query(GetMyConnection(),"Select id, name From departments");
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
