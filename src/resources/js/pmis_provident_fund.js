require('./bootstrap');
window.Vue = require('vue');
import Vuex from 'vuex'
Vue.use(Vuex);

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);

import 'bootstrap-vue/dist/bootstrap-vue.css'

//Notification
import Notifications from 'vue-notification'
Vue.use(Notifications);

/** Layout defined **/
import App from './layouts/pmis-provident-fund/App';

/** Route defined with store **/
import VueRouter from 'vue-router'
Vue.use(VueRouter);
/** Application routes defined based on acton **/
import routes from './routes/pmis_provident_fund';
/** Route configured with vuex store and applicaiton routes **/
let router = new VueRouter({routes});

import store from './store/store';
Vue.prototype.$store = store;
import repo from './Repository/ApiRepository';
Vue.prototype.$repo = repo;

Vue.prototype.$repo.callApi(Vue.prototype.$repo.GET_COMMAND, "/admin/auth-acl").then(res => {
    Vue.prototype.$store.commit('setMenus',res.data.user_menus);
    Vue.prototype.$store.commit('setPermissions',res.data.user_permissions);
    Vue.prototype.$store.commit('setReports',res.data.user_reports);
    Vue.prototype.$store.commit('setGrantAccess',res.data.grant_access);
    Vue.prototype.$store.commit('setRoles',res.data.user_roles);
    Vue.prototype.$store.commit('setReportingEmpId',res.data.reporting_empId);
    Vue.prototype.$store.commit('setUser',res.data.user);
    router.beforeEach((to, from, next) => {
        let menus = Vue.prototype.$store.getters.menus;
        if (Vue.prototype.$store.getters.hasGrantAccess || menus.includes(to.name)) {
            next();
        }
        else
           next('access-denied');
    });

    /** Run the application  **/
    const app = new Vue({
        el: '#providentFund',
        router,
        render: h => h(App)
    });
});
