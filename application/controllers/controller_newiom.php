<?php

class Controller_Newiom extends Controller
{
    function __construct()
    {
        $this->model = new Model_Newiom();
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
            $flip_roles = Array();
            $flip_budgets = Array();
            foreach($roles as $value){
                $flip_roles[$value['role_name']][] = '<option  data-content="<h5>'.$value['fullname'].'<small>'.$value['department'].'</small></h5>"  emp_id="'.$value['id'].'" role_power="'.$value['role_power'].'">'.$value['id'].' </option>';
            }
            foreach($budgets as $value){
                $flip_budgets[$value['budget_type_name']][] = '<option  data-content="<h5>'.$value['budget_name'].'<small>'.$value['planed_cost'].'</small></h5>" planed_cost="'.$value['planed_cost'].'">'.$value['id'].' </option>';
            }
            foreach($flip_budgets as $key=>$value){
                $data['budgets'].='<optgroup label="'.$key.'"'.'data-max-options="">'.implode('',$value).'</optgroup>';
            }
//            $data['budgets'] = $flip_budgets;
            $data['roles'] = $flip_roles;
            $this->view->generate('newiom_view.php', 'template_view.php', $data);
        }
    }
}
