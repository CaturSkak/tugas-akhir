<?php
namespace App\Controller;


class DashboardController{
    //buat function index()
    public static function index($app, $req, $rsp, $args){
        $username = $_SESSION['username'];

        $id = $app->db->get('tbl_admin','*',[
            "username" => $username
        ]);
        $data = $app->db->select('tbl_mahasiswa',[
            "[><]tbl_jurusan"=>["id_jurusan" => "jurusan_id"]
        ],[
            'id',
            'nama',
            'jenis_kelamin',
            'kota',
            'jurusan',
        ]);
        // var_dump($data);
        $jurusan = $app->db->select('tbl_jurusan','*');
        
        $app->view->render($rsp, 'index.html', [
            'username' => $_SESSION['username'],
            'id'     => $id,
            'data'   => $data,
            'jurusan'=> $jurusan
        ]);
    }

    public static function ubah($app, $req, $rsp, $args){
        $id = $args['data'];

       

        $select = $app->db->select('tbl_mahasiswa',[
            "[><]tbl_jurusan"=>["id_jurusan" => "jurusan_id"]
        ],[
            'nama',
            'jenis_kelamin',
            'kota',
            'jurusan',
            'id_jurusan'
        ],[
            "tbl_mahasiswa.id"=>$id
        ]);
        return $rsp->withJson($select);
        // return $rsp->withJson($data);

    }

    public static function delete($app, $req, $rsp, $args){
        $id = $args['data'];
        $data = $app->db->delete('tbl_mahasiswa',[
            "user_id"=>$id
        ]);
        return var_dump($data);
    }
   
        
    
}

?>