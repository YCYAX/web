<?php
//接受请求
function get_request()
{
    if (isset($_GET["action"])) {
        return $_GET['action'];
    }
}
//登录验证
function login($action)
{
    //验证请求
    if ($action == "login") {
        $username = $_POST['username'];
        $userpassword = $_POST['userpassword'];
        //数据库连接，头请求
        include ('connect.php');
        $result = $connect->query("SELECT `username`, `userpassword` FROM user WHERE `username` = '$username' AND `userpassword` = '$userpassword' ");
        if ($result->num_rows == 0) {
            $response = "失败";
        } else{
            $response = "成功";
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
//调用函数
$action_get = get_request();
login($action_get);
?>

