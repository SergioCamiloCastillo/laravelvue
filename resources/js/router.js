import Vue from "vue";
import Router from "vue-router";
import usecom from "./vuex/usecom";

//ADMIN PAGES ROUTER
import home from "../js/components/pages/home.vue";
import tags from "../js/admin/pages/tags.vue";
import category from "../js/admin/pages/category";
import adminusers from "../js/admin/pages/adminusers";
import login from "./admin/pages/login.vue";
import role from "./admin/pages/role";
import assignRole from "./admin/pages/assignRole";

Vue.use(Router);
const routes = [
    {
        path: "/",
        component: home,
        name: 'home'
    },
    {
        path: "/tags",
        component: tags,
        name: 'tags'
    },
    {
        path: "/category",
        component: category,
        name: 'category'
    },
    {
        path: "/adminusers",
        component: adminusers,
        name: 'adminusers'
    },
    {
        path: "/login",
        component: login,
        name: 'login'
    },
    {
        path: "/role",
        component: role,
        name: 'role'
    },
    {
        path: "/assignRole",
        component: assignRole,
        name: 'assignRole'
    }
];

export default new Router({
    mode: "history",
    routes
});
