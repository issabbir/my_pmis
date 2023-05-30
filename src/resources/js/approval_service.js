require('./bootstrap');
window.Vue = require('vue');
import Vuex from 'vuex'
Vue.use(Vuex)

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
import 'bootstrap-vue/dist/bootstrap-vue.css'

const veeValidateConfigurations = {
    fieldsBagName: 'veeFields',
    validity: false, // To use html5 message pop-up features from second time form submission, you may make it to 'true'.
    classes: true, // To use classes in validations
    dictionary: { // To customize field names in error message. To customize error messages.
        en: {
            attributes: {
                'empId': 'empId',
                'ot_year': 'year',
                'ot_month': 'month',
                'effective_start_date': 'effective start date',
                'effective_end_date': 'effective end date',
                'roster_month_id': 'roster month',
                'roster_group_id': 'group',
                'month_slab_id': 'month slab',
                'shift_id': 'shift',
                'group_id': 'group',
            }
        },
    },
    classNames: {
        touched: 'touched', // the control has been blurred
        untouched: 'untouched', // the control hasn't been blurred
        valid: ['border-success'], // model is valid
        invalid: ['border-danger'], // model is not valid
        pristine: 'pristine', // control has not been interacted with
        dirty: 'dirty', // control has been interacted with,
    }
};

import VeeValidate from 'vee-validate';
Vue.use(VeeValidate, veeValidateConfigurations || {});

//Notification
import Notifications from 'vue-notification'
Vue.use(Notifications);

/** Layout defined **/
import App from './layouts/approval_service/App';

/** Route defined with store **/
import VueRouter from 'vue-router'
Vue.use(VueRouter);
/** Application routes defined based on acton **/
import routes from './routes/approval_service';
/** Route configured with vuex store and applicsaiton routes **/
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
        el: '#approval_service',
        router,
        render: h => h(App)
    });
});
