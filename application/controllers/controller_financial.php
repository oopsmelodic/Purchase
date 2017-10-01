<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 03.03.2016
 * Time: 14:26
 */

class Controller_Financial extends Controller
{
    function __construct()
    {
        $this->model = new Model_Financial();
        $this->view = new View();
        $this->controller = new Controller();
    }

    function action_index()
    {
        session_start();
        if($this->controller->check_session()) {
            $data = $this->model->get_user_data($_SESSION['id']);

            $this->view->generate('financial_view.php', 'template_view.php');
        }

    }

    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }


}
