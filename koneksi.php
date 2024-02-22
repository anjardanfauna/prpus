<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db = 'perpus';


$koneksi = mysqli_connect($host, $username, $password, $db) or die(mysqli_error($koneksi));
