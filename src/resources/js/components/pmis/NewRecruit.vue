<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">New Recruit</b-card-header>
                <b-card-body class="border">
                    <Datatable :fields="fields" :items="items" :totalList="totalList" :perPage="perPage">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary" @click="showModal(rows.item)">
                                <i class="bx bx-cog cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
        <b-modal ref="process-modal" hide-footer @close="reset">
            <b-form @submit.prevent="approve">
                <b-row>
                    <b-col md="12">
                        <b-form-group
                          class="requiredField"
                          label="Employee Code"
                          label-cols-md="4"
                          label-for="emp_code">
                            <b-form-input
                              v-model.trim="$v.formData.emp_code.$model"
                              placeholder="Employee Code">
                            </b-form-input>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_code.$error && !$v.formData.emp_code.required}">Employee code is required!</div>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                          class="requiredField"
                          label="Employee type"
                          label-cols-md="4"
                          label-for="emp_type_id">
                            <v-select v-model="employeeTypes" :options="empTypeList"
                                      name="emp_type_id" id="emp_type_id" label="text"
                                      class="uppercase">
                                <template #search="{attributes, events}">
                                    <input class="vs__search" v-bind="attributes" v-on="events"/>
                                </template>
                            </v-select>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_type_id.$error && !$v.formData.emp_type_id.required}">Employee Type is required!</div>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                          class="requiredField"
                          label="Joining Date"
                          label-cols-md="4"
                          label-for="emp_join_date">
                            <date-picker v-model="$v.formData.emp_join_date.$model"
                                         width="100%"
                                         input-class="form-control"
                                         type="date"
                                         lang="en"
                                         format="DD-MM-YYYY"
                                         :value-type="valueType"
                                         :editable="false"
                                         name="emp_join_date">
                            </date-picker>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_join_date.$error && !$v.formData.emp_join_date.required}">Joining date is required!</div>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                          class="requiredField"
                          label="Bank"
                          label-cols-md="4"
                          label-for="bank_id">
                            <v-select @input="bankChange(banks.value)"
                                      v-model="banks"
                                      :options="bankList"
                                      name="bank_id"
                                      id="bank_id"
                                      label="text"
                                      class="uppercase">
                                <template #search="{attributes, events}">
                                    <input class="vs__search"
                                           v-bind="attributes" v-on="events"/>
                                </template>
                            </v-select>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.bank_id.$error && !$v.formData.bank_id.required}">Bank is required!</div>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                          class="requiredField"
                          label="Branch"
                          label-cols-md="4"
                          label-for="branch_id">
                            <v-select v-model="branches"
                                      :options="branchList"
                                      name="branch_id"
                                      id="branch_id"
                                      label="text"
                                      class="uppercase">
                                <template #search="{attributes, events}">
                                    <input class="vs__search"
                                           v-bind="attributes" v-on="events"/>
                                </template>
                            </v-select>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.branch_id.$error && !$v.formData.branch_id.required}">Branch is required!</div>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                          class="requiredField"
                          label="Bank Account No"
                          label-cols-md="4"
                          label-for="emp_bank_acc_no">
                            <b-form-input
                              id="emp_bank_acc_no"
                              v-model.trim="$v.formData.emp_bank_acc_no.$model"
                              type="text"
                              placeholder="Enter Bank Account No"
                              :max-length="13"
                              name="emp_bank_acc_no">
                            </b-form-input>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_bank_acc_no.$error && !$v.formData.emp_bank_acc_no.required}">Bank account number is required!</div>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_bank_acc_no.$error && (!$v.formData.emp_bank_acc_no.maxLength || !$v.formData.emp_bank_acc_no.minLength)}">Bank account number needs to be 13 characters!</div>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-button class="mt-1" variant="primary" type="submit" block>Process</b-button>
            </b-form>

        </b-modal>
    </div>
</template>

<script>
    import Datatable from '../../layouts/common/datatable';
    import moment from "moment";
    import ApiRepository from "../../Repository/ApiRepository";
    import DatePicker from 'vue2-datepicker';
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    import {validationMixin} from "vuelidate";
    const { required, maxLength, minLength } = require("vuelidate/lib/validators");
    export default {
        name: "NewRecruit",
        components: {Datatable, DatePicker, vSelect},
        data(){
            return {
                bankList: [],
                empTypeList: [],
                branchList: [],
                employeeTypes: { text: '', value: ''},
                banks: { text: '', value: '' },
                branches:{ text: '', value: '' },
                valueType: this.dateFormatter(),
                fields: [
                    {key:'index',label:'SL', sortable:true},
                    {key:'first_name',label:'First Name', sortable:true},
                    {key:'last_name',label:'Last Name', sortable:true},
                    {key:'father_name',label:'Father\'s Name', sortable:true},
                    {key:'quota_name',label:'Quota', sortable:true},
                    {key:'gender_name',label:'Gender', sortable:true},
                    {key:'action',label:'Action', class:'text-center'}
                ],
                items: [],
                totalList: 1,
                perPage: 10,
                formData: {
                    application_id: '',
                    job_user_id: '',
                    emp_code: '',
                    emp_type_id: '',
                    emp_join_date: '',
                    bank_id: '',
                    branch_id: '',
                    emp_bank_acc_no: ''
                }
            }
        },
        mixins: [validationMixin],
        validations: {
            formData: {
                application_id: {required},
                job_user_id: {required},
                emp_code: {required},
                emp_type_id: {required},
                emp_join_date: {required},
                bank_id: {required},
                branch_id: {required},
                emp_bank_acc_no: {
                    required,
                    minLength: minLength(13),
                    maxLength: maxLength(13)
                }
            }
        },
        mounted() {
            this.loadData()
            this.allBasicInfo()
        },
        watch: {
            employeeTypes: function(val, oldVal){
                if (val.value !== null) {
                    this.formData.emp_type_id = val.value;
                } else {
                    this.formData.emp_type_id ='';
                }
            },
            banks:function (val, oldVal) {
                if (val.value !== null) {
                    this.formData.bank_id = val.value;
                } else {
                    this.formData.bank_id ='';
                }
            },
            branches:function (val, oldVal) {
                if (val.value !== null) {
                    this.formData.branch_id = val.value;
                } else {
                    this.formData.branch_id = '';
                }
            },
        },
        methods: {
            loadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/new-recruit`).then(res => {
                    this.items = res.data
                    this.totalList = res.data.length
                })
            },
            showModal(item) {
                this.formData.application_id = item.application_id
                this.formData.job_user_id = item.job_user_id
                this.$refs['process-modal'].show()
            },
            approve() {
                this.$v.$touch()
                this.$v.formData.$touch()
                if(!this.$v.formData.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/admin/recruit-process`, this.formData).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$refs['process-modal'].hide()
                            this.reset()
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    })
                }

            },
            allBasicInfo() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos').then(result => {
                    this.bankList = result.data.banks;
                    this.empTypeList = result.data.empType;
                })
                /* if (this.id == null){
                     ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/employee/generate-emp-code").then(resp => {
                         this.generatedCode = resp.data
                     })

                 }*/
            },
            bankChange(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/branches/${id}`).then(result => {
                    this.branchList = result.data;
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
            reset() {
                this.formData = {
                    application_id: '',
                    job_user_id: '',
                    emp_code: ''
                }
                this.$v.$reset()
            }
        }
    }
</script>

<style scoped>

</style>
