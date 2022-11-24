<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Middleware\Auth;
use App\Middleware\isLogin;
use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\DataController;




return function (App $app) {
    $container = $app->getContainer();
    //Merigister View
    $container['view'] = function ($container) {
        $view = new \Slim\Views\Twig('../templates', [
            'cache' => false
        ]);

        $router = $container->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

        return $view;
    };
    
    $app->get('/login', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        return AuthController::index($this, $request, $response,  $args);
    })->add(new isLogin());

    $app->post('/islogin', function (Request $request, Response $response, array $args) use ($container) {
        $reg = $request->getParsedBody();
        // return var_dump($reg);
        return AuthController::login($this, $request, $response,  [
            'data' => $reg
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
            'reg' => $reg
        ]);
    });

    $app->get('/logout', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        session_destroy();
        return AuthController::index($this, $request, $response,  $args);
    });
    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        return DashboardController::index($this, $request, $response,  $args);
    });
    $app->get('/Data', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        return DataController::index($this, $request, $response,  $args);
    })->add(new Auth());

    

    
    $app->post('/delete', function (Request $request, Response $response, array $args) use ($container) {
        $data = $request->getParsedBody();
        // $del = $container->db->delete('tbl_mahasiswa', [
        //     "id" => $data
        // ]);
        return DataController::delete($this, $request, $response,  [
            'data' => $data
        ]);
        return var_dump($data);
    });
    $app->get('/{id}/select', function (Request $request, Response $response, array $args) use ($container) {
        $data = $args['id'];

        return DataController::ubah_modal($this, $request, $response,  [
            'data' => $data
        ]);
    });

    $app->post('/tambah-data', function (Request $request, Response $response, array $args) use ($container) {
        $tambah = $request->getParsedBody();

        // return var_dump($tambah);
        return DataController::tambah_data($this, $request, $response,  [
            'tambah' => $tambah
        ]);
    });
    
    $app->get('/tampil-data', function (Request $req, Response $response, array $args) use ($container) {
        
         return DataController::tampil_data($this, $req, $response,  $args);
    });

    $app->post('/ubah', function (Request $request, Response $response, array $args) use ($container) {
        $data = $request->getParsedBody();
        return DataController::ubah_data($this, $request, $response,  [
            'data' => $data
        ]);
    });

    
};
