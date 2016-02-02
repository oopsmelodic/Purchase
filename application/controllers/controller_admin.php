<?php

class Controller_Admin extends Controller
{
    function __construct()
    {
//        $this->model = new Model_Auth();
        $this->view = new View();        
    }

    function action_index()
    {
        $this->view->generate('admin_view.php', 'template_view.php');
    }
}
