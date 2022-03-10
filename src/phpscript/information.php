<?php
//接受请求
function get_request()
{
    if (isset($_GET["action"])) {
        return $_GET['action'];
    }
}
//展示所有
function find_all($action)
{
    $response = array();
    //验证请求
    if ($action == "find") {
        //数据库连接，头请求
        include ('connect.php');
        $result = $connect->query("SELECT * FROM `user`");
        $find = array();
        //转换格式
        while ($row = $result->fetch_assoc()) {
            array_push($find, $row);
        }
        //存储数据
        $response['find'] = $find;
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
//删除数据
function del($action)
{
    //验证请求
    if ($action == "del") {
        $userid = $_POST['del_id'];
        //数据库连接，头请求
        include('connect.php');
        $connect->query("DELETE FROM `user` WHERE `userid` = '$userid'");
    }
}
//搜索
function search($action)
{
    //验证请求
    if ($action == "search") {
        $username = $_POST['search_username'];
        $userpassword = $_POST['search_userpassword'];
        $response = array();
        include('connect.php');
        if ($username == "") {
            $result = $connect->query("SELECT `userid`, `username`, `userpassword` FROM `user` WHERE `userpassword` LIKE '%$userpassword%' ORDER BY length(REPLACE(`userpassword`,'$userpassword',''))/length(`userpassword`)");
        } elseif ($userpassword == "") {
            $result = $connect->query("SELECT `userid`, `username`, `userpassword` FROM `user` WHERE `username` LIKE '%$username%' ORDER BY length(REPLACE(`username`,'$username',''))/length(`username`)");
        } else {
            $result = $connect->query("SELECT `userid`, `username`, `userpassword` FROM `user` WHERE `username` LIKE '%$username%' AND `userpassword` LIKE '%$userpassword%' ORDER BY length(REPLACE(`username`,'$username',''))/length(`username`), length(REPLACE(`username`,'$username',''))/length(`username`)");
        }
        $find = array();
        while ($row = $result->fetch_assoc()) {
            array_push($find, $row);
        }
        if ($find == null) {
            $response["find"] = "失败";
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            $response['find'] = $find;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
}
//修改
function change($action)
{
    //验证请求
    if ($action == "change") {
        $userid = $_POST['change_id'];
        $username = $_POST['change_username'];
        $userpassword = $_POST['change_userpassword'];
        $response = array();
        include('connect.php');
        $result = $connect->query("SELECT `username` FROM `user` WHERE `username` = '$username'");
        if ($result->num_rows != 0) {
            $response["find"] = "重复";
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            $connect->query("UPDATE `user` SET `username` = '$username', `userpassword` = '$userpassword' WHERE `userid` = '$userid'");
        }
    }
}
//调用函数
$action_get = get_request();
find_all($action_get);
del($action_get);
search($action_get);
change($action_get);
?>