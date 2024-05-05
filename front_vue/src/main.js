import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes'

/*
const port = process.env.PORT || 8080;
app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});
*/

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

router.beforeEach((to, from, next) => {
    const isAuthenticatedUser = localStorage.getItem('access_token_0');
    const isAuthenticatedAdmin = localStorage.getItem('access_token_1');
    const isAuthenticatedSuper = localStorage.getItem('access_token_2');

    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (isAuthenticatedUser && isAuthenticatedAdmin && isAuthenticatedSuper) {
            next(); 
        } else {
            next('/'); 
        }
    } else {
        next(); 
    }
});

const app = createApp(App);

window.Vue = app;

app.use(VueAxios, axios);



app.use(router);
app.mount('#app');



