<template>
  <AppHeader></AppHeader>

  <div class="content">

    <router-view></router-view>
  </div>



  <AppFooter></AppFooter>


</template>

<script>

import AppHeader from './components/AppHeader.vue';
import AppFooter from './components/AppFooter.vue';

//import AppSlider from './components/AppSlider.vue';


export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
  //  AppSlider,
   
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
  font-family: Avenir, Helvetica, Arial, sans-serif;
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
}

.wrapper {
  flex: 1;
}

.footer {
  flex-shrink: 0;
  margin-top: auto; 
}

@import '../public/css/bootstrap.min.css';
@import '../public/css/jav.css';
</style>

