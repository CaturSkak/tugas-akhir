<?php

namespace App\Middleware;
// session_start();

class Auth {
    public function __invoke($req, $res, $next){
        if(!isset($_SESSION['username'])){
            return $res->withRedirect('/login');
        }
        return $next($req, $res);
    }

    public static function isLogin(){
        $login = false;

        if(isset($_SESSION['username'])){
            $login = true;
        }

        return $login;
    }
}


?>