<?php

/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 17.02.2016
 * Time: 16:07
 */
include 'conn.php';
include_once 'PHPExcel/IOFactory.php';

class Iom
{
    public function __construct()
    {
        $this->fyStart = date("Y").'-04-01';
        $this->fyEnd = (date("Y")+1).'-03-30';
    }

    var $FISH = 'JHENEK';

//MAIL_SETTINGS
//
    var $mail_host = '10.6.5.121';
    var $mail_username = 'docflow.russia@sunpharma.com';
    var $mail_pwd = 'india@123';


    public function getAllIoms($params){

        $user_id = $params['user_session_id'];
        $query= "SELECT im.id,dep.name as department_name,dep.id as department_id, im.employee_id,im.substantation, im.time_stamp,im.name,em.fullname, im.status,im.actualcost,im.substantation,".
            " (Select concat(' ',ih.event_name,' by ',em.fullname,'|',ih.date_time )".
            " From iom_history as ih".
                " Left Join employee as em on em.id=ih.employee_id".
            " Where ih.iom_id=im.id".
            " ORDER BY ih.date_time DESC".
            " LIMIT 1) as latest_action,".
            "( ".$user_id." in (Select employee_id From sign_chain Where status='in progress' and iom_id=im.id)) as sign_status,".
            "( Select sc.status From sign_chain as sc Where sc.employee_id=".$user_id." and iom_id=im.id LIMIT 1) as user_last_status," .
            " (Select sum(cost) From iom_budgets as ib Where ib.iom_id=im.id) as iom_sum_budget,".
            " (Select sum(cost) From iom_source as iis Where iis.iom_id_to=im.id) as iom_sum_source".
            " FROM iom as im".
                " Left Join employee as em on im.employee_id=em.id" .
                " Left Join departments as dep on em.department_id=dep.id".
            " Where ".$user_id." in (Select employee_id From sign_chain Where iom_id=im.id) or im.employee_id=".$user_id." ORDER BY im.id DESC";

//        echo $query;
        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            $query_results[$key]['status_filter']=$value['status'];
            $query_results[$key]['user_last_status_filter']=$value['user_last_status'];
            switch ($value['status']){
                case "in progress":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "pending":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "N/A":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "Approved":
                    $query_results[$key]['status']='<span class="label label-success"><i class="fa fa-check"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "Canceled":
                    $query_results[$key]['status']='<span class="label label-danger"><i class="fa fa-close"></i>&nbsp;'.$value['status'].'</span>';
                    break;
            }
            $query_results[$key]['status'].= '<p><span class="label label-primary">&nbsp;'.number_format(floatval($value['iom_sum_budget'])+floatval($value['iom_sum_source'])).' ₽</span></p>';
            switch ($value['user_last_status']){
                case "in progress":
                    $query_results[$key]['user_last_status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['user_last_status'].'</span>';
                    break;
                case "pending":
                    $query_results[$key]['user_last_status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['user_last_status'].'</span>';
                    break;
                case "N/A":
                    $query_results[$key]['user_last_status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['user_last_status'].'</span>';
                    break;
                case "Approved":
                    $query_results[$key]['user_last_status']='<span class="label label-success"><i class="fa fa-check"></i>&nbsp;'.$value['user_last_status'].'</span>';
                    break;
                case "Canceled":
                    $query_results[$key]['user_last_status']='<span class="label label-danger"><i class="fa fa-close"></i>&nbsp;'.$value['user_last_status'].'</span>';
                    break;
            }
            $time_array = explode('|',$value['latest_action']);
            $query_results[$key]['latest_action']='<h5>'.$time_array[0].' <small>'.$this->time_elapsed_string($time_array[1]).'</small></h5>';
        }

        return $query_results;
    }

    public function getApprovedIoms($params){

        $user_id = $params['user_session_id'];
        $query = "Select im.name,im.id,im.time_stamp,im.status," .
            "(Select sum(ib.cost) From iom_budgets as ib Where ib.iom_id = im.id ) as iom_sum," .
            "( ".$user_id." in (Select employee_id From sign_chain Where status='in progress' and iom_id=im.id)) as sign_status," .
            "( Select sc.status From sign_chain as sc Where sc.employee_id=".$user_id." and iom_id=im.id Limit 1) as user_last_status" .
            " From iom as im" .
            " Left Join employee as em on em.id=im.employee_id" .
            " Where (Select sc.status From sign_chain as sc Where iom_id=im.id and employee_id=".$user_id." Limit 1)='in progress' Order by im.time_stamp DESC Limit 5";
        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            switch ($value['status']){
                case "in progress":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "pending":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "N/A":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "Approved":
                    $query_results[$key]['status']='<span class="label label-success"><i class="fa fa-check"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "Canceled":
                    $query_results[$key]['status']='<span class="label label-danger"><i class="fa fa-close"></i>&nbsp;'.$value['status'].'</span>';
                    break;
            }
        }

        return $query_results;
    }

    public function getTotalIoms($params){

        $query= "SELECT im.id,dep.name as department_name,dep.id as department_id, im.employee_id,im.substantation, im.time_stamp,im.name,em.fullname, im.status,im.actualcost,im.substantation,".
            " (Select concat(' ',ih.event_name,' by ',em.fullname,'|',ih.date_time )" .
            " From iom_history as ih".
            " Left Join employee as em on em.id=ih.employee_id".
            " Where ih.iom_id=im.id".
            " ORDER BY ih.date_time DESC".
            " LIMIT 1) as latest_action," .
            " (Select sum(cost) From iom_budgets as ib Where ib.iom_id=im.id) as iom_sum," .
            " (Select sum(iiv.cost) From iom_invoice as iiv Where iiv.iom_id=im.id) as iom_invoice" .
            " FROM iom as im".
            " Left Join employee as em on im.employee_id=em.id" .
            " Left Join departments as dep on em.department_id=dep.id";
        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            switch ($value['status']){
                case "in progress":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "pending":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "N/A":
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
        $query= "SELECT sc.id,em.fullname,sc.time_stamp,sc.status,sc.employee_id,dep.name as dep_name,rol.name as role_name".
            " From sign_chain as sc".
            " Left Join employee as em on em.id=sc.employee_id".
			" Left Join departments as dep on em.department_id=dep.id".
			" Left Join roles as rol on em.role_id=rol.id".
            " Where sc.iom_id=".$params['iom_id'];

        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            switch ($value['status']){
                case "in progress":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "pending":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "N/A":
                    $query_results[$key]['status']='<span class="label label-primary"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
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

    public function getInvoiceSum($params){
        $query = "Select ii.date_time,ii.invoice_comment,ii.invoice_date,ii.invoice_num,ii.cost,ii.id From iom_invoice as ii Where ii.iom_id=".$params['iom_id'];

        $query_results = $this->sendQuery($query);

        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return $query_results;
        }
    }

    public function sendInvoiceSum($params){
//        $query = "Update iom Set actualcost=".$params['invoice']." Where id=".$params['iom_id'];

        $query = "Insert Into iom_invoice (cost,invoice_date,invoice_num,invoice_comment,iom_id) Values(".$params['cost'].",'".$params['date']."','".$params['num']."','".$params['comment']."',".$params['iom_id'].")";

        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()),'query'=>$query);
        }
        else {
            return Array('type'=>'success','event_id'=>$params['iom_id'],'query'=>$query);
        }
    }

    public function delInvoice($params){

//        $query = "Update iom Set actualcost=".$params['invoice']." Where id=".$params['iom_id'];

        $query = "Delete From iom_invoice Where id=".$params['id'];

        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()),'query'=>$query);
        }
        else {
            return Array('type'=>'success','query'=>$query);
        }
    }

    public function getIomBudgets($params){
        $query= "Select  b.name,(Select sum(cost) From budget_relocations Where budget_id=ib.budget_id) as relocation_cost,(Select sum(cost) From iom_invoice Where iom_id=".$params['iom_id'].") as ionvoice_cost, bb.name as brand_name, bm.name as mapping_name,b.budget_type,ib.cost as cur_cost,b.budget_date, ib.budget_id,b.planed_cost,b.date_time,".
		" (Select sum(cost) From iom_budgets as ibs Left Join iom as im on im.id=ibs.iom_id Where ibs.budget_id=b.id and ibs.iom_id<".$params['iom_id']." and ibs.iom_id!=".$params['iom_id']." and (im.status!='Canceled' or im.status is null)) as current_balance".
		" From iom_budgets as ib".
                " Left Join budget as b on ib.budget_id=b.id".
                " Left Join budget_relocations as br on br.budget_id=ib.budget_id".
                " Left Join budget_mapping as bm on b.mapping_id=bm.id".
                " Left Join budget_brand as bb on b.brand_id=bb.id".
                " Where ib.iom_id=".$params['iom_id'];

//        echo $query;
        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function getIomSource($params){
        $query= "Select sum(cost) as iom_cost,im.name,im.id From iom_source as iis Left Join iom as im on iis.iom_id_from=im.id Where im.status!='Canceled' and iis.iom_id_to=".$params['iom_id'];

//        echo $query;
        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function getIomEvents($params){
        $query= " Select concat( e.event_name,' by ',em.fullname) as event, e.date_time,e.id,e.cancel,e.event_name,em.id as employee_id  From iom_history as e".
                " Left Join employee as em on e.employee_id=em.id".
                " Where e.iom_id=".$params['iom_id'];

        $query_results = $this->sendQuery($query);
        return $query_results;

    }

    public function cancelEvent($params){
        $query = "Update iom_history Set cancel=1 Where id=".$params['id'];
        $this->sendQuery($query);
        $query = "Update sign_chain Set status='in progress' Where employee_id=".$params['employee_id']." and iom_id=".$params['iom_id'];
        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','event_id'=>$params['id']);
        }
    }

    public function deleteFile($params){
        $query = "Delete From files Where id=".$params['id'];
        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else{
            return Array('type'=>'success','file_id'=>$params['id']);
        }
    }

    public function getIomFiles($params){
        $query= " Select fs.filename,fs.title,fs.type, fs.filepath,fs.id  From files as fs".
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

    function sendToSigners($iom_id,$type,$user_name,$signer_id){

        $query = "Select em.fullname,im.name,sc.employee_id,em.fullname as em_name,sc.status,im.time_stamp,em.email From sign_chain as sc" .
            " Left Join iom as im on im.id=".$iom_id.
            " Left Join employee as em on sc.employee_id=em.id" .
            " Where sc.iom_id=".$iom_id .
            " and sc.id=".$signer_id." and sc.status!='N/A'";

        $res = $this->sendQuery($query);
//print_r($res);
        if ($res){
            foreach ($res as $value){
                if ($value['status']!='N/A') {
                    $this->sendMessage('IOM "' . $value['name'] . '" has been ' . $type . ' by user ' . $user_name, 'Event Notification', $value['employee_id'], 8000);
                    $this->sendMail($value['email'], 'IOM "' . $value['name'] . '" has been Created. For your review please.',
                        '<p style="border-bottom: 3px solid #ef9c00;color:#ef9c00;"><h1>IOM Tracking System</h1></p><p> Dear ' . $value['em_name'] . ',
                     </p><p>Please be informed that IOM "' . $value['name'] . '" has been created by Initiator on ' . $value['time_stamp'] . '. Last ' . $type . ' by ' . $user_name . '. </p><p>To Approve/Cancel this IOM please go via <a href="' . $_SERVER['HTTP_HOST'] . '/show/' . $iom_id . '"> link. </a></p><p><img src="img/logo.png"></p>');
                }
            }
        }

    }

    public function getComments($params){
        $query = "Select c.id,c.text,c.time_stamp,em.fullname,sc.status From comments as c Left Join employee as em on +c.employee_id=em.id".
                 " Left Join sign_chain as sc on c.employee_id=sc.employee_id and c.iom_id=sc.iom_id".
                 " Where c.iom_id=".$params['iom_id'];


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
        $query="Select b.id,(Select sum(cost) From budget_relocations Where budget_id=b.id) as relocation_cost, b.date_time, b.planed_cost,b.budget_date ,b.budget_type, bb.name as brand_name, b.brand_id as budget_brand,b.mapping_id as budget_mapping, b.name, bm.name as mapping_name,(b.planed_cost-sum(ib.cost)) as cur_sum From budget as b".
                " Left Join budget_brand as bb on b.brand_id=bb.id" .
                " Left Join budget_relocations as br on br.budget_id=b.id" .
                " Left Join budget_mapping as bm on b.mapping_id=bm.id" .
                " Left Join iom_budgets as ib on b.id = ib.budget_id  and (Select count(id) From iom as im Where ib.iom_id=im.id and im.status='Canceled')=0 Where b.deleted=0 and b.department_id=".$_SESSION['user']['department_id']." and b.budget_date BETWEEN '".$this->fyStart."' and '".$this->fyEnd."' GROUP BY b.id";

        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            $query_results[$key]['select_sum'] = 0;
        }
        return $query_results;
    }

    public function getIomsSource(){
        $query="Select im.name,im.id,em.department_id,(Select sum(cost) From iom_invoice Where iom_id=im.id) as invoice_cost, (Select sum(cost) From iom_budgets Where iom_id=im.id) as budget_cost,(Select sum(iis.cost) From iom_source as iis Left Join iom as iim on iis.iom_id_to=iim.id Where iim.status!='Canceled' and iis.iom_id_from=im.id) as source_cost, im.status From iom as im Left Join employee as em on im.employee_id=em.id Where im.status!='Canceled' and em.department_id=".$_SESSION['user']['department_id']." ";

        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            $query_results[$key]['select_sum'] = 0;
        }
        return $query_results;
    }
    public function getBudgetRelocations($params){

        $query = "Select b.name as name_relocation, b.budget_date as budget_date_relocation, br.cost,br.id From budget_relocations as br" .
            " Left Join budget as b on b.id=br.budget_id Where br.budget_id=".$params['budget_id'];

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function sendRel($params){
//        $query = "Update iom Set actualcost=".$params['invoice']." Where id=".$params['iom_id'];

        $query = "Insert Into budget_relocations (cost,budget_id) Values(".$params['cost'].",".$params['budget_id'].")";

        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()),'query'=>$query);
        }
        else {
            return Array('type'=>'success','query'=>$query);
        }
    }

    public function delRel($params){
//        $query = "Update iom Set actualcost=".$params['invoice']." Where id=".$params['iom_id'];

        $query = "Delete From budget_relocations Where id=".$params['id'];

        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()),'query'=>$query);
        }
        else {
            return Array('type'=>'success','query'=>$query);
        }
    }

    public function getRelocations(){

        $query = "Select b.name as name_relocation, b.budget_date as budget_date_relocation, br.cost,br.id From budget_relocations as br" .
            " Left Join budget as b on b.id=br.budget_id";

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function getAllBudgets(){
        $query="Select b.id, b.date_time,b.budget_date,b.department_id as budget_department, b.date_time, dep.name as department_name , b.planed_cost,b.budget_type, bb.name as brand_name, b.brand_id as budget_brand,b.mapping_id as budget_mapping, br.id as budget_relocations, (Select sum(cost) From budget_relocations Where budget_id=b.id) as relocation_cost, b.name, bm.name as mapping_name,(b.planed_cost-sum(ib.cost)) as cur_sum From budget as b".
            " Left Join budget_brand as bb on b.brand_id=bb.id" .
            " Left Join budget_relocations as br on br.budget_id=b.id" .
            " Left Join budget_mapping as bm on b.mapping_id=bm.id" .
            " Left Join departments as dep on b.department_id=dep.id" .
            " Left Join budget_sum as bs on bs.budget_id=b.id" .
            " Left Join iom_budgets as ib on b.id = ib.budget_id  and (Select count(id) From iom as im Where ib.iom_id=im.id and im.status='Canceled')=0" .
            " Where b.deleted=0 GROUP BY b.id";

        $query_results = $this->sendQuery($query);
//echo $query;
        foreach($query_results as $key => $value){
            $new_date = date_parse($value['budget_date']);
            if ($new_date['month']>=4){
                $query_results[$key]['fy']='FY-'.$new_date['year'].'-'.($new_date['year']+1);
            }else{
                $query_results[$key]['fy']='FY-'.($new_date['year']-1).'-'.$new_date['year'];
            }
//            $query_results[$key]['budget_date']=;
        }

        return $query_results;
    }

    public function getBudgetIoms($params){
        $query="Select im.id,im.name,em.fullname,im.status,im.time_stamp,sum(ib.cost) iom_cost From iom_budgets as ib Left Join iom as im on im.id=ib.iom_id" .
            " Left Join employee as em on em.id=im.employee_id" .
            " Where ib.budget_id=" .$params['budget_id'].
            " Group By im.id";

        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            switch ($value['status']){
                case "in progress":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "pending":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "N/A":
                    $query_results[$key]['status']='<span class="label label-primary"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
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

    public function getMappings(){
        $query = "Select id,name From budget_mapping";

        $query_results = $this->sendQuery($query);
        return $query_results;
    }

    public function getBrands(){
        $query = "Select id,name From budget_brand";

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
//        $query3 = "Select id,name From budget_type";
        $query4 = "Select id,name From budget_brand";
        $query5 = "Select id,name From budget_mapping";
        $query6 = "Select b.id,concat(b.id,'/',b.name,'/',bb.name,'/',DATE_FORMAT(b.budget_date,'%M'),' - ',dep.name) as name From budget as b Left Join budget_brand as bb on b.brand_id=bb.id Left Join departments as dep on dep.id=b.department_id";
        $query_results['roles'] = $this->make_string_select($this->sendQuery($query));
        $query_results['departments'] = $this->make_string_select($this->sendQuery($query2));
//        $query_results['budget_type'] = $this->make_string_select($this->sendQuery($query3));
        $query_results['brand_name'] = $this->make_string_select($this->sendQuery($query4));
        $query_results['mapping_name'] = $this->make_string_select($this->sendQuery($query5));
        $query_results['budgets'] = $this->make_string_select($this->sendQuery($query6));
        return $query_results;
    }

    public function getFilterData($params){
        $filed = $params['field_name'];
        $query = "Select `".$params['field_name']."` From `".$params['table_name']."` Group By `".$params['field_name']."`";

        $result = mysqli_query(GetMyConnection(),$query);

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[$row[$filed]] = $row[$filed];
        }
        mysqli_free_result($result);

        return $rows;
    }

    public function addEmployee($params){

        $query = "INSERT INTO employee(position,fullname, role_id, department_id, username, email,password)"
            . " VALUES (0,'" . $params["fullname"] . "',"
            . $params["role"] . ","
            . $params["department"]  . ",'"
            . $params["username"] . "','"
            . $params["email"] . "'";

        if ($params['password']!=''){
            $query.= ",'".md5($this->FISH . md5(trim($params['password'])))."'";
        }

        $query.=')';

//        $query.=",'1b55a674f1bf15056ec9784728c5a160')";

        $query_results = $this->sendQuery($query);
        $last_id = mysqli_insert_id(GetMyConnection());
//        echo $query;
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','user_id'=>$last_id);
        }

    }

    public function addBudget_relocations($params){

        $query = "Insert Into budget_relocations (cost,budget_id) Values(" . $params["cost"] . "," . $params["name_relocation"] .")";

        $query_results = $this->sendQuery($query);
        $last_id = mysqli_insert_id(GetMyConnection());
//        echo $query;
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','relocation_id'=>$last_id);
        }
    }

    public function updateEmployee($params){
        $passstring = "";
        if($params['password']!==""){
            $password = md5($this->FISH . md5(trim($params['password'])));
            $passstring="',password='".$password;
        }else $passstring="";

//        $passstring = "',password='1b55a674f1bf15056ec9784728c5a160";

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
        $query = "Insert Into budget (name,brand_id,mapping_id,budget_type,department_id,planed_cost) Values('".$insert_arr['name']."',".$insert_arr['brand_name'].",".$insert_arr['mapping_name'].",'".$insert_arr['budget_type']."',".$insert_arr['department_name'].",".$insert_arr['planed_cost'].")";

        $query_results = $this->sendQuery($query);
        $last_id = mysqli_insert_id(GetMyConnection());
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','user_id'=>$last_id);
        }
    }

    public function addBudget_mapping($insert_arr){
        $query = "Insert Into budget_mapping (name) Values('".$insert_arr['name']."')";

        $query_results = $this->sendQuery($query);
        $last_id = mysqli_insert_id(GetMyConnection());
//        echo $query;
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','user_id'=>$last_id);
        }
    }

    public function addBudget_brand($insert_arr){
        $query = "Insert Into budget_brand (name) Values('".$insert_arr['name']."')";

        $query_results = $this->sendQuery($query);
        $last_id = mysqli_insert_id(GetMyConnection());
//        echo $query;
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','user_id'=>$last_id);
        }
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

    public function deleteBudget_mapping($params){
        $query = "UPDATE budget_mapping SET deleted=1".
            " WHERE id=".$params['id'];

        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','budget_id'=>$params['id']);
        }
    }

    public function deleteBudget_brand($params){
        $query = "UPDATE budget_brand SET deleted=1".
            " WHERE id=".$params['id'];

        $query_results = $this->sendQuery($query);
        if (!$query_results){
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','budget_id'=>$params['id']);
        }
    }

    public function updateBudget_brand($params){
        $query = "Update budget_brand Set name='".$params['name']."'+ Where id=".$params['id'];

        $res = $this->sendQuery($query);

//        echo $query;
        if (!$res) {
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','id'=>$params['id']);
        }
    }

    public function updateBudget_mapping($params){
        $query = "Update budget_mapping Set name='".$params['name']."' Where id=".$params['id'];

        $res = $this->sendQuery($query);

//        echo $query;
        if (!$res) {
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','id'=>$params['id']);
        }
    }

    public function updateBudget($params){
        $query = "Update budget Set budget_type='".$params['budget_type']."',brand_id=".$params['brand_name'].",mapping_id=".$params['mapping_name'].",name='".$params['name']."',department_id=".$params['department_name'].",planed_cost=".$params['planed_cost']." Where id=".$params['id'];

        $res = $this->sendQuery($query);

//        echo $query;
        if (!$res) {
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
        else {
            return Array('type'=>'success','id'=>$params['id']);
        }
    }

    public function createIomReq($params){
        $chain = json_decode($params['sign_chain']);
        $budgets = json_decode($params['budgets'],true);
        $iom_source = json_decode($params['iom_source'],true);
        $query = "INSERT INTO iom(employee_id,name,power,costsize,actualcost,substantation) "
            . "VALUES (" . $params["employee_id"] . ",'"
            . mysqli_escape_string(GetMyConnection(),$params["purchase_text"]). "',0," . $params["expense_size"] . ",0,'".mysqli_escape_string(GetMyConnection(),$params["substantiation_text"])."')";
        $result = $this->sendQuery($query);

        $iom_num = mysqli_insert_id(GetMyConnection());

        if ($iom_num!=0) {

            $iom_cost = 0;

            $budget_type = '';

            $budgets_value = '';
            $budgets_approve = Array('1032', '1035', '1047');
            $budgets_check = Array('1045', '1046');
            if (count($budgets) != 0) {
                $query = "INSERT INTO iom_budgets(iom_id,budget_id,cost) Values ";
                foreach ($budgets as $key => $value) {
                    $query .= "(" . $iom_num . "," . $value['id'] . "," . $value['value'] . "),";
                    $iom_cost += intval($value['value']);
                    $budget_type = $value['budget_type'];
                    $budgets_value = $value['id'];
                }

                $res = $this->sendQuery(trim($query, ','));
            }

            if (count($iom_source) != 0) {
                $query = "INSERT INTO iom_source(iom_id_from,iom_id_to,cost) Values ";
                foreach ($iom_source as $key => $value) {
                    $query .= "(" . $value['id'] . "," . $iom_num . "," . $value['value'] . "),";
                    $iom_cost += intval($value['value']);
                    $budgets_value = $value['id'];
                }

                $res = $this->sendQuery(trim($query, ','));
            }

            $this->addIomEvent($iom_num, $params["employee_id"], 'Created');

            $query = "INSERT INTO sign_chain(iom_id,employee_id,status) Values ";

            $status = 'pending';

            foreach ($chain as $key => $value) {
                if (!is_null($value)) {
                    if ($value == reset($chain)) {
                        $status = 'in progress';
                    } else {
                        $status = 'pending';
                    }
                    foreach ($value as $v) {
                        if ($status == 'in progress') {
                            $this->sendMessage('IOM #' . $iom_num . ' Created!', $params['purchase_text'], $v, 3000);
                        }
                        if ($value == end($chain)) {
                            if ($budget_type == 'OPEX' or in_array($budgets_value, $budgets_check)) {
                                if ($iom_cost < 300000) {
                                    $query .= "(" . $iom_num . "," . $v . ",'N/A'),";
                                } else {
                                    $query .= "(" . $iom_num . "," . $v . ",'" . $status . "'),";
                                }
                            } elseif (in_array($budgets_value, $budgets_approve)) {
                                $query .= "(" . $iom_num . "," . $v . ",'" . $status . "'),";
                            } else {
                                $query .= "(" . $iom_num . "," . $v . ",'N/A'),";
                            }
                        } else {
                            $query .= "(" . $iom_num . "," . $v . ",'" . $status . "'),";
                        }
                    }
                }
            }

            $res = $this->sendQuery(trim($query, ','));

            $this->sendMessage('You created IOM #' . $iom_num, $params['purchase_text'], $_SESSION['user']['id'], 10000);

            $query = "Select sc.id,sc.employee_id From sign_chain as sc  Where sc.iom_id=" . $iom_num . " LIMIT 1";

            $last = mysqli_query(GetMyConnection(), $query);

            $row = mysqli_fetch_array($last, MYSQLI_ASSOC);


            $next_id = intval($row['id']);

            $this->sendToSigners($iom_num, 'Created', $params['user_session_fullname'], $next_id);


            if ($result) {
                return Array('type' => 'success', 'id' => $iom_num, 'query' => $query, 'budget' => $budgets);
            } else {
                return Array('type' => 'error', 'error_msg' => mysqli_error(GetMyConnection()));
            }

        }else{
            return Array('type' => 'error', 'error_msg' => mysqli_error(GetMyConnection()));
        }


    }

    public function updateIomReq($params){
        $chain = json_decode($params['sign_chain']);
        $budgets = json_decode($params['budgets'],true);

        $query = "Update iom Set name='". mysqli_escape_string(GetMyConnection(),$params["purchase_text"])."', substantation='".mysqli_escape_string(GetMyConnection(),$params["substantiation_text"])."',status='in progress'".
            " Where id=".$params['iom_id'];
        $result = $this->sendQuery($query);

        $budget_type = '';

        $iom_num = $params['iom_id'];

        $this->addIomEvent($iom_num,$params["employee_id"],'Restarted');

        $query = "Delete From sign_chain Where iom_id=".$params['iom_id'];

        $result = $this->sendQuery($query);

        $query = "Delete From iom_budgets Where iom_id=".$params['iom_id'];

        $result = $this->sendQuery($query);

        $iom_cost = 0;

        $budgets_value = '';
        $budgets_approve = Array('1032','1035','1047');
        $budgets_check = Array('1045','1046');
        if (count($budgets) != 0) {
            $query = "INSERT INTO iom_budgets(iom_id,budget_id,cost) Values ";
            foreach ($budgets as $key => $value) {
                $query .= "(" . $iom_num . "," . $value['id'] . "," . $value['value'] . "),";
                $iom_cost+=intval($value['value']);
                $budget_type = $value['budget_type'];
                $budgets_value = $value['id'];
            }

            $res = $this->sendQuery(trim($query, ','));
        }

        $this->addIomEvent($iom_num,$params["employee_id"],'Created');

        $query = "INSERT INTO sign_chain(iom_id,employee_id,status) Values ";

        $status ='pending';

        foreach($chain as $key=>$value){
            if (!is_null($value)) {
                if ($value == reset($chain)){
                    $status = 'in progress';
                }else{
                    $status = 'pending';
                }
                foreach ($value as $v) {
                    if ($status == 'in progress'){
                        $this->sendMessage('IOM #' . $iom_num . ' Restarted!', $params['purchase_text'], $v, 3000);
                    }
                    if ($value == end($chain)){
                        if ($budget_type=='OPEX' or in_array($budgets_value,$budgets_check)) {
                            if ($iom_cost < 300000) {
                                $query .= "(" . $iom_num . "," . $v . ",'N/A'),";
                            } else {
                                $query .= "(" . $iom_num . "," . $v . ",'" . $status . "'),";
                            }
                        }elseif(in_array($budgets_value,$budgets_approve)){
                            $query .= "(" . $iom_num . "," . $v . ",'".$status."'),";
                        }else{
                            $query .= "(" . $iom_num . "," . $v . ",'N/A'),";
                        }
                    }else{
                        $query .= "(" . $iom_num . "," . $v . ",'".$status."'),";
                    }
                }
            }
        }

        $this->sendMessage('You created IOM #'.$iom_num,$params['purchase_text'],$_SESSION['user']['id'],10000);

        $res = $this->sendQuery(trim($query,','));

        $query = "Select sc.id,sc.employee_id From sign_chain as sc  Where sc.iom_id=" . $iom_num ." LIMIT 1";

        $last = mysqli_query(GetMyConnection(), $query);

        $row = mysqli_fetch_array($last, MYSQLI_ASSOC);


        $next_id = intval($row['id']);

        $this->sendToSigners($iom_num,'Created',$params['user_session_fullname'],$next_id);


        if ($result){
            return Array('type'=>'success','id'=>$iom_num,'query'=>$query,'budget'=>$budget_type);
        }else{
            return Array('type'=>'error','error_msg'=>mysqli_error(GetMyConnection()));
        }
    }

    public function signIom($params){
        $type='Error';
        if ($params['type']=='Confirm' or $params['type']=='Send to C.H' ){
            $type='Approved';
        }else{
            $type='Canceled';
        }
//OLD CHECK
        if ($this->checkSignIom($params['id'],$params['user_session_id'])) {
            $query = "Update sign_chain Set status='" . $type . "' Where iom_id=" . $params['id'] . " and employee_id=" . $params['user_session_id'];
            $res = mysqli_query(GetMyConnection(), $query);
            $query = "Select sc.id,sc.employee_id,sc.status From sign_chain as sc  Where sc.iom_id=" . $params['id'] . " and sc.employee_id=" . $params['user_session_id']." ORDER BY sc.id DESC LIMIT 1";
            $last = mysqli_query(GetMyConnection(), $query);
            $row = mysqli_fetch_array($last, MYSQLI_ASSOC);
            $next_id = intval($row['id'])+1;
            $next_status = $row['status'];
            $query ='';
            if ($params['type'] == 'Send to C.H'){
                $query = "Update sign_chain Set status='in progress' Where id=" . strval($next_id) . " and status!='Approved'";
            }else{
                if ($params['type'] == 'Confirm') {
                    $query = "Update sign_chain Set status='in progress' Where id=" . strval($next_id) . " and status!='Approved' and status!='N/A'";
                }else{
                    $query = "Update sign_chain Set status='pending' Where id=" . strval($next_id) . " and status!='Approved' and status!='N/A'";
                }
            }
            $res2 = mysqli_query(GetMyConnection(), $query);
            if ($res) {
                $this->checkIom($params['id']);
                $this->sendToSigners($params['id'],$type,$params['user_session_fullname'],$next_id);
                $this->addIomEvent($params['id'],$params['user_session_id'],$type);
                if ($params['comment']!='') {
                    $mass =  Array('user_session_id' => $params['user_session_id'], 'iom_id' => $params['id'], 'text' => $params['comment']);
                    $this->newComment($mass);
                }
                return Array('type' => 'success', 'id' => $params['id'],'next'=> $next_id);
            } else {
                return Array('type' => 'error', 'error_msg' => mysqli_error(GetMyConnection()));
            }
        }else{
            return Array('type' => 'error', 'error_msg' => "Before you have the chain signatory.");
        }
    }

    public function appendFileToIom($iom_id,$file_title,$filename,$type,$file_path){

        $query = "Insert Into files (iom_id,title,filename,filepath,type) Values(".$iom_id.",'" . $file_title . "','".$filename."','".$file_path."','".$type."')";
//        echo $query;
        $this->sendQuery($query);
    }

    public function addIomEvent($iom_id,$employee_id,$event_name){

        $query = "Insert Into iom_history (iom_id,employee_id,event_name) Values(".$iom_id.",".$employee_id.",'".$event_name."')";

        $this->sendQuery($query);

    }

    public function getLatestActions($params){

        $query = "Select ih.event_name,im.name,ih.date_time,em.fullname From iom_history as ih".
            " Left Join employee as em on em.id=ih.employee_id".
            " Left Join iom as im on im.id=ih.iom_id Order By ih.date_time DESC LIMIT 5";

        $results = $this->sendQuery($query);
//        $query_results[$key]['latest_action']='<h5>'.$time_array[0].' <small>'.$this->time_elapsed_string($time_array[1]).'</small></h5>';

        for ($i = 0;$i<5;$i++){
            $results[$i]['latest_action'] = '<h5>IOM "'.$results[$i]['name'].'" '.$results[$i]['event_name'].' by '.$results[$i]['fullname'].' <small>'.$this->time_elapsed_string($results[$i]['date_time']).'</small></h5>';
        }

        return $results;

    }

    public function getBudgetsGraph($params){
        $query = "Select concat(b.name,'/',bm.name,'/',bb.name) as budget_name,b.id,dep.name as department_name From budget as b Left Join departments as dep on dep.id=b.department_id Left Join budget_brand as bb on b.brand_id=bb.id Left Join budget_mapping as bm on b.mapping_id=bm.id Where b.department_id=".$params['department_id'];

        $budgets= $this->sendQuery($query);

        $result_series=null;

        foreach($budgets as $value){
            $q = "Select ib.cost,im.name,im.time_stamp,ib.iom_id From iom_budgets as ib Left Join iom as im on ib.iom_id=im.id Where im.status!='Canceled' and im.time_stamp!=0 and ib.budget_id=".$value['id'].' ORDER BY im.time_stamp';
            $drill= $this->sendQuery($q);
            $sort=null;
            if($drill!=null) {
                foreach ($drill as $val) {
                    $sort[] = Array(strtotime($val['time_stamp']) * 1000,intval($val['cost']));
                }
                $result_series[] = Array('type'=>'line','visible'=>false,'budget_id'=>$value['id'],'marker'=>Array('enabled'=>true,'radius'=>3),'name' => $value['budget_name'], 'data' => $sort);
            }
        }

        return $result_series;
    }

    public function getIomsGraph($params){
        $query = "Select im.id,im.time_stamp From iom as im Left Join employee as em on im.employee_id=em.id";

        $budgets= $this->sendQuery($query);

        $result_series=null;

        foreach($budgets as $value){
            $q = "Select sum(ib.cost) From iom_budgets as ib Where ib.iom_id=".$value['id'];
            $drill= $this->sendQuery($q);
            $sort=null;
            if($drill!=null) {
                foreach ($drill as $val) {
                    $sort[] = Array(strtotime($value['time_stamp']) * 1000,intval($val['cost']));
                }
            }
            $result_series[] = Array('type'=>'line','iom_id'=>$value['id'],'marker'=>Array('enabled'=>true,'radius'=>3),'name' => $value['id'], 'data' => $sort);
        }

        return $result_series;
    }

    public function getIomsByBudget($params){
        $query= "SELECT im.id,dep.name as department_name,dep.id as department_id, im.employee_id,im.substantation, im.time_stamp,im.name,em.fullname, im.status,im.actualcost,im.substantation," .
            " (Select concat(' ',ih.event_name,' by ',em.fullname,'|',ih.date_time )" .
            " From iom_history as ih" .
            " Left Join employee as em on em.id=ih.employee_id" .
            " Where ih.iom_id=im.id" .
            " ORDER BY ih.date_time DESC" .
            " LIMIT 1) as latest_action," .
            " (Select sum(cost) From iom_budgets as ib Where ib.iom_id=im.id) as iom_sum," .
            " (Select sum(iiv.cost) From iom_invoice as iiv Where iiv.iom_id=im.id) as iom_invoice" .
            " FROM iom as im" .
            " Left Join employee as em on im.employee_id=em.id" .
            " Left Join departments as dep on em.department_id=dep.id" .
            " Left Join iom_budgets as ib on ib.iom_id=im.id" .
            " Where ib.budget_id=".$params['budget_id'];

        $query_results = $this->sendQuery($query);

        foreach($query_results as $key => $value){
            switch ($value['status']){
                case "in progress":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "pending":
                    $query_results[$key]['status']='<span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;'.$value['status'].'</span>';
                    break;
                case "N/A":
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

    public function getReport($params){
////        $all_budgets = $this->getAllBudgets();
//
////        print_r($all_budgets);
//
//        $report_data = json_decode($_GET['datareport']);
//
//        $objPHPExcel = new PHPExcel();
//        $objPHPExcel->setActiveSheetIndex(0);
//        $rowCount = 1;
//        foreach($report_data as $value){
//            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value['id']);
//            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, strval($value['department_name']));
//            $rowCount++;
//        }
//
//        //SAVE FILE XLSX
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        header("Pragma: public");
//        header("Expires: 0");
//        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//        header('Content-type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment; filename="file.xls"');
//        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//        header("Content-Type: application/force-download");
//        header("Content-Type: application/octet-stream");
//        header("Content-Type: application/download");
//        header("Content-Transfer-Encoding: binary ");
//        $objWriter->save('php://output');
    }

    function checkIom($iom_id){
        $query = "Select im.id,im.name,count(sc.id) as need_count, ".
                  "(Select count(id) From sign_chain Where (status='Approved' or status='N/A') and iom_id=im.id) as app_count, ".
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
                    $send_query = "Select im.employee_id as emp_id,em.email as email,em.fullname as em_name, im.name as iom_name From iom as im Left Join employee as em on im.employee_id=em.id Where im.id=".$iom_id." LIMIT 1";
                    $emp_res = $this->sendQuery($send_query);
                    $this->sendMessage('Your IOM #'.$emp_res[0]['iom_name'].'has been Canceled','Event Notification', $emp_res[0]['emp_id'], 8000);
                    $this->sendMail($emp_res[0]['email'],
                        'IOM "' . $emp_res[0]['iom_name'] . '" has been Canceled. For your review please.',
                        '<p style="border-bottom: 3px solid #ef9c00;color:#ef9c00;"><h1>IOM Tracking System</h1></p><p> Dear ' . $emp_res[0]['em_name'] . ',</p><p>Your IOM "' .$emp_res[0]['iom_name']. '" has been Canceled.</p><p><img src="img/logo.png"></p>');
                } else if (intval($value['app_count']) == intval($value['need_count'])) {
                    $this->updateIomStatus("Approved", $iom_id);
                    $send_query = "Select im.employee_id as emp_id,em.email as email,em.fullname as em_name, im.name as iom_name From iom as im Left Join employee as em on im.employee_id=em.id Where im.id=".$iom_id." LIMIT 1";
                    $emp_res = $this->sendQuery($send_query);
                    $this->sendMessage('Your IOM #'.$emp_res[0]['iom_name'].'has been Approved','Event Notification', $emp_res[0]['emp_id'], 8000);
                    $this->sendMail($emp_res[0]['email'],
                        'IOM "' . $emp_res[0]['iom_name'] . '" has been Approved. For your review please.',
                        '<p style="border-bottom: 3px solid #ef9c00;color:#ef9c00;"><h1>IOM Tracking System</h1></p><p> Dear ' . $emp_res[0]['em_name'] . ',</p><p>Your IOM "' .$emp_res[0]['iom_name']. '" has been Approved.</p><p><img src="img/logo.png"></p>');
                }
            }
        }
    }

    function checkSignIom($iom_id,$user_id){
        $query = "Select id,employee_id,status From sign_chain Where iom_id=".$iom_id." ORDER BY id DESC";

        $results = $this->sendQuery($query);

        for ($i=0;$i<=count($results);$i++){
            if ($results[$i]['employee_id']==$user_id){
                if ($i+1==count($results)){
                    return true;
                }else if($results[$i+1]['status']=='Approved'){
                    return true;
                }else{
                    return true;
                }
            }
        }

    }


    function newChain($params){
        $chain_name = $params['name'];
        $user_id = $params['user_id'];
        $chain_id = 0;
        $chain = json_decode($params['sign_chain']);

        $query = "INSERT INTO saved_chain(employee_id,`name`) Values (".$user_id.",'".$chain_name."')";

        $query_results = $this->sendQuery($query);
        $last_id = mysqli_insert_id(GetMyConnection());

        $query = "INSERT INTO saved_chain_details(chain_id,employee_id) Values ";

        foreach ($chain as $key => $value) {
            if (!is_null($value)) {
                foreach ($value as $v) {
                    $query .= "(" .$last_id . "," . $v . "),";
                }
            }
        }
        $result = $this->sendQuery(trim($query, ','));

        if ($result) {
            return Array('type' => 'success', 'id' => $last_id, 'query' => $query,'result' => $result);
        } else {
            return Array('type' => 'error', 'error_msg' => mysqli_error(GetMyConnection()),'result' => $result);
        }
    }

    function getChain($params){
        $chain_id = $params['id'];
        $query = "Select employee_id From saved_chain_details Where chain_id=".$chain_id;

        $results = $this->sendQuery($query);

        return $results;
    }

    function deleteChain($params){
        $chain_id = $params['id'];
        $query = "Delete From saved_chain_details Where chain_id=".$chain_id;

        $results = $this->sendQuery($query);

        $query = "Delete From saved_chain Where id=".$chain_id;

        $results = $this->sendQuery($query);

        return $results;
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
        $mail->Port = 25;
//        $mail->Port = 587;
//        $mail->SMTPSecure = 'tls';
        //$mail->SMTPAuth = true;
        $mail->Username = $this->mail_username;
        $mail->Password = $this->mail_pwd;
        $mail->setFrom($this->mail_username, 'IOM Tracking System');
//        $mail->addReplyTo('replyto@example.com', 'First Last');
        $mail->addAddress($to, '');
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