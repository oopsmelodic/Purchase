<?php

class Controller_Profile extends Controller
{
    function __construct()
    {
        $this->model = new Model_Profile();
        $this->view = new View();
        $this->controller = new Controller();
    }

    function action_index()
    {
        session_start();
        if($this->controller->check_session()) {
            $data['employee'] = $this->model->get_profile_data($_SESSION['id'])[0];
            $data['settings'] =$_SESSION['settings'];
            //print_r($data);
            $this->view->generate('profile_view.php', 'template_view.php', $data);
        }
    }
}
