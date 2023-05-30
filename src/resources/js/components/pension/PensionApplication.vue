<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Application</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
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
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                        label="Name"
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
                                            v-model="pensionApplication.lpr_date"
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
                                            v-model="pensionApplication.perm_retd_date"
                                            @change="onChangeRetirement()"
                                            disabled
                                            width="100%"
                                            id="perm_retd_date"
                                            input-class="form-control"
                                            type="date"
                                            lang="en"
                                            :value-type="valueType"
                                            format="DD-MM-YYYY"
                                            :input-attr="{ required: true }"
                                    ></date-picker>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row class="mb-1">
                            <b-col class="border ml-1 mr-1 p-2">
                                <b-table
                                        :items="nomineeItems"
                                        :fields="nomineeFields"
                                        sort-icon-left
                                        responsive="sm"
                                        :small="small"
                                        hover
                                        head-variant="dark"
                                >
                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                </b-table>
                            </b-col>
                        </b-row>

                        <b-row class="mb-1">
                            <b-col md="4">
                                <b-form-group label="Branch Name of Sonali Bank" label-for="branch_name">
                                    <b-form-input
                                            id="branch_name"
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
                                            v-model="pensionApplication.emp_bank_acc_no"
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
                                      placeholder="Service Preiod"
                                      readonly
                                    ></b-form-input>
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

                        <b-row>
                            <b-col>
                                <b-card class="border">
                                    <b-card-title >
                                        Attachments
                                        <b-button type='button' size="sm" class="btn btn-info float-right" @click="addNewRow"><i class="fa fa-plus-circle"></i> Add</b-button>
                                    </b-card-title>
                                    <b-card-body class="border-top">
                                        <b-table-simple bordered striped hover  :small="small">
                                            <b-thead>
                                                <b-tr>
                                                    <b-th class="p-1 text-center">SL</b-th>
                                                    <b-th class="p-1">Title</b-th>
                                                  <!--  <b-th class="p-1">Attachment Type</b-th>-->
                                                    <b-th class="p-1">Attachment</b-th>
                                                    <b-th class="p-1 text-center">Remove</b-th>
                                                </b-tr>
                                            </b-thead>
                                            <b-tbody>
                                                <b-tr v-for="(item, k) in pensionApplication.attachments" :key="`${k}`">
                                                    <b-td class="p-1 text-center">
                                                        {{k+1}}
                                                    </b-td>
                                                    <b-td class="p-1">
                                                        <b-form-input size="sm" v-model="item.title"></b-form-input>
                                                    </b-td>
                                                      <b-td class="p-1">
                                                            <b-form-select
                                                                size="sm"
                                                                v-model="item.attachment_type_id"
                                                                text-field="type"
                                                                value-field="attachment_type_id"
                                                                :options="attachmentOptions"
                                                            ></b-form-select>
                                                        </b-td>
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
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Application List</b-card-header>
<!--                <template v-slot:pension_status="{ rows }">-->
<!--                    <span v-if="rows.item.pension_status == 'Y'" class="text-success text-center">Approved</span>-->
<!--                    <span class="text-danger text-center" v-else>Pending</span>-->
<!--                </template>-->
                <b-card-body class="border">
                    <Datatable v-bind:fields="columns" :totalList="totalItems" perPage="5" v-bind:items="listItems" v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'emp_code'">
                        <template v-slot:action4="{ rows }">
<!--                            <a :href="reportUrl" @click="renderPdf(rows.item.emp_code)" target="_blank">-->
<!--                                <i class="bx bx-file cursor-pointer"></i>-->
<!--                            </a>-->
                            <a size="sm" variant="primary" :href="reportUrl" @click="renderPdf(rows.item.emp_code)" target="_blank"><i class="bx bx-file cursor-pointer"></i></a>
                            <b-link size="sm" variant="primary" v-b-modal.modal-center @click="renderModal(rows.item)">
                                <i class="bx bx-show cursor-pointer"></i>
                            </b-link>
<!--                            <b-button variant="warning" v-if="rows.item.clearance_open_yn == 'N'" size="sm" @click="openForClearance(rows.item.apps_id)">-->
<!--                               Open For Clearance-->
<!--                            </b-button>-->

<!--                                <a :href="reportUrl" class="btn btn-dark btn-secondary mr-2 btn-sm" @click="renderPdf(rows.item)" target="_blank">-->
<!--&lt;!&ndash;                                   :href="`/report/render/RPT_HONORARIUM_BILL?xdo=/~weblogic/Payroll/RPT_HONORARIUM_BILL.xdo&p_other_allowance_id=${rows.item.emp_other_allwoance_id ? rows.item.emp_other_allwoance_id : 0}&type=pdf&filename=RPT_HONORARIUM_BILL`">&ndash;&gt;-->
<!--                                     Print</a>-->


                        </template>
                        <template v-slot:action2="{ rows }">
                            <span v-if="rows.item.pension_status == 'Settlement Complete'" class="text-success text-center">Settlement Complete</span>
                            <span class="text-warning text-center" v-else>On clearance process</span>
                        </template>

                    </Datatable>
                </b-card-body>
            </b-card>
            <div>
                <b-modal
                        id="modal-center"
                        scrollable
                        size="xl"
                        body-bg="light"
                        title="Pension Clearance Status"
                >
                        <b-card>
                            <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Clearance Status
                               for {{this.clearanceEmp }}
                            </b-card-header>
                            <b-card-body class="border">
                                <b-row class="mb-1">
                                    <b-col class="border ml-1 mr-1 p-2">
                                        <b-table
                                            :items="pensionItems"
                                            :fields="pensionfields"
                                            sort-icon-left
                                            responsive="sm"
                                            :small="small"
                                            hover
                                            head-variant="dark"
                                        >
                                            <template v-slot:cell(index)="data">
                                                {{ data.index + 1 }}
                                            </template>
                                        </b-table>
                                    </b-col>
                                </b-row>
                                <div v-if=" attachmentItems.length > 0 ? true : false" class="border p-2">
                                    <h5>Attachments:</h5>
                                    <b-table
                                        :items="attachmentItems"
                                        :fields="attachmentsFields"
                                        sort-icon-left
                                        responsive="sm"
                                        :small="small"
                                        hover
                                        head-variant="dark"
                                    >
                                        <template v-slot:cell(index)="data">
                                            {{ data.index + 1 }}
                                        </template>
                                        <template #cell(action)="data">
                                            <a size="sm" @click="showAttachment(data.item.attachment_id)"><i class="bx bx-download cursor-pointer"></i></a>
                                        </template>
                                    </b-table>
                                </div>
                            </b-card-body>
                        </b-card>
                </b-modal>
            </div>
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
        props: ['id'],
        data() {
            return {
                reportUrl:'',
                reportParams: {
                    xdo:'/~weblogic/Pension/Employee_details.xdo',
                    type:"pdf",
                    P_EMP_CODE:'',
                    filename:'Employee Details'},
                attachmentUrl: '',
                attachmentOptions: [],
                attachmentItems:[],
                valueType: this.dateFormatter(),
                disabled: false,
                selectedEmployee: [],
                empIdList: [],
                totalItems: 0,
                nomineeItems: [],
                pensionItems: [],
                totalPension: 0,
                totalNominee: 0,
                clearanceEmp:' ' ,
                small: true,
                listItems: [],
                length: '',
                branches: [],
                getattachments: [],
                permanentDate: null,
                pensionApplication: {
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
                    actual_service_period:"",
                    application_date: new Date(),
                    attachments: [
                        {
                            attachment_type_id:'',
                            attachment_id:'',
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
                columns: [
                    {label: 'SL', key: 'index', sortable: false},
                    {label: 'Employee Code', key: 'emp_code', sortable: true},
                    {label: 'Name', key: 'emp_name', sortable: true},
                    {label: 'Designation', key: 'designation', sortable: true},
                    {label: 'Department', key: 'department_name', sortable: true},
                    {label: 'Application Date', key: 'apps_date', sortable: true},
                    // {key: 'pension_status', label: 'Pension Status'},
                    {key: 'action2', label: 'Pension Status'},
                    {key: 'action4', label: 'Action'}
                ],
                pensionfields: [
                    {label: 'SL', key: 'index', sortable: false},
                    {label: 'Clearance Department', key: 'department_name', sortable: true, },
                    {label: 'Clearance Section', key: 'dpt_section', sortable: true, },
                    {key: 'clearance_date', label: 'Date',formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, sortable: true, sortDirection: 'desc', class: 'text-center',variant: 'danger' },
                    {label: 'Personal Debt Amount', key: 'personal_debt', sortable: true, class: 'text-right',variant: 'success'},
                    {label: 'Personal Debt Remarks', key: 'personal_debt_remarks', sortable: true, variant: 'warning'},
                    {label: 'Institutional Debt Amount', key: 'institutional_debt', sortable: true, class: 'text-right',variant: 'success'},
                    {label: 'Institutional Debt Remarks', key: 'institutional_debt_remarks', sortable: true, variant: 'warning'},
                    {label: 'Status', key: 'status', sortable: true, class: 'text-center' ,variant: 'default'},
                    {label: 'Clearance By', key: 'clearance_by_name', class: 'text-center', sortable: true,variant: 'primary'}


                ],

                attachmentsFields: [
                    {label: 'SL', key: 'index'},
                    {label: 'Title', key: 'title' },
                    {label: 'File Name', key: 'filename' },
                    {label: 'Attachment',key: 'action'},

                ],
                nomineeFields: [
                    {key: 'index', label: 'SL', sortable: true},
                    {key: 'nominee_name', label: 'Nominee Name', sortable: true},
                    {key: 'relationship', label: 'Relationship', sortable: true},
                    {key: 'nominee_dob', label: 'Birth Date', sortable: true},
                    {key: 'percentage', label: 'Percentage', sortable: true},
                    {key: 'marital_status', label: 'Marital Status', sortable: true}
                ],
                show: true
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.pensionApplication = {
                        bank_id: 37,
                        emp_bank_acc_no: val.account_number,
                        emp_code: val.emp_code,
                        emp_id: val.emp_id,
                        emp_name: val.emp_name,
                        department_name: val.department_name,
                        designation: val.designation,
                        account_number: val.account_number,
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
                        actual_service_period:val.actual_service_period,
                        perm_retd_date : val.permanent_retirement_date,
                        application_date: this.pensionApplication.application_date,
                        attachments: [
                            {
                                attachment_type_id:'',
                                title: '',
                                filename:'',
                                file_content:'',
                                pension_emp_id:'',
                                file_extension:'',
                                emp_code:'',
                                attachment_id:''
                            }
                        ]
                    }
                    this.loadNominee(val.emp_id);
                }
            }
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension Application"});
            this.loadBrances();
            this.loadAttachmentTypes()
            this.loadTable();

        },

        filters: {
            dateFormat: function (d) {
                return moment(d).format("YYYY-M-D");
            }
        },
        methods: {
            addNominee: function () {
                this.pensionApplication.nominees.push(Vue.util.extend({}, this.nominee));
                if (this.pensionApplication.nominees.length > 8) {
                    this.disabled = true;
                } else {
                    this.disabled = false;
                }
            },
            removeNominee: function (index) {
                Vue.delete(this.pensionApplication.nominees, index);
                if (this.pensionApplication.nominees.length < 9) {
                    this.disabled = false;
                } else {
                    this.disabled = true;
                }
            },
            onSubmit() {
                let data = this.pensionApplication;

                if (data.application_id != null) {
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pension/applications/${data.application_id}`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadTable();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                } else {

                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/applications`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadTable();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }
            },
            onReset() {
                this.selectedEmployee = [];
                this.pensionApplication = {
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
                    actual_service_period:"",
                    application_date: new Date(),
                    attachments: [
                        {
                            attachment_type_id:'',
                            title: '',
                            filename:'',
                            file_content:'',
                            pension_emp_id:'',
                            file_extension:'',
                            emp_code:'',
                            attachment_id:''
                        }
                    ]
                };

                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications-controller-wise/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            loadTable: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/applications-controller-wise').then(res => {
                    this.listItems = res.data;
                    this.totalItems = res.data.length;
                });
            },
            loadBrances: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/applications/form-data').then(res => {
                    this.branches = res.data.branches;
                });
            },
            loadNominee: function (id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications/nominee/${id}`).then(res => {
                    this.nomineeItems = res.data;
                    this.totalNominee = res.data.length;
                });
            },
            loadAttachmentTypes(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/attachments-types`).then(res => {
                    this.attachmentOptions = res.data;
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

            renderModal(item) {
                let id = item.emp_id;

                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/get-pension-clearance-status/${id}`).then(res => {
                    this.pensionItems = res.data;
                    this.clearanceEmp=res.data[0].emp_name;
                    this.totalPension = res.data.length;

                    //new api for get attachments
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/get-attachments/${id}`).then(res => {
                        this.attachmentItems = res.data;
                        console.log(this.getattachments)

                    });

                });
            },
            showAttachment(id) {
                window.open(ApiRepository.apiBasePath + `/pension/show-attachment/${id}`);
            },
            onChangeRetirement(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications/emp/duration/${this.pensionApplication.emp_id}/${this.pensionApplication.perm_retd_date}`).then(res => {
                    this.pensionApplication.service_period = res.data.service_period
                });
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
            },
            openForClearance(id){
                this.$bvModal.msgBoxConfirm('Please confirm that you want to open the application for CLEARANCE!', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                }).then(value => {
                    if(value == true){
                        ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pension/open-for-clearance/${id}`).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                this.onReset();
                                this.loadTable();
                            } else {
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                            }
                        });
                    }
                }).catch(err => {

                })
            },
            addNewRow() {
                this.pensionApplication.attachments.push({
                    attachment_type_id:'',
                    title: '',
                    filename:'',
                    file_content:'',
                    pension_emp_id:'',
                    file_extension:'',
                    attachment_id:'',
                    emp_code:''
                })
            },
            deleteRow(index, item) {
                let idx = this.pensionApplication.attachments.indexOf(item)
                if (idx > -1 && this.pensionApplication.attachments.length > 1) {
                    this.pensionApplication.attachments.splice(idx, 1)
                }
            },
            renderPdf(emp_code) {
                this.reportParams.P_EMP_CODE = emp_code
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function(key) {
                    return  key+"="+params[key]
                }).join('&');

                this.reportUrl = '/report/render?'+queryString;
            }

        }

    }

</script>

