import Vue from 'vue';
import Router from 'vue-router';
import firstPage from './components/pages/myFirstVuePage.vue'
import hooks from './components/pages/basic/hooks.vue'
import methods from './components/pages/basic/methods.vue'

Vue.use(Router);
const routes =[
    {
        path:'/mynamevuerouter',
        component: firstPage
    },
    {
        path:'/hooks',
        component: hooks
    }
    ,
    {
        path:'/methods',
        component: methods
    }
]

export default new Router({
    mode:'history',
    routes
});