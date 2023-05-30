require('./bootstrap');
window.Vue = require('vue');
import Vuex from 'vuex'
Vue.use(Vuex)

/** Layout defined **/
import App from './layouts/traffic/App';

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
import 'bootstrap-vue/dist/bootstrap-vue.css'

/** Route defined with store **/
import VueRouter from 'vue-router'
Vue.use(VueRouter);
/** Application routes defined based on acton **/
import routes from './routes/traffic';
/** Route configured with vuex store and applicsaiton routes **/
let router = new VueRouter({routes});

import store from './store/store';
Vue.prototype.$store = store;

/** Run the application  **/
const app = new Vue({
    el: '#traffic',
    router,
    render: h => h(App)
});

