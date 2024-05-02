import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes'


/*
const state = reactive({
    service: [
        { baseUrl: 'http://127.0.0.1:8000/', token: 'token1' },
        { baseUrl: 'http://192.168.0.8:8000/', token: 'token2' },
        // Agrega más opciones según sea necesario
    ],
    selectedOptionIndex: 0, // Índice predeterminado
});
*/


import VueAxios from 'vue-axios';
import axios from 'axios';
//axios.defaults.baseURL = 'http://127.0.0.1:8000/';


const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);

window.Vue = app;

app.use(VueAxios, axios);



app.use(router);
app.mount('#app');



