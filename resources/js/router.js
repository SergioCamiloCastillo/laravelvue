import Vue from 'vue';
import Router from 'vue-router';
import firstPage from './components/pages/myFirstVuePage.vue'
Vue.use(Router);
const routes =[
    {
        path:'/mynamevuerouter',
        component: firstPage
    }
]

export default new Router({
    mode:'history',
    routes
});