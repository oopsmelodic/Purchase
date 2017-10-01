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

            $this->view->generate('main_view.php', 'template_view.php', $data);
        }
    }
    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    function action_info(){

        echo $_GET['id'];

    }

}
