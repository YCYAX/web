

## 一、技术架构

#### 前端

* vue-cli 4.5.15

  vue中axios处理请求，router处理多页面

#### 后端

* PHP 8.1.2

#### 数据库

* MySql 8.0.28

#### 运行环境

* nginx 1.20.2
* php-cgi

## 二、各项功能说明

### 2.1   注册功能说明及关键代码

#### 功能描述：

为用户提供在网站注册的功能

#### 开发思路：

![](C:\Users\YCYAW\Desktop\register.png)

#### 关键代码：

###### 前端

```javascript
add() {
      //DOM操作获取用户输入值
      ...
      //判断输入内容
      if (add_user_value === "" || add_userpassword_value === "") {
        alert("用户名或密码为空");
      } else {
        //axios配置
        this.axios({...}).then((res) => {
          //判断注册的名字是否重复
          if (res.data === "用户名重复") {
            //提示用户名重复
            alert("用户名重复");
          } else {
            //添加数据并跳转到登录界面
            alert("注册成功准备跳转到登录界面");
            this.$router.push({ path: "/" });
          }
        });
      }
    }
```

###### 后端

```php
<?php
//接受请求
function get_request() {...}
//主函数
function add($action)
{
    //验证请求
    if ($action == "add") {
        //接受前端axios的post传参
		...
        //数据库连接，头请求
        include ('connect.php');
        //查询申请注册的用户名
        $UserNameRepeat = $connect->query("SELECT `username` FROM `user` WHERE `username` = '$username'");
        //用户名重复判断
        if ($UserNameRepeat->num_rows == 0) {
            //注册成功
            $connect->query("INSERT INTO `user` (`username`, `userpassword`) VALUES ('$username', '$userpassword')");
        } else {
            //注册失败
            $response = '用户名重复';
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
}
?>
```



### 2.2  登录功能说明及关键代码

#### 功能描述：

为用户提供登录网站的功能

#### 开发思路：

![](C:\Users\YCYAW\Desktop\login.png)

#### 关键代码：

##### 前端

```javascript
login() {
      //DOM操作获取输入值
      ...
      //axios配置
      this.axios({...}).then((res) => {
        //验证判断
        if (res.data === "失败") {
            //登录失败
          alert("用户名或密码错误");
        } else {
            //登录成功
          this.$router.push({ path: "/Information" });
          alert("登录成功正在跳转");
        }
      });
    }
```

##### 后端

```php
<?php
//接受请求
function get_request(){...}
//登录验证
function login($action)
{
    //验证请求
    if ($action == "login") {
        //接受前端axios的post传参
		...
        //数据库连接，头请求
        include ('connect.php');
        $result = $connect->query("SELECT `username`, `userpassword` FROM user WHERE `username` = '$username' AND `userpassword` = '$userpassword' ");
        //登录验证
        if ($result->num_rows == 0) {
            //登录失败
            $response = "失败";
        } else{
            //登录成功
            $response = "成功";
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
?>
```



### 2.3  信息展示页底部按钮功能说明及关键代码

#### 功能描述：

为用户提供按钮切，换控制当前页数

#### 开发思路：

![](C:\Users\YCYAW\Desktop\button.png)

#### 关键代码：

##### 前端

```javascript
//计算按钮数
Button_number() {
      let length_number = this.list.length;
      this.button_number = 0;
      //长度小于等于10/整除/否则转化为字符串10进1
      if (length_number <= 10) {
        this.button_number++;
      } else if (length_number % 10 === 0) {
        this.button_number += length_number / 10;
      } else {
        this.button_number = Number(String(length_number).slice(0, -1)) + 1;
      }
    }
//向左
left() {
    //当前按钮为第一个
      if (this.index === 1) {
        document.getElementById(this.button_number).click();
      } else {
        document.getElementById(this.index - 1).click();
      }
    }
//向右
right() {
    //当前按钮为最后一个
      if (this.index === this.button_number) {
        document.getElementById("1").click();
      } else {
        document.getElementById(this.index + 1).click();
      }
    }
//当前按钮所显示的数据
this_page(item) {
    //css样式控制
      if (this.index > 0) {...}
      this.index = item;
      this.items.length = 0;
      let number = this.list.length;
      //是否为最后一页判断
      if (item === this.button_number) {
        if (number % 10 === 0) {
           //添加数据
          for (let i = 0; i < 10; i++) {
            this.items.push(this.list[i + (item - 1) * 10]);
          }
        } else {
          for (let i = 0; i < number % 10; i++) {
            this.items.push(this.list[i + (item - 1) * 10]);
          }
        }
      } else {
        for (let i = 0; i < 10; i++) {
          this.items.push(this.list[i + (item - 1) * 10]);
        }
      }
       //css提示当前所在页面
      document.getElementById(item).style.backgroundColor = "red";
    }
```

### 2.4  信息展示功能说明及关键代码

#### 功能描述：

为用户提供显示数据库全部内容功能，页面内容默认显示前10行，可以利用底部按钮切换页数

#### 开发思路：

![](C:\Users\YCYAW\Desktop\find.png)

#### 关键代码：

##### 前端

```javascript
find() {
      //axios的get请求
      this.Find_promise().then((res) => {
        //获取结果
        this.list = res.data.find;
          //计算器按钮
        this.Button_number();
          //默认显示第一页
        document.getElementById("1").click();
      });
    }
```

##### 后端

```php
//接受请求
function get_request(){...}
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
```



### 2.5 信息检索功能说明及关键代码

#### 功能描述：

为用户提供自定义搜索功能，可根据用户名和密码搜索。

#### 开发思路：

![](C:\Users\YCYAW\Desktop\search.png)

#### 关键代码：

##### 前端

```javascript
Search_promise() {
    //DOM操作获取输入值
    ...
    //判断输入是否为空
      if (search_userpassword_value === "" && search_user_value === "") {
        alert("登录号或密码不能都为空");
      } else {
          //返回axios
        return this.axios({...});
      }
    }
search() {
      //axios配置
      this.Search_promise().then((res) => {
        this.list = res.data.find;
          //验证后端传回数据
        if (this.list === "失败") {
          alert("没有找到您需要的数据");
        } else {
            //计算按钮
          this.Button_number();
          document.getElementById("1").click();
        }
      });
    },                          
```

##### 后端

```php
//接受请求
function get_request(){...}
//搜索
function search($action)
{
    //验证请求
    if ($action == "search") {
        //post参数
        ...
        $response = array();
        //数据库连接，头请求
        include('connect.php');
        //验证数据是否为空
        if ($username == "") {
            $result = $connect->query("SELECT `userid`, `username`, `userpassword` FROM `user` WHERE `userpassword` LIKE '%$userpassword%' ORDER BY length(REPLACE(`userpassword`,'$userpassword',''))/length(`userpassword`)");
        } elseif ($userpassword == "") {
            $result = $connect->query("SELECT `userid`, `username`, `userpassword` FROM `user` WHERE `username` LIKE '%$username%' ORDER BY length(REPLACE(`username`,'$username',''))/length(`username`)");
        } else {
            $result = $connect->query("SELECT `userid`, `username`, `userpassword` FROM `user` WHERE `username` LIKE '%$username%' AND `userpassword` LIKE '%$userpassword%' ORDER BY length(REPLACE(`username`,'$username',''))/length(`username`), length(REPLACE(`username`,'$username',''))/length(`username`)");
        }
        //转换数据
        $find = array();
        while ($row = $result->fetch_assoc()) {
            array_push($find, $row);
        }
        //返回结果
        if ($find == null) {
            $response["find"] = "失败";
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            $response['find'] = $find;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
}
```

### 2.6  信息删除功能说明及关键代码

#### 功能描述：

为用户提供删除信息功能

#### 开发思路：

![](C:\Users\YCYAW\Desktop\del.png)

#### 关键代码：

##### 前端

```javascript
del(user_id) {
      //axios配置
      this.axios({...}).then(() => {
        let old_number = this.list.length;
        //列表只剩最后一条数据
        if (old_number === 1) {
          this.Find_promise().then((res) => {
            this.list = res.data.find;
            alert("目前页面的数据已删除干净重载页面");
            window.location.reload();
          });
        } else {
           //渲染列表只剩最后一条数据
          if (this.items.length === 1) {
            let number = this.index;
            this.Find_promise().then((res) => {
              this.list = res.data.find;
              let new_number = this.list.length;
                //按钮数差1
              if (new_number === old_number - 1) {
                this.Button_number();
                document.getElementById(String(number - 1)).click();
              } else {
                  //axios配置
                this.Search_promise().then((res) => {
                  this.list = res.data.find;
                    //读取后端返回数据
                  if (this.list === "失败") {
                    alert("没有找到您需要的数据");
                  } else {
                    this.Button_number();
                    document.getElementById(String(number - 1)).click();
                  }
                });
              }
            });
          } else {
              //axios配置
            this.Find_promise().then((res) => {
              this.list = res.data.find;
              let new_number = this.list.length;
                //按钮数差1
              if (new_number === old_number - 1) {
                this.Button_number();
                let number = this.index;
                document.getElementById(String(number)).click();
              } else {
                  //axios配置
                this.Search_promise().then((res) => {
                  this.list = res.data.find;
                    //读取后端返回数据
                  if (this.list === "失败") {
                    alert("没有找到您需要的数据");
                  } else {
                    this.Button_number();
                    let number = this.index;
                    document.getElementById(String(number)).click();
                  }
                });
              }
            });
          }
        }
      });
    }
```



##### 后端

```php
//接受请求
function get_request(){...}
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
```

### 2.7  信息修改功能说明及关键代码

#### 功能描述：

为用户提供修改功能

#### 开发思路：

![](C:\Users\YCYAW\Desktop\change.png)

#### 关键代码：

##### 前端

```javascript
changeok() {
      let change_id = this.change_id;
      //DOM操作获取输入值
    	...
       //判断是否为空
      if (change_user_value === "" || change_userpassword_value === "") {
        alert("登录号或密码不能为空");
      } else {
          //axios配置
        this.axios({...}).then((res) => {
          let result = res.data.find;
            //获取后端传回值
          if (result === "重复") {
            alert("用户名重复了");
          } else {
              //改变显示修改控制台
            this.change_button = false;
            this.Find_promise().then((res) => {
              //获取结果
              this.list = res.data.find;
              document.getElementById(this.index).click();
            });
          }
        });
      }
    }
```

##### 后端

```php
//接受请求
function get_request(){...}
//修改
function change($action)
{
    //验证请求
    if ($action == "change") {
        //post传参
        ...
        $response = array();
        //数据库连接，头请求
        include('connect.php');
        $result = $connect->query("SELECT `username` FROM `user` WHERE `username` = '$username'");
        //判断是否重复
        if ($result->num_rows != 0) {
            $response["find"] = "重复";
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            //成功
            $connect->query("UPDATE `user` SET `username` = '$username', `userpassword` = '$userpassword' WHERE `userid` = '$userid'");
        }
    }
}
```



## 三、数据库说明

MySql版本8.0.28

数据库工具使用Navicat

数据表结构

| userid        | username    | userpassword |
| :------------ | ----------- | :----------- |
| 主键自增，int | varchar(18) | varchar(18)  |

表中数据为自动生成

![](C:\Users\YCYAW\Desktop\微信图片_20220210160043.png)

# 附录

### 源码包含生产文件
