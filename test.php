<?php

$endpoint = 'http://localhost/RPLD/pasien.php';
$data = file_get_contents($endpoint);
$array_data = json_decode($data, true);

print_r($array_data);