<template>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <div class="content">
    <AppHeader></AppHeader>
    <router-view></router-view>
    <AppFooter></AppFooter>
  </div>






</template>

<script>

import AppHeader from './components/AppHeader.vue';
import AppFooter from './components/AppFooter.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter
   
}
}

</script>

<style>
.content {
  flex: 1;
}

AppFooter {
  margin-top: auto;
}

#app {
  font-family: sans-serif, Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: rgb(255, 255, 255) !important;
  font-weight: 200;
}

.wrapper {
  flex: 1;
}

.footer {
  flex-shrink: 0;
  margin-top: auto; 
}

.btm-primary{
    background-color: #30aba9 !important;
}

@import '../public/css/bootstrap.min.css';
@import '../public/css/jav.css';
</style>

