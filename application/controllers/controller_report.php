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
//        $this->model = new Model_Main();
        $this->view = new View();
//        $this->controller = new Controller();
    }

    function action_index()
    {
        $this->view->generate('report_view.php', 'template_view.php');
    }

}
