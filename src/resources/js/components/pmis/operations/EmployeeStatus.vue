<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Status Information</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="showConfirmBox" @reset.prevent="onReset" class="form form-vertical col-md-12">
                        <b-row>
                            <b-col sm="4">
                                <b-form-group label="EMPLOYEE CODE" label-for="empCode" class="requiredField">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="employeeOptions"
                                        @search="searchEmployee"
                                        @input="employeeChange"
                                        id="emp_code">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events" />
                                        </template>
                                    </v-select>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_id.$error && !$v.formData.emp_id.required}">Employee is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="Employee Name" label-for="emp_name">
                                    <b-form-input
                                        id="emp_name"
                                        v-model="formData.emp_name"
                                        readonly
                                        placeholder="Employee Name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="Designation" label-for="designation">
                                    <b-form-input
                                        id="designation"
                                        v-model="formData.designation"
                                        readonly
                                        placeholder="Designation"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="Department" label-for="department_name">
                                    <b-form-input
                                        id="department_name"
                                        v-model="formData.department_name"
                                        readonly
                                        placeholder="Department"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="Division" label-for="division_name">
                                    <b-form-input
                                        id="division_name"
                                        v-model="formData.dpt_division_name"
                                        readonly
                                        placeholder="Division"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="Current Status" label-for="curr_emp_status">
                                    <b-form-input
                                        id="curr_emp_status"
                                        v-model="formData.curr_emp_status"
                                        readonly
                                        placeholder="Current Status"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="Change Status" label-for="emp_status" class="requiredField">
                                    <v-select
                                        label="emp_status"
                                        v-model="selectedStatus"
                                        :options="statusOptions"
                                        id="emp_status">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events" />
                                        </template>
                                    </v-select>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.change_emp_status_id.$error && !$v.formData.change_emp_status_id.required}">Change status is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Application No"
                                    label-for="application_no">
                                    <b-form-input
                                        id="application_no"
                                        v-model.trim="$v.formData.application_no.$model"
                                        placeholder="Application No"
                                    ></b-form-input>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.application_no.$error && !$v.formData.application_no.required}">Application no is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Application Date"
                                    label-for="application_date">
                                    <date-picker
                                        v-model.trim="$v.formData.application_date.$model"
                                        width="100%"
                                        input-class="form-control"
                                        type="date" lang="en"
                                        name="application_date"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        :editable="false">
                                    </date-picker>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.application_date.$error && !$v.formData.application_date.required}">Application date is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Order No"
                                    label-for="order_no">
                                    <b-form-input
                                        id="order_no"
                                        v-model.trim="$v.formData.order_no.$model"
                                        placeholder="Order No"
                                    ></b-form-input>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.order_no.$error && !$v.formData.order_no.required}">Order no is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Order Date"
                                    label-for="order_date">
                                    <date-picker
                                        v-model.trim="$v.formData.order_date.$model"
                                        width="100%"
                                        input-class="form-control"
                                        type="date" lang="en"
                                        name="order_date"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        :editable="false">
                                    </date-picker>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.order_date.$error && !$v.formData.order_date.required}">Order date is required!</div>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    class="requiredField"
                                    label="Effective Date"
                                    label-for="effective_date">
                                    <date-picker
                                        v-model.trim="$v.formData.effective_date.$model"
                                        width="100%"
                                        input-class="form-control"
                                        type="date" lang="en"
                                        name="effective_date"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        :editable="false">
                                    </date-picker>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.effective_date.$error && !$v.formData.effective_date.required}">Effective date is required!</div>
                                </b-form-group>
                            </b-col>
                           <!-- <b-col md="4">
                                <b-form-group
                                    class="requiredField"
                                    label="Approve Status"
                                    label-for="approved_yn"
                                >
                                    <b-form-radio-group
                                        v-model.trim="$v.formData.approved_yn.$model"
                                        :options="approveOptions"
                                        name="approved_yn"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>-->
                            <b-col md="4">
                                <b-form-group
                                    class="requiredField"
                                    label="Approve Date"
                                    label-for="approve_date">
                                    <date-picker
                                        v-model.trim="formData.approved_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date" lang="en"
                                        name="approve_date"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        :editable="false">
                                    </date-picker>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.approved_date.$error && !$v.formData.approved_date.required}">Approve date is required!</div>
                                </b-form-group>
                            </b-col>

                            <b-col sm="8">
                                <b-form-group label="Attachment" label-for="attachment">
                                    <b-form-file
                                        @change="encodeFileEnd"
                                        id="attachment"
                                        placeholder="Attachment"
                                    ></b-form-file>
                                </b-form-group>
                            </b-col>
                            <b-col sm="12">
                                <b-form-group
                                    class=""
                                    label="Remarks"
                                    label-for="remarks">
                                    <b-form-textarea
                                        id="remarks"
                                        v-model.trim="$v.formData.remarks.$model"
                                        placeholder="Remarks"
                                    ></b-form-textarea>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.formData.remarks.$error && !$v.formData.remarks.required}">Remarks is required!</div>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button type="submit" class="btn btn-dark shadow mr-1">Submit</b-button>&nbsp;
                                <b-button type="reset" class="btn btn-outline-dark">Reset</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark"
                               header-text-variant="white">Change Employee Status To PRL Based On Current Month</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col class="d-flex justify-content-end">
                            <b-button type="submit" @click="employeeStatusChange()" class="btn btn-dark shadow mr-1">Submit</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Status Changed List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'emp_operation_id'"></Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../../Repository/ApiRepository";
    import vSelect from 'vue-select';
    import DatePicker from "vue2-datepicker";
    import Datatable from "../../../layouts/common/datatable";
    import 'vue-select/dist/vue-select.css';
    import moment from "moment";
    import Vue from "vue";
    import VueSimpleAlert from "vue-simple-alert";

    Vue.use(VueSimpleAlert);

    const { required, maxLength, minLength, email } = require("vuelidate/lib/validators");

    export default {
        name: "employee-status",
        components: {DatePicker, Datatable, vSelect},
        data() {
            return {
                items: [],
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'emp_code', label: 'Employee Code', sortable: true},
                    {key: 'emp_name', label: 'Employee Name', sortable: true},
                    {key: 'curr_emp_status', label: 'Current Employee Status', sortable: true},
                    {key: 'change_emp_status', label: 'Change Employee Status', sortable: true},
                    {
                        key: 'effective_date',
                        label: 'Effective Date',
                        sortable: true,
                        formatter : value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }

                    }

                ],
                totalList: 1,
                perPage: 5,
                valueType: this.dateFormatter(),
                selectedEmployee: {
                    text: '',
                    value: ''
                },
                selectedStatus: {
                    text: '',
                    value: ''
                },
                employeeOptions: [],
                statusOptions: [],
                approveOptions:[
                    {text: 'Approve', value:'Y'},
                    {text: 'Reject', value:'N'}
                ],
                formData: {
                    emp_operation_id: '',
                    emp_id: '',
                    emp_name: '',
                    department_name: '',
                    designation: '',
                    dpt_division_name: '',
                    curr_emp_status: '',
                    curr_emp_status_id: '',
                    change_emp_status_id: '',
                    application_no: '',
                    application_date: '',
                    app_attachment: '',
                    approved_date: '',
                    approved_yn: 'Y',
                    order_no: '',
                    order_date: '',
                    effective_date: '',
                    remarks: ''
                }
            }
        },
        validations: {
            formData: {
                emp_operation_id: {},
                emp_id: {
                    required
                },
                curr_emp_status_id: {
                    required
                },
                change_emp_status_id: {
                    required
                },
                application_no: {},
                application_date: {},
                app_attachment: {},
                approved_date: {
                    required
                },
                approved_yn: {},
                order_no: {},
                order_date: {},
                effective_date: {
                    required
                },
                remarks: {}
            }
        },
        mounted() {
            this.loadTable()
        },
        watch: {
            selectedEmployee(val, oldVal) {
                if(val) {
                    this.formData.emp_id = val.emp_id
                    this.formData.dpt_division_name = val.dpt_division_name
                    this.formData.emp_name = val.emp_name
                    this.formData.designation = val.designation
                    this.formData.department_name = val.department_name
                    this.formData.curr_emp_status = val.emp_status
                    this.formData.curr_emp_status_id = val.emp_status_id
                    this.loadStatus(val.emp_status_id)
                }
            },
            selectedStatus(val, oldVal){
                if(val){
                    this.formData.change_emp_status_id = val.emp_status_id
                }
            }
        },
        computed: {

        },
        methods: {
            onSubmit() {
                this.$v.$touch()
                this.$v.formData.$touch()
                if (!this.$v.formData.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/employee-status`, this.formData).then(res => {
                        if(res.data.o_status_code == 1){
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                            this.onReset()
                            this.loadTable()
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    })
                }

            },
            onReset() {
                this.$nextTick(() => {
                    this.formData = {
                        emp_operation_id: '',
                        emp_id: '',
                        emp_name: '',
                        department_name: '',
                        designation: '',
                        division_name: '',
                        curr_emp_status: '',
                        curr_emp_status_id: '',
                        change_emp_status_id: '',
                        application_no: '',
                        application_date: '',
                        app_attachment: '',
                        approved_date: '',
                        approved_yn: 'Y',
                        order_no: '',
                        order_date: '',
                        effective_date: '',
                        remarks: ''
                    }
                    this.statusOptions = []
                    this.selectedStatus = {
                        text: '',
                        value: ''
                    }
                    this.selectedEmployee = {
                        text: '',
                        value: ''
                    }

                    this.$v.$reset()
                })
            },
            searchEmployee(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/employee-for-status/${id}`).then(res => {
                        this.employeeOptions = res.data;
                    })
                }
            },
            loadStatus(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/employee-status/${id}`).then(res => {
                   // this.statusOptions = res.data;
                    this.statusOptions = res.data.filter(function(item,index) {
                        return  item.emp_status_id != 9;
                    });
                })
            },
            loadTable(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/employee-status-datatable`).then(res => {
                    this.items = res.data;
                    this.totalList = res.data.length
                })
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
            encodeFileEnd(e){
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.formData.app_attachment = reader.result;
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
            employeeChange(){
                this.statusOptions = []
                this. selectedStatus = {
                    text: '',
                    value: ''
                }
            },
            employeeStatusChange(){
                this.$confirm("Are you sure, Want To Change All PRL Employee Status?").then(() => {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/employee-status-change`).then(res => {
                        // console.log(res);
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                    })
                });
            },
            showConfirmBox() {
                this.$v.$touch()
                this.$v.formData.$touch()
                if (!this.$v.formData.$invalid){
                    this.$bvModal.msgBoxConfirm('Please confirm that you want to change the status.', {
                        title: 'Please Confirm',
                        size: 'sm',
                        buttonSize: 'sm',
                        okVariant: 'danger',
                        okTitle: 'YES',
                        cancelTitle: 'NO',
                        footerClass: 'p-2',
                        hideHeaderClose: false,
                        centered: true
                    })
                    .then(value => {
                        if(value == true){
                            this.onSubmit()
                        }
                    })
                    .catch(err => {
                        // An error occurred
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
