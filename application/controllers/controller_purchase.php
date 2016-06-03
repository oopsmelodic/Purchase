<?php

class Controller_Purchase extends Controller
{
    function __construct()
    {
        $this->model = new Model_Purchase();
        $this->view = new View();
        $this->controller = new Controller();
    }    
    
    function action_index()
    {
        session_start();
        if($this->controller->check_session()) {
            $data = $this->model->get_user_data($_SESSION['id']);
//            print_r($data);
            $roles = $this->model->get_roles_data();
            $budgets = $this->model->get_budgets();
            $mapping = $this->model->get_mapping();
            $brand = $this->model->get_brand();
            $flip_roles = Array();
            $flip_budgets = Array();
            foreach($roles as $value){
                $flip_roles[$value['role_name']][] = '<option  data-content="<h5>'.$value['fullname'].'<small>'.$value['department'].'</small></h5>"  emp_id="'.$value['id'].'" role_power="'.$value['role_power'].'">'.$value['id'].' </option>';
            }
            foreach($budgets as $value){
                $flip_budgets[$value['budget_type_name']][] = '<option  data-content="<h5>'.$value['budget_name'].' - '.date('M/Y',strtotime($value['date_time'])).'<small>'.(is_null($value['cur_sum']) ? $value['planed_cost'] : $value['cur_sum']).'</small></h5>" planed_cost="'.$value['planed_cost'].'">'.$value['id'].' </option>';
            }
            foreach($flip_budgets as $key=>$value) {
                $data['budgets'] .= '<optgroup label="' . $key . '"' . 'data-max-options="">' . implode('', $value) . '</optgroup>';
            }
            $data['roles'] = $flip_roles;
            $this->view->generate('purchase_view.php', 'template_view.php', $data);
        }
    }
    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location:/');
    }

    function action_info(){

        echo $_GET['id'];

    }

}
