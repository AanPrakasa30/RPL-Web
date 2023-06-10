<?php
include "koneksi.php";

$request = $_SERVER["REQUEST_METHOD"];
switch ($request){
    case"GET":
        $sql= "SELECT * FROM tbl_pasien";
        $query = mysqli_query($con, $sql);
        if($query){
            $data=array();
            while($row= mysqli_fetch_object($query)){
                $data[]=$row;
            }
            echo json_encode($data);
        }
        break;
}

?>

