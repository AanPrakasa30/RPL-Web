
<?php
//masukan data koneksi datbase
require 'Koneksi.php';

session_start();
// if(!isset($_SESSION['session_username'])){
//     header("location:login.php");
//     exit();
// }
// print_r($_SESSION);
// print_r($_COOKIE);

$nama_pasien    = "";
$alamat         = "";
$poli       = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $ID         = $_GET['ID'];
    $sql1       = "delete from tbl_pasien where ID = '$ID'";
    $q1         = mysqli_query($con,$sql1);
    if($q1){
        $sukses = "Berhasil di hapus datanya";
    }else{
        $error  = "Gagal hapus data mas";
    }
}
if ($op == 'edit') {
    $ID         = $_GET['ID'];
    $sql1       = "select * from tbl_pasien where ID = '$ID'";
    $q1         = mysqli_query($con, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama_pasien= $r1['nama_pasien'];
    $alamat     = $r1['alamat'];
    $poli   = $r1['poli'];

    if ($ID == '') {
        $error = "Datanya ngga ada mas";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nama_pasien= $_POST['nama_pasien'];
    $alamat     = $_POST['alamat'];
    $poli   = $_POST['poli'];

    if ($nama_pasien && $alamat && $poli) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update tbl_pasien set nama_pasien = '$nama_pasien',alamat = '$alamat',poli='$poli' where id = '$ID'";
            $q1         = mysqli_query($con, $sql1);
            if ($q1) {
                $sukses = "Datanya berhasil di update mas";
            } else {
                $error  = "Datanya gagal di update mas";
            }
        } else { //untuk insert
            $sql1   = "insert into tbl_pasien(nama_pasien,alamat,poli) values ('$nama_pasien','$alamat','$poli')";
            $q1     = mysqli_query($con, $sql1);
            if ($q1) {
                $sukses     = "Kita dapat data baru mas";
            } else {
                $error      = "Gagal dapat data baru";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data tbl_pasien</title>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>

  <!-- nav -->
  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
       <a href="logout.php"> <i class="fa-solid fa-arrow-left mt-2 ms-3 text-danger fs-4"></i></a>
  </li>
</ul>

  <!-- tutup -->
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=daftar.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=daftar.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama_pasien" class="col-sm-2 col-form-label">nama_pasien</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo $nama_pasien ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                     <div class="mb-3 row">
                        <label for="poli" class="col-sm-2 col-form-label">poli</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="poli" name="poli" value="<?php echo $poli ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                             <input class="btn btn-secondary me-2 ms-3" type="reset">
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary mx-auto p-3">
                Data Pasien
            </div>
             <form class="d-flex mb-3 mt-2 me-2 ms-3" method="post">
              <input class="form-control me-2 w-20" type="search" name="cari" value="<?=@$_POST['cari']?>" placeholder="Cari data" aria-label="Search">
              <button class="btn btn-info" type="submit" name="vcari">Search</button>
            </form>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">nama pasien</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">poli</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $urut   = 1;

                        if (isset($_POST['vcari'])) {
                          //tampil data 
                          $cari = $_POST["cari"];
                          $sql2 = "select * from tbl_pasien WHERE nama_pasien like '%$cari%' or alamat like '%$cari%' or poli like '%$cari%' order by ID desc";
                        }else{
                            $sql2   = "select * from tbl_pasien order by ID desc";
                        }
                      
                        $q2     = mysqli_query($con, $sql2);
                       
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $ID         = $r2['ID'];
                            $nama_pasien= $r2['nama_pasien'];
                            $alamat     = $r2['alamat'];
                            $poli   = $r2['poli'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama_pasien ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $poli ?></td>
                                <td scope="row ">
                                    <a href="daftar.php?op=edit&ID=<?php echo $ID ?>"><button type="button" class="btn btn-warning ">Edit</button></a>
                                    <a href="daftarpunyaadmin.php?op=delete&ID=<?php echo $ID?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger mt-2">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>
