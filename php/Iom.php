<?php

/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 17.02.2016
 * Time: 16:07
 */
include 'conn.php';

class Iom
{

    var $FISH = 'JENEK';

    public function getAllIoms($params){

        $user_id = $params['user_session_id'];
        $query= "SELECT im.id, im.employee_id, im.time_stamp, im.name,em.fullname, im.status,im.actualcost,im.substantation,".
            " (Select concat(' by ',em.fullname,'|',sc.time_stamp )".
            " From sign_chain as sc".
            " Left Join employee as em on em.id=sc.employee_id".
            " Where sc.iom_id=im.id".
            " ORDER BY sc.time_stamp DESC".
            " LIMIT 1) as latest_action,".
            "( ".$user_id." in (Select employee_id From sign_chain Where status='in progress' and iom_id=im.id)) as sign_status,".
            "( Select sc.status From sign_chain as sc Where sc.employee_id=".$user_id." and iom_id=im.id) as user_last_status".
            " FROM iom as im".
            " Left Join employee as em on im.employee_id=em.id".
            " Where ".$user_id." in (Select employee_id From sign_chain Where iom_id=im.id) or im.employee_id=".$user_id;
        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            switch ($value['status']){
                case "in progress":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "Approved":
                    $query_results[$key]['status']='<span class="label label-success"><i class="fa fa-check"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "Canceled":
                    $query_results[$key]['status']='<span class="label label-danger"><i class="fa fa-close"></i>&nbsp;'.$value['status'].'</span>';
                    break;
            }
            $time_array = explode('|',$value['latest_action']);
            $query_results[$key]['latest_action']='<h5>'.$time_array[0].' <small>'.$this->time_elapsed_string($time_array[1]).'</small></h5>';
        }

        return $query_results;
    }

    public function getIomSigners($params){
        $query= "SELECT sc.id,em.fullname,sc.time_stamp,sc.status".
            " From sign_chain as sc".
            " Left Join employee as em on em.id=sc.employee_id".
            " Where sc.iom_id=".$params['iom_id'];

        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            switch ($value['status']){
                case "in progress":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "Approved":
                    $query_results[$key]['status']='<span class="label label-success"><i class="fa fa-check"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "Canceled":
                    $query_results[$key]['status']='<span class="label label-danger"><i class="fa fa-close"></i>&nbsp;'.$value['status'].'</span>';
                    break;
            }
            $time_array = explode('|',$value['latest_action']);
            $query_results[$key]['latest_action']='<h5>'.$time_array[0].' <small>'.$this->time_elapsed_string($time_array[1]).'</small></h5>';
        }

        return $query_results;
    }

    public function getIomBudgets($params){
        $query= " Select concat(bt.name,' ',b.name) as budget_name, ib.cost as cur_cost  From iom_budgets as ib".
                " Left Join budget as b on ib.budget_id=b.id".
                " Left Join budget_type as bt on b.type_id=bt.id".
                " Where ib.iom_id=".$params['iom_id'];

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function getIomFiles($params){
        $query= " Select fs.filename, fs.filepath  From files as fs".
            " Where fs.iom_id=".$params['iom_id'];

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function getUsers(){
        $query="SELECT em.username, em.fullname as fullname,em.email, em.id as id, dp.name as department,rl.name as role, em.position FROM employee as em".
            " Left Join departments as dp on em.department_id=dp.id".
            " Left Join roles as rl on em.role_id=rl.id Where em.status=1";

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function getDepRoles(){
        $query = "Select id,name,power From roles";
        $query2 = "Select id,name,sub From departments";
        $query_results['roles'] = $this->make_string_select($this->sendQuery($query));
        $query_results['departments'] = $this->make_string_select($this->sendQuery($query2));
        return ($query_results);
    }

    public function addUser($insert_arr){
        $query = "INSERT INTO `employee`(`fullname`, `position`, `role_id`, `department_id`, `username`, `password`,`email`)"
            . "VALUES ('" . $insert_arr["fullname"] . "','"
            . $insert_arr["position"] . "',"
            . $insert_arr["role"] . ","
            . $insert_arr["department"] . ",'"
            . $insert_arr["username"] . "','"
            . md5($this->FISH . md5(trim($insert_arr))) . "','"
            . $insert_arr["email"] . "')";

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function checkUser($params){
        $query = "SELECT username FROM employee WHERE username='" . $params['username'] . "'";

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function deleteUser($params){
        $query = "UPDATE employee SET status=2".
            " WHERE id=".$params['user_id'];

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function updateUser($params){
        $passstring = "";
        if($params['password']!==""){
            $password = md5($this->FISH . md5(trim($params['password'])));
            $passstring="',password='".$password;
        }else $passstring="";

        $query = "UPDATE employee SET fullname='".$params['fullname'].
            "',position='".$params['position'].
            "',role_id=".$params['role'].
            ",department_id=".$params['department'].
            ",username='".$params['username'].
            $passstring.
            "',email='".$params['email'].
            "' WHERE id=".$params['id'].";";

        $res = mysqli_query(GetMyConnection(), $query);

        if (!$res) {
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else return "success";
    }

    public function addIomReq($params){
        $chain = json_decode($params['sign_chain']);
        $budgets = json_decode($params['budgets'],true);
        $query = "INSERT INTO iom(employee_id,name,power,costsize,actualcost,substantation) "
            . "VALUES (" . $params["employee_id"] . ",'"
            . $params["purchase_text"]. "',0,0,0,'".$params["substantiation_text"]."')";
        $result = $this->sendQuery($query);
//echo $query;
        $iom_num = mysqli_insert_id(GetMyConnection());
        $query = "INSERT INTO sign_chain(iom_id,employee_id,status) Values ";
        foreach($chain as $key=>$value){
            if (!is_null($value)) {
                foreach ($value as $v) {
                    $query .= "(".$iom_num.",".$v.",'in progress'),";
                }
            }
        }

        $res = $this->sendQuery(trim($query,','));

        $query = "INSERT INTO iom_budgets(iom_id,budget_id,cost) Values ";
        foreach($budgets as $key=>$value){
                    $query .= "(".$iom_num.",".$value['id'].",".$value['value']."),";
        }
//        echo $query;
        $res = $this->sendQuery(trim($query,','));

        if ($result){
            return Array('type'=>'success','id'=>$iom_num,'query'=>$query);
        }else{
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }


    }

    public function signIom($params){
        $type='Error';
        if ($params['type']=='Confirm'){
            $type='Approved';
        }else{
            $type='Canceled';
        }

        if ($this->checkSignIom($params['id'],$params['user_session_id'])) {
            $query = "Update sign_chain Set status='" . $type . "' Where iom_id=" . $params['id'] . " and employee_id=" . $params['user_session_id'];

            $res = mysqli_query(GetMyConnection(), $query);

            if ($res) {
                $this->checkIom($params['id']);
                return Array('type' => 'success', 'id' => $params['id']);
            } else {
                return Array('type' => 'error', 'error_msg' => mysqli_error(GetMyConnection()));
            }
        }else{
            return Array('type' => 'error', 'error_msg' => "Before you have the chain signatory.");
        }
    }

    public function appendFileToIom($iom_id,$filename,$file_path){

        $query = "Insert Into files (iom_id,filename,filepath) Values(".$iom_id.",'".$filename."','".$file_path."')";

//        echo $query;
        $this->sendQuery($query);

    }

    function checkIom($iom_id){
        $query = "Select im.id,im.name,count(sc.id) as need_count, ".
                  "(Select count(id) From sign_chain Where status='Approved' and iom_id=im.id) as app_count, ".
                  "(Select count(id) From sign_chain Where status='Canceled' and iom_id=im.id) as cancel_count ".
                "From iom as im ".
                  "Left Join sign_chain as sc on im.id=sc.iom_id ".
                "Where im.id=".$iom_id.
                " GROUP BY im.id";

        $results = $this->sendQuery($query);
        if (is_array($results)){
            foreach ($results as $value) {
                if (intval($value['cancel_count']) > 0) {
                    $this->updateIomStatus("Canceled", $iom_id);
                } else if (intval($value['app_count']) == intval($value['need_count'])) {
                    $this->updateIomStatus("Approved", $iom_id);
                }
            }
        }
    }

    function checkSignIom($iom_id,$user_id){
        $query = "Select id,employee_id,status From sign_chain Where iom_id=".$iom_id." ORDER BY id DESC";

        $results = $this->sendQuery($query);

        for ($i=0;i<=count($results);$i++){
            if ($results[$i]['employee_id']==$user_id){
                if ($i+1==count($results)){
                    return true;
                }else if($results[$i+1]['status']=='Approved'){
                    return true;
                }else{
                    return false;
                }
            }
        }

    }

    function updateIomStatus($status,$iom_id){
        $query = "Update iom Set status='".$status."' Where id=".$iom_id;

        $results = $this->sendQuery($query);
//        echo $query;
//        return $results;
    }


    function sendQuery($query){
        $result = mysqli_query(GetMyConnection(),$query);
        $rows = array();
        if (!is_bool($result)) {
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $rows[] = $row;
                }
                mysqli_free_result($result);
                return $rows;
            } else {
                return mysqli_error(GetMyConnection());
            }
        }else {
            return true;
        }
    }


    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    function make_string_select($arr){
        $str = '';
        foreach($arr as $key =>$value){
            $str.='<option data-content="' . $value["name"] . '">' . $value["id"] . '</option>';
        }
        return $str;
    }

}