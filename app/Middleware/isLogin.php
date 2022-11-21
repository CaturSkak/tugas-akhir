<?php

namespace App\Middleware;
// session_start();

class isLogin {
    public function __invoke($req, $res, $next){
        if ($_SESSION['username'] == true) {
            return $res->withRedirect('/');
        }
        $response = $next($req, $res);
        return $response;
    }
}


?>