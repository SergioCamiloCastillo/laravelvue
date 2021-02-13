import Vue from 'vue';
import Router from 'vue-router';
import usecom from './vuex/usecom'

//ADMIN PAGES ROUTER
import home from '../js/components/pages/home.vue'
import tags from '../js/admin/pages/tags.vue'
import category from '../js/admin/pages/category'
import adminusers from '../js/admin/pages/adminusers'



Vue.use(Router);
const routes =[
    {
        path:'/testvuex',
        component: usecom
    },
    {
        path:'/',
        component: home
    },
    {
        path:'/tags',
        component: tags
    },
    {
        path:'/category',
        component:category
    },
    {
        path:'/adminusers',
        component:adminusers
    }
   
]

export default new Router({
    mode:'history',
    routes
});