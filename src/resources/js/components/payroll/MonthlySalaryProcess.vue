<template>
    <div class="content-wrapper">
        <div id="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Salary Process</b-card-header>
                <b-card-body class="border">
                    <b-alert variant="success" :show=alertMessage.success dismissible>
                        {{alertMessage.message}}
                    </b-alert>
                    <b-alert variant="danger" :show=alertMessage.error dismissible>
                        {{alertMessage.message}}
                    </b-alert>
                    <b-row class="d-flex justify-content-start">
                        <b-col md="4" offset-md="2">
                            <b-form-group label="Year" label-for="year" label-cols-md="3" label-cols-sm="3" label-align-md="right">
                                <b-form-select
                                  @change="changeYear"
                                  v-model="salaryHeadObj.years"
                                  :options="yearsList"
                                  name="years"
                                  value-field="fy_name"
                                  text-field="fy_name"
                                  v-validate="'required'"
                                ></b-form-select>
                                <span :style="errorMessage">{{ errors.first('years') }}</span>
                                </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group label="Month" label-for="month" label-cols-md="3" label-cols-sm="3" label-align-md="right">
                                <b-form-select @change="changeMonth" v-model="salaryHeadObj.months" :options="monthsList" name="months" v-validate="'required'"></b-form-select>
                                <span :style="errorMessage">{{ errors.first('months') }}</span>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
            <div>
                <b-card v-if="showButton" >
                    <b-card-body class="border">
                        <b-row class="d-flex justify-content-center">
                            <h3 class="text-center">Salary Process of {{months[salaryHeadObj.months]}}</h3>
                        </b-row>
                        <b-row class="d-flex justify-content-center">
                            <button class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary  process-salary" v-b-modal.modal-center >Process Salary</button>
                        </b-row>
                    </b-card-body>
                </b-card>
                <b-modal id="modal-center" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                        @ok="processPayroll">
                    <div>Are you want to process salary?</div>
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
                alertMessage : {show:true, message:'', success:false, error:false},
                valueType: this.dateFormatter(),
                employeeSearch: {
                    years: '',
                    month: '',
                 },
                salaryHeadObj:{
                    years : null,
                    months : null,
                    salaryHeadBasic: [],
                    noEveryMonthSalary: [],
                    SalaryHeadInputs : {},
                },
                selected: 'first',
                totalLength:0,
                emp_status: [],

                tableData: {
                    fields: [{key:'salaryHead', label:'salary Head', sortable:true}, {key:'action', sortable:true}, {key:'bank_name_bng', sortable:true}, 'action'],
                    items: [
                      { salaryHead: 'Basic', action: ''},
                      { salaryHead: 'Medical Allowance', action: ''},
                    ]
                },
                text: '',
                show: false,
                showButton: false,
                monthId:0,
                salaryHeadList: [],
                yearsList: [],
                monthsList: [],
                months:[],
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Monthly Salary Process"});
            // this.$validator.attach('months', 'required');
                this.allSalarySetup();
                this.changeYear();
        },
        methods: {
            changeMonth(value){
                console.log(this.salaryHeadObj.years);
                 if (this.salaryHeadObj.years && value){
                      this.monthWiseSalaryHead(value);
                    this.show = true;
                }else{
                     this.show = false;
                 }
            },
            changeYear(value){
                if(value){
                    let that = this;
                   ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/months/"+value).then(res => {
                       that.monthsList = res.data;
                       that.monthsList.forEach(function(item) {
                            that.months[item.value] = item.text
                           if (item.text == moment().format("MMMM")) {
                               that.salaryHeadObj.months = item.value;
                               that.changeMonth(that.salaryHeadObj.months);
                           }
                        });
                   });
                    this.salaryHeadObj.years = value;
                }else{
                  this.salaryHeadObj.years = null;
                }
                return this.salaryHeadObj.years;
            },
             checkSalaryHead(value){
                  this.salaryHeadList = this.salaryHeadList.filter(e => e !== value)
                },
            addRow() {
                  this.salaryHeadObj.SalaryHeadInputs.push({ })
                },
                deleteRow(head_id) {
                    let currObj = this;
                    if (confirm('Are you want to delete this head!')){
                      // this.salaryHeadObj.noEveryMonthSalary.splice(head_id,1)
                        ApiRepository.callApi(ApiRepository.DELETE_COMMAND, "/payroll/salary-setup/"+head_id+'/' + this.monthId).then(res => {
                             this.monthWiseSalaryHead(this.monthId);
                             if (res.data.o_status_code == 1){
                                 currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                 currObj.salaryHeadObj.SalaryHeadInputs = {};
                                 currObj.allSalarySetup();
                            }else{
                                 currObj.$notify({group: 'pmis', text: res.data.o_status_message ? res.data.o_status_message : 'error', type: 'error'})
                             }
                            }).catch(err => {
                                currObj.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' });
                            });
                     }

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
            notAfterYears() {
                return moment();
            },
            allSalarySetup() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/periods").then(res => {
                    this.yearsList = res.data.fecialYearList.filter(a=>a.current_yn == 'Y');
                    this.salaryHeadObj.years = this.yearsList[0].fy_name
                    this.changeYear(this.salaryHeadObj.years);
                    /*this.yearsList.forEach( item => {
                        if (item.current_yn == 'Y') {
                            this.salaryHeadObj.years = item.value;

                        }

                    });*/

                    /*this.yearsList = res.data.years;
                    let that = this;
                    this.yearsList.forEach(function(item) {
                        if (item.current_yn == 'Y') {
                            that.salaryHeadObj.years = item.fy_id;
                            that.changeYear();
                        }
                    });*/
                  // this.monthsList = res.data.months;


                 });
            },
            monthWiseSalaryHead(value){
                this.monthId = value;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/" + value).then(res => {
                        this.salaryHeadObj.noEveryMonthSalary = res.data.salary_head;
                        this.salaryHeadObj.salaryHeadBasic = res.data.salaryHeadBasic;
                        this.totalLength = res.data.salaryHeadBasic.length;
                        this.salaryHeadList = res.data.salaryHeads;
                             if(res.data.salary_head.length > 0){
                                this.showButton = true;
                            } else if(this.salaryHeadObj.salaryHeadBasic.length > 0){
                                this.showButton = true;
                            }
                    });
            },
            saveData(e) {
                e.preventDefault();
                // console.log('here',this.salaryHeadObj.SalaryHeadInputs.salaryHead); return false;
                let currObj = this;
                 this.$validator.validateAll().then(() => {
                     if (!this.errors.any()) {
                     ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/salary-setup", this.salaryHeadObj).then(res => {
                         this.monthWiseSalaryHead(this.monthId);
                         if (res.data.o_status_code == 1){
                             currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                              //this.salaryHeadList = [];
                              //currObj.allSalarySetup();
                                currObj.salaryHeadObj.SalaryHeadInputs = {};
                             }else{
                             currObj.$notify({group: 'pmis', text: res.data.o_status_message ? res.data.o_status_message : 'Data Already Exist', type: 'error'})
                         }
                     }).catch(err => {
                                currObj.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' });
                            });
                     } else {
                        console.log('here', currObj.errors);
                    }
                 });
            },
           onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            },
            processPayroll: function() {

                // ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/salary-setup", this.salaryHeadObj).then(res => {
                //     console.log('Data save success');
                // });

                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/monthly-process", this.salaryHeadObj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.alertMessage.message = res.data.o_status_message;
                        this.alertMessage.show = true;
                        this.alertMessage.success = true;
                        this.alertMessage.error = false;

                        //this.$router.push('/salary-process')
                    }
                    else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        this.alertMessage.message = res.data.o_status_message;
                        this.alertMessage.show = true;
                        this.alertMessage.success = false;
                        this.alertMessage.error = true;
                    }
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
