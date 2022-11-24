<?php

namespace App\Controller;
use App\Model\MahasiswaModel;

class DashboardController
{
    //buat function index()
    public static function index($app, $req, $rsp, $args)
    {
        // var_dump($_SESSION['admin']['tipe']);
        $username = $_SESSION['username'];

        $id = $app->db->get('tbl_admins', '*', [
            "username" => $username
        ]);
        $data = $app->db->select('tbl_mahasiswa', [
            "[><]tbl_jurusan" => ["id_jurusan" => "jurusan_id"]
        ], [
            'id',
            'nama',
            'jenis_kelamin',
            'kota',
            'jurusan',
        ]);
        // var_dump($data);
        $jurusan = $app->db->select('tbl_jurusan', '*');

        $hasvalidate = isset($_SESSION['hasvalidate']);
        unset($_SESSION['hasvalidate']);

        $app->view->render($rsp, 'index.html', [
            'username' => $_SESSION['username'],
            'id'     => $id,
            'data'   => $data,
            'jurusan' => $jurusan,
            'hasvalidate' => $hasvalidate
        ]);
    }

}
