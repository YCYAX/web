<template>
  <div id="app">
    <div id="bottom">
      <bottom></bottom>
    </div>
    <div id="main">
    <router-view/>
    </div>
  </div>
</template>

<style>
#app {
  text-align: center;
}
#main {
  margin-top: 10%;
}
</style>
<script>
import bottom from "@/components/bottom";
export default {
  components: {
    bottom,
  },
};
</script>
