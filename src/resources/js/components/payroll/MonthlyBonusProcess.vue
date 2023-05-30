<template>
    <div class="content-wrapper">
        <div id="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Bonus Process</b-card-header>
                <b-card-body class="border">
                    <b-row class="d-flex justify-content-start">
                        <b-col md="3">
                            <b-form-group label="Year" label-for="year" label-cols-md="3" label-cols-sm="3" label-align-md="right">
                                <b-form-select @change="changeYear" v-model="bonusHeadObj.years" :options="yearsList" name="years" v-validate="'required'"></b-form-select>
                                <span :style="errorMessage">{{ errors.first('years') }}</span>
                                </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Month" label-for="month" label-cols-md="3" label-cols-sm="3" label-align-md="right">
                                <b-form-select @change="changeMonth" v-model="bonusHeadObj.months" :options="monthsList" name="months" v-validate="'required'"></b-form-select>
                                <span :style="errorMessage">{{ errors.first('months') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Bonus Head" label-for="bonus_head" label-cols-md="3" label-cols-sm="3" label-align-md="right">
                                <b-form-select v-model="bonusHeadObj.bonus_head" :options="bonusHeads" name="bonus_head" text-field="salary_head" value-field="salary_head_id" v-validate="'required'"></b-form-select>
                                <span :style="errorMessage">{{ errors.first('bonus_head') }}</span>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
            <div>
                <b-card v-if="showButton" >
                    <b-card-body class="border">
                        <b-row class="d-flex justify-content-center">
                            <h3>Bonus Process of {{months[bonusHeadObj.months]}}</h3>
                        </b-row>
                        <b-row class="d-flex justify-content-center">
                            <button class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary  process-salary" v-b-modal.modal-center >Process Bonus</button>
                        </b-row>
                    </b-card-body>
                </b-card>
                <b-modal id="modal-center" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                        @ok="processBonus">
                    <div>Are you want to process Bonus?</div>
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
                valueType: this.dateFormatter(),
                employeeSearch: {
                    years: '',
                    month: '',
                 },
                bonusHeadObj:{
                    years : null,
                    months : null,
                    bonus_head : null,
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
                bonusHeads: [],
                months:[],
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Bonus Process"});
            // this.$validator.attach('months', 'required');
                this.allSalarySetup();
                this.changeYear();
                this.allBonusHeads();
              },
        methods: {
            changeMonth(value){
                console.log(this.bonusHeadObj.years);
                 if (this.bonusHeadObj.years && value){
                      this.monthWiseSalaryHead(value);
                    this.show = true;
                }else{
                     this.show = false;
                 }
            },
            changeYear(value){
                if(value){
                    let that = this;
                   ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/months/"+value+"?p=b").then(res => {
                       that.monthsList = res.data;
                       that.monthsList.forEach(function(item) {
                            that.months[item.value] = item.text
                           if (item.text == moment().format("MMMM")) {
                               that.bonusHeadObj.months = item.value;
                               that.changeMonth(that.bonusHeadObj.months);
                           }
                        });
                   });
                     this.bonusHeadObj.years = value;
                }else{
                    this.bonusHeadObj.years = null;
                }
                return this.bonusHeadObj.years;
            },
             checkSalaryHead(value){
                  this.salaryHeadList = this.salaryHeadList.filter(e => e !== value)
                },
            addRow() {
                  this.bonusHeadObj.SalaryHeadInputs.push({ })
                },
                deleteRow(head_id) {
                    let currObj = this;
                    if (confirm('Are you want to delete this head!')){
                      // this.salaryHeadObj.noEveryMonthSalary.splice(head_id,1)
                        ApiRepository.callApi(ApiRepository.DELETE_COMMAND, "/payroll/salary-setup/"+head_id+'/' + this.monthId).then(res => {
                             this.monthWiseSalaryHead(this.monthId);
                             if (res.data.o_status_code == 1){
                                 currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                 currObj.bonusHeadObj.SalaryHeadInputs = {};
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
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup").then(res => {
                    this.yearsList = res.data.years;
                    let that = this;
                    this.yearsList.forEach(function(item) {
                        if (item.current_yn == 'Y') {
                            that.salaryHeadObj.years = item;
                            that.changeYear(item.fy_id);
                        }
                    });
                   // this.monthsList = res.data.months;
                    this.salaryHeadList = res.data.salaryHeads;
                    this.bonusHeadObj.salaryHeadBasic = res.data.salaryHeadBasic;
                    this.totalLength = res.data.salaryHeadBasic.length;
                 });
            },
            allBonusHeads() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-process-heads").then(res => {
                    this.bonusHeads = res.data.bonusHeads;
                });
            },
            monthWiseSalaryHead(value){
                this.monthId = value;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/" + value).then(res => {
                        this.bonusHeadObj.noEveryMonthSalary = res.data;
                        this.showButton = true;
                             /*if(res.data.length > 0){
                                this.showButton = true;
                            } else if(this.bonusHeadObj.salaryHeadBasic.length > 0){
                                this.showButton = true;
                            }*/
                    });
            },
            saveData(e) {
                e.preventDefault();
                // console.log('here',this.salaryHeadObj.SalaryHeadInputs.salaryHead); return false;
                let currObj = this;
                 this.$validator.validateAll().then(() => {
                     if (!this.errors.any()) {
                     ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/salary-setup", this.bonusHeadObj).then(res => {
                         this.monthWiseSalaryHead(this.monthId);
                         if (res.data.o_status_code == 1){
                             currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                              //this.salaryHeadList = [];
                              //currObj.allSalarySetup();
                                currObj.bonusHeadObj.SalaryHeadInputs = {};
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
            processBonus: function() {

                // ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/salary-setup", this.salaryHeadObj).then(res => {
                //     console.log('Data save success');
                // });

                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/monthly-bonus-process", this.bonusHeadObj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        //this.$router.push('/salary-process')
                    }
                    else
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})

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
