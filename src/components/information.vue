<template>
  <div id="all">
    <div v-if="change_button" id="change">
      <div class="change">
        <input
          id="change_username"
          name="change_username"
          type="text"
          placeholder="登录号"
          maxlength="18"
          class="box"
        />
      </div>
      <div class="change">
        <input
          id="change_userpassword"
          name="change_userpassword"
          type="password"
          placeholder="密码"
          maxlength="18"
          class="box"
        />
      </div>
      <div class="change">
        <button class="submit" @click="changeok()">确定</button>
      </div>
      <div class="change">
        <p class="submit">当前修改id{{ change_id }}</p>
      </div>
    </div>
    <div id="search">
      <div class="search">
        <input
          id="username"
          name="searchusername"
          type="text"
          placeholder="登录号"
          maxlength="18"
          class="box"
        />
      </div>
      <div class="search">
        <input
          id="userpassword"
          name="searchuserpassword"
          type="text"
          placeholder="密码"
          maxlength="18"
          class="box"
        />
      </div>
      <div class="search">
        <button class="submit" @click="search()">搜索</button>
      </div>
      <div class="search">
        <button class="submit" id="find" @click="find()">全部</button>
      </div>
    </div>
    <div id="searchnext">
      <table id="table">
        <tr id="tr">
          <th>内部id</th>
          <th>登录名</th>
          <th>密码</th>
          <th>修改</th>
          <th>删除</th>
        </tr>
        <tr id="trtr" v-for="item in items" :key="item.userid" >
          <td class="trtdid">{{ item.userid }}</td>
          <td class="trtdname">{{ item.username }}</td>
          <td class="trtd">{{ item.userpassword }}</td>
          <td class="trtd">
            <button class="beautiful_button" @click="change(item.userid)">
              修改
            </button>
          </td>
          <td class="trtd">
            <button class="beautiful_button" @click="del(item.userid)">
              删除
            </button>
          </td>
        </tr>
      </table>
      <div id="button">
        <div class="button">
          <button class="gradient-button-2" @click="left()">《</button>
        </div>
        <div class="button">
          <button class="gradient-button-2" @click="right()">》</button>
        </div>
        <div class="button" v-for="item in button_number" :key="item">
          <button
            class="gradient-button-2"
            :id="item"
            @click="this_page(item)"
          >
            {{ item }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "information",
  data() {
    return {
      list: [],
      button_number: 0,
      items: [],
      index: 0,
      change_button: false,
      change_id: 0,
    };
  },
  methods: {
    left() {
      if (this.index === 1) {
        document.getElementById(this.button_number).click();
      } else {
        document.getElementById(this.index - 1).click();
      }
    },
    right() {
      if (this.index === this.button_number) {
        document.getElementById("1").click();
      } else {
        document.getElementById(this.index + 1).click();
      }
    },
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
    },
    Find_promise() {
      return this.axios({
        //get请求
        type: "get",
        url: "/information.php",
        //参数配置
        params: {
          action: "find",
        },
      });
    },
    Search_promise() {
      let search_user_value = document.getElementById("username").value;
      let search_userpassword_value =
        document.getElementById("userpassword").value;
      if (search_userpassword_value === "" && search_user_value === "") {
        alert("登录号或密码不能都为空");
      } else {
        return this.axios({
          method: "post",
          url: "/information.php",
          //get传参
          params: {
            action: "search",
          },
          //post数据
          data: {
            search_username: search_user_value,
            search_userpassword: search_userpassword_value,
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
        });
      }
    },
    find() {
      this.Find_promise().then((res) => {
        //获取结果
        this.list = res.data.find;
        this.Button_number();
        document.getElementById("1").click();
      });
    },
    this_page(item) {
      if (this.index > 0) {
        document.getElementById(this.index).style.backgroundColor = "white";
        document.getElementById(String(this.index)).style.borderImage =
          "linear-gradient(to right, orangered, transparent)";
        document.getElementById(String(this.index)).style.borderImageSlice =
          "1";
      }
      this.index = item;
      this.items.length = 0;
      let number = this.list.length;
      if (item === this.button_number) {
        if (number % 10 === 0) {
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
      document.getElementById(item).style.backgroundColor = "red";
    },
    del(user_id) {
      //axios配置
      this.axios({
        method: "post",
        url: "/information.php",
        //get传参
        params: {
          action: "del",
        },
        //post数据
        data: {
          del_id: user_id,
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
      }).then(() => {
        let old_number = this.list.length;
        //渲染列表为1
        if (old_number === 1) {
          this.Find_promise().then((res) => {
            this.list = res.data.find;
            alert("目前页面的数据已删除干净重载页面");
            document.getElementById("find").click();
          });
        } else {
          if (this.items.length === 1) {
            let number = this.index;
            this.Find_promise().then((res) => {
              //获取结果
              this.list = res.data.find;
              let new_number = this.list.length;
              if (new_number === old_number - 1) {
                this.Button_number();
                document.getElementById(String(number - 1)).click();
              } else {
                this.Search_promise().then((res) => {
                  this.list = res.data.find;
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
            this.Find_promise().then((res) => {
              //获取结果
              this.list = res.data.find;
              let new_number = this.list.length;
              if (new_number === old_number - 1) {
                this.Button_number();
                let number = this.index;
                document.getElementById(String(number)).click();
              } else {
                this.Search_promise().then((res) => {
                  this.list = res.data.find;
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
    },
    search() {
      this.Search_promise().then((res) => {
        this.list = res.data.find;
        if (this.list === "失败") {
          alert("没有找到您需要的数据");
        } else {
          this.Button_number();
          document.getElementById("1").click();
        }
      });
    },
    change(user_id) {
      this.change_button = true;
      this.change_id = user_id;
    },
    changeok() {
      let change_id = this.change_id;
      let change_user_value = document.getElementById("change_username").value;
      let change_userpassword_value = document.getElementById(
        "change_userpassword"
      ).value;
      if (change_user_value.trim() === "" || change_userpassword_value.trim() === "") {
        alert("登录号或密码不能为空");
      } else {
        this.axios({
          method: "post",
          url: "/information.php",
          //get传参
          params: {
            action: "change",
          },
          //post数据
          data: {
            change_username: change_user_value,
            change_userpassword: change_userpassword_value,
            change_id: change_id,
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
          let result = res.data.find;
          if (result === "重复") {
            alert("用户名重复了");
          } else {
            this.change_button = false;
            this.Find_promise().then((res) => {
              //获取结果
              this.list = res.data.find;
              document.getElementById(this.index).click();
            });
          }
        });
      }
    },
  },
  mounted() {
    //axios配置
    this.Find_promise().then((res) => {
      //获取结果
      this.list = res.data.find;
      this.Button_number();
    });
    setTimeout(function () {
      document.getElementById("1").click();
    }, 500);
  },
};
</script>

<style scoped>
.change p {
  margin: 2px;
}
.change button,
.change input {
  margin-right: 40%;
  margin-left: 40%;
}
#change {
  height: 60px;
  margin: 2px auto;
}
.change {
  float: left;
  width: 25%;
}
.gradient-button-2 {
  border: solid 4px transparent;
  border-image: linear-gradient(to right, orangered, transparent);
  border-image-slice: 1;
}
.gradient-button-2:hover {
  color: white;
  background-image: linear-gradient(to right, orangered, transparent);
  border-right: none;
}
.beautiful_button {
  display: inline-block;
  padding: 8px 8px;
  font-size: 8px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #4caf50;
  border: none;
  border-radius: 15px;
  box-shadow: 0 9px #999;
}
.beautiful_button:hover {
  background-color: #3e8e41;
}
.beautiful_button:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
#search {
  height: 60px;
  margin: 2px auto;
}
.search {
  float: left;
  width: 25%;
}
.search button,
.search input {
  margin-right: 40%;
  margin-left: 40%;
}
.submit {
  background: none;
  display: block;
  text-align: center;
  border: 5px solid #2ecc71;
  padding: 5px 10px;
  outline: none;
  color: white;
  border-radius: 24px;
  transition: 0.25s;
  cursor: pointer;
}
.submit:hover {
  background: #2ecc71;
}
.box {
  width: 50px;
  padding: 20px;
  top: 10%;
  left: 50%;
  background: #191919;
  text-align: center;
}
.box {
  background: none;
  display: block;
  text-align: center;
  border: 2px solid #3498db;
  padding: 10px 10px;
  width: 50px;
  outline: none;
  color: white;
  border-radius: 25px;
  transition: 0.25s;
}
.box:focus {
  width: 80%;
  border-color: #2ecc71;
}
#all {
  margin-left: 20%;
  margin-right: 20%;
}
.trtdid:first-child {
  color: coral;
}
.trtdname {
  color: rosybrown;
}
#trtr:hover {
  background-color: #ccc;
}
#trtr:nth-child(odd) {
  background-color: #eee;
}
#tr {
  background-color: #008c8c;
  color: #fff;
}
th,
td {
  border: 1px solid #999;
  text-align: center;
  padding: 10px 0;
  width: 10%;
}
#button {
  height: 30px;
  margin-left: 10%;
  margin-right: 10%;
}
.button {
  float: left;
  width: 50px;
  margin-top: 5px;
  margin-bottom: 5px;
}
#table {
  border-collapse: collapse;
  margin: auto;
  top: 0;
  left: 50%;
  right: 0;
  bottom: 0;
}
</style>
