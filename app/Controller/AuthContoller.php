<?php
namespace App\Controller;
use Medoo\Medoo;
// use Middleware\Auth;
// use PHPUnit\Framework\Constraint\Count;

class AuthController{
    //buat function index()
    public static function index($app, $req, $rsp, $args){

        $app->view->render($rsp, 'login.html', $args);
    }
    public static function register($app, $req, $rsp, $args){

        $app->view->render($rsp, 'register.html', $args);
    }
    public static function form_register($app, $req, $rsp, $args){
        $first_name = $req->getParsedBody('first_name');
        $last_name = $req->getParsedBody('last_name');
        $username = $req->getParsedBody('username');
        $password = md5($req->getParsedBody('password'));
        
        $rsp = $app->db->insert('user_details', [
                'username' => $username,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'password' => $password
            ]);
            
        $app->view->render($rsp, 'login.html', $args);
    }

    public static function login($app, $req, $rsp, $args){
        $password = md5($req->getParam('password'));
        $email = $req->getParam('email');

        $valid = $app->db->get("tbl_member","id",[
            "email" => $email,
            "password" => $password
        ]);

        
        
    }

        
    
}

?>