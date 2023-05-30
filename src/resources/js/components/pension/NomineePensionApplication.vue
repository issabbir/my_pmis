<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Nominee Pension Application</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Employee Code"
                                    label-for="emp_code"
                                >
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
                            <b-col md="4">
                                <b-form-group
                                    label="Employee Name"
                                    label-for="name"
                                >
                                    <b-form-input
                                        id="name"
                                        type="text"
                                        required
                                        readonly
                                        v-model="pensionApplication.emp_name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="DESIGNATION"
                                    label-for="designation"
                                >
                                    <b-form-input
                                        v-model="pensionApplication.designation"
                                        id="designation"
                                        type="text"
                                        required
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="DEPARTMENT"
                                    label-for="department_name"
                                >
                                    <b-form-input
                                        v-model="pensionApplication.department_name"
                                        id="department_name"
                                        type="text"
                                        required
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="PRL DATE"
                                    label-for="prl_date"
                                >
                                    <date-picker
                                        id="prl_date"
                                        v-model="pensionApplication.emp_lpr_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        format="DD-MM-YYYY"
                                        disabled
                                    ></date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="PERMANENT RETIREMENT DATE"
                                    label-for="perm_retd_date"
                                >
                                    <date-picker
                                        v-model="pensionApplication.permanent_retirement_date"
                                        :disabled="pensionApplication.permanent_retirement_date!=null"
                                        width="100%"
                                        id="perm_retd_date"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        format="DD-MM-YYYY"
                                        :input-attr="{ required: true }"
                                    ></date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group label="Branch Name of Sonali Bank" label-for="branch_of_sonali_bank">
                                    <b-form-input
                                        id="account_no"
                                        v-model="pensionApplication.branch_name"
                                        disabled
                                        type="text"
                                        required
                                        placeholder="Branches Name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Account No" label-for="account_no">
                                    <b-form-input
                                        id="account_no"
                                        v-model="pensionApplication.account_number"
                                        disabled
                                        type="text"
                                        required
                                        placeholder="Account No"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Service Period" label-for="service_period">
                                    <b-form-input
                                        id="service_period"
                                        v-model="pensionApplication.service_period"
                                        type="text"
                                        placeholder="Service Preiod"
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Actual Service Period" label-for="actual_service_period">
                                    <b-form-input
                                      id="actual_service_period"
                                      v-model="pensionApplication.actual_service_period"
                                      type="text"
                                      placeholder="Actual Service Preiod"
                                      readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                  label="DEATH DATE"
                                  label-for="death_date"
                                >
                                    <date-picker
                                      v-model="pensionApplication.death_date"
                                      :disabled="true"
                                      width="100%"
                                      id="death_date"
                                      input-class="form-control"
                                      type="date"
                                      lang="en"
                                      format="DD-MM-YYYY"
                                      :input-attr="{ required: true }"
                                    ></date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Application Date"
                                    label-for="application_date"
                                >
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="pensionApplication.application_date"
                                        type="date"
                                        lang="en"
                                        :value-type="valueType"
                                        :editable="false"
                                        :input-attr="{ required: true }"
                                        format="DD-MM-YYYY">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row class="mb-1" v-if="nomineeItems.length > 0">
                            <b-col class="border ml-1 mr-1 p-2">
                                <b-table-simple>
                                    <b-thead>
                                        <b-tr>
                                            <b-th class="p-1">SL</b-th>
                                            <b-th class="p-1">Nominee Name</b-th>
                                            <b-th class="p-1">Birth Date</b-th>
                                            <b-th class="p-1">Relation</b-th>
                                            <b-th class="p-1">Percentage</b-th>
                                            <b-th class="p-1">Bank Info</b-th>
                                            <b-th class="p-1">Is Autistic</b-th>
                                            <b-th class="p-1">Is Applicant</b-th>
                                        </b-tr>
                                    </b-thead>
                                    <b-tbody>
                                        <b-tr v-for="(nominee, k) in nomineeItems" :key="`${k}`">
                                            <b-td class="p-1 text-right">
                                                {{k+1}}
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.nominee_name"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.nominee_dob"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.relationship"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.percentage"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.bank_info"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.is_autistic"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <input type="radio" name="is_applicant" :checked="nominee.nominee_id == nominee_id" @change="onChangeIsApplicant(nominee)" >
                                            </b-td>
                                        </b-tr>
                                    </b-tbody>
                                </b-table-simple>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <b-card class="border">
                                    <b-card-title>
                                        Attachments
                                        <b-button type='button' size="sm" class="btn btn-info float-right" @click="addNewRow"><i class="fa fa-plus-circle"></i> Add</b-button>
                                    </b-card-title>
                                    <b-card-body>
                                        <b-table-simple>
                                            <b-thead>
                                                <b-tr>
                                                    <b-th class="p-1"></b-th>
                                                    <b-th class="p-1">Titel</b-th>
                                                    <!--  <b-th class="p-1">Attachment Type</b-th>-->
                                                    <b-th class="p-1">Attachment</b-th>
                                                    <b-th class="p-1"></b-th>
                                                </b-tr>
                                            </b-thead>
                                            <b-tbody>
                                                <b-tr v-for="(item, k) in pensionApplication.attachments" :key="`${k}`">
                                                    <b-td class="p-1 text-right">
                                                        {{k+1}}
                                                    </b-td>
                                                    <b-td class="p-1">
                                                        <b-form-input size="sm" v-model="item.title"></b-form-input>
                                                    </b-td>
                                                    <!--  <b-td class="p-1">
                                                          <b-form-select
                                                              size="sm"
                                                              v-model="item.attachment_type_id"
                                                              text-field="type"
                                                              value-field="attachment_type_id"
                                                              :options="attachmentOptions"
                                                          ></b-form-select>
                                                      </b-td>-->
                                                    <b-td class="p-1">
                                                        <b-form-file size="sm"  @change="encodeFile(k)"></b-form-file>
                                                    </b-td>
                                                    <b-td scope="row" class="text-danger text-center p-1">
                                                        <i class="bx bx-trash" @click="deleteRow(k, item)"></i>
                                                    </b-td>
                                                </b-tr>
                                            </b-tbody>
                                        </b-table-simple>
                                    </b-card-body>
                                </b-card>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button-group>
                                    <b-button type="submit" variant="primary">Submit</b-button>
                                    <b-button type="reset" variant="secondary">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Application List
                </b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="columns" :totalList="totalItems" perPage="5" v-bind:items="listItems"
                               v-bind:pageColSize="4" v-bind:searchColSize="5">
                        <template v-slot:action4="{ rows }">
                            <b-link ml="4" class="text-primary" @click="edit(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import { TablePlugin } from 'bootstrap-vue'

    export default {
        components: {DatePicker, Datatable, vSelect, vcss, TablePlugin},
        data() {
            return {
                nominee_id: '',
                valueType: this.dateFormatter(),
                value: 'Y',
                selected: '',
                disabled: false,
                selectedEmployee: [],
                empIdList: [],
                totalItems: 0,
                nomineeItems: [],
                pensionItems: [],
                totalPension: 0,
                clearanceEmp:' ' ,
                small: true,
                listItems: [],
                length: '',
                branches: [],
                permanentDate: null,
                pensionApplication: {
                    apps_id: '',
                    application_type: 'AFD',
                    nominee_id: '',
                    application_date: moment(new Date()).format("YYYY-MM-DD"),
                    bank_id: null,
                    emp_code: null,
                    emp_id: null,
                    emp_name: null,
                    perm_retd_date: null,
                    lpr_date: null,
                    department_name: null,
                    designation: null,
                    account_number: "",
                    account_type: '',
                    account_type_id: '',
                    available_days: '',
                    bank_info: "",
                    branch_id: "",
                    branch_name: null,
                    designation_id: "",
                    dpt_department_id: "",
                    emp_lpr_date: "",
                    emp_status: "",
                    option_name: "",
                    permanent_retirement_date: "",
                    service_period:"",
                    actual_service_period: '',
                    death_date: null,
                    attachments: [
                        {
                            attachment_type_id:'',
                            title: '',
                            filename:'',
                            file_content:'',
                            pension_emp_id:'',
                            file_extension:'',
                            emp_code:''
                        }
                    ]
                },
                employeeTitleList: [
                    {text: 'MR.', value: 'MR.'},
                    {text: 'MRS.', value: 'MRS.'}
                ],
                options: [
                    {text: 'Male', value: ''},
                    {text: 'Female', value: 'second'},
                    {text: 'Other', value: 'third'}
                ],
                isApplicantOptions: [
                    { item: 'Y', name: '' },
                ],
                columns: [
                    {label: 'SL', key: 'index', sortable: false},
                    {label: 'Employee Name', key: 'emp_name', sortable: true},
                    {label: 'Employee Code', key: 'emp_code', sortable: true},
                    {
                        label: 'Death Date',
                        key: 'death_date',
                        sortable: true,
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY')
                            }
                        }
                    },
                    {
                        label: 'Application Date',
                        key: 'application_date',
                        sortable: true,
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY')
                            }
                        }
                    },

                    {label: 'Applicant Name', key: 'nominee_name', sortable: true},
                    {label: 'Action', key: 'action4', class: 'text-center'}
                ],
                pensionFields: [
                    {label: 'SL', key: 'index'},
                    {label: 'Clearance Department', key: 'department_name', sortable: true, },
                    {key: 'clearance_date', label: 'Date',formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY')
                            }
                        }, sortable: true, sortDirection: 'desc', class: 'text-center',variant: 'danger' },
                    {label: 'Status', key: 'dependency_yn', sortable: true, class: 'text-center',variant: 'success'},
                    {label: 'Remarks', key: 'remarks', sortable: true, class: 'text-center' ,variant: 'warning'},
                    {label: 'Clearance By', key: 'clearance_by_name', class: 'text-center', sortable: true,variant: 'primary'}


                ],
                nomineeFields: [
                    {key: 'index', label: 'SL', sortable: true},
                    {key: 'nominee_name', label: 'Nominee Name', sortable: true},
                    {key: 'relationship', label: 'Relationship', sortable: true},
                    {key: 'nominee_dob', label: 'Birth Date', sortable: true},
                    {key: 'percentage', label: 'Percentage', sortable: true},
                    {key: 'marital_status', label: 'Marital Status', sortable: true}
                ],
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.pensionApplication = {
                        apps_id: val.apps_id? val.apps_id: this.pensionApplication.apps_id,
                        bank_id: 37,
                        emp_bank_acc_no: val.account_number,
                        emp_code: val.emp_code,
                        emp_id: val.emp_id,
                        emp_name: val.emp_name,
                        department_name: val.department_name,
                        designation: val.designation,
                        account_number: val.account_number,
                        application_date: this.pensionApplication.application_date,
                        account_type: val.account_type,
                        account_type_id: val.account_type_id,
                        available_days: val.available_days,
                        bank_info: val.bank_info,
                        branch_id: val.branch_id,
                        branch_name: val.branch_name,
                        designation_id: val.designation_id,
                        dpt_department_id: val.dpt_department_id,
                        emp_lpr_date: val.emp_lpr_date,
                        lpr_date: val.emp_lpr_date,
                        emp_status: val.emp_status,
                        option_name: val.option_name,
                        permanent_retirement_date: val.permanent_retirement_date,
                        service_period:val.service_period,
                        actual_service_period: val.actual_service_period,
                        perm_retd_date : val.permanent_retirement_date,
                        death_date: val.death_date,
                        nominee_id: val.nominee_id ? val.nominee_id : this.pensionApplication.nominee_id,
                        attachments: [
                            {
                                attachment_type_id:'',
                                title: '',
                                filename:'',
                                file_content:'',
                                pension_emp_id:'',
                                file_extension:'',
                                emp_code:''
                            }
                        ]
                    }
                    this.loadNominee(val.emp_id, val.nominee_id)
                }
            }
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Nominee Pension Application"});
            this.loadBrances();
            this.loadTable();

        },

        filters: {
            dateFormat: function (d) {
                return moment(d).format("YYYY-M-D");
            }
        },
        methods: {
            onSubmit() {
                if (!this.pensionApplication.nominee_id){
                    this.$notify({group: 'pmis', text: 'Select a nominee', type: 'error'});
                } else {
                    this.pensionApplication.application_type = "AFD"
                    this.pensionApplication.application_date = this.pensionApplication.application_date

                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/nominee-pension-application`, this.pensionApplication).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset()
                            this.loadTable()
                            this.nomineeItems = []
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }
            },
            edit(item){
                this.pensionApplication = item
                this.selectedEmployee = item
                this.nominee_id = item.nominee_id;
            },
            onReset() {
                this.selectedEmployee = [];
                this.pensionApplication = {
                    apps_id: '',
                    application_type: 'AFD',
                    nominee_id: '',
                    application_date: moment(new Date()).format("YYYY-MM-DD"),
                    bank_id: null,
                    emp_code: null,
                    emp_id: null,
                    emp_name: null,
                    perm_retd_date: null,
                    lpr_date: null,
                    department_name: null,
                    designation: null,
                    account_number: "",
                    account_type: '',
                    account_type_id: '',
                    available_days: '',
                    bank_info: "",
                    branch_id: "",
                    branch_name: null,
                    designation_id: "",
                    dpt_department_id: "",
                    emp_lpr_date: "",
                    emp_status: "",
                    option_name: "",
                    permanent_retirement_date: "",
                    service_period:"",
                    actual_service_period: '',
                    death_date: null,
                    attachments: [
                        {
                            attachment_type_id:'',
                            title: '',
                            filename:'',
                            file_content:'',
                            pension_emp_id:'',
                            file_extension:'',
                            emp_code:''
                        }
                    ]
                }
                this.nomineeItems = []
                this.$nextTick(() => {
                })
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/nominee-emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            loadTable: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/all-nominee-application').then(res => {
                    this.listItems = res.data;
                    this.totalItems = res.data.length
                })
            },
            loadBrances: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/applications/form-data').then(res => {
                    this.branches = res.data.branches;
                });
            },
            encodeFile(index) {
                let file_limit = 2000000;
                let vm = this;
                if(event.target.files[0].size<=file_limit){
                    if (event.target.files[0].type=='application/pdf'||event.target.files[0].type=='image/jpeg'||event.target.files[0].type=='image/jpg'){
                        let file = event.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.pensionApplication.attachments[index].file_content = reader.result;
                            vm.pensionApplication.attachments[index].emp_code = vm.pensionApplication.emp_code;
                            vm.pensionApplication.attachments[index].filename = name;
                            vm.pensionApplication.attachments[index].file_extension = type;
                            vm.pensionApplication.attachments[index].pension_emp_id = vm.pensionApplication.emp_id;
                            console.log(vm.pensionApplication.attachments)
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }

            },
            addNewRow() {
                this.pensionApplication.attachments.push({
                    attachment_type_id:'',
                    title: '',
                    filename:'',
                    file_content:'',
                    pension_emp_id:'',
                    file_extension:'',
                    emp_code:''
                })
            },
            deleteRow(index, item) {
                let idx = this.pensionApplication.attachments.indexOf(item)
                if (idx > -1 && this.pensionApplication.attachments.length > 1) {
                    this.pensionApplication.attachments.splice(idx, 1)
                }
            },
            loadNominee: function (emp_id, nominee_id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/nominee/${emp_id}`).then(res => {
                    this.nomineeItems = res.data.map(option => {
                        if(option.nominee_id == nominee_id){
                            let newPropsObj = {
                                is_applicant:true
                            }
                            return Object.assign(option, newPropsObj)
                        }else{
                            let newPropsObj = {
                                is_applicant:''
                            }
                            return Object.assign(option, newPropsObj)
                        }


                    })


                });
            },
            onChangeIsApplicant(nominee) {
                this.pensionApplication.nominee_id = nominee.nominee_id
            },
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            }

        }
    }
</script>

