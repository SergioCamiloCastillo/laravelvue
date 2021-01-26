import Vue from 'vue';
import Router from 'vue-router';

//ADMIN PAGES ROUTER
import home from '../js/components/pages/home.vue'
import tags from '../js/admin/pages/tags.vue'
import category from '../js/admin/pages/category'


Vue.use(Router);
const routes =[
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
    }
   
]

export default new Router({
    mode:'history',
    routes
});