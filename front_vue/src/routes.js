


/*** new * */



import HomeMain from './components/Home/HomeMain.vue';
import AppErrorComponent from './components/AppErrorComponent.vue';

import LoginUser from './components/User/LoginUser.vue';

/***** */
import OrderDetail from './components/Orders/OrderDetail.vue';
import OrderMain from './components/Orders/OrderMain';
import HistoricalMovement from './components/Inventory/HistoricalMovement';
import RecipeMain from './components/Recipe/RecipeMain.vue';
import HistoricalPurchase from './components/Inventory/HistoricalPurchase';

const routes = [


    {
        path: '/home',
        component: HomeMain,
    },
    {
        path : '/login',
        name : 'LoginUser',
        component: LoginUser,
    },


    /***nuevas  */

    {
        path : '/order/:id?',
        name : 'OrderDetail',
        component: OrderDetail,
    },
    {
        path: '/orders',
        name: 'OrderMain',
        component: OrderMain
    },
    {
        path: '/recipe',
        name: 'RecipeMain',
        component: RecipeMain 
    },
    {
        path: '/history_movoments',
        name: 'HistoricalMovement',
        component: HistoricalMovement
    },
    {
        path: '/purchase',
        name: 'HistoricalPurchase',
        component: HistoricalPurchase 
    },
 

    {
        path: '/:pathMatch(.*)*',
        component: AppErrorComponent

    },
    


];

export default routes;


