<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'jooncorporation';

$con = mysqli_connect($host, $user, $password, $database) or die("Connection Failed" . mysqli_error($con));
