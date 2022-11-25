<?php

namespace App\Controller;

class ContactController
{
    //buat function index()
    public static function index($app, $req, $rsp, $args)
    {
        // var_dump($_SESSION['admin']['tipe']);
        $username = $_SESSION['username'];

        $id = $app->db->get('tbl_pengguna', '*', [
            "username" => $username
        ]);
        
      

        $hasvalidate = isset($_SESSION['hasvalidate']);
        unset($_SESSION['hasvalidate']);

        $app->view->render($rsp, 'contact.html', [
            'username' => $_SESSION['username'],
            'id'     => $id,

            'hasvalidate' => $hasvalidate
        ]);
    }

}
