<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Nominee Search </b-card-header>
                <b-card-body class="border">
                    <b-form>
                        <b-row>
                            <b-col md="6">
                                <b-form-group label="Employee Code" label-for="emp_code" label-cols-md="4" class="requiredField">
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
                                <b-button type="submit" id="basic_sub_btn" @click="searchNominee" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pending Nominee For Approval</b-card-header>
                <b-card-body class="border">
                    <b-form
                        @submit.prevent="showConfirmBox"
                        class="form form-vertical col-md-12 ">
                        <Datatable
                          :fields="tableData.fields"
                          :items="tableData.items.filter(a=>a.percentage > 0)"
                          :perPage="perPage"
                          :totalList="totalList"
                          :filter-ignored-fields="['auth_attachment']"
                          :tbody-tr-class="rowClass"
                        >
                            <template v-slot:actions="{ rows }">
                                <b-button size="sm" @click="showModalDetail(rows.item)" variant="primary">Detail</b-button>
                                <b-button size="sm" v-if="rows.item.approved_yn=='N' && rows.item.approval_workflow_id != null" @click="showModalApproval(rows.item)" variant="primary">Approve</b-button>
                                <b-button size="sm" v-if="rows.item.approval_workflow_id==null" @click="showWorkflowModal(rows.item.nominee_id)" variant="primary">WORKFLOW</b-button>
                                <!--<a  @click="rows.item.approved_yn=(rows.item.approved_yn == 'Y')?'N':'Y'">
                                    <i v-if="rows.item.approved_yn == 'Y'" title="Keep process"  class='text-success bx bxs-checkbox-checked' ></i>
                                    <i class='bx bxs-checkbox text-danger' title="Hold" v-else ></i>
                                </a>-->
                            </template>
                        </Datatable>
<!--                        <b-row class="mt-4">-->
<!--                            <b-col class="d-flex justify-content-end">-->
<!--                                <b-button-group>-->
<!--                                    <b-button type="submit" variant="primary">Approve</b-button>-->
<!--                                </b-button-group>-->
<!--                            </b-col>-->
<!--                        </b-row>-->
                    </b-form>
                </b-card-body>
            </b-card>
        </div>
        <b-modal ref="workflow_modal" @ok="mapWorkflow" @close="hideWorkflowModal">
            <b-form-select v-model="workflowData.approval_workflow_id" text-field="work_flow_name" value-field="approval_workflow_id" :options="workflowOptions"></b-form-select>
        </b-modal>
        <b-modal v-model="approveShow" size="xl" okTitle="Submit" :hide-footer=true :hide-header=true>
            <b-row >
                <b-col>
                    <h4>{{'Nominee approval process'}}</h4>
                </b-col>
                <b-col class="d-flex justify-content-end">
                    <b-button size="sm" variant="outline-secondary" @click="hideApprovalModal()">Close</b-button>
                </b-col>
            </b-row>
            <b-row  class="border mb-1 pt-1 pb-1 mt-2">
                <b-col>
                    <h5>Process Step</h5>
                    <b-progress :value="current_step.process_step*25"  variant="success" key="success"></b-progress>
                    <b-form @submit.prevent="addState(next_step?next_step:current_step)">
                        <b-row class="pt-1">
                            <b-col v-if="current_step">
                                <b-list-group>
                                    <b-list-group-item href="#" class="flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div class="text-success">{{current_step.workflow}}</div>
                                            <small><span class="badge badge-pill badge-secondary">{{current_step.insert_date|dateFormat}}</span></small>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <small>By {{(current_step.user)?current_step.user.emp_name:''}}</small>
                                            <small>{{(current_step.user)?current_step.user.designation:''}}</small>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between" v-if="false">
                                            <div>
                                                Current status: <b-badge variant="warning">Pending</b-badge>
                                            </div>
                                            <div>
                                                <b-button size="sm"  pill variant="success">Accept</b-button>
                                                <b-button size="sm" pill variant="outline-danger">Change request</b-button>
                                            </div>
                                        </div>
                                        <div>
                                            <b-list-group >
                                                <b-list-group-item v-if="false">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <b-input-group>
                                                            <b-form-input></b-form-input>
                                                            <b-input-group-append>
                                                                <b-button variant="outline-primary">ADD</b-button>
                                                            </b-input-group-append>
                                                        </b-input-group>
                                                    </div>
                                                </b-list-group-item>
                                                <b-list-group-item  class="mt-1">
                                                    <div><pre>{{current_step.note}}</pre></div>
                                                </b-list-group-item>
                                            </b-list-group>
                                        </div>
                                    </b-list-group-item>
                                </b-list-group>

                                <div v-if="hasHistoryPermission()" class="mt-1">
                                    <b-button  variant="warning" @click="showHistory = !showHistory" ><i
                                        class='bx bxs-down-arrow-square'></i> Show Authorization Status Histories
                                    </b-button>
                                    <b-list-group v-if="showHistory" class="mt-1">
                                        <b-list-group-item v-for="state in workflowProcess" :key="state.workflow_step.workflow_key" href="#" class="flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <div class="text-success">{{state.workflow_step.workflow}}</div>
                                                <small><span class="badge badge-pill badge-secondary">{{state.workflow_step.insert_date|dateFormat}}</span></small>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between">
                                                <small>By {{state.user.emp_name}}</small>
                                                <small>{{state.user.designation}}</small>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between" v-if="false">
                                                <div>
                                                    Current status: <b-badge variant="warning">Pending</b-badge>
                                                </div>
                                                <div>
                                                    <b-button size="sm"  pill variant="success">Accept</b-button>
                                                    <b-button size="sm" pill variant="outline-danger">Change request</b-button>
                                                </div>
                                            </div>
                                            <div>
                                                <b-list-group >
                                                    <b-list-group-item v-if="false">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <b-input-group>
                                                                <b-form-input></b-form-input>
                                                                <b-input-group-append>
                                                                    <b-button variant="outline-primary">ADD</b-button>
                                                                </b-input-group-append>
                                                            </b-input-group>
                                                        </div>
                                                    </b-list-group-item>
                                                    <b-list-group-item class="mt-1">
                                                        <div>{{state.note}}</div>
                                                    </b-list-group-item>
                                                </b-list-group>
                                            </div>
                                        </b-list-group-item>
                                    </b-list-group>
                                </div>
                            </b-col>
                            <b-col>
                                <div>
                                    <div v-if="!next_step" class="d-flex w-100 justify-content-center">
                                        <b-card bg-variant="success" text-variant="white" :title="nextState.status_name">
                                            <b-card-text >
                                                <b-row v-if="backWard">
                                                    <b-col md="12">
                                                        <b-form-group label="Change state to" label-for="from-state">
                                                            <b-form-select required v-model="workflow.workflow_step_id" :options="splicedOptions"></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="12">
                                                        <b-form-group class="requiredField" label="Note" label-for="workflow-note">
                                                            <b-form-textarea :disabled="!hasPermission(current_step)"
                                                                             v-model="workflow.note"
                                                                             required
                                                                             placeholder="Enter something..."
                                                            ></b-form-textarea>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="12" class="d-flex justify-content-center">
                                                        <b-button type="submit" :disabled="!hasPermission(current_step)" class="mr-1" variant="dark"><i class='bx bxs-send'></i> Update State</b-button>
                                                        <b-button @click="backWard=false" variant="primary">Back to Approve</b-button>
                                                        <small class="text-danger" v-if='!hasPermission(current_step)'>You don't have permission to do this!!</small>
                                                    </b-col>
                                                </b-row>
                                                <b-row v-else>
                                                    <b-col md="12" >
                                                        <div>All approval process has been done. Now the application ready to approve.</div>

                                                    </b-col>
                                                    <b-col class="d-flex justify-content-center">
                                                        <b-button type="button" :disabled="!hasPermission(current_step)" class="mr-1" variant="primary" @click="confirmShow = true" >Approve</b-button>
                                                        <b-button @click="backWard = true">Backward</b-button>
                                                        <small class="text-danger" v-if='!hasPermission(current_step)'>You don't have permission to change the state!!</small>
                                                    </b-col>
                                                </b-row>
                                            </b-card-text>
                                        </b-card>
                                    </div>
                                    <div v-else>
                                        <b-form-group label="Change state to" label-for="from-state">
                                            <b-form-select required v-model="workflow.workflow_step_id" :options="options"></b-form-select>
                                        </b-form-group>
                                        <b-form-group class="requiredField" label="Note" label-for="workflow-note">
                                            <b-form-textarea :disabled="!hasPermission(current_step)"
                                                             v-model="workflow.note"
                                                             required
                                                             placeholder="Enter something..."
                                            ></b-form-textarea>
                                        </b-form-group>
                                        <div>
                                            <b-button type="submit" :disabled="!hasPermission(current_step)" variant="dark"><i
                                                class='bx bxs-send'></i> Update State
                                            </b-button>
                                            <small class="text-danger" v-if='!hasPermission(current_step)'>You don't have permission to do this!!</small>
                                        </div>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                    </b-form>
                    <b-modal v-model="confirmShow" :centered="true" title="Please Confirm"  size="sm"
                             buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2" @ok="finalApproved()"
                             :hideHeaderClose="false" >
                        <div>Are you sure want to final approve this?</div>
                    </b-modal>
                </b-col>
            </b-row>
        </b-modal>
        <b-modal ref="detail_modal" size="xl" hide-footer title="Nominee Details">
            <b-row>
                <b-col md="3">
                    <b-form-group
                            label="Employee"
                            label-for="employee"
                    >
                        <b-form-input id="employee" readonly :value="detailFormData.emp_code+' - '+detailFormData.emp_name"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Nominee Name"
                        label-for="nominee_name"
                    >
                        <b-form-input id="nominee_name" readonly v-model="detailFormData.nominee_name"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Relation"
                            label-for="relation_type"
                    >
                        <b-form-input id="relation_type" readonly v-model="detailFormData.relation_type"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Contact Number"
                            label-for="nominee_contact_no"
                    >
                        <b-form-input id="nominee_contact_no" readonly v-model="detailFormData.nominee_contact_no"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Email"
                            label-for="nominee_email"
                    >
                        <b-form-input id="nominee_email" readonly v-model="detailFormData.nominee_email"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Birth Date"
                            label-for="nominee_dob"
                    >
                        <b-form-input id="nominee_dob" readonly :value="detailFormData.nominee_dob|dateFormat2"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Gender"
                            label-for="gender_name"
                    >
                        <b-form-input id="gender_name" readonly :value="detailFormData.gender_name"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Autistic"
                            label-for="autistic"
                    >
                        <b-form-input id="autistic" readonly :value="detailFormData.autistic"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Bank"
                            label-for="bank_name"
                    >
                        <b-form-input id="bank_name" readonly :value="detailFormData.bank_name"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Branch"
                            label-for="branch"
                    >
                        <b-form-input id="branch" readonly :value="detailFormData.branch"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Account Number"
                            label-for="nominee_acc_no"
                    >
                        <b-form-input id="nominee_acc_no" readonly :value="detailFormData.nominee_acc_no"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                            label="Percentage"
                            label-for="percentage"
                    >
                        <b-form-input id="percentage" readonly :value="detailFormData.percentage"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="12" class="d-flex justify-content-end">
                    <b-link v-if="detailFormData.auth_attachment" @click="showAttachment(detailFormData.auth_attachment)" class="mr-2">
                        <i class="bx bx-download cursor-pointer"></i></b-link>
                    <b-button size="sm" v-if="detailFormData.approval_workflow_id==null" @click="showWorkflowModal(detailFormData.nominee_id)" variant="primary">WORKFLOW</b-button>
                </b-col>
            </b-row>
        </b-modal>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from "../../layouts/common/datatable"
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';

    export default {
        name: "nominee-approval",
        components: {DatePicker, Datatable, vSelect, vcss},
        data(){
            return{
                detailFormData: {

                },
                nomineeSearch: { emp_id:null},
                nominee_id: 0,
                dateValueType: this.dateFormatter(),
                nominee: {
                    item: {},
                    object_id: '',
                    note:''
                },
                approveShow: false,
                workflowOptions: [],
                workflowProcess:[],
                next_step:{},
                workflow_step_id:'',
                previous_step:{},
                current_step:{},
                process_step:'',
                billStates:[],
                nextState:{},
                approval:{},
                comment:{},
                stateOptions: [],
                currentStatus: {process_step:''},
                options:[],
                showHistory:false,
                confirmShow:false,
                backWard: false,
                workflowData: {
                    approval_workflow_id: '',
                    nominee_id: ''
                },
                workflow:{
                    workflow_step_id:'',
                    note:''
                },

                perPage: 15,
                totalList: 1,
                selectedEmployee: [],
                empIdList: [],
                departmentList: [],
                disabled: false,
                datetime: new Date(),
                departmentOptions: [],
                searchParam: '',
                submitBtn: 'Save',
                formData: {
                    emp_id: "",
                    emp_code: "",
                    emp_name: "",
                    department_id: null,
                },
                show: true,
                tableData: {
                    fields: [
                        {key: 'index', label: 'Sl', sortable: true},
                        {key: 'nominee_name', label: 'Nominee Name', sortable: true},
                        {
                            key: 'nominee_for_id',
                            label: 'Nominee For',
                            sortable: true,
                            formatter: value => {
                                if(value == 1) {
                                    return 'GPF'
                                } else if(value == 2){
                                    return 'Pension'
                                } else {
                                    return 'BNF'
                                }
                            },
                        },
                        {key: 'emp_code', label: 'Employee Code', sortable: true},
                        {key: 'emp_name', label: 'Employee Name', sortable: true},
                        {key: 'nominee_contact_no', label: 'Nominee Contact NO', sortable: true},
                        {
                            key: 'autistic_yn',
                            label: 'Autistic',
                            formatter: value => {
                                if(value == 'Y') {
                                    return 'Yes'
                                } else if(value == 'N'){
                                    return 'No'
                                } else {
                                    return ''
                                }
                            },
                            class: 'text-center',
                            sortable: true
                        },
                        {key: 'percentage', label: 'Percentage', sortable: true},
                        {key: 'last_updated_by', label: 'Last Updated By', sortable: true},
                        {key: 'action', class: 'text-center'}
                    ],
                    items: []
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval Nominees"});
            this.loadNominee()
            this.loadWorkflow();
           // this.$router.nominee_id
            //console.log(this.$route.query.nominee_id)
        },
        computed:{

        },
        watch:{
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.nomineeSearch.emp_id = val.emp_id;
                    this.nomineeSearch.emp_code = val.emp_code;
                    this.nomineeSearch.emp_name = val.emp_name;
                    this.nomineeSearch.department_id = val.dpt_department_id;
                }
            }
        },
        filters: {
            dateFormat: function(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY hh:mm')
                }
            },
            dateFormat2: function(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY')
                }
            }
        },
        methods: {
            rowClass(item, type) {
                let nominee_id = this.$route.query.nominee_id ? this.$route.query.nominee_id : '';
                if (!item || type !== 'row') return
                if (item.nominee_id == nominee_id) return 'table-success active'
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
            searchNominee() {
                let empId = this.nomineeSearch.emp_id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/unapproved-nominees?emp_id=`+empId).then(res => {
                    this.tableData.items = res.data
                    this.totalList = res.data.length
                })
            },
            hideApprovalModal(){
                this.approveShow = false;
            },
            changeStatus(item) {
                let status = item.hold_yn=='Y' ? 'N' : 'Y'
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/nominees/update-nominee-hold-yn/'+item.nominee_id+'/'+status, items).then(res => {
                    if (res.data.status) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        this.loadNominee();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
            },
            setEmployee: function (item) {
                this.selectedEmployee = {
                    emp_id: item.emp_id,
                    option_name: item.emp_code + ' ' + item.emp_name,
                    designation: item.designation,
                    department_name: item.department_name,
                    basic_amt: item.basic_from,
                    emp_code: item.emp_code,
                    emp_name: item.emp_name,
                    department_id: item.department_id,
                    dpt_department_id:item.dpt_department_id,
                    designation_id: item.designation_id,
                }
            },
            showAttachment(order_attachment) {
                const win = window.open("","_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="'+order_attachment+'"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);

            },
            renderModal(item) {
                this.setEmployee(item)
                this.tour.tour_id = item.tour_id;
                this.tour.approve_note = item.approve_note;
            },
            onProcess() {
                let obj = {};
                obj.items = this.tableData.items.filter( i => {
                    return i.approved_yn == 'Y';
                });
                let empId = this.nomineeSearch.emp_id;
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pmis/employee/approve-nominee?emp_id=`+empId, obj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadNominee();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                        // console.log(res.data);
                    })
                }
            },
            showWorkflowModal(id){
                this.workflowData.nominee_id = id
                this.$refs['workflow_modal'].show()
            },
            hideWorkflowModal(){
                this.workflowData.nominee_id = ''
                this.$refs['workflow_modal'].hide()
            },
            showModalApproval(item) {
                this.nominee = {
                    item: item,
                    object_id:'Nominee'+item.nominee_id,
                    note:''
                };
                //console.log(this.nominee.item.nominee_name)
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow/status/${item.approval_workflow_id}/${this.nominee.object_id}`).then(res => {
                    this.workflowProcess = res.data.workflowProcess;
                    this.next_step = res.data.next_step;
                    if (this.next_step)
                        this.workflow_step_id = this.next_step.workflow_step_id;
                    this.previous_step = res.data.previous_step;
                    this.current_step = res.data.current_step;
                    this.options = res.data.options;
                    this.approveShow = true;
                    this.workflow.workflow_step_id = res.data.next_step.workflow_step_id;
                });

            },

            showModalDetail(item){
                this.detailFormData = item
                this.$refs['detail_modal'].show()
            },
            mapWorkflow(){
                let nominee_id = this.workflowData.nominee_id
                this.workflowData.nominee_id = 'Nominee'+this.workflowData.nominee_id
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pmis/employee/update-nominee-workflow/${nominee_id}`, this.workflowData).then(res => {
                    if (res.data.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Successfully Done', type: 'success'});
                        this.loadNominee();
                    } else {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Failed', type: 'error'});
                    }
                });
            },
            loadWorkflow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow_for_module/1`).then(res => {
                    this.workflowOptions = res.data
                });
            },
            onReset() {
                this.selectedEmployee = {emp_id:null};
                this.tour={};
                this.submitBtn = 'Save';
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`;
                this.infoModal.content = JSON.stringify(item, null, 2);
                this.$root.$emit("bv::show::modal", this.infoModal.id, button);
            },
            resetInfoModal() {
                this.infoModal.title = "";
                this.infoModal.content = "";
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
            loadNominee() {
                let empId = '';
                let nominee_id = this.$route.query.nominee_id ? this.$route.query.nominee_id : '';
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/unapproved-nominees?emp_id=`+empId+`&nominee_id=`+ nominee_id).then(res => {
                    this.tableData.items = res.data
                    this.totalList = res.data.length
                })
            },
            /*hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },*/
            hasPermission: function(step) {
                if(step.role_yn=='Y'){
                    let hasRole = this.$store.getters.roles.filter( element => element.role_key == step.user_role);
                    return hasRole.length>0;
                } else {
                    return step.user_name == this.$store.state.user.user_name
                }

            },
            hasHistoryPermission:function() {
                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess;
                }

                return this.$store.getters.permissions.includes('CAN_SEE_STATUS_HISTORIES');
            },
            finalApproved: function() {
                let state = (this.next_step)?this.next_step:this.current_step;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/employee/final-approve/${state.approval_workflow_id}/${this.nominee.item.nominee_id}`, state).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.hideApprovalModal();
                        this.loadNominee();
                        this.confirmShow = false;
                        this.approveShow = false;
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            addState: function(state) {
                state.workflow_object_id = (this.next_step)?this.next_step.approval_workflow_id:this.current_step.approval_workflow_id;
                state.note = this.workflow.note;
                state.workflow_step_id = this.workflow.workflow_step_id;
                state.target_url = window.location.pathname.substring(1)+'#'+this.$route.path+'?nominee_id='+this.nominee.item.nominee_id
                state.message = 'Nominee (' + this.nominee.item.nominee_name + ') approval review request sent to you.'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/workflow/status/${state.approval_workflow_id}/${this.nominee.object_id}`, state).then(res => {
                    this.workflowProcess = res.data.workflowProcess;
                    this.next_step = res.data.next_step;
                    if (this.next_step)
                        this.workflow_step_id = this.next_step.workflow_step_id;
                    this.previous_step = res.data.previous_step;
                    this.current_step = res.data.current_step;
                    this.options = res.data.options;
                    this.workflow.note = ''
                    this.backWard = false
                    // this.$emit('current-status');
                });
            },
            showConfirmBox() {
                this.$bvModal.msgBoxConfirm('Please confirm that you want to approve the Nominee.', {
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
                        this.onProcess()
                    }
                })
                .catch(err => {
                })
        }
        }
    }
</script>

<style scoped>
    .bx{
        font-size: 2.2rem;
    }
</style>
