import Vue from "vue";

require('./bootstrap');
window.Vue = require('vue');
import Vuex from 'vuex'
Vue.use(Vuex)

import DataTable from 'laravel-vue-datatable';

Vue.use(DataTable);

import Vuelidate from "vuelidate/src";
Vue.use(Vuelidate)

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);

const veeValidateConfigurations = {
    fieldsBagName: 'veeFields',
    validity: false, // To use html5 message pop-up features from second time form submission, you may make it to 'true'.
    classes: true, // To use classes in validations
    dictionary: { // To customize field names in error message. To customize error messages.
        en: {
            attributes: {
                'emp_photo': 'photo',
                'emp_code': 'code',
                'emp_name': 'full name',
                'emp_name_bng': 'full name bangla',
                'pin_id_no': 'pin/id no',
                'emp_father_name': 'father name',
                'emp_mother_name': 'mother name',
                'emp_dob': 'date of birth',
                'emp_gender_id': 'gender',
                'salutation_id': 'salutation',
                'nid_no': 'authentication id',
                'auth_doc_type_id': 'authentication type',
                'emp_blood_group_id': 'blood group',
                'emp_maritial_status_id': 'marital status',
                'emp_nationality_id': 'nationality',
                'point': 'point',
                'emp_religion_id': 'religion',
                'emp_tribal_yn': 'tribal',
                'auth_document': 'authentication document',
                'auth_type_id': 'authentication type',
                'dpt_division_id': 'division',
                'dpt_department_id': 'department',
                'designation_id': 'designation',
                'emp_grade_id': 'grade',
                'exam_id': 'name of exam',
                'subject': 'subject/group/major',
                'exam_result': 'exam result',
                'board': 'exam body',
                'exam_result_type_id': 'exam result type',
                'grade_step_id': 'grade step',
                'emp_join_date': 'join date',
                'emp_lpr_date': 'prl date',
                'emp_type_id': 'type',
                'emp_status_id': 'status',
                'emp_tin_no': 'tin no',
                'ot_category_id': 'overtime category',
                'appointment_type_id': 'appointment type',
                'emp_pf_id': 'Provident fund ID',
                'emp_quota_id': 'quota',
                'bank_id': 'bank',
                'branch_id': 'branch',
                'emp_bank_acc_no': 'bank account no',
                'on_pension_yn': 'pension',
                'emp_emergency_contact_mobile': 'emergency contact mobile',
                'bill_code': 'bill code',
                'allowance_yn': 'allowance',
                'approved_yn': 'approved',
                'auth_id': 'authentication identity',
                'nominee_photo': "nominee's photo",
                'nominee_name': "nominee's name",
                'nominee_contact_no': "nominee's contact no",
                'nominee_email': "nominee's e-mail",
                'nominee_auth_id': 'authentication identity',
                'relationship_id': "relationship with nominee",
                'nominee_dob': "nominee's date of birth",
                'nominee_auth_doc': "nominee's auth document",
                'passing_year': 'passing year',
                'address_type_id': 'address type',
                'division_id': 'division',
                'district_id': 'district',
                'thana_id': 'thana',
                'post_code': 'post code',
                'emp_contact_type_id': 'contact type',
                'emp_contact': 'contact',
                'emp_contact_info': 'contact info',
                'designation': 'designation',
                'work_from': 'work from',
                'work_to': 'work to',
                'employer_name': 'employer name',
                'emp_member_name': 'member name',
                'emp_member_dob': 'dob',
                'emp_member_mobile': 'mobile',
                'gender_id': 'gender',
                'certificate_name': 'certificate name',
                'certificate_date': 'certificate date',
                'certificate_doc': 'certificate document',
                'tour_name': 'tour name',
                'tour_type_id': 'tour type',
                'tour_duration': 'tour duration',
                'tour_start_date': 'start date',
                'tour_end_date': 'end date',
                'gpf_pct': 'precentage',
                'training_name': 'training name',
                'training_type_id': 'training type',
                'training_duration': 'training duration',
                'training_report': 'training report',
                'building_type_id': 'building type',
                'no_of_tap': 'no of tap',
                'no_of_burner': 'no of burner',
                'employee_name': 'employee name',
                'order_date':'order date',
                'charge_type_id':'charge type',
                'charge_activation_date':'charge activation date',
                'charge_end_date':'charge end date',
                'status_type':'status type',
                'lookup_code': 'club',
                'deduction_yn': 'deduction',
                'active_yn': 'status',
                'type_of': 'type',
                'value_of': 'value',
                'previous_workplace':'previous workplace',
                'previous_designation':'previous designation',
                'previous_office_address':'previous office address',
                'take_over_date': 'take over date'
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

//Overlay plugin
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);
import 'bootstrap-vue/dist/bootstrap-vue.css'
/** Layout defined **/
import App from './layouts/pmis/App';
/** Route defined with store **/
import VueRouter from 'vue-router'
Vue.use(VueRouter);
/** Application routes defined based on acton **/
import routes from './routes/pmis';
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
        el: '#pmis',
        router,
        render: h => h(App)
    });
});


