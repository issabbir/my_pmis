<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Search For Arrear Bill</b-card-header>
                <b-card-body class="border">
            <b-row  class="border mb-1 pt-1 pb-1 mt-2">
                <b-col>
                    <h5>Process Step</h5>
                    <b-progress :value="current_step.process_step * progressValue"  variant="success" key="success"></b-progress>
                    <b-form>
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

                                <div  class="mt-1">
                                    <b-button  variant="warning" @click="showHistory = !showHistory" ><i
                                        class='bx bxs-down-arrow-square'></i> Show Authorization Status Histories
                                    </b-button>
                                    <b-list-group v-if="showHistory" class="mt-1">
                                        <b-list-group-item v-for="(state, index) in workflowProcess" :key="index" href="#" class="flex-column align-items-start">
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
                                <div v-if="next_step">
                                    <div v-if="next_step.workflow_key == 'APPROVED'" class="d-flex w-100 justify-content-center">
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
                                                            <b-form-textarea :disabled="!hasPermission(next_step.user_role)"
                                                                             v-model="workflow.note"
                                                                             required
                                                                             placeholder="Enter something..."
                                                            ></b-form-textarea>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="12" class="d-flex justify-content-center">
                                                        <b-button type="button" @click="addState(next_step)" :disabled="!hasPermission(next_step.user_role)" class="mr-1" variant="dark"><i class='bx bxs-send'></i> Update State</b-button>
                                                        <b-button @click="backWard=false" variant="primary">Back to Approve</b-button>
                                                        <small class="text-danger" v-if='!hasPermission(next_step.user_role)'>You don't have permission to do this!!</small>
                                                    </b-col>
                                                </b-row>
                                                <b-row v-else>
                                                    <b-col md="12" >
                                                        <div>All approval process has been done. Now the application ready to approve.</div>
                                                        <b-form-group label="Note" label-for="workflow-note">
                                                            <b-form-textarea
                                                                :disabled="!hasPermission(next_step.user_role)"
                                                                v-model="workflow.note"
                                                                placeholder="Enter something..."
                                                            ></b-form-textarea>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col class="d-flex justify-content-center">
                                                        <b-button type="button" :disabled="!hasPermission(next_step.user_role)" class="mr-1" variant="primary" @click="confirmShow = true" >Approve</b-button>
                                                        <b-button @click="backWard = true">Backward</b-button>
                                                        <small class="text-danger" v-if='!hasPermission(next_step.user_role)'>You don't have permission to change the state!!</small>
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
                                            <b-form-textarea :disabled="!hasPermission(next_step.user_role)"
                                                             v-model="workflow.note"
                                                             required
                                                             placeholder="Enter something..."
                                            ></b-form-textarea>
                                        </b-form-group>
                                        <div>
                                            <b-button type="button" :disabled="!hasPermission(next_step.user_role)" variant="dark" @click="addState(next_step)"><i
                                                class='bx bxs-send'></i> Update State
                                            </b-button>
                                            <small class="text-danger" v-if='!hasPermission(next_step.user_role)'>You don't have permission to do this!!</small>
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
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    import ApiRepository from "../../Repository/ApiRepository";

    export default {
        name: "Approval",
        props: ['title', 'group_id', 'module_name_url', 'item', 'id', 'showModal', 'datatable'],
        data() {
            return {
                progressValue: 0,
                backWard: false,
                process: {
                    workflow_process_id: '',
                    bill_master_id: ''
                },
                currentShowModal: false,
                nextState: {
                    status_name: ''
                },
                show: false,
                next_step: {
                    approval_workflow_id: '',
                    workflow_object_id: '',
                    user_role: '',
                    enabled_yn: "",
                    insert_date: "",
                    process_step: "",
                    workflow: "",
                    workflow_key: "",
                    workflow_step_id: ''
                },
                workflow_step_id: '',
                previous_step: [],
                current_step: {
                    note: '',
                    insert_date: '',
                    workflow: '',
                    process_step: '',
                    user: {
                        designation: '',
                        emp_name: ''
                    }
                },
                showHistory: false,
                workflowProcess: [],
                workflow: {
                    workflow_step_id: '',
                    note: ''
                },
                options: [],
                confirmShow: false
            }
        },
        mounted() {
            this.getWorkflowSteps()
            if(this.showModal == true){
                this.$refs['approve_modal'].show()
            }
        },
        methods: {
            hide() {
                this.$refs['approve_modal'].hide()
                this.currentShowModal = false
                this.$emit('update:showModal', this.currentShowModal)
                this.workflowProcess = []
                this.next_step = {
                    approval_workflow_id: '',
                    workflow_object_id: '',
                    user_role: ''
                }
                this.workflow_step_id = ''
                this.previous_step = []
                this.current_step = {
                    note: '',
                    insert_date: '',
                    workflow: '',
                    process_step: '',
                    user: {
                        designation: '',
                        emp_name: ''
                    }
                }
                this.options = []

            },
            showModalApproval() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow/status/${this.group_id}/${this.id}`).then(res => {
                    if(res.data){
                        this.workflowProcess = res.data.workflowProcess
                        this.next_step = res.data.next_step
                        if (this.next_step)
                            this.workflow_step_id = this.next_step.workflow_step_id
                        this.previous_step = res.data.previous_step
                        this.current_step = res.data.current_step
                        this.options = res.data.options
                    }
                })
            },
            addState(state) {
                state.workflow_object_id = this.next_step.approval_workflow_id
                state.note = this.workflow.note
                state.workflow_step_id = this.workflow.workflow_step_id
                state.target_url = window.location.pathname.substring(1)+'#'+this.$route.path
                state.message = 'Approval review request sent to you.'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/workflow/status/${this.group_id}/${this.id}`, state).then(res => {
                    this.workflowProcess = res.data.workflowProcess
                    this.process = {
                        workflow_process_id: res.data.workflowProcess[0].workflow_process_id,
                        bill_master_id: res.data.workflowProcess[0].workflow_object_id
                    }
                    this.updateProcess()
                    this.next_step = res.data.next_step
                    if (this.next_step)
                        this.workflow_step_id = this.next_step.workflow_step_id
                    this.previous_step = res.data.previous_step
                    this.current_step = res.data.current_step
                    this.options = res.data.options
                    this.workflow.note = ''
                    this.backWard = false
                })
            },
            updateProcess() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/payroll/update-process-id`, this.process).then(res => {
                    this.datatable()
                })
            },
            finalApproved() {
                let state = this.next_step;
                state.note = this.workflow.note
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/${this.module_name_url}/final-approve/${this.group_id}/${this.id}`, state).then(res => {
                    /* this.addState(this.next_step)*/
                    this.datatable()
                    this.workflowProcess = res.data.workflowProcess
                    this.next_step = res.data.next_step
                    if (this.next_step)
                        this.workflow_step_id = this.next_step.workflow_step_id
                    this.previous_step = res.data.previous_step
                    this.current_step = res.data.current_step
                    this.options = res.data.options
                    this.$emit('current-status')
                    this.workflow.note = ''
                    this.confirmShow = false

                })
            },
            hasHistoryPermission() {
                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess
                } else {
                    return this.$store.getters.permissions.includes('CAN_SEE_STATUS_HISTORIES')
                }

            },
            hasPermission(role) {
                let hasRole = this.$store.getters.roles.filter( element => element.role_key == role)
                return hasRole.length > 0
            },
            getWorkflowSteps() {
                if (this.group_id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/get-workflow-steps/${this.group_id}`).then(res => {
                        this.progressValue = 100/res.data.length
                    });
                }
            },
        },
        filters: {
            dateFormat(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY hh:mm')
                }
            }
        },
        computed: {
            splicedOptions: function () {
                return this.options.slice(0,-1)
            }
        },
        watch: {
            showModal: {
                handler: function(val, oldVal) {
                    if(val === true){
                        alert('sdfs')
                        this.$refs['approve_modal'].show()
                        this.currentShowModal = val
                        this.$nextTick(()=>{
                            this.showModalApproval()
                            this.getWorkflowSteps()
                        })
                    }
                },
            }
        }
    }
</script>

<style scoped>

</style>
