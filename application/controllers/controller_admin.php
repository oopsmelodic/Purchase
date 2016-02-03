<?php

class Controller_Admin extends Controller
{
    function __construct()
    {
//        $this->model = new Model_Auth();
        $this->view = new View();
        $this->controller = new Controller();
    }

    function action_index()
    {
        session_start();
        if($this->controller->check_session()) {
            $this->view->generate('admin_view.php', 'template_view.php');
        }
    }
}
