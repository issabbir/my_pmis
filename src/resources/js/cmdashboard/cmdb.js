require('../bootstrap');
import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App";
import routes from "./routes/routes";
import GlobalComponents from "./globalComponents";
import GlobalDirectives from "./globalDirectives";
//import Notifications from "./components/NotificationPlugin"
import Notifications from 'vue-notification'
import Colxx from "./components/Colxx";
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import MaterialDashboard from "./material-dashboard";
import Chartist from "chartist";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import store from '../store/store';
import repo from '../Repository/ApiRepository';

Vue.use(BootstrapVue);
Vue.use(Loading);

const router = new VueRouter({
  routes,
  linkExactActiveClass: "nav-item active"
});

Vue.use(VueRouter);
Vue.use(MaterialDashboard);
Vue.use(GlobalComponents);
Vue.use(GlobalDirectives);
Vue.use(Notifications);
Vue.component('b-colxx', Colxx);

Vue.prototype.$Chartist = Chartist;
Vue.prototype.$store = store;
Vue.prototype.$repo = repo;

Vue.prototype.$repo.callApi(Vue.prototype.$repo.GET_COMMAND, "/admin/auth-acl").then(res => {
    Vue.prototype.$store.commit('setMenus',res.data.user_menus);
    Vue.prototype.$store.commit('setPermissions',res.data.user_permissions);
    Vue.prototype.$store.commit('setReports',res.data.user_reports);
    Vue.prototype.$store.commit('setGrantAccess',res.data.grant_access);
    Vue.prototype.$store.commit('setRoles',res.data.user_roles);
    Vue.prototype.$store.commit('setUser',res.data.user);
    //console.log(Vue.prototype.$store.getters.hasGrantAccess)
    router.beforeEach((to, from, next) => {
        let menus = Vue.prototype.$store.getters.menus;

        if (Vue.prototype.$store.getters.hasGrantAccess || menus.includes(to.name) || to.name == 'Dashboard') {
            next();
        }
        else
            next('access-denied');
    });

    const app = new Vue({
        el: '#cmdb',
        router,
        render: h => h(App),
        data: {
            Chartist: Chartist
        }
    });
});
