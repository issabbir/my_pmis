import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        hideSeek: true,
        perPage: 5,
        breadCrumbs: [],
        permissions:[],
        menus:[],
        reports:[],
        grantAccess:true,
        roles:[],
        backgroundProcess:false,
        reportingEmpId:'',
        user:''
     },
     mutations: {
        setReportingEmpId(state,data) {
            state.reportingEmpId = data;
        },
        setUser(state,data) {
            state.user = data;
        },
        setHideSeek(state, data){
            state.hideSeek = data
        },
        setPerPage(state, data) {
             state.perPage = data;
         },
        setBreadcrumb (state, {label, link}) {
            state.breadCrumbs.push({"label": label, "link": link});
        },
        setBreadcrumbEmpty (state) {
            if (state.breadCrumbs.length > 0)
            state.breadCrumbs = [];
        },
        setPermissions(state, data) {
            state.permissions = data;
        },
        setMenus(state, data) {
            state.menus = data;
        },
        setReports(state, data) {
            state.reports = data;
        },
        setGrantAccess(state,data) {
            state.grantAccess = data;
        },
        setRoles(state,data) {
            state.roles = data;
        },
        processStart(state) {
            state.backgroundProcess = true;
        },
        processEnd(state) {
            state.backgroundProcess = false;
        }
    },
    actions: {
        getMenues(data) {
            // console.log("text")
            axios.get("access-modules")
                .then((response) => {
                    data.commit("setMenus", response.data)
                }).catch((error) => {

            })
        },
    },
    getters: {
        breadCrumbs: state => state.breadCrumbs,
        permissions: state => state.permissions,
        menus: state => state.menus,
        reports: state => state.reports,
        hasGrantAccess: state => state.grantAccess,
        roles: state => state.roles,
        hideSeek: state => state.hideSeek,
        reportingEmpId: state => state.reportingEmpId,
        user: state => state.user
    }
});
