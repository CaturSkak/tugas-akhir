<?php
namespace App\Controller;


class DashboardController{
    //buat function index()
    public static function index($app, $req, $rsp, $args){

        
        $app->view->render($rsp, 'index.html', $args);
    }
   
        
    
}

?>