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
//            $mapping = $this->model->get_mapping();
//            $brand = $this->model->get_brand();
            $chain = $this->model->get_saved_chain();
            $flip_roles = Array();
//            $flip_budgets = Array();
            foreach($roles as $value){
                $flip_roles[$value['role_name']][] = '<option  data-content="<h5>'.$value['fullname'].'<small>'.$value['department'].'</small></h5>"  emp_id="'.$value['id'].'" role_power="'.$value['role_power'].'">'.$value['id'].' </option>';
            }
            $data['roles'] = $flip_roles;

            //SAVED_CHAIN TEST
            if ($chain!=null) {
                foreach ($chain as  $value) {
                    $data['chain'].= '<option data-content="' . $value['name'] . '"' . 'data-max-options="">' . $value['id'] . '</option>';
                }
            }
//            $data['chain'] = $chain;
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
