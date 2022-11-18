<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\login;


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

     //Merender menggunakan twig melalui controler
     $app->get('/login', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        return login::index($this, $request, $response,  $args);
    });

     $app->get('/register', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        return login::register($this, $request, $response,  $args);
    });

    $app->post('/form-register', function (Request $request, Response $response, array $args) use ($container) {
        return login::form_register($this, $request, $response,  $args);
    });

    
    

    
};




?>