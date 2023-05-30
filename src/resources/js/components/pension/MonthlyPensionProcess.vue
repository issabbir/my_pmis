<template>
    <div class="content-wrapper">
        <div id="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Monthly Pension Process</b-card-header>
                <b-card-body class="border">
                    <b-row class="d-flex justify-content-start">
                        <b-col md="4">
                            <b-form-group label="Year" label-for="year" class="requiredField">
                                <b-form-select
                                    @change="changeYear"
                                    v-model="pensionHeadObj.fy_id"
                                    :options="yearsList"
                                    name="years"
                                    v-validate="'required'"
                                ></b-form-select>
                                <span :style="errorMessage">{{ errors.first('fy_id') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group label="Month" label-for="month" class="requiredField">
                                <b-form-select

                                    v-model="pensionHeadObj.pr_month_id"
                                    :options="monthsList"
                                    name="months"
                                    v-validate="'required'"
                                ></b-form-select>
                                <span :style="errorMessage">{{ errors.first('pr_month_id') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="4" >
                            <b-form-group
                                label-for="pensionCat"
                                class="requiredField"
                                label="PENSION CATEGORY"
                            >
                                <b-form-select v-model="pensionHeadObj.pension_cat" name="pensionCat"
                                               :options="process_type_List"
                                               label="text" required>
                                </b-form-select>
                            </b-form-group>
                        </b-col>
                       <!-- <b-col md="3">
                            <b-form-group label="Department" label-for="department" class="requiredField">
                                <b-form-select

                                    v-model="pensionHeadObj.department_id"
                                    :options="departmentList"
                                    name="department"
                                    v-validate="'required'"
                                ></b-form-select>

                            </b-form-group>
                        </b-col>-->
                    </b-row>
                    <b-row class="d-flex justify-content-center">
                        <!--                            <h3>Pension Process of {{pr_month_id[pensionHeadObj.pr_month_id]}}</h3>-->
                    </b-row>
                    <b-row class="d-flex justify-content-center">
                        <button class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary  process-salary" v-b-modal.modal-center >Process Pension </button>
                    </b-row>
                </b-card-body>
            </b-card>
            <div>

                <b-modal id="modal-center" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                         @ok="processPension">
                    <div>Are you want to process Pension?</div>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from '../../Repository/ApiRepository';
    import Multiselect from 'vue-multiselect';

    export default {
        components: { DatePicker, Datatable,Multiselect },
        data() {
            return {
                errorMessage: {color: 'red'},
                pensionHeadObj:{
                    fy_id : '',
                    pr_month_id : null,
                    department_id: null,
                    process_type:null,
                    pension_cat:null
                },
                selected: 'first',
                totalLength:0,
                emp_status: [],

                text: '',
                show: false,
                showButton: false,
                pr_month_id:0,
                salaryHeadList: [],
                yearsList: [],
                monthsList: [],
                departmentList:[],
                process_type_List:[
                    { value: '50', text: '50%' },
                    { value: '100', text: '100%' },
                ],

                //pr_month_id:[],
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Monthly Pension Process"});
            // this.$validator.attach('months', 'required');
            this.allSalarySetup();
            this.changeYear();
            this.preLoadData();
        },
        methods: {
            preLoadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    //console.log(this.res);
                    this.departmentList= res.data.departments;
                });
            },
            changeYear(){
                if(this.pensionHeadObj.fy_id ){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pension/salary-setup/months-by-year-id/"+ this.pensionHeadObj.fy_id).then(res => {
                        console.log(this.res);
                        this.monthsList = res.data;
                        let that = this;
                        this.monthsList.forEach( month => {
                            if (month.text == moment().format("MMMM")) {
                                this.pensionHeadObj.pr_month_id = month.value;
                            }
                        });

                    });
                }
                },

            // Year list show from payroll
            // allSalarySetup() {
            //     ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/year-list").then(res => {
            //         this.yearsList = res.data;
            // });
            // },


            // Finalcial Year show from Pension
            allSalarySetup() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pension/bonus-process-heads").then(res => {
                    this.yearsList= res.data.fecialYearList;
                    let that = this;
                    this.yearsList.forEach(function(item) {
                        if (item.current_yn == 'Y') {
                            that.pensionHeadObj.fy_id = item.fy_id;
                            that.changeYear();
                            return;
                        }
                    });
                });
            },

            processPension: function() {
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/monthly-pension-process", this.pensionHeadObj).then(res => {
                    if (res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        //this.$router.push('/salary-process')
                    }
                    else
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});

                });
            }

        }
    }
</script>
<style>
    .mx-datepicker-popup {
        z-index: 9999;
    }
    .table.pr_month_setup td {
        border-bottom: 1px solid #DFE3E7;
        font-size: 14px;
        text-transform: capitalize;
    }
    .salaryInput td{
        padding-top: 20px;
        border:0px !important;
    }

    .process-salary{
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 12px 22px;
    }
</style>
