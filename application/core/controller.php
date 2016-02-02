<?php

class Controller {
    
    public $model;
    public $view;
    
    function __construct()
    {
        $this->view = new View();
    }
    
    function check_session(){
        if (isset($_SESSION['login_status'])){
            if ( $_SESSION['login_status'] == "access_granted" )
            {
                return true;
            }
            else
            {
                session_destroy();
                Route::loop();
            }
        }else{
            session_destroy();
            Route::loop();            
        }
    }
    
    function action_index()
    {
        include './php/conn.php';
        mylog('Start Constructor');
    }
}