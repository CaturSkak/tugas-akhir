<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Middleware\Auth;
use App\Middleware\isLogin;
use App\Controller\AuthController;
use App\Controller\DashboardController;



return function (App $app) {
    $container = $app->getContainer();
    //Merigister View
    $container['view'] = function ($container) {
        $view = new \Slim\Views\Twig('../templates',[
            'cache' => false
        ]);

        $router = $container->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension (new \Slim\Views\TwigExtension($router, $uri));

        return $view;
    };

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        return DashboardController::index($this, $request, $response,  $args);
    })->add(new Auth());

     $app->get('/logout', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        session_destroy();
        return AuthController::index($this, $request, $response,  $args);
    });
     $app->get('/login', function (Request $request, Response $response, array $args) use ($container) {
        
        // Render index view
        return AuthController::index($this, $request, $response,  $args);
    })->add(new isLogin());

    $app->post('/islogin', function (Request $request, Response $response, array $args) use ($container) {
        $reg = $request->getParsedBody();
        // return var_dump($reg);
        return AuthController::login($this, $request, $response,  [
            'data'=>$reg
        ]);
        // Render index view
    });

     $app->get('/register', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        return AuthController::register($this, $request, $response,  $args);
    })->add(new isLogin());

    $app->post('/form-register', function (Request $request, Response $response, array $args) use ($container) {
        $reg = $request->getParsedBody();
        // return var_dump($reg);
        return AuthController::form_register($this, $request, $response,  [
            'reg'=>$reg
        ]);
    });

    
    

    
};




?>