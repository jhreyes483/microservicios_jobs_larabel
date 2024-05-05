import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes'



import VueAxios from 'vue-axios';
import axios from 'axios';
import { existToken } from './polices/auth';


const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if ( existToken() ) {
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



