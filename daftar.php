<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAFTAR</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <nav>
        <div class="wrapper">
            <div class="logo"><a href=''>RS. TADIKA</a></div>
            <a href="#" class="tombol-menu">
    <span class="garis"></span>
    <span class="garis"></span>
    <span class="garis"></span>
    </a>
            <div class="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="daftar.php">Daftar</a></li>
                    <li><a href="spes.php">Spesialis</a></li>
                    <li><a href="info.php">Info</a></li>    
                    <li><a href="login.php" class="tbl-pink">ADMIN</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <!-- untuk home -->
        <section id="home">
            <div class="kolom"></div>
        </section>

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
        $sukses = "Berhasil";
    }else{
        $error  = "Gagal Hapus Data";
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
        $error = "Datanya Kosong";
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
                $sukses = "Update Berhasil";
            } else {
                $error  = "Update Gagal";
            }
        } else { //untuk insert
            $sql1   = "insert into tbl_pasien(nama_pasien,alamat,poli) values ('$nama_pasien','$alamat','$poli')";
            $q1     = mysqli_query($con, $sql1);
            if ($q1) {
                $sukses     = "Berhasil Daftar";
            } else {
                $error      = "Gagal Daftar, Masukkan Hingga Lengkap";
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
    <title>Daftar Pasien</title>
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
  <!-- tutup -->
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                DAFTAR PASIEN
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
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">nama pasien</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">poli</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                $endpoint = 'http://localhost/RPLD/pasien.php';
                $data = file_get_contents($endpoint);
                $array_data = json_decode($data, true);

                for($i = 0; $i < count($array_data); $i++){
                    $ID = $array_data[$i]["ID"];
                    $nama_pasien = $array_data[$i]["nama_pasien"];
                    $alamat = $array_data[$i]["alamat"];
                    $poli = $array_data[$i]["poli"];
                ?>
                    <tr>
                        <th scope="row"><?=$ID;?></th>
                        <td scope="row"><?=$nama_pasien;?></td>
                        <td scope="row"><?=$alamat;?></td>
                        <td scope="row"><?=$poli;?></td>
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

    <div id="copyright">
        <div class="wrapper">
            &copy; 2023. <b>Lulus Try Hard.</b> All Rights Reserved.
        </div>
    </div>
    
</body>
</html>