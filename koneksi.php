<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db = 'perdig';


$koneksi = mysqli_connect($host, $username, $password, $db) or die(mysqli_error($koneksi));
