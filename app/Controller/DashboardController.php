<?php

namespace App\Controller;


class DashboardController
{
    //buat function index()
    public static function index($app, $req, $rsp, $args)
    {
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

        $app->view->render($rsp, 'index.html', [
            'username' => $_SESSION['username'],
            'id'     => $id,
            'data'   => $data,
            'jurusan' => $jurusan
        ]);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_mahasiswa', [
            "id" => $id
        ]);
        return $rsp->withJson($del);
        // return $rsp->withJson($data);

    }
    public static function ubah($app, $req, $rsp, $args)
    {
        $id = $args['data'];



        $select = $app->db->select('tbl_mahasiswa', [
            "[><]tbl_jurusan" => ["id_jurusan" => "jurusan_id"]
        ], [
            'nama',
            'jenis_kelamin',
            'kota',
            'jurusan',
            'id_jurusan'
        ], [
            "tbl_mahasiswa.id" => $id
        ]);
        return $rsp->withJson($select);
        // return $rsp->withJson($data);

    }

    public static function tambah_data($app, $req, $rsp, $args)
    {

        $reg = $args['tambah'];

        $nama = $reg['name'];
        $jenis_kelamin = $reg['kelamin'];
        $kota = $reg['kta'];
        $id_jurusan = $reg['jrs'];

        // $data = $app->db->insert('tbl_mahasiswa', [
        //     'nama' => $nama,
        //     'jenis_kelamin' => $jenis_kelamin,
        //     'kota' => $kota,
        //     'id_jurusan' => $id_jurusan
        // ]);
        return var_dump($reg);
    }
}
