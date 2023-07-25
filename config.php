<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "major_project";

$conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed");

$base_url = "http://localhost/Major%20Project/";
$my_email = "rockyfelix007@gmail.com";

$smtp['host'] = "smtp.gmail.com";
$smtp['user'] = "rockyfelix007@gmail.com";
$smtp['pass'] = "rgpbtzzvpholqowr";
$smtp['port'] = 465;
