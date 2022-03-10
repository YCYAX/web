<?php
//接受请求
function get_request()
{
    if (isset($_GET["action"])) {
        return $_GET['action'];
    }
}
//添加数据
function add($action)
{
    //验证请求
    if ($action == "add") {
        $username = $_POST['add_username'];
        $userpassword = $_POST['add_userpassword'];
        //数据库连接，头请求
        include ('connect.php');
        $UserNameRepeat = $connect->query("SELECT `username` FROM `user` WHERE `username` = '$username'");
        //用户名重复判断
        if ($UserNameRepeat->num_rows == 0) {
            $connect->query("INSERT INTO `user` (`username`, `userpassword`) VALUES ('$username', '$userpassword')");
        } else {
            $response = '用户名重复';
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
}
//调用函数
$action_get = get_request();
add($action_get);