<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">bill code mapping</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="emp_id"
                                        label="Biller Employee"
                                        label-for="emp_id"
                                    >
                                        <v-select
                                            label="option2"
                                            name="selectedEmployee"
                                            v-model="selectedEmployee"
                                            :options="empIdList"
                                            @search="searchempcods">
                                            <template #search="{attributes, events}">
                                                <input
                                                    class="vs__search"
                                                    :required="Object.keys(selectedEmployee).length === 0"
                                                    v-bind="attributes"
                                                    v-on="events"
                                                />
                                            </template>
                                        </v-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        id="Empoyee_Name"
                                        label="Biller Name"
                                        label-for="Empoyee_Name"
                                    >
                                        <b-form-input v-model="biller.emp_name" disabled ></b-form-input>
                                    </b-form-group>

                                </b-col>
                                <b-col md="3">
                                    <b-form-group>
                                        <b-form-group
                                            id="designation"
                                            label="Biller Designation"
                                            label-for="designation"
                                        >
                                            <b-form-input disabled v v-model="biller.designation" ></b-form-input>
                                        </b-form-group>
                                    </b-form-group>

                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        id="Department"
                                        label="Biller Department"
                                        label-for="Department"
                                    >
                                        <b-form-input v-model="biller.department_name" disabled ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row class="pull-top">
                                <b-col md="3">
                                    <b-form-group
                                        id="Section"
                                        label="Biller Section"
                                        label-for="Section"
                                    >
                                        <b-form-input v-model="biller.section" disabled ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        id="biller_code"
                                        label="biller code"
                                        label-for="biller_code"
                                    >
                                        <b-form-input v-model="biller.biller_bill_code" disabled ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="bill_code"
                                        label="bill code"
                                        label-for="bill_code"
                                    >
                                        <b-form-select v-model="biller.emp_bill_code"
                                                       class="select2 form-control"
                                                       id="bill_code"
                                                       name="bill_code"
                                                       required
                                                       :options="billCodeList">
                                        </b-form-select>
                                        <b-link  ml="4" v-show="biller.emp_bill_code > 0" class="text-primary"
                                                 @click="viewEmployee(0,biller.emp_bill_code)">
                                            <i class="bx bx-street-view cursor-pointer"></i>
                                        </b-link>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="activation_flag"
                                        label="activation flag"
                                        label-for="activation_flag"
                                    >
                                        <b-form-select v-model="biller.activation_flag" :options="activationFlagList"></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="activation_date"
                                        label="activation date"
                                        label-for="activation_date"
                                    >
                                        <date-picker width="100%" input-class="form-control" v-model="biller.activation_date" type="date" :editable="false" lang="en" format="YYYY-MM-DD" :value-type="dateValueType" ></date-picker>
                                    </b-form-group>
                                    <span :style="errorMessage" v-show="req_activation_date">Activation Date Required!</span>
                                    <span :style="errorMessage" v-show="req_check_date">Date range are not valid!</span>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="deactive_date"
                                        label="deactive date"
                                        label-for="deactive_date"
                                    >
                                        <date-picker width="100%" input-class="form-control" v-model="biller.deactive_date" type="date" :editable="false" lang="en" format="YYYY-MM-DD" :value-type="dateValueType"></date-picker>
                                    </b-form-group>
                                    <span :style="errorMessage" v-show="req_deactive_date">Deactive Date Required!</span>
                                    <span :style="errorMessage" v-show="req_check_date">Date range are not valid!</span>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="description"
                                        label-for="description"
                                    >
                                        <b-form-textarea v-model="biller.description" placeholder="Type description"></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col class="mt-2 d-flex justify-content-end">
                                    <b-button md="6"  size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                    <b-button md="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                </b-col>
                            </b-row>
                            <!--</fieldset>-->
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>

            <template>
                <div>
                    <b-modal id="modal-xl" size="xl"  v-model="modalShow" hide-footer >
                        <b-card title="Employee List">
                            <template>
                                <div class="content-wrapper">
                                    <div class="content-body">
                                        <Datatable v-bind:fields="modalfields" v-bind:items="employees" >
                                        </Datatable>
                                    </div>
                                </div>
                            </template>
                        </b-card>
                    </b-modal>
                </div>

            </template>
            <b-card>
                <!-- Zero configuration table -->
                <b-row>
                    <b-col>
                        <b-card title="bill code mapping List">
                            <template>
                                <div class="content-wrapper">
                                    <div class="content-body">
                                        <Datatable  v-bind:fields="fields" v-bind:items="items" >
                                            <template  v-slot:action4="{ rows }" >
                                            </template>
                                            <template v-slot:actions="{ rows }">
                                                <b-link  v-show="rows.item.activation_flag == 'Y'" ml="4" class="text-primary"
                                                        @click="editRow(rows.item.bill_mapping_id)">
                                                    <i class="bx bx-edit cursor-pointer"></i>
                                                </b-link>
                                                <b-link  ml="4" class="text-primary"
                                                         @click="viewEmployee(rows.item.biller_bill_code,rows.item.emp_bill_code)">
                                                    <i class="bx bx-street-view cursor-pointer"></i>
                                                </b-link>
                                            </template>
                                        </Datatable>
                                    </div>
                                </div>
                            </template>
                        </b-card>
                    </b-col>

                </b-row>
                <!--/ Zero configuration table -->
            </b-card>
        </div>

    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import moment from 'moment';
    import  vcss from 'vue-select/dist/vue-select.css';
    import Datatable from '../../../layouts/common/datatable';
    import DatePicker from "vue2-datepicker";
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker,Vue,vSelect,vcss,Datatable},
        watch: {
            selectedEmployee:function(val,oldVal) {
                this.biller.emp_name = val.emp_name;
                this.biller.biller_emp_id = val.emp_id;
                this.biller.biller_bill_code = val.bill_code;
                if ( val.department) {
                    this.biller.department_name =  val.department.department_name;
                }

                if(val.designation) {
                    this.biller.designation=  val.designation.designation;
                }

                if(val.section) {
                    this.biller.section = val.section.section_name;
                }
            },
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "biller"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Entry"});
            this.loadData();
            this.biller.activation_flag = 'Y';
        },
        data() {
            return {
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                biller:{},
                billCodeList:[],
                emp_name:'',
                modalShow: false,
                selectedEmployee:{},
                empIdList:[],
                submitBtn: 'Save',
                req_activation_date:false,
                req_deactive_date:false,
                req_check_date:false,
                items: [],
                employees:[],
                modalfields:[
                    {key:'emp_code', label:'Emp Code', sortable:true},
                    {key:'emp_name', label:'Emp Name', sortable:true},
                    {key:'designation.designation', label:'Designation', sortable:true},
                    {key:'department.department_name', label:'Department', sortable:true},
                    {key:'section.dpt_section', label:'Section', sortable:true},
                    {key:'bill_code', label:'Bill Code', sortable:true},
                ],
                fields: [
                    {key:'employee.emp_code', label:'Biller Emp Code', sortable:true},
                    {key:'employee.emp_name', label:'Biller Name', sortable:true},
                    {key:'employee.designation.designation', label:'Biller Designation', sortable:true},
                    {key:'employee.department.department_name', label:'Biller Department', sortable:true},
                    {key:'employee.section.dpt_section', label:'Biller Section', sortable:true},
                    {key:'biller_bill_code', label:'Biller Code', sortable:true},
                    {key:'emp_bill_code', label:'Bill Code', sortable:true},
                    {key:'description', label:'Description', sortable:true},
                    {key:'activation_flag', label:'Activation Flag', sortable:true},
                    {key:'activation_date',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label:'Activation Date', sortable:true},
                    {key:'deactive_date',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label:'Deactivate Date', sortable:true},
                    'action'],
                activationFlagList: [{text: 'Yes', value: 'Y'},{text: 'No', value: 'N'}]
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
            searchempcods(id){
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/biller/billerinfo/${id}`, this.biller).then(res => {
                        this.empIdList = res.data.empcodeList;
                        this.emp_name=res.data.empcodeList.emp_name;
                    })
                }
            },
            viewEmployee(billerCode,billCode){
                this.modalShow = true;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/biller/employee-list/${billerCode}/${billCode}`, this.biller).then(res => {
                    this.employees = res.data.data;
                })
            },
            onSubmit(evt) {
                evt.preventDefault();
                this.req_activation_date = false;
                this.req_deactive_date = false;
                this.req_check_date = false;
                let activation_date = this.biller.activation_date;
                let deactive_date = this.biller.deactive_date;
                if(activation_date == undefined || activation_date == ''){
                    this.req_activation_date = true;
                    return false;
                }else if(deactive_date == undefined || deactive_date == ''){
                    this.req_deactive_date = true;
                    return false;
                }
                if(new Date(activation_date).getTime() > new Date(deactive_date).getTime()){
                    this.req_check_date = true;
                    return false;
                }
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/biller/biller-entry", this.biller).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        this.onReset();
                    } else{
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    }
                });
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/admin/biller/bill-code").then(res => {
                    this.billCodeList =  res.data.billCodes;
                    this.items=res.data.records;
                });
            },
            onReset() {
                this.biller.emp_id = null;
                this.biller.emp_name = '';
                this.biller.designation = '';
                this.biller.department_name = '';
                this.biller.section = '';
                this.submitBtn = 'Save';
                this.selectedEmployee = '';
                this.biller.description = '';
                this.biller.emp_bill_code = '';
                this.biller.biller_bill_code = '';
                this.biller.activation_date = '';
                this.biller.deactive_date = '';
                this.biller.activation_flag = 'Y';
                this.items=[];
                this.loadData();
            },
            editRow(id){
                this.biller.bill_mapping_id = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/biller/biller-map/${id}`).then(res => {
                    this.billCodeList =  res.data.billCodes.billCodes;
                    this.biller = res.data.data;
                    this.biller.emp_bill_code = res.data.data.emp_bill_code;
                    this.selectedEmployee = res.data.data.employee;
                    this.submitBtn = 'Update';
                });
            }
        },

    }
</script>
<style>
    .pull-top{
        margin-top: -20px;
    }
</style>

