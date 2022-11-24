<?php

namespace App\Model;

class MahasiswaModel{

    public static function insert($db, $data){
        $db->insert("tbl_mahasiswa",$data);
    }

}

?>