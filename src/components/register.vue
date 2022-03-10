<template>
  <div>
    <div id="body">
      <input
        id="add_user"
        name="username"
        type="text"
        placeholder="登录号长度限制为18"
        maxlength="18"
        class="box"
      /><br />
      <input
        id="add_userpassword"
        name="userpassword"
        type="password"
        placeholder="密码长度限制为18"
        maxlength="18"
        class="box"
      /><br />
      <button id="submit" @click="add()">注册</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "register",
  methods: {
    add() {
      //获取输入值
      let add_user_value = document.getElementById("add_user").value;
      let add_userpassword_value =
        document.getElementById("add_userpassword").value;
      //判断输入内容
      if (
        add_user_value.trim() === "" ||
        add_userpassword_value.trim() === ""
      ) {
        alert("用户名或密码为空");
      } else {
        //axios配置
        this.axios({
          method: "post",
          url: "/register.php",
          //get传参
          params: {
            action: "add",
          },
          //post数据
          data: {
            add_username: add_user_value,
            add_userpassword: add_userpassword_value,
          },
          //头模拟
          headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=utf-8;",
          },
          //数据转换
          transformRequest: [
            (data = {}) =>
              Object.entries(data)
                .map((ent) => ent.join("="))
                .join("&"),
          ],
        }).then((res) => {
          //判断是否重复
          if (res.data === "用户名重复") {
            alert("用户名重复");
          } else {
            //添加数据并跳转到登录界面
            alert("注册成功准备跳转到登录界面");
            this.$router.push({ path: "/" });
          }
        });
      }
    },
  },
};
</script>
<style scoped>
#body{
  margin: 0;
  padding: 0;
  font-family: sans-serif;
  background: #34495e;
}

.box{
  width: 300px;
  padding: 40px;
  top: 50%;
  left: 50%;
  background: #191919;
  text-align: center;
}
.box {
  border:0;
  background: none;
  display: block;
  margin: 20px auto;
  text-align: center;
  border: 2px solid #3498db;
  padding: 14px 10px;
  width: 200px;
  outline: none;
  color: white;
  border-radius: 24px;
  transition: 0.25s;
}
.box:focus {
  width: 280px;
  border-color: #2ecc71;
}
#submit{
  border:0;
  background: none;
  display: block;
  margin: 20px auto;
  text-align: center;
  border: 2px solid #2ecc71;
  padding: 14px 40px;
  outline: none;
  color: white;
  border-radius: 24px;
  transition: 0.25s;
  cursor: pointer;
}
#submit:hover{
  background: #2ecc71;
}
</style>
