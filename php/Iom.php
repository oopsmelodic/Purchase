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

    var $FISH = 'JHENEK';

//MAIL_SETTINGS

    var $mail_host = 'mail.nic.ru';
    var $mail_username = 'postmaster@oopsmelodic.ru';
    var $mail_pwd = 'qwe12345678';



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
//            $time_array = explode('|',$value['latest_action']);
//            $query_results[$key]['latest_action']='<h5>'.$time_array[0].' <small>'.$this->time_elapsed_string($time_array[1]).'</small></h5>';
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
        $query= " Select fs.filename,fs.title,fs.type, fs.filepath  From files as fs".
            " Where fs.iom_id=".$params['iom_id'];

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function getUsers(){
        $query="SELECT em.username, em.fullname as fullname,em.email, em.id as id, dp.name as department,rl.name as role, em.position, dp.id as depid, rl.id as roleid FROM employee as em".
            " Left Join departments as dp on em.department_id=dp.id".
            " Left Join roles as rl on em.role_id=rl.id Where em.deleted=0";

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    function sendMessage($msg,$title,$user_id,$delay){

        $query = "Insert Into messages (msg,title,employee_id,delay) Values('".$msg."','".$title."',".$user_id.",".$delay.")";

        return $this->sendQuery($query);

    }

    function sendToSigners($iom_id,$type,$user_name){

        $query = "Select em.fullname,sc.employee_id,em.email From sign_chain as sc" .
            " Left Join employee as em on sc.employee_id=em.id" .
            " Where sc.iom_id=".$iom_id;

        $res = $this->sendQuery($query);

        if ($res){
            foreach ($res as $value){
                $this->sendMessage('Application #'.$iom_id.' has been '.$type.' by user '.$user_name,$type,$value['employee_id'],5000);
                $this->sendMail($value['email'],$type.' application #'.$iom_id,'Application #'.$iom_id.' has been '.$type.' by user '.$user_name.' <p><a href="'.$_SERVER['HTTP_HOST'].'/show/'.$iom_id.'">Go to Application</a></p>');
            }
        }

    }

    public function getComments($params){
        $query = "Select id,text,time_stamp From comments Where iom_id=".$params['iom_id'];

        $results = $this->sendQuery($query);
        return $results;
    }

    public function newComment($params){
        $query = "Insert Into comments (employee_id,iom_id,text) Values(".$params['user_session_id'].",".$params['iom_id'].",'".$params['text']."')";

        $results = $this->sendQuery($query);

        return $query;
    }

    public function getMessages($params){

        $query = "Select id,msg,title,delay From messages Where noty_status=0 and employee_id=".$params['user_session_id'];

        $query_results= $this->sendQuery($query);

        if ($query_results!=null){
            foreach ($query_results as $value){
                $this->sendQuery("Update messages Set noty_status=1 Where id=".$value['id']);
            }
        }

        return $query_results;
    }

    public function getLastMessages($params){
        $query = "Select id,msg,title,delay,time_stamp From messages Where employee_id=".$params['user_session_id']." Order By id DESC LIMIT 5";

        $results_query = $this->sendQuery($query);

        $out_mass = '';

        if ($results_query){
            if (count($results_query)>0){
                foreach ($results_query as $value){
                    $out_mass.= '<div class="user-alert"><span class="label label-primary">'.$value['title'].'</span> '.$value['msg'].'<br><small>'.$this->time_elapsed_string($value['time_stamp']).'</small></div><dp/><br>';
                }
            }
        }
        return $out_mass;
    }

    public function getBudgets(){
        $query="Select b.id, b.date_time, b.planed_cost, bt.name as type_name, b.type_id as budget_type, b.name From budget as b".
                " Left Join budget_type as bt on b.type_id=bt.id Where b.deleted=0";

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function getColumns($params){
        $query = "Show Columns From ".strtolower($params['table']);

        $results = $this->sendQuery($query);
        return $results;
    }

    public function getDepRoles(){
        $query = "Select id,name,power From roles";
        $query2 = "Select id,name,sub From departments";
        $query3 = "Select id,name From budget_type";
        $query_results['roles'] = $this->make_string_select($this->sendQuery($query));
        $query_results['departments'] = $this->make_string_select($this->sendQuery($query2));
        $query_results['budget_type'] = $this->make_string_select($this->sendQuery($query3));
        return ($query_results);
    }

    public function addEmployee($params){

        $query = "INSERT INTO employee(fullname, role_id, department_id, username, email,password)"
            . "VALUES ('" . $params["fullname"] . "',"
            . $params["role"] . ","
            . $params["department"]  . ",'"
            . $params["username"] . "','"
            . $params["email"] . "'";

        if ($params['password']!=''){
            $query.= ",'".md5($this->FISH . md5(trim($params['password'])))."'";
        }
        $query.=')';
        $query_results = $this->sendQuery($query);
        $last_id = mysqli_insert_id(GetMyConnection());
        echo $query;
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','user_id'=>$last_id);
        }
    }

    public function updateEmployee($params){
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
        else {
            return Array('type'=>'success','id'=>$params['id']);
        }
    }

    public function checkUser($params){
        $query = "SELECT username FROM employee WHERE username='" . $params['username'] . "'";

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function deleteEmployee($params){
        $query = "UPDATE employee SET deleted=1".
            " WHERE id=".$params['id'];
        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','user_id'=>$params['id']);
        }
    }

    public function addBudget($insert_arr){
        $query = "Insert Into budget (name,type_id,planed_cost) Values('".$insert_arr['name']."',".$insert_arr['budget_type'].",".$insert_arr['planed_cost'].")";

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function deleteBudget($params){
        $query = "UPDATE budget SET deleted=1".
            " WHERE id=".$params['id'];

        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','budget_id'=>$params['id']);
        }
    }

    public function updateBudget($params){
        $query = "Update budget Set type_id=".$params['budget_type'].",name='".$params['name']."',planed_cost=".$params['planed_cost']." Where id=".$params['id'];

        $res = $this->sendQuery($query);

//        echo $query;
        if (!$res) {
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','id'=>$params['id']);
        }
    }

    public function addIomReq($params){
        $chain = json_decode($params['sign_chain']);
        $budgets = json_decode($params['budgets'],true);
        $query = "INSERT INTO iom(employee_id,name,power,costsize,actualcost,substantation) "
            . "VALUES (" . $params["employee_id"] . ",'"
            . $params["purchase_text"]. "',0," . $params["expense_size"] . ",0,'".$params["substantiation_text"]."')";
        $result = $this->sendQuery($query);

        $iom_num = mysqli_insert_id(GetMyConnection());
        $query = "INSERT INTO sign_chain(iom_id,employee_id,status) Values ";
        foreach($chain as $key=>$value){
            if (!is_null($value)) {
                foreach ($value as $v) {
                    $query .= "(".$iom_num.",".$v.",'in progress'),";
                    $this->sendMessage('Application #'.$iom_num.' Created!',$params['purchase_text'],$v,10000);

                }
            }
        }
        
        $this->sendMessage('You created Application #'.$iom_num,$params['purchase_text'],$_SESSION['user']['id'],10000);

        $res = $this->sendQuery(trim($query,','));
        if (count($budgets) != 0) {
            $query = "INSERT INTO iom_budgets(iom_id,budget_id,cost) Values ";
            foreach ($budgets as $key => $value) {
                $query .= "(" . $iom_num . "," . $value['id'] . "," . $value['value'] . "),";
            }

            $res = $this->sendQuery(trim($query, ','));
        }
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

                $this->sendToSigners($params['id'],$type,$params['user_session_fullname']);

                return Array('type' => 'success', 'id' => $params['id']);
            } else {
                return Array('type' => 'error', 'error_msg' => mysqli_error(GetMyConnection()));
            }
        }else{
            return Array('type' => 'error', 'error_msg' => "Before you have the chain signatory.");
        }
    }

    public function appendFileToIom($iom_id,$file_title,$filename,$file_path){

        $query = "Insert Into files (iom_id,title,filename,filepath) Values(".$iom_id.",'" . $file_title . "','".$filename."','".$file_path."')";

        $this->sendQuery($query);
    }

    public function getLatestActions($params){

        $query = "Select sc.iom_id, concat(' by ',em.fullname,'|',sc.time_stamp ) as latest_action".
                " From sign_chain as sc".
                " Left Join employee as em on em.id=sc.employee_id".
                " Where sc.iom_id in (Select iom_id From sign_chain Where employee_id=65)".
                " ORDER BY sc.time_stamp DESC".
                " LIMIT 5";

        $results = $this->sendQuery($query);
//        $query_results[$key]['latest_action']='<h5>'.$time_array[0].' <small>'.$this->time_elapsed_string($time_array[1]).'</small></h5>';

        for ($i = 0;$i<5;$i++){
            $time_array = explode('|',$results[$i]['latest_action']);
            $results[$i]['latest_action'] = '<h5>Application #'.$results[$i]['iom_id'].' Edited'.$time_array[0].' <small>'.$this->time_elapsed_string($time_array[1]).'</small></h5>';
        }

        return $results;

    }

    public function getBudgetsGraph(){
        $query = "Select ib.cost,i.time_stamp, b.name From iom_budgets as ib".
                    " Left Join budget as b on b.id=ib.budget_id".
                    " Left Join budget_type as bt on bt.id=b.type_id".
                    " Left Join iom as i on i.id=ib.iom_id";

        $results = $this->sendQuery($query);

        $result_array['categories'] = null;
        $result_array['series'] = null;
        $mass= Array();
        foreach ($results as $value){
            $result_array['categories'][] = $value['time_stamp'];
            $mass[$value['name']][] = intval($value['cost']);
        }

        foreach ($mass as $key=>$value){
            $result_array['series'][] = Array('name'=>$key,'data'=>$value);
        }

        return $result_array;
    }

    public function getDashboardData($params){

        $return_array = Array();

        $query = "Select count(id) as msg_count From messages Where employee_id=".$params['user_session_id']." and noty_status=0";

        $results = $this->sendQuery($query);

        $msg_count= $results[0]['msg_count'];

        $query = "Select count(id) as app_count From sign_chain Where status='in progress' and employee_id=".$params['user_session_id'];

        $results = $this->sendQuery($query);

        $app_count = $results[0]['app_count'];

        $return_array['msg_count'] = $msg_count;
        $return_array['app_count'] = $app_count;
        $return_array['messages'] = $this->getMessages($params);
        $return_array['last_msg'] = $this->getLastMessages($params);

        return $return_array;

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

    function sendMail($to,$subj,$msg){
        require_once 'PHPMailer-master/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = $this->mail_host;
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = $this->mail_username;
        $mail->Password = $this->mail_pwd;
        $mail->setFrom($this->mail_username, 'Test Sender oOpsMelodicHost');
//        $mail->addReplyTo('replyto@example.com', 'First Last');
        $mail->addAddress($to, 'John Doe');
        $mail->Subject = $subj;
        $mail->msgHTML($msg);
//        $mail->AltBody = 'This is a plain-text message body';
//        $mail->addAttachment('images/phpmailer_mini.png');
        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return "Message sent!";
        }
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