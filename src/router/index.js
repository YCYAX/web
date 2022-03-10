import Vue from "vue";
import VueRouter from "vue-router";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Information from "../views/Information.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Login",
    component: Login,
    meta: {
      title: "仁爱登陆系统",
    },
  },
  {
    path: "/Register",
    name: "Register",
    component: Register,
    meta: {
      title: "仁爱注册系统",
    },
  },
  {
    path: "/Information",
    name: "Information",
    component: Information,
    meta: {
      title: "仁爱查询系统",
    },
  },
];
const router = new VueRouter({
  mode: "history",
  routes,
});

export default router;
router.beforeEach((to, from, next) => {
  /* 路由发生变化修改页面title */
  if (to.meta.title) {
    document.title = to.meta.title;
  }
  next();
});
