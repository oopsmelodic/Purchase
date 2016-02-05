<?php

class Controller_Main extends Controller
{
    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
        $this->controller = new Controller();
    }    
    
    function action_index()
    {
        session_start();
        if($this->controller->check_session()) {
            $data = $this->model->get_user_data($_SESSION['id']);
            $roles = $this->model->get_roles_data();
            $flip_roles = Array();
            foreach($roles as $value){
                $flip_roles[$value['role_name']][] = '<option  data-content="<h5>'.$value['fullname'].'<small>'.$value['department'].'</small></h5>"  emp_id="'.$value['id'].'" role_power="'.$value['role_power'].'">'.$value['id'].' </option>';
            }
            $data['roles'] = $flip_roles;
            $data['check'] = $_SESSION['id'];
            $this->view->generate('main_view.php', 'template_view.php', $data);
        }
    }
    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location:/');
    }
}
