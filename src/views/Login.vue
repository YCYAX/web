<template>
  <div id="body">
    <login class="body"></login>
    <div id="submit">
      <router-link to="/Register" >注册</router-link>
    </div>
  </div>
</template>

<script>
import login from "../components/login";
export default {
  name: "Login",
  components: {
    login,
  },
};
</script>

<style scoped>
#body {
  background: #34495e;
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
  width: 5%;
}
#submit:hover{
  background: #2ecc71;
}
#submit a {
  font-weight: bold;
  color: #2c3e50;
}

#submit a.router-link-exact-active {
  color: #42b983;
}
</style>
