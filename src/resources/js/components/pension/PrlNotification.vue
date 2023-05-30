<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Notification Search
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="3">
                                <b-form-group label="DEPARTMENT" label-for="department" class="requiredField">
                                    <b-form-select
                                            id="department"
                                            v-model="searchPrlNotification.department_id"
                                            :options="departmentOptions"
                                            text-field="department_name"
                                            value-field="department_id"
                                            required
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Employee Code" label-for="emp_code">
                                    <v-select
                                            label="option_name"
                                            v-model="selectedEmployee"
                                            :options="empIdList"
                                            @search="searchEmpCode"
                                            id="emp_code">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group label="Prl Date" label-for="date">
                                    <date-picker
                                            v-model="searchPrlNotification.prl_date"
                                            width="100%"
                                            type="date"
                                            lang="en"
                                            format="DD-MM-YYYY"

                                    ></date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group>
                                    <b-button-group class="mt-1">
                                        <b-button type="submit" variant="success">Search</b-button>
                                        <b-button type="reset" variant="secondary">Reset</b-button>
                                    </b-button-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">
                    PRL Notification List
                   <!-- <b-button size="sm" class="float-right" variant="success" @click="automaticMail">Send All Mail</b-button>-->
                </b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList"
                               :perPage="perPage">
                        <template v-slot:actions="{ rows }">
                            <a :href="reportUrl" @click="printNotice(rows.item)" target="_blank"><i
                                    class="bx bx-printer cursor-pointer"></i> </a>
<!--                            <a :href="mailUrl" @click="sendMail(rows.item)" target="_blank"><i-->
<!--                                    class="bx bx-send"></i></a>-->
                            <a :class="rows.item.email==null?'text-danger':rows.item.prl_sent_email_yn=='N'?'text-warning':'text-success'" @click="sendMail(rows.item)" target="_blank"><i
                                    class="bx bx-envelope cursor-pointer"></i></a>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>
<script>

    import DatePicker from 'vue2-datepicker';
    import BFormDatepicker from 'bootstrap-vue'
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';


    export default {
        components: {DatePicker, Datatable, vSelect, vcss, BFormDatepicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PRL Notification"});
            this.preLoadData();
            this.onSearch()
        },
        data() {
            return {
                searchPrlNotification: {
                    emp_id: '',
                    department_id: '',
                    prl_date: '',
                },
                reportParams: {
                    xdo: '/~weblogic/Pension/retirement_notice.xdo',
                    type: "pdf",
                    p_department_id: '',
                    p_emp_code: '',
                    filename: 'Retirement Notice'
                },
                mailParams: {
                    to_email: ' ',
                    from_mail:' ',
                    subject:' ' ,
                    body:' ',
                    file:' '

                },
                reportUrl: '',
                mailUrl: ' ',
                modalData: {},
                selectedEmployee: {},
                empIdList: [],
                departmentOptions: [],
                message: '',
                totalList: null,
                perPage: 5,
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL', class: 'text-left'},
                        {key: 'emp_code', label: 'Emp Code ', sortable: true, class: 'text-left'},
                        {key: 'emp_name', label: 'Name', sortable: true, class: 'text-left'},
                        {key: 'department_name', label: 'Department', sortable: true,class: 'text-left'},
                        {key: 'designation', label: 'Designation', sortable: true,class: 'text-left'},
                        {key: 'quota_name', label: 'Quata', sortable: true,class: 'text-left'},
                        {key: 'emp_dob', label: 'Date of Birth', sortable: true, class: 'text-left'},
                        {key: 'emp_join_date', label: 'Joining Date', sortable: true, class: 'text-left'},
                        {key: 'emp_lpr_date', label: 'PRL Date', sortable: true, class: 'text-left'},
                        'action'
                    ],
                    items: [],
                }
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.searchPrlNotification.emp_id = val.emp_id;
                }
            }
        },

        methods: {

            onSearch() {
                let data = this.searchPrlNotification;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/search-prl-notification`, data).then(res => {
                    this.tableData.items = res.data;
                    this.totalList = res.data.length;
                });
            },

            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/emp-search/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            preLoadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.departmentOptions = res.data.departments;
                });
            },

            printNotice(i) {
                let item = Object.assign({}, i);
                // let title='Prl-notice'
                this.reportParams.p_department_id = item.dpt_department_id;
                this.reportParams.p_emp_code = item.emp_code;
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                this.reportUrl = '/report/render/PRL Notice?' + queryString;
            },
            sendMail(data) {
                if(data.email){
                    const h = this.$createElement
                    const titleVNode = h('div', { domProps: { innerHTML: '<i>Please Confirm<i>' } })
                    const messageVNode = h('div', { class: ['foobar'] }, [
                        h('p', { class: ['text-center'] }, [
                            h('strong', 'Please confirm that you want to send the email'),
                        ]),
                        h('p', { class: ['text-left'] }, [
                            'To: ',
                            h('strong',data.email),
                        ])
                    ])


                    this.$bvModal.msgBoxConfirm([messageVNode], {
                        title: [titleVNode],
                        size: 'sm',
                        buttonSize: 'sm',
                        okVariant: 'warning',
                        okTitle: 'YES',
                        cancelTitle: 'NO',
                        footerClass: 'p-2',
                        hideHeaderClose: false,
                        centered: true
                    }).then(response => {
                        if(response == true){
                            let item = Object.assign({}, data);

                                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/pension/send-mail-notification',item).then(result => {
                                    if (result.data.o_status_code == 1) {
                                        this.onSearch()
                                        this.$notify({group: 'pmis', text: result.data.message, type: 'success'});
                                    } else {
                                        //alert (res.data.o_status_message);
                                        this.$notify({group: 'pmis', text: result.data.message, type: 'error'});

                                    }
                                }).then(response=> {
                                }).catch(error => {
                                    this.$notify({group: 'pmis', text: error, type: 'error'});
                                });



                        }
                    }).catch(err=>{
                        this.$notify({group: 'pmis', text: err, type: 'error'});
                    })
                } else {
                    this.$notify({group: 'pmis', text: 'This employee does not have any email address!', type: 'error'});
                }
            },
            automaticMail(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/pension/automatic-mail-notification').then(result => {
                    if (result.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: result.data.message, type: 'success'});
                    } else {
                        //alert (res.data.o_status_message);
                        this.$notify({group: 'pmis', text: result.data.message, type: 'error'});
                    }
                })
            }
            // sendMail(i) {
            //     let item = Object.assign({}, i);
            //     this.mailParams.to_email ='hurokan91@gmail.com';
            //     this.mailParams.from_mail='';
            //     this.mailParams.body="";
            //     this.mailParams.subject="";
            //     this.mailParams.file='';
            //    // let params = this.mailParams;
            //     // let queryString = Object.keys(params).map(function (key) {
            //     //     return key + "=" + params[key]
            //     // }).join('&');
            //     this.mailUrl = `/mail/plain-mail/${this.mailParams.to_email}`;
            // }

        }
    }
</script>

