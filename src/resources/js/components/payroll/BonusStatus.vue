<template>
    <div>
        <b-row  class="border mb-1 pt-1 pb-1" v-if="billStatusShow">
            <b-col>
                <h5>Bill Step</h5>
                <b-progress :value="currentStatus.process_step*20"  variant="success" key="success"></b-progress>
                <b-form>
                    <b-row class="pt-1">
                        <b-col v-if="currentStatus">
                            <b-list-group>
                                <b-list-group-item href="#" class="flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="text-success">{{currentStatus.status_name}}</div>
                                        <small><span class="badge badge-pill badge-secondary">{{currentStatus.pbs_insert_date|dateFormat}}</span></small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <small>By {{currentStatus.emp_name}}</small>
                                        <small>{{currentStatus.designation}}</small>
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
                                                <div><pre>{{currentStatus.note}}</pre></div>
                                            </b-list-group-item>
                                        </b-list-group>
                                    </div>
                                </b-list-group-item>
                            </b-list-group>

                            <div v-if="hasHistoryPermission()" class="mt-1">
                                <b-button  variant="warning" @click="showHistory = !showHistory" ><i
                                        class='bx bxs-down-arrow-square'></i> Show Bill Status Histories
                                </b-button>
                                <b-list-group v-if="showHistory" class="mt-1">
                                <b-list-group-item v-for="state in billStates" :key="state.bill_state_id" href="#" class="flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="text-success">{{state.status_name}}</div>
                                        <small><span class="badge badge-pill badge-secondary">{{state.pbs_insert_date|dateFormat}}</span></small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <small>By {{state.emp_name}}</small>
                                        <small>{{state.designation}}</small>
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
                        <b-col v-if='nextState && hasPermission(nextState.role)'>
                            <div v-if="nextState">
                                <div v-if="nextState.status_key == 'BILL_DISBURSED'" class="d-flex w-100 justify-content-center">
                                    <b-card bg-variant="dark" text-variant="white" :title="nextState.status_name">
                                        <b-card-text>
                                            All approval process has been done. Now the bill is ready to disburse.
                                        </b-card-text>
                                        <b-button type="button" :disabled="!hasPermission(nextState.role)" variant="primary" @click="confirmShow = true" >Apply Disbursement</b-button>
                                        <small class="text-danger" v-if='!hasPermission(nextState.role)'>You don't have permission to change the state!!</small>
                                    </b-card>
                                </div>
                                <div v-else>
                                        <b-form-group label="Change state to" label-for="from-state">
                                            <b-form-select v-model="nextState.pr_bill_status_id" :options="options"></b-form-select>
                                        </b-form-group>
                                        <b-form-group label="Note" label-for="workflow-note">
                                            <b-form-textarea :disabled="!hasPermission(nextState.role)"
                                                    v-model="nextState.note"
                                                    placeholder="Enter something..."
                                            ></b-form-textarea>
                                        </b-form-group>
                                        <div>
                                            <b-button type="button" :disabled="!hasPermission(nextState.role)" variant="dark" @click="addState(nextState)"><i
                                                    class='bx bxs-send'></i> Update State
                                            </b-button>
                                            <small class="text-danger" v-if='!hasPermission(nextState.role)'>You don't have permission to do this!!</small>
                                        </div>
                                </div>
                            </div>
                            <div v-else>
                                <b-card bg-variant="dark" text-variant="white" title="Status">
                                    <b-card-text>
                                        All approval process has been done. And bill already disbursed.
                                    </b-card-text>
                                </b-card>
                            </div>
                        </b-col>
                    </b-row>
                </b-form>
                <b-modal v-model="confirmShow" :centered="true" title="Please Confirm" size="sm"
                         buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"
                         :hideHeaderClose="false"
                         @ok="billDisbursement()">
                    <div>Are you sure want to disburse the bonus?</div>
                </b-modal>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import ApiRepository from '../../Repository/ApiRepository';
    import moment from 'moment';

    export default {
        props:['process'],
        data() {
            return {
                billStatusShow:false,
                process_step:'',
                billStates:[],
                nextState:{},
                approval:{},
                comment:{},
                stateOptions: [],
                currentStatus: {process_step:''},
                options:[],
                showHistory:false,
                confirmShow:false
            }
        },
        mounted() {
            this.getBillStatus();
        },
        components: {
        },
        filters: {
            dateFormat: function(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY hh:mm')
                }
            }
        },
        methods: {
            changeStatus: function(state) {

            },

            addState: function(state) {
                console.log('this.process',this.process)
                state.bill_code = this.process.bill_code;
                state.month_id = this.process.pr_month;
                state.head = this.process.bonus_head;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/payroll/bonus/'+this.process.bill_code+'/status/'+this.process.pr_month+'/'+this.process.bonus_head, state).then(res => {
                    this.billStates = res.data.bill_status;
                    this.nextState = res.data.next_status;
                    this.currentStatus = res.data.current_status;
                    this.options = res.data.options;
                    this.billStatusShow = true;
                    this.$emit('current-status');
                });
            },
            getBillStatus: function() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/payroll/bonus/'+this.process.bill_code+'/status/'+this.process.pr_month+'/'+this.process.bonus_head).then(res => {
                    this.billStates = res.data.bill_status;
                    this.nextState = res.data.next_status;
                    this.currentStatus = res.data.current_status;
                    this.options = res.data.options;
                    this.billStatusShow = true;
                });
            },
            hasPermission: function(role) {
                let hasRole = this.$store.getters.roles.filter( element => element.role_key == role);
                return hasRole.length>0;
            },
            billDisbursement: function() {
                let state = this.nextState;
                state.bill_code = this.process.bill_code;
                state.month_id = this.process.pr_month;
                state.head = this.process.bonus_head;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/payroll/bonus-disburse', state).then(res => {
                    this.billStates = res.data.bill_status;
                    this.nextState = res.data.next_status;
                    this.currentStatus = res.data.current_status;
                    this.options = res.data.options;
                    this.billStatusShow = true;
                    this.$emit('current-status');
                    this.confirmShow = false;
                });
            },
            hasHistoryPermission:function() {
                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess;
                }

                return this.$store.getters.permissions.includes('CAN_SEE_STATUS_HISTORIES');
            }
        }
    };
</script>
