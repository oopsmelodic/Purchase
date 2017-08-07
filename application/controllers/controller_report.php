<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 03.03.2016
 * Time: 14:26
 */

class Controller_Report extends Controller
{
    function __construct()
    {
        $this->model = new Model_Report();
        $this->view = new View();
        $this->controller = new Controller();
        $this->power = 60;
    }

    function action_index()
    {
        session_start();
        if($this->controller->check_session()) {
            if ($this->power<=$_SESSION['user']['power']) {
                $departments = $this->model->get_departments();
                $data = null;
                if ($departments != null) {
                    foreach ($departments as $value) {
                        $data['departments'] .= '<option data-content="' . $value['name'] . '"' . 'data-max-options="">' . $value['id'] . '</option>';
                    }
                }
                $this->view->generate('report_view.php', 'template_view.php', $data);
            }
        }
    }

    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location:/');
    }

    function action_info(){

        echo $_GET['id'];

    }

}
