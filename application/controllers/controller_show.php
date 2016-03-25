<?php

class Controller_Show extends Controller {

    function __construct() {
        $this->model = new Model_Show();
        $this->view = new View();
        $this->controller = new Controller();
    }

    function action_index($id) {
        session_start();
        if ($this->controller->check_session()) {
            $data = $this->model->get_iom_data($_SESSION['id'], $id);
//            print_r($data);
            if ($data['id'] == null) {
                header('Location:/main');
            }
            $this->view->generate('show_view.php', 'template_view.php', $data);
        }
    }

}
