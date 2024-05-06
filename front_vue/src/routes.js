


import HomeMain from './components/Home/HomeMain.vue';
import AppErrorComponent from './components/AppErrorComponent.vue';

import LoginUser from './components/User/LoginUser.vue';

/***** */
import OrderDetail from './components/Orders/OrderDetail.vue';
import OrderMain from './components/Orders/OrderMain';
import HistoricalMovement from './components/Inventory/HistoricalMovement';
import RecipeMain from './components/Recipe/RecipeMain.vue';
import HistoricalPurchase from './components/Inventory/HistoricalPurchase';
import MarkertMain from './components/Marker/MarkertMain';


const routes = [

    {
        path : '/',
        name : 'LoginUser',
        component: LoginUser,
    },
    {
        path: '/home',
        component: HomeMain,
        meta: { requiresAuth: true }
    },
    {
        path : '/marker',
        name : 'MarkertMain',
        component: MarkertMain,
        meta: { requiresAuth: true }

    },
    {
        path : '/order/:id?',
        name : 'OrderDetail',
        component: OrderDetail,
        meta: { requiresAuth: true }
    },
    {
        path: '/orders',
        name: 'OrderMain',
        component: OrderMain,
        meta: { requiresAuth: true }
    },
    {
        path: '/recipe',
        name: 'RecipeMain',
        component: RecipeMain,
        meta: { requiresAuth: true }
    },
    {
        path: '/history_movoments',
        name: 'HistoricalMovement',
        component: HistoricalMovement,
        meta: { requiresAuth: true }
    },
    {
        path: '/purchase',
        name: 'HistoricalPurchase',
        component: HistoricalPurchase ,
        meta: { requiresAuth: true }
    },
    {
        path: '/:pathMatch(.*)*',
        component: AppErrorComponent,

    },
    
];

export default routes;


