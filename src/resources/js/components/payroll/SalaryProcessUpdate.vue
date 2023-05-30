<template>
    <div class="content-body">
        <div id="stacked-pill">
            <div class="col-md-12">
                <div class="card bg-transparent border">
                    <div class="card-content">
                        <div class="card-body pt-1">
                            <div class="pills-stacked">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 border-right pr-md-0">

                                        <b-card title="Salary Process Update">
                                            <span style="color:red">{{errorMessage}}</span>
                                            <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                                                <b-row>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="Fiscal Years"
                                                            class="requiredField"
                                                            label-for="Fiscal_Years"
                                                        >
                                                            <b-form-select
                                                                v-model="fiscalYear"
                                                                :options="fiscalYearOptions"
                                                                class=""
                                                                value-field="value"
                                                                text-field="text"
                                                                disabled-field="notEnabled" name="fiscalYear" required  v-validate="'required'"  data-vv-scope="search"
                                                            ></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="Month"
                                                            class="requiredField"
                                                            label-for="Month"
                                                        >
                                                            <b-form-select v-model="processUpdate.pr_month" name="pr_month" required  v-validate="'required'"  :options="fiscal_months" value-field="pr_month" text-field="text" data-vv-scope="creationForm">
                                                            </b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="Bill No."
                                                            class="requiredField"
                                                            label-for="bill_code"
                                                        >
                                                            <b-form-input
                                                                id="postcode"
                                                                v-model="processUpdate.bill_code"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Bill Code"
                                                            ></b-form-input>

                                                        </b-form-group>
                                                    </b-col>

                                                </b-row>

                                                <b-row>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="Employee Code"
                                                            class="requiredField"
                                                            label-for="emp_code"
                                                        >
                                                            <b-form-input
                                                                id="postcode"
                                                                v-model="processUpdate.emp_code"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Employee Code"
                                                                name="emp_code"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                                    <b-button type="submit" id="basic_sub_btn"
                                                              class="btn btn-dark shadow mr-1 mb-1">Search
                                                    </b-button>
                                                    <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">
                                                        Reset
                                                    </b-button>
                                                </div>
                                            </b-form>
                                        </b-card>
                                        <b-card v-if="isSearch">
                                            <b-row>
                                                <b-col md="3">
                                                    <label for="employee_name">Employee Name</label>
                                                     {{employee_name}}
                                                </b-col>
                                                <b-col md="3">
                                                    <label for="emp_code">Employee Code</label>
                                                    {{emp_code}}
                                                </b-col>
                                                <b-col md="3">
                                                    <label for="designation">Designation</label>
                                                    {{designation}}
                                                </b-col>
                                                <b-col md="3">
                                                    <img id="profilepic" :src="photo" style="height: 100px;" class="img-fluid" alt="...">
                                                </b-col>
                                            </b-row>

                                                <b-row>
                                                    <b-col md="3" v-for="(list, index) in processList" :key="index">
                                                        <label>{{list.salary_head}}</label>
                                                        <b-form-input id="postcode" type="text" required placeholder="Enter Employee Code" :value="list.amount"></b-form-input>
                                                    </b-col>
                                                    <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                                        <b-button type="button"
                                                                  class="btn btn-dark shadow mr-1 mb-1">Update
                                                        </b-button>
                                                    </div>
                                                </b-row>
                                        </b-card>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";

    export default {
        props: ['id'],
        components: {Datatable},
        data() {
            return {
                errorMessage: {},
                processUpdate:{},
                show:{},
                submitBtn: 'Save',
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                employee_name:{},
                emp_code:{},
                designation:{},
                photo:{},
                isSearch:false,
                processList:[],
                staticFiscalYear: null,
                staticFiscalYearName: '',
                fiscalYearOptions: [],
                fiscal_months:[],
                fiscalYear: null,
                items: [
                    // { child_name: '', gender: '', date_of_birth: '', status: '', relationship: '', address:'', contact_no: '', Action: '' },
                ],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                }
            }
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "processUpdate"});
            this.totalRows = this.items.length;
            this.load();
            this.onReset();
        },

        methods: {
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            load(){
                let url = '/payroll/salary-process';
                ApiRepository.callApi(ApiRepository.GET_COMMAND, url).then(res => {
                    this.fiscal_months = res.data.pr_months;
                    this.fiscal_months = res.data.fiscal_months;
                    this.fiscalYearOptions = res.data.fecialYearList;
                });
            },
            onSubmit(evt) {
                evt.preventDefault();
                if(this.processUpdate.emp_code.trim() == ""){
                    this.errorMessage = 'Please Provide a Valid Employee Code!';
                    return false;
                }
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/search", this.processUpdate).then(res => {
                    if(res.data.hasError == 0){
                        this.employee_name = res.data.employee.emp_name;
                        this.emp_code = res.data.employee.emp_code;
                        this.designation = res.data.employee.designation;
                        this.photo = (res.data.employee.emp_photo) ? res.data.employee.emp_photo : '/images/avatar.png';
                        this.processList = res.data.prprocess;
                        this.isSearch = true;
                        this.errorMessage = '';
                    }else{
                        this.errorMessage = 'Please Provide a Valid Employee Code!';
                        this.isSearch = false;
                    }
                });
            },
            onReset() {
                // Reset our form values
                this.processUpdate.bill_code = '';
                this.processUpdate.emp_code = '';
                this.employee_name = '';
                this.emp_code = '';
                this.designation = '';
                this.errorMessage = '';
                this.isSearch = false;
                this.photo = '/images/avatar.png';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            }
        }
    }
</script>
<style>
    div.requiredField  label.d-block:after{
        content: '*';
        color: red;
    }
</style>
