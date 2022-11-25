<?php

namespace App\Controller;

use App\Model\MahasiswaModel;

class DataController
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

        $hasvalidate = isset($_SESSION['hasvalidate']);
        unset($_SESSION['hasvalidate']);

        $app->view->render($rsp, 'data.html', [
            'username' => $_SESSION['username'],
            'id'     => $id,
            'data'   => $data,
            'jurusan' => $jurusan,
            'hasvalidate' => $hasvalidate
        ]);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_mahasiswa', [
            "id" => $id
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



        $select = $app->db->select('tbl_mahasiswa', [
            "[><]tbl_jurusan" => ["id_jurusan" => "jurusan_id"]
        ], [
            'id',
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


    public static function tampil_data($app, $req, $rsp, $args)
    {

        $data = $app->db->select('tbl_mahasiswa', [
            "[><]tbl_jurusan" => ["id_jurusan" => "jurusan_id"]
        ], [
            'id',
            'nama',
            'jenis_kelamin',
            'kota',
            'jurusan',
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

        $req->getParam('jurusan');

        $conditions = [
            "LIMIT" => [$start, $limit]
        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $conditions['OR'] = [
                'tbl_mahasiswa.nama[~]' => '%' . $search . '%',
                'tbl_mahasiswa.jenis_kelamin[~]' => '%' . $search . '%',
                'tbl_mahasiswa.kota[~]' => '%' . $search . '%',
                'tbl_jurusan.jurusan[~]' => '%' . $search . '%',
            ];
        }

        $mahasiswa = $app->db->select('tbl_mahasiswa', [
            "[><]tbl_jurusan" => ["id_jurusan" => "jurusan_id"]
        ], [
            'id',
            'nama',
            'jenis_kelamin',
            'kota',
            'jurusan',
        ], $conditions);

        $data = array();

        if (!empty($mahasiswa)) {
            $no = $req->getParam('start') + 1;
            foreach ($mahasiswa as $m) {

                $datas['no'] = $no . '.';
                $datas['nama'] = $m['nama'];
                $datas['jenis_kelamin'] = $m['jenis_kelamin'];
                $datas['kota'] = $m['kota'];
                $datas['jurusan'] = $m['jurusan'];

                if ($_SESSION['admin']['tipe'] == 1) {
                    $datas['aksi'] = '<button type="button" class="btn btn-warning item_edit" data="' . $m['id'] . '"><span class="fa fa-pencil-square-o"></span> Ubah</button> 
                    <button type="button" class="btn btn-danger item_hapus " data="' . $m['id'] . '"><span class="fa fa-trash-o"></span> Delete</button>';
                } else {
                    $datas['aksi'] = '';
                }

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

        MahasiswaModel::insert($app->db, $reg);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),

        );

        echo json_encode($json_data);
    }
    public static function tambah($app, $req, $rsp, $args)
    {

        $reg = $args['tambah'];
        $nama = $reg['tambah_nama'];

        $nama = $app->db->select('tbl_mahasiswa', '*', [
            'nama' => $nama
        ]);
        // var_dump($nama);
        // die();
        if ($nama == null) {
            $app->db->insert(
                'tbl_mahasiswa',
                $reg
            );

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
        $id = $reg['id'];
        $nama = $reg['nama'];
        $jenis_kelamin = $reg['jenis_kelamin'];
        $kota = $reg['kota'];
        $id_jurusan = $reg['id_jurusan'];

        $user_awal = $app->db->update('tbl_mahasiswa', [
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'kota' => $kota,
            'id_jurusan' => $id_jurusan,
        ], [
            'id' => $id
        ]);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }
}
