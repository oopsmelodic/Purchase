<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 16.06.2016
 * Time: 3:02
 */

class Controller_Edit extends Controller {

    function __construct() {
        $this->model = new Model_Edit();
        $this->view = new View();
        $this->controller = new Controller();
    }

    function action_index($id) {
        session_start();
        if ($this->controller->check_session()) {
            $data = $this->model->get_iom_data($_SESSION['id'], $id);
//            print_r($data);
            if ($data['id'] == null) {
                header('Location:/purchase');
            }
            $this->view->generate('edit_view.php', 'template_view.php', $data);
        }
    }

}
