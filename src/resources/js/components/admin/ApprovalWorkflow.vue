<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Approval Workflow</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Workflow Name"
                                    label-for="work_flow_name"
                                    label-cols-md="3"
                                    label-align-md="right"
                                >
                                    <b-form-input v-model.trim="$v.masterData.work_flow_name.$model" id="work_flow_name"></b-form-input>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.masterData.work_flow_name.$error && !$v.masterData.work_flow_name.required}">Workflow name is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Modules"
                                    label-for="module_id"
                                    label-cols-md="3"
                                    label-align-md="right"
                                >
                                    <b-form-select
                                        v-model.trim="$v.masterData.module_id.$model"
                                        :options="moduleOptions"
                                        text-field="text"
                                        value-field="value"
                                    ></b-form-select>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.masterData.module_id.$error && !$v.masterData.module_id.required}">Module is required!</div>

                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Departments"
                                    label-for="department_id"
                                    label-cols-md="3"
                                    label-align-md="right"
                                >
                                    <b-form-select
                                        v-model.trim="$v.masterData.department_id.$model"
                                        :options="departmentOptions"
                                        text-field="department_name"
                                        value-field="department_id"
                                    ></b-form-select>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.masterData.department_id.$error && !$v.masterData.department_id.required}">Department is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col class="text-right">
                                <b-button type="submit" variant="success">Submit</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Approval Workflow List</b-card-header>
                <b-card-body class="border">
                    <Datatable :fields="fields" :items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'approval_workflow_id'">
                        <template v-slot:actions="{ rows }">
                            <b-button size="sm" variant="primary" @click="openModal(rows.item)"><i class='bx bx-list-plus'></i>ADD STEPS</b-button>
                            <b-button size="sm" variant="danger" @click="deleteWorkflow(rows.item.approval_workflow_id)"><i class='bx bx-trash'></i>DELETE</b-button>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>

            <b-modal ref="steps_modal" size="xl" title="Workflow Steps" hide-footer @close="closeModal">
                <b-card-body class="border">
                    <b-form @submit.prevent="addNewRow">
                        <b-row>
                            <b-col md="3">
                                <b-form-group>
                                    <b-form-checkbox id="role_yn" v-model="formData.role_yn" name="role_yn" value="Y" unchecked-value="N">Role Based</b-form-checkbox>
                                </b-form-group>
                            </b-col >
                        </b-row>
                        <b-row>

                            <b-col md="3">
                                <b-form-group
                                    :label="formData.role_yn == 'Y'?'Role':'User'"
                                    label-for="role_id"
                                >
                                    <v-select
                                        v-if="formData.role_yn == 'Y'"
                                        v-model="selectedRole"
                                        :options="roleOptions"
                                        name="role_id"
                                        id="role_id"
                                        label="text"
                                        class="uppercase">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>

                                    <v-select
                                        v-else
                                        v-model="selectedUser"
                                        :options="userOptions"
                                        name="user_id"
                                        id="user_id"
                                        label="option_name"
                                        @search="searchUser"
                                        class="uppercase">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.user_role.$error && !$v.formData.user_role.required}">Role is required!</div>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.user_name.$error && !$v.formData.user_name.required}">User is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col md="2">
                                <b-form-group
                                    label="Forward Title"
                                    label-for="forward_title"
                                >
                                    <b-form-input v-model="formData.forward_title" id="forward_title"></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="2">
                                <b-form-group
                                    label="Backward Title"
                                    label-for="backward_title"
                                >
                                    <b-form-input v-model="formData.backward_title" id="backward_title"></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="1">
                                <b-form-group
                                    label="Notify SMS"
                                    label-for="notify_sms_yn"
                                >
                                    <b-form-checkbox id="notify_sms_yn" v-model="formData.notify_sms_yn" name="notify_sms_yn" value="Y" unchecked-value="N"></b-form-checkbox>
                                </b-form-group>
                            </b-col>

                            <b-col md="1">
                                <b-form-group
                                    label="Notify Email"
                                    label-for="notify_email_yn"
                                >
                                    <b-form-checkbox id="notify_email_yn" v-model="formData.notify_email_yn" name="notify_email_yn" value="Y" unchecked-value="N"></b-form-checkbox>
                                </b-form-group>
                            </b-col>

                            <b-col md="2">
                                <b-form-group
                                    label="Process Step"
                                    label-for="process_step"
                                >
                                    <b-form-input v-model="formData.process_step" id="process_step" number></b-form-input>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.process_step.$error && !$v.formData.process_step.required}">Process step is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col md="1">
                                <b-form-group
                                    label="Enabled"
                                    label-for="enabled_yn"
                                >
                                    <b-form-checkbox id="enabled_yn" v-model="formData.enabled_yn" name="enabled_yn" value="Y" unchecked-value="N"></b-form-checkbox>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-button type='submit' size="sm" class="btn btn-info float-right mb-2"><i class="fa fa-plus-circle"></i> Add</b-button>
                    </b-form>
                    <b-table responsive bordered small :items="stepList" :fields="stepFields">
                        <template #table-colgroup="scope">
                            <col style="width:7%">
                            <col style="width:15%">
                            <col style="width:7%">
                            <col style="width:7%">
                            <col style="width:7%">
                            <col style="width:16%">
                            <col style="width:16%">
                            <col style="width:7%">
                            <col style="width:18%">
                        </template>
                        <template #cell(action)="row">
                            <b-button size="sm" v-if="row.item.edit_yn == 'N'" @click="row.item.edit_yn = 'Y'" variant="warning">Edit</b-button>
                            <b-button size="sm" v-if="row.item.edit_yn == 'Y'" @click="row.item.edit_yn = 'N'" variant="warning">Undo</b-button>
                            <b-button size="sm" @click="deleteRow(row.item, row.index)" class="mr-1">Remove</b-button>
                        </template>
                        <template v-slot:cell(backward_title)="{ value, item, field: { key }}">
                            <template v-if="item.edit_yn == 'N'">{{ value }}</template>
                            <b-form-input class="text-right" v-else v-model="item[key]" />
                        </template>
                        <template v-slot:cell(forward_title)="{ value, item, field: { key }}">
                            <template v-if="item.edit_yn == 'N'">{{ value }}</template>
                            <b-form-input class="text-right" v-else v-model="item[key]" />
                        </template>
                        <template v-slot:cell(process_step)="{ value, item, field: { key }}">
                            <template v-if="item.edit_yn == 'N'">{{ value }}</template>
                            <b-form-input class="text-right" v-else v-model="item[key]" />
                        </template>
                        <template v-slot:cell(enabled_yn)="{ value, item, field: { key }}">
                            <template v-if="item.edit_yn == 'N'">{{ value }}</template>
                            <select class="custom-select"  name="enabled" id="enabled" v-else v-model="item[key]" >
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select >
                        </template>
                    </b-table>
                    <b-row class="mb-2">
                        <b-col class="d-flex justify-content-center">
                            <b-button size="sm" class="col-md-4" variant="primary" type="button" @click.prevent="submit" pill>Save</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../Repository/ApiRepository";
    import Datatable from '../../layouts/common/datatable';
    import vSelect from 'vue-select';
    import moment from "moment";
    const {required, requiredIf, maxLength, minLength, maxValue, email} = require("vuelidate/lib/validators");
    export default {
        components: {Datatable, vSelect},
        name: "ApprovalWorkflow",
        data(){
            return {
                masterData: {
                    work_flow_name: '',
                    module_id: '',
                    department_id: ''
                },
                departmentOptions: [],
                formData: {
                    approval_workflow_id: '',
                    role_yn: 'N',
                    user_role: '',
                    user_id: '',
                    user_name: '',
                    forward_title: '',
                    backward_title: '',
                    notify_sms_yn: 'N',
                    notify_email_yn: 'N',
                    process_step: '',
                    enabled_yn: 'N',
                    workflow_step_id: '',
                    edit_yn: 'N'
                },
                userOptions: [],
                moduleOptions: [],
                selectedUser: {},
                roleOptions: [],
                selectedRole: {},
                stepList: [],
                stepFields: [
                    {
                        key: 'role_yn',
                        formatter: value => {
                            if(value == 'N') {
                                return 'No'
                            } else if(value == 'Y'){
                                return 'Yes'
                            } else {
                                return ''
                            }
                        },
                        label: 'Role Based'},
                    {
                        key: 'user_name',
                        label: 'User/Role',
                        formatter: (value, key, item) => {
                            return item.user_name?item.user_name:item.user_role
                        }
                    },
                    {
                        key: 'notify_sms_yn',
                        formatter: value => {
                            if(value == 'N') {
                                return 'No'
                            } else if(value == 'Y'){
                                return 'Yes'
                            } else {
                                return ''
                            }
                        },
                        label: 'Notify SMS'
                    },
                    {
                        key: 'notify_email_yn',
                        formatter: value => {
                            if(value == 'N') {
                                return 'No'
                            } else if(value == 'Y'){
                                return 'Yes'
                            } else {
                                return ''
                            }
                        },
                        label: 'Notify Email'
                    },
                    {key: 'process_step', label: 'Process Step', class: 'text-right'},
                    {key: 'backward_title', label: 'Backward Title'},
                    {key: 'forward_title', label: 'Forward Title' },
                    {
                        key: 'enabled_yn',
                        formatter: value => {
                            if(value == 'N') {
                                return 'No'
                            } else if(value == 'Y'){
                                return 'Yes'
                            } else {
                                return ''
                            }
                        },
                        label: 'Enabled'
                    },
                    {key: 'action', class:'text-center'}
                ],
                fields: [
                    {key: 'work_flow_name', label: 'Workflow Name', class: 'widthThirty'},
                    {key: 'module.module_name', label: 'Module', class: 'widthThirty'},
                    {key: 'department.department_name', label: 'Department', class: 'widthTen'},
                    {key: 'action', class:'text-center widthTen'}
                    ],
                items: [],
                totalList: 1,
                perPage: 5
            }
        },
        validations: {
            masterData: {
                work_flow_name: {required},
                module_id: {required},
                department_id: {required}
            },
            formData: {
                approval_workflow_id: {required},
                role_yn: {required},
                user_role: {
                    required: requiredIf(function () {
                        return this.formData.role_yn == 'Y' ? true : false
                    })
                },
                user_id: {},
                user_name: {
                    required: requiredIf(function () {
                        return this.formData.role_yn == 'N' ? true : false
                    })
                },
                forward_title: {},
                backward_title: {},
                notify_sms_yn: {required},
                notify_email_yn: {required},
                process_step: {required},
                enabled_yn: {required},
                workflow_step_id: {},
                edit_yn: {}
            }
        },
        mounted(){
            this.loadWorkflow()
            this.loadRoles()
            this.loadModules()
            this.loadDepartment()
        },
        watch: {
            selectedUser:function (val, oldVal) {
                if (val){
                    this.formData.user_name = val.emp_code
                    this.formData.user_id = val.user_id
                    this.formData.user_role = ''
                } else {
                    this.formData.user_name = ''
                    this.formData.user_id = ''
                    this.formData.user_role = ''
                }
            },
            selectedRole:function (val, oldVal) {
                if (val){
                    this.formData.user_role = val.value.role_key
                    this.formData.user_id = ''
                } else {
                    this.formData.user_role = ''
                    this.formData.user_id = ''
                }
            }
        },
        methods:{
            onSubmit(){
                this.$v.masterData.$touch();
                if (!this.$v.masterData.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND,`/workflow`,this.masterData).then(result => {
                       this.loadWorkflow()
                    });
                }
            },
            onReset(){
                this.formData= {
                    approval_workflow_id: this.formData.approval_workflow_id,
                    role_yn: 'N',
                    user_role: '',
                    user_id: '',
                    user_name: '',
                    forward_title: '',
                    backward_title: '',
                    notify_sms_yn: 'N',
                    notify_email_yn: 'N',
                    process_step: '',
                    enabled_yn: 'N',
                    workflow_step_id: '',
                    edit_yn: 'N'
                }
                this.selectedRole = {
                    text: '',
                    value: {}
                }
                this.selectedUser = {
                    option_name: '',
                    emp_code: ''
                }
                this.$v.$reset()
            },
            loadWorkflow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/workflow-for-all`).then(result => {
                    this.items = result.data
                    this.totalList = this.items.length
                });
            },
            loadModules(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/pmis/get-modules`).then(result => {
                    this.moduleOptions = result.data
                });
            },
            loadDepartment(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/admin/employee-position/departments`).then(result => {
                    this.departmentOptions = result.data
                });
            },
            openModal(item){
                this.$refs['steps_modal'].show()
                this.formData.approval_workflow_id = item.approval_workflow_id
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/workflow-steps/${item.approval_workflow_id}`).then(result => {
                    this.stepList = result.data
                });
            },
            deleteWorkflow(id){
                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                }).then(response=>{
                    if(response == true){
                        ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/workflow/${id}`).then(result => {
                            this.items = result.data
                            this.totalList = this.items.length
                        }).catch(error => {
                            this.$store.commit('processEnd');
                            this.$notify({group: 'pmis', text: 'The workflow already used in a process!', type: 'error'});
                        });
                    }
                }).catch(err=>{

                })
            },
            addNewRow() {
                this.$v.formData.$touch();
                if (!this.$v.formData.$invalid){
                    this.stepList.unshift(this.formData)
                    this.$nextTick(function () {
                        this.onReset()
                    })
                }

            },
            deleteRow(item, index) {

                if(item.workflow_step_id){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/delete-workflow-steps/${item.approval_workflow_id}/${item.workflow_step_id}`).then(result => {
                        this.stepList = result.data
                        this.$notify({group: 'pmis', text: 'The step has been deleted!', type: 'success'});
                    }).catch(error => {
                        this.$notify({group: 'pmis', text: 'The step already used in a process!', type: 'error'});
                    });
                } else {
                    let idx = this.stepList.indexOf(item)
                    if (idx > -1 && this.stepList.length > 1) {
                        this.stepList.splice(idx, 1)
                    }
                }
            },
            searchUser(name){
                if (name) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${name}`).then(res => {
                        this.userOptions = res.data;
                    })
                }
            },
            loadRoles(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/system-admin/role`).then(res => {
                    this.roleOptions = res.data.roles;
                })
            },
            closeModal(){
                this.stepList = []
                this.formData= {
                    approval_workflow_id: '',
                    role_yn: 'N',
                    user_role: '',
                    user_id: '',
                    user_name: '',
                    forward_title: '',
                    backward_title: '',
                    notify_sms_yn: 'N',
                    notify_email_yn: 'N',
                    process_step: '',
                    enabled_yn: 'N',
                    workflow_step_id: '',
                    edit_yn: 'N'
                }
                this.selectedRole = {
                    text: '',
                    value: {}
                }
                this.selectedUser = {
                    option_name: '',
                    emp_code: ''
                }
            },
            submit(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND,`/store-workflow-steps`,this.stepList).then(result => {
                    this.stepList = result.data
                    if(result.data.length > 0){
                        this.$notify({group: 'pmis', text: 'The steps has been added!', type: 'success'});
                    }
                });
            }
        }
    }
</script>

<style>
    .widthThirty {
        width:30%;
    }
    .widthTen{
        width: 20%;
    }
</style>
