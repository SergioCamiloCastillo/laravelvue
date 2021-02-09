require('./bootstrap');
window.Vue = require('vue')
import router from './router';
import store from './store'
import ViewUI from 'view-design';
import common from './components/pages/common'

import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);
Vue.mixin(common);


Vue.component('mainapp', require('./components/mainapp.vue').default)
const app = new Vue({
    el: '#app', 
    router, 
    store
  
})