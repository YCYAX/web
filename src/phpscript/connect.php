<?php
//头请求
header("Access-Control-Allow-Origin: *");
//定义数据库变量
$host = 'localhost';
$name = '****';
$password = '******';
$database = 'tjra';
$port = '3306';
//连接数据库
$connect = mysqli_connect($host, $name, $password, $database, $port);
//如果连接失败断开连接
if ($connect->connect_error) {
    die(mysqli_connect_error());
}
?>