<template>
    <div class="content-wrapper" id="setup_form">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Biller Setup</b-card-header>
                <b-card-body class="border">
                    <b-form  @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    class="requiredField"
                                    id="emp_id"
                                    label="Employee"
                                    label-for="emp_id"
                                >
                                    <v-select
                                        label="option_name"
                                        name="selectedEmployee"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchempcods">
                                        <template #search="{attributes, events}">
                                            <input
                                                class="vs__search"
                                                :required="require_employee"
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
                                    label="Empoyee Name"
                                    label-for="Empoyee_Name"
                                >
                                    <b-form-input v-model="billersetup.emp_name" disabled ></b-form-input>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group>
                                    <b-form-group
                                        id="designation"
                                        label="Designation"
                                        label-for="designation"
                                    >
                                        <b-form-input disabled v v-model="billersetup.designation" ></b-form-input>
                                    </b-form-group>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    id="Department"
                                    label="Department"
                                    label-for="Department"
                                >
                                    <b-form-input v-model="billersetup.department_name" disabled ></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row class="pull-top">
                            <b-col md="3">
                                <b-form-group
                                    id="Section"
                                    label="Section"
                                    label-for="Section"
                                >
                                    <b-form-input v-model="billersetup.section" disabled ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    id="bill_code"
                                    label="bill code"
                                    label-for="bill_code"
                                >
                                    <b-form-input v-model="billersetup.bill_code" disabled ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    class="requiredField"
                                    id="activation_flag"
                                    label="activation flag"
                                    label-for="activation_flag"
                                >
                                    <b-form-select v-model="billersetup.active_yn" :options="activationFlagList"></b-form-select>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button md="6"  size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                <b-button md="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Biller List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="fields" v-bind:items="loadData"  :perPage="perPage" :totalList="totalList">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary"
                                    @click="editRow(rows.item)">
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
                this.require_employee = true;
                if(val != null){
                    this.require_employee = false;
                    this.billersetup.emp_name = val.emp_name;
                    this.billersetup.emp_id = val.emp_id;
                    this.billersetup.bill_code = val.bill_code;
                    if ( val.department) {
                        this.billersetup.department_name =  val.department.department_name;
                        this.billersetup.department_id =  val.department.department_id;
                    }else {
                        this.billersetup.department_id = '';
                    }

                    if(val.designation) {
                        this.billersetup.designation=  val.designation.designation;
                    }

                    if(val.section) {
                        this.billersetup.section = val.section.section_name;
                    }
                }
            },
            'billersetup.shift':function(val, oldval) {
                this.getShiftHours();
            },
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "billersetup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Entry"});
            this.billersetup.active_yn = 'Y';
        },
        data() {
            return {
                perPage: 10,
                totalList: '',
                errorMessage: {color: 'red'},
                billersetup:{},
                emp_name:'',
                require_employee: true,
                selectedEmployee:{},
                empIdList:[],
                submitBtn: 'Save',
                items: [],
                fields: [
                    {key:'employee.emp_code', label:'Emp Code', sortable:true},
                    {key:'employee.emp_name', label:'Emp Name', sortable:true},
                    {key:'employee.designation.designation', label:'Biller Designation', sortable:true},
                    {key:'employee.department.department_name', label:'Biller Department', sortable:true},
                    {key:'employee.section.dpt_section', label:'Biller Section', sortable:true},
                    {key:'bill_code', label:'Bill Code', sortable:true},
                    {
                        key:'active_yn',
                        label:'Activation',
                        formatter: value => {
                            if (value == 'Y') {
                                return 'Active';
                            } else {
                                return 'In-Active';
                            }
                        },
                        sortable:true
                    },
                    {key:'action', class: 'text-center'}
                ],
                activationFlagList: [{text: 'Yes', value: 'Y'},{text: 'No', value: 'N'}]
            }
        },
        methods: {
            scroll() {
                const element = document.getElementById('setup_form');
                element.scrollIntoView({ behavior: 'smooth' });
            },
            searchempcods(id){
                id = id.trim();
                if(id.length > 0) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/salary-allocation/get-empinfo/${id}`, this.billersetup).then(res => {
                        this.empIdList = res.data.empcodeList;
                        this.emp_name=res.data.empcodeList.emp_name;

                    })
                }
            },
            onSubmit(evt) {
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/biller/biller", this.billersetup).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        this.loadData();
                        this.onReset();
                    } else{
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    }
                });
            },
            loadData(ctx, callback) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/admin/biller/biller-list"+'?page=' + ctx.currentPage + '&size=' + ctx.perPage+'&filter=' + ctx.filter).then(res => {
                    //this.items=res.data.records;
                    const items =res.data.records.data;
                    this.currentPage =res.data.records.current_page;
                    this.totalList = res.data.records.total;
                    callback(items);
                });
                return null
            },
            onReset() {
                this.selectedEmployee = '';
                this.billersetup.emp_id = '';
                this.billersetup.emp_name = '';
                this.billersetup.designation = '';
                this.billersetup.department_name = '';
                this.billersetup.section = '';
                this.billersetup.bill_code = '';
                this.submitBtn = 'Save';
            },
            editRow(data){
                this.billersetup = data;
                this.selectedEmployee = data.employee;
                this.submitBtn = 'Update';
                this.scroll()
            }
        },

    }
</script>
<style>

</style>

