<template>
  <div id="body">
    <input
      id="user"
      name="username"
      type="text"
      placeholder="登录号"
      maxlength="18"
      class="box"
    /><br />
    <input
      id="userpassword"
      name="userpassword"
      type="password"
      placeholder="密码"
      maxlength="18"
      class="box"
    /><br />
    <button id="submit" @click="login()">登录</button>
  </div>
</template>

<script>
export default {
  name: "login",
  data() {
    return {
      list: [],
    };
  },
  methods: {
    login() {
      //获取输入值
      let user_value = document.getElementById("user").value;
      let userpassword_value = document.getElementById("userpassword").value;
      //axios配置
      this.axios({
        method: "post",
        url: "/login.php",
        //get传参
        params: {
          action: "login",
        },
        //post数据
        data: {
          username: user_value,
          userpassword: userpassword_value,
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
        //验证判断
        if (res.data === "失败") {
          alert("用户名或密码错误");
        } else {
          this.$router.push({ path: "/Information" });
          alert("登录成功正在跳转");
        }
      });
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
