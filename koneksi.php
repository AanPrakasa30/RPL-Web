<?php

//deklasrasi variabel
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "kesehatan";    

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if($con) {
    // echo "Koneksi Berhasil!";
} else {
    echo "Koneksi Gagal! : ". mysqli_connect_error();
}

// function hapus("id"){
//     global $con;
//     mysqli_query($con,"DELETE FROM tbl_pasien WHERE id=$id");
//     return mysqli_affected_rows ($con)
// }