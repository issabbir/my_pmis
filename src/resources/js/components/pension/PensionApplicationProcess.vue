<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Search for Pension Calculation</b-card-header>

                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch" @reset.prevent="onReset">
                        <b-row>
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
                                <b-form-group label="DEPARTMENT" label-for="department" class="requiredField">
                                    <b-form-select
                                        id="department"
                                        v-model="formData.department_id"
                                        :options="departmentOptions"
                                        text-field="department_name"
                                        value-field="department_id"
                                    >
                                        <template #first>
                                            <option value="">ALL</option>
                                        </template>
                                    </b-form-select>
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
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Calculation List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                        <template v-slot:actions="{ rows }">
                            <a v-if="rows.item.calculation_status == 'Calculated'" size="sm" variant="primary" :href="reportUrl" @click="printDrafRLt(rows.item.emp_code)" target="_blank"><i class="bx bx-file cursor-pointer"></i></a>
                            <!--                            <a v-b-modal.modal-center @click="editRow(rows.item)"><i class="bx bx-edit cursor-pointer"></i> </a>-->
                            <a v-b-modal.modal-center v-if="(rows.item.calculation_status!='Calculated') && rows.item.approval_workflow_id == null" @click="renderModal(rows.item)"><i class="bx bx-edit cursor-pointer"></i> </a>

<!--                                    <b-link v-b-modal.modal-center v-if="rows.item.calculation_status == 'Calculated'"  variant="primary"  @click="renderModal(modalData.emp_code)" ><i class="bx bx-show cursor-pointer"></i></b-link>-->
<!--                           <b-link :to='"/prl-personal-record/"+rows.item.emp_id'>hello&ndash;&gt;-->
<!--                               <i class="bx bx-link cursor-pointer"></i>&ndash;&gt;&ndash;&gt;-->
<!--                            </b-link>&ndash;&gt;-->
                        </template>
                        <template v-slot:action2="{ rows }">
                            <span v-if="rows.item.calculation_status == 'Calculated'" class="text-success text-center">Calculated</span>
                            <span class="text-danger text-center" v-else>Not Calculated</span>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <div>
                <b-modal
                    id="modal-center"
                    @ok="processed()"
                    ok-title="Calculate"
                    scrollable
                    size="xl"
                    body-bg="light"
                    :title="message+' '+modalData.emp_name">
                    <b-container fluid>
                        <fieldset class="border pr-2 pl-2">
                            <legend class="w-auto" style="font-weight: bold;">Basic Information</legend>
                            <b-row>
                                <b-col md="3">
                                    <b-form-group label="Employee Name" label-for="emp_name">
                                        <b-form-input
                                            id="emp_name"
                                            v-model="modalData.emp_name"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Birth Date" label-for="dob">
                                        <b-form-input
                                            id="dob"
                                            v-model="modalData.emp_dob"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Gender" label-for="emp_gender_name">
                                        <b-form-input
                                            id="emp_gender_name"
                                            v-model="modalData.emp_gender_name"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Religion" label-for="emp_religion_name">
                                        <b-form-input
                                            id="emp_religion_name"
                                            v-model="modalData.emp_religion_name"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Father's Name" label-for="emp_father_name">
                                        <b-form-input
                                            id="emp_father_name"
                                            v-model="modalData.emp_father_name"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Mother's Name" label-for="emp_mother_name">
                                        <b-form-input
                                            id="emp_mother_name"
                                            v-model="modalData.emp_mother_name"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="NID" label-for="nid_no">
                                        <b-form-input
                                            id="nid_no"
                                            v-model="modalData.nid_no"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Contact" label-for="contract">
                                        <b-form-input
                                            id="contract"
                                            v-model="modalData.contract"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group label="Present Address" label-for="present_address">
                                        <b-form-textarea
                                            id="present_address"
                                            v-model="modalData.present_address"
                                            rows="2"
                                            max-rows="3"
                                            readonly
                                        ></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group label="Permanent Address" label-for="permanent_address">
                                        <b-form-textarea
                                            id="permanent_address"
                                            v-model="modalData.permanent_address"
                                            rows="2"
                                            max-rows="3"
                                            readonly
                                        ></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </fieldset>
                        <fieldset class="border pr-2 pl-2">
                            <legend class="w-auto" style="font-weight: bold;">Job Information</legend>
                            <b-row>
                                <b-col md="3">
                                    <b-form-group label="Employee Code" label-for="emp_code">
                                        <b-form-input
                                            id="emp_code"
                                            v-model="modalData.emp_code"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Division" label-for="division_name">
                                        <b-form-input
                                            id="division_name"
                                            v-model="modalData.division_name"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Department" label-for="department_name">
                                        <b-form-input
                                            id="department_name"
                                            v-model="modalData.department_name"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Designation" label-for="designation">
                                        <b-form-input
                                            id="designation"
                                            v-model="modalData.designation"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Employee Type" label-for="emp_type">
                                        <b-form-input
                                            id="emp_type"
                                            v-model="modalData.emp_type"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Status" label-for="emp_status">
                                        <b-form-input
                                            id="emp_status"
                                            v-model="modalData.emp_status"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Class" label-for="emp_class">
                                        <b-form-input
                                            id="emp_class"
                                            v-model="modalData.emp_class"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="NPS Year" label-for="nps_year">
                                        <b-form-input
                                            id="nps_year"
                                            v-model="modalData.nps_year"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="12" class="border mb-2">
                                    <b-table
                                        :items="nomineeItems"
                                        :fields="nomineeFields"
                                        sort-icon-left
                                        responsive="sm"
                                        :small="small"
                                        hover
                                        head-variant="dark"
                                        class="mt-2"
                                    >
                                        <template v-slot:cell(index)="data">
                                            {{ data.index + 1 }}
                                        </template>
                                    </b-table>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Joining Date" label-for="emp_join_date">
                                        <b-form-input
                                            id="emp_join_date"
                                            v-model="modalData.emp_join_date"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="PRL Date" label-for="emp_lpr_date">
                                        <b-form-input
                                            id="emp_lpr_date"
                                            v-model="modalData.emp_lpr_date"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="GPF STATUS" label-for="gpf_status">
                                        <b-form-radio-group
                                            id="gpf_status"
                                            v-model="modalData.gpf_status"
                                        >
                                            <b-form-radio value="Y" disabled>Yes</b-form-radio>
                                            <b-form-radio value="N" disabled>No</b-form-radio>
                                        </b-form-radio-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="GPF ID" label-for="gpf_id">
                                        <b-form-input
                                            id="gpf_id"
                                            v-model="modalData.gpf_id"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Bank Account" label-for="emp_bank_acc_no">
                                        <b-form-input
                                            id="emp_bank_acc_no"
                                            v-model="modalData.emp_bank_acc_no"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Bank Name" label-for="bank">
                                        <b-form-input
                                            id="bank"
                                            v-model="modalData.bank"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Branch Name" label-for="bank_branch">
                                        <b-form-input
                                            id="bank_branch"
                                            v-model="modalData.bank_branch"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Bill Code" label-for="bill_code">
                                        <b-form-input
                                            id="bill_code"
                                            v-model="modalData.bill_code"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Biller Code" label-for="biller_code">
                                        <b-form-input
                                            id="biller_code"
                                            v-model="modalData.biller_code"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Grade" label-for="emp_grade_id">
                                        <b-form-input
                                            id="emp_grade_id"
                                            v-model="modalData.emp_grade_id"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group label="Grade Step" label-for="grade_step_id">
                                        <b-form-input
                                            id="grade_step_id"
                                            v-model="modalData.grade_step_id"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Last Pay Scale" label-for="last_scale">
<!--                                        <b-input-group prepend="৳">-->
                                            <b-form-input
                                                id="last_scale"
                                                v-model="modalData.last_scale"
                                                class="text-right"
                                                readonly
                                            ></b-form-input>
<!--                                        </b-input-group>-->
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Service Period" label-for="service_period">
                                        <b-form-input
                                            id="service_period"
                                            v-model="modalData.service_period"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Actual Service Period" label-for="actual_service_period">
                                        <b-form-input
                                          id="actual_service_period"
                                          v-model="modalData.actual_service_period"
                                          readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group label="Last Basic" label-for="basic">
                                        <b-form-input
                                            id="basic"
                                            v-model="modalData.last_basic"
                                            class="text-right"
                                            readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="12">
                                    <b-form-group label="Comment" label-for="comment">
                                        <b-form-textarea
                                          id="comment "
                                          v-model="modalData.comment"
                                        ></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </fieldset>
                    </b-container>

                    <template v-slot:modal-footer="{ ok, cancel }">
                        <b-button size="sm" :hidden="ProcessBtnHidden" variant="success" @click="ok()">Calculate</b-button>
<!--                        <b-button size="sm" :hidden="UpdateBtnHidden" variant="outline-secondary" @click="update()">Update</b-button>-->
                        <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
                    </template>
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
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Application Calculation"});
            this.preLoadData()
            this.onSearch()
        },
        data() {
            return {
                reportUrl:'',
                reportParams: {
                    xdo:'/~weblogic/Pension/RPT_PENSION_APPLICATION_CALCULATION.xdo',
                    type:"pdf",
                    P_EMP_CODE:'',
                    filename:'Employee Details'},
                selectedEmployee: [],
                empIdList: [],
                departmentOptions:[],
                totalNominee:0,
                small: true,
                nomineeItems:[],
                formData: {
                    department_id: ''
                },
                modalData:{
                    comment: null,
                    last_basic: null
                },
                readonly:false,
                disabledRadio:false,
                UpdateBtnhidden:false,
                ProcessBtnhidden:false,
                message:'',
                employeeCode:null,
                totalList:null,
                perPage:5,
                nomineeFields: [
                    {key:'index', label:'SL', sortable:true},
                    {key:'nominee_name', label: 'Nominee Name', sortable:true},
                    {key:'relationship', label: 'Relationship', sortable:true},
                    {key:'percentage', label: 'Percentage', sortable:true},
                ],
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL', class: 'text-center'},
                        {key: 'emp_code', label: 'Title', sortable: true, class: 'text-center'},
                        {key: 'emp_name', label: 'Title BN', class: 'text-left'},
                        {key: 'department_name', label: 'Note EN'},
                        {key: 'designation', label: 'Designation', sortable: true},
                        {key: 'apps_date', label: 'Application Date', sortable: true, class: 'text-left'},
                        {key: 'pension_amt', label: 'Calculated Amount', sortable: true, class: 'text-right'},
                        // {key: 'calculation_status', label: 'Calculation Status', sortable: true},
                        {key: 'action2', label: 'Calculation Status'},
                        'action'],
                    items: []
                }
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.formData.emp_code = val.emp_code;
                    this.formData.emp_id = val.emp_id;
                    this.formData.department_id = val.dpt_department_id;
                    this.formData.designation_id = val.designation_id;
                    this.formData.apps_id=val.apps_id;
                }
            }
        },

        filters: {
            dateFormat: function(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY hh:mm')
                }
            }
        },

        methods: {

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
            onSearch() {
                let data=this.formData;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/search-pension-calculated-data`, data).then(res => {
                    this.tableData.items = res.data;
                    this.totalList=res.data.length;
                });
            },
            renderModal(item) {
                this.message='Pension Settlement For';
                this.modalData = item;
                this.readonly=true;
                this.disabledRadio=true;
                this.UpdateBtnHidden=true;
                this.ProcessBtnHidden=false;
                this.loadNominee(this.modalData.emp_id);
            },
            editRow(item) {
                this.message='Pension Calculation Information For';
                this.modalData = item;
                this.readonly=false;
                this.disabledRadio=false;
                this.UpdateBtnHidden=false;
                this.ProcessBtnHidden=true;
                this.loadNominee(this.modalData.emp_id);
            },

            processed() {
                if(confirm("Do you really want to process?")){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/pension-calculation`,this.modalData).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onSearch();
                        this.formData={};
                        this.selectedEmployee=[];
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
                }
            },
            update(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/pension-process`, this.modalData).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.formData={};
                this.selectedEmployee=[];
                this.tableData.items=[];
            },
            // printDraft(i) {
            //     // let title='Prl-notice'
            //     this.reportParams.p_emp_code =i;
            //     let params = this.reportParams;
            //     let queryString = Object.keys(params).map(function (key) {
            //         return key + "=" + params[key]
            //     }).join('&');
            //     this.reportUrl = '/report/render/settlement_draft?' + queryString;
            // },
            printDrafRLt(i) {
                // let title='Prl-notice'
                this.reportParams.p_emp_code =i;
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                this.reportUrl = '/report/render/employee_details?' + queryString;
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/search-pension-empcode/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            preLoadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.departmentOptions = res.data.departments;
                });
            },

            loadNominee: function(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications/nominee/${id}`).then(res => {
                    this.nomineeItems = res.data;
                    this.totalNominee=res.data.length;
                    console.log(res.data);
                });
            },
            showWorkflowModal(id){
                this.workflowData.pension_calculation_id = id
                this.$refs['workflow_modal'].show()
            },
            hideWorkflowModal(){
                this.workflowData.pension_calculation_id = ''
                this.$refs['workflow_modal'].hide()
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

