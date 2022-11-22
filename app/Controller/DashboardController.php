<?php
namespace App\Controller;


class DashboardController{
    //buat function index()
    public static function index($app, $req, $rsp, $args){
        $username = $_SESSION['username'];

        $id = $app->db->get('user_details','*',[
            "username" => $username
        ]);
        $data = $app->db->select('user_details','*');
        var_dump($data);

        
        $app->view->render($rsp, 'index.html', [
            'username' => $_SESSION['username'],
            'id'     => $id,
            'data'   => $data
        ]);
    }
   
        
    
}

?>