<?php

namespace App\Controller;

use Medoo\Medoo;
// use Middleware\Auth;
// use PHPUnit\Framework\Constraint\Count;

class AuthController
{
    //buat function index()
    public static function index($app, $req, $rsp, $args)
    {

        $app->view->render($rsp, 'login.html', $args);
    }
    public static function logout($app, $req, $rsp, $args)
    {
        $app->view->render($rsp, 'login.html', $args);
    }
    public static function admin($app, $req, $rsp, $args)
    {

        $app->view->render($rsp, 'index.html', $args);
    }
    public static function register($app, $req, $rsp, $args)
    {

        $app->view->render($rsp, 'register.html', $args);
    }
    public static function form_register($app, $req, $rsp, $args)
    {

        $reg = $args['reg'];
        // return var_dump($reg);
        $first_name = $reg['first_name'];
        $last_name = $reg['last_name'];
        $username = $reg['username'];
        $password = md5($reg['password']);

        $user_awal = $app->db->select('tbl_admin', '*', [
            'username' => $username
        ]);
        // return var_dump($user_awal);
        if ($user_awal == null) {
            $app->db->insert('tbl_admins', [
                'username' => $username,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'password' => $password
            ]);
            $app->view->render($rsp, 'login.html', [
                'hasRegistered' => true
            ]);
        } else {
            $app->view->render($rsp, 'register.html', [
                'hasData' => true
            ]);
        }
    }

    public static function login($app, $req, $rsp, $args)
    {
        $log = $args['data'];

        $username = $log['username'];
        $password = md5($log['password']);

        // return var_dump($password);


        $valid = $app->db->get('tbl_admins', '*', [
            "username" => $username,
            "password" => $password
        ]);

        if ($valid == null) {
            $app->view->render($rsp, 'login.html', [
                'notvalidate' => true
            ]);
        } else {
            $_SESSION['username'] = $username = $log['username'];

            $data = $app->db->select('tbl_mahasiswa', [
                "[><]tbl_jurusan" => ["id_jurusan" => "jurusan_id"]
            ], [
                'id',
                'nama',
                'jenis_kelamin',
                'kota',
                'jurusan'
            ]);
            $jurusan = $app->db->select('tbl_jurusan', '*');
            // var_dump($data);
            // die();
            $app->view->render($rsp, 'index.html', [
                'hasvalidate' => true,
                'username' => $_SESSION['username'],
                'data'   => $data,
                'jurusan' => $jurusan
            ]);
        }
    }
}
