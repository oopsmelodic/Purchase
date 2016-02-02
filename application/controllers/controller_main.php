<?php

class Controller_Main extends Controller
{
    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }    
    
    function action_index()
    {
        session_start();
        $data= $this->model->get_user_data($_SESSION['id']);
        $data['check']= $_SESSION['id'];
        $this->view->generate('main_view.php', 'template_view.php',$data);
    }
    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location:/');
    }
}
