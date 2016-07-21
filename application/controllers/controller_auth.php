<?php

class Controller_Auth extends Controller
{
    function __construct()
    {
        $this->model = new Model_Auth();
        $this->view = new View();        
    }    
    
    function action_index()
    {		
        $data["login_status"] = "access_denied";
        $data["return"] = "";
        
        
        if(isset($_POST['login']) && isset($_POST['password']))
        {

                $login = $_POST['login'];
                $password =$_POST['password'];
                $user = $this->model->get_login_data($login,$password);
                $data["return"] = $user;
                if(!is_null($user))
                {
                   $data["login_status"] = "access_granted";
                   session_start(); 
                   $_SESSION['id'] = $user['id'];
                   $_SESSION['user'] = $user;
                   $_SESSION['login_status'] = $data["login_status"];
                   header('Location:/main');
                    //$this->view->generate('main_view.php', 'template_view.php', $data);
                }
                else
                {
                        $data["login_status"] = "access_denied";
                }
        }
        else
        {
                session_start();
                if (isset($_SESSION["login_status"])){
                    header('Location:/purchase');
                }else{
                    session_destroy();
                }
        }

        $this->view->generate('', 'auth_view.php', $data);
    }
}
