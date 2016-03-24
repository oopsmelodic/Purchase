<?php

class Controller_Iom extends Controller {

    function __construct() {
        $this->model = new Model_Iom();
        $this->view = new View();
        $this->controller = new Controller();
    }

    function action_index() {
        session_start();
        if ($this->controller->check_session()) {
            $data = $this->model->get_iom_data($_SESSION['id'], "61");
//            print_r($data);


            $this->view->generate('newiom_view.php', 'template_view.php', $data);
        }
    }

}
