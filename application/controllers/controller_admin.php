<?php

class Controller_Admin extends Controller
{
    function __construct()
    {
        $this->model = new Model_Admin();
        $this->view = new View();
        $this->controller = new Controller();
        $this->power = 100;
    }

    function action_index()
    {
        session_start();
        if($this->controller->check_session()) {
            if ($this->power<=$_SESSION['user']['power']) {
                $data['departments'] = $this->model->get_departments();
                $data['roles'] = $this->model->get_roles();
                $this->view->generate('admin_view.php', 'template_view.php', $data);
            }
        }
    }
}
