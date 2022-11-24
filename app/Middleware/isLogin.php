<?php

namespace App\Middleware;
// session_start();

class isLogin {
    public function __invoke($req, $res, $next){
        if (isset($_SESSION['username'])) {
            return $res->withRedirect('/');
        }
        $response = $next($req, $res);
        return $response;
    }
}


?>