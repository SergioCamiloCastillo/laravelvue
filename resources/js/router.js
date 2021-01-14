import Vue from 'vue';
import Router from 'vue-router';
import firstPage from './components/pages/myFirstVuePage.vue'
import hooks from './components/pages/basic/hooks.vue'

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
]

export default new Router({
    mode:'history',
    routes
});