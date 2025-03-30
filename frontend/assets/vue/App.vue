<template>
  <div>
    <h1>Hello, Vue.js in Symfony 7!</h1>
    <router-view></router-view>
  </div>
</template>

<script>
import Users from './components/Users.vue';

export default {
  name: 'App',
  components: {
    Users
  },
  mounted() {
    console.log('App mounted');
  },
  created() {
    console.log('App created');
  }
};
</script>
