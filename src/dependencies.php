<?php

use Slim\App;
use Medoo\Medoo;


return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    //Register DB
    $container['db'] = function($c) {
        $database = new Medoo([
            'database_type' => 'mysql',
            'server' => '127.0.0.1',
            'database_name' => 'belajar_db',
            'username' => 'root',
            'password' => '',
        ]);
        return $database;
    };

    //konfigurasi twig
    //Merigister View
    // $container['view'] = function ($container) {
    //     $view = new \Slim\Views\Twig('../templates',[
    //         'cache' => false
    //     ]);

    //     $router = $container->get('router');
    //     $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    //     $view->addExtension (new \Slim\Views\TwigExtension($router, $uri));

    //     return $view;
    // };
};
