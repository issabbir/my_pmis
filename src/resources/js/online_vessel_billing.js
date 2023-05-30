require('./bootstrap');
window.Vue = require('vue');
import Vuex from 'vuex'
Vue.use(Vuex)

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
import 'bootstrap-vue/dist/bootstrap-vue.css'


/** Layout defined **/
import App from './layouts/online_vessel_billing/App';

/** Route defined with store **/
import VueRouter from 'vue-router'
Vue.use(VueRouter);
/** Application routes defined based on acton **/
import routes from './routes/online_vessel_billing';
/** Route configured with vuex store and applicsaiton routes **/
let router = new VueRouter({routes});

import store from './store/store';
Vue.prototype.$store = store;

/** Run the application  **/
const app = new Vue({
    el: '#online_vessel_billing',
    router,
    render: h => h(App)
});
