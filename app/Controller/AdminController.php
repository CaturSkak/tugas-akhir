<?php

namespace App\Controller;

use App\Model\MahasiswaModel;

class AdminController
{
    //buat function index()
    public static function index($app, $req, $rsp, $args)
    {
        $username = $_SESSION['username'];
        

        $id = $app->db->get('tbl_pengguna', '*', [
            "username" => $username
        ]);
        $data = $app->db->select('tbl_pengguna', [
            "[><]tbl_tipe_pengguna" => ["tipe" => "tipe_id"]
        ], [
            'user_id',
            'first_name',
            'last_name',
            'username',
            'tipe',
            'pengguna'
        ]);
        // var_dump($data);
        // $pengguna = $app->db->select('tbl_pengguna', '*');

        
   

        $app->view->render($rsp, 'admin.html', [
            'username' => $_SESSION['username'],
            'id'     => $id,
            'data'   => $data,
          
        ]);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_pengguna', [
            "user_id" => $id
        ]);

        // return $rsp->withJson($del);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function ubah_modal($app, $req, $rsp, $args)
    {
        $id = $args['data'];

        $select = $app->db->select('tbl_pengguna', [
            "[><]tbl_tipe_pengguna" => ["tipe" => "tipe_id"]
        ], [
            'user_id',
            'username',
            'first_name',
            'last_name',
            'tipe',
            'pengguna'
        ], [
            "tbl_pengguna.user_id" => $id
        ]);

        return $rsp->withJson($select);
        // return $rsp->withJson($data);

    }


    public static function tampil_data($app, $req, $rsp, $args)
    {

        $data = $app->db->select('tbl_pengguna', [
            "[><]tbl_tipe_pengguna" => ["tipe" => "tipe_id"]
        ], [
            'user_id',
            'username',
            'first_name',
            'last_name',
            'pengguna'
        ]);


        $columns = array(
            0 => 'id',
        );

        $totaldata = count($data);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];

        // $req->getParam('jurusan');

        $conditions = [
            "LIMIT" => [$start, $limit]
        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $conditions['OR'] = [
                'tbl_pengguna.username[~]' => '%' . $search . '%',
                'tbl_pengguna.first_name[~]' => '%' . $search . '%',
                'tbl_pengguna.last_name[~]' => '%' . $search . '%',
                'tbl_pengguna.pengguna[~]' => '%' . $search . '%',
            ];
        }

        $mahasiswa = $app->db->select('tbl_pengguna', [
            "[><]tbl_tipe_pengguna" => ["tipe" => "tipe_id"]
        ], [
            'user_id',
            'username',
            'first_name',
            'last_name',
            'pengguna'
        ]
        , $conditions);

        $data = array();

        if (!empty($mahasiswa)) {
            $no = $req->getParam('start') + 1;
            foreach ($mahasiswa as $m) {

                $datas['no'] = $no . '.';
                $datas['username'] = $m['username'];
                $datas['first_name'] = $m['first_name'];
                $datas['last_name'] = $m['last_name'];
                $datas['pengguna'] = $m['pengguna'];
                $datas['aksi'] = 
                    '<button type="button" class="btn btn-warning item_edit" data="' . $m['user_id'] . '"><span class="fa fa-pencil-square-o"></span> Ubah</button> 
                    <button type="button" class="btn btn-danger item_hapus " data="' . $m['user_id'] . '"><span class="fa fa-trash-o"></span> Delete</button>';
                

                $data[] = $datas;
                $no++;
            }
        }

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public static function tambah_data($app, $req, $rsp, $args)
    {

        $reg = $args['tambah'];

        $app->db->insert('tbl_pengguna',$reg);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),

        );

        echo json_encode($json_data);
    }
    public static function tambah($app, $req, $rsp, $args)
    {

        $reg = $args['tambah'];
        $nama = $reg['tambah_nama'];
        $jenis_kelamin = $reg['tambah_kelamin'];
        $kota = $reg['tambah_kota'];
        $jurusan = $reg['tambah_jurusan'];
        
        $nama_db = $app->db->select('tbl_pengguna', '*', [
            'nama' => $nama
        ]);
        // var_dump($nama);
        // die();
        if ($nama_db == null) {
            $data = $app->db->insert(
                'tbl_pengguna',[
                    'nama' => $nama,
                    'jenis_kelamin' => $jenis_kelamin,
                    'kota' => $kota,
                    'id_jurusan' => $jurusan
                ]);
                // return var_dump($data);
            $_SESSION['hasvalidate'] = true;
            return $rsp->withRedirect('/Data');
        } else {
            $_SESSION['notvalidate'] = true;
            return $rsp->withRedirect('/Data');
        }
    }

    public static function ubah_data($app, $req, $rsp, $args)
    {

        $reg = $args['data'];
        // return var_dump($reg);
        $id = $reg['user_id'];
        $username = $reg['username'];
        $first_name = $reg['first_name'];
        $last_name = $reg['last_name'];
        $tipe_pengguna = $reg['tipe_pengguna'];

        $user_awal = $app->db->update('tbl_pengguna', [
            'username' => $username,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'tipe' => $tipe_pengguna,
        ], [
            'user_id' => $id
        ]);
        // return var_dump($first_name);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }
}
