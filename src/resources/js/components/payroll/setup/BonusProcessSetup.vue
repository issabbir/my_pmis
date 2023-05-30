<template>
    <div class="content-wrapper"  id="setup_form">
        <div id="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Bonus Process</b-card-header>
                <b-card-body class="border">
                    <b-form  @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row class="d-flex justify-content-start">
                            <b-col md="4">
                                <b-form-group label="Year" label-for="year" label-cols-md="3" label-cols-sm="3" label-align-md="right">
                                    <b-form-select @change="changeYear" v-model="bonusSetup.years" :options="yearsList" name="years"></b-form-select>
                                    </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Month" label-for="month" label-cols-md="3" label-cols-sm="3" label-align-md="right">
                                    <b-form-select @change="changeMonth" v-model="bonusSetup.pr_month_id" :options="monthsList" name="months"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Bonus Head" label-for="bonus_head" label-cols-md="3" label-cols-sm="3" label-align-md="right">
                                    <b-form-select v-model="bonusSetup.salary_head_id" :options="bonusHeads" name="bonus_head" text-field="salary_head" value-field="salary_head_id"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Festival Date"
                                    label-for="festival_date"
                                    class="requiredField"
                                    label-cols-md="3"
                                >
                                    <date-picker
                                        v-model="bonusSetup.bonus_effective_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        name="to_date"
                                        id="to_date"
                                        :not-before="new Date()"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                    >
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Active" label-for="active_yn" label-cols-md="3" label-cols-sm="3" label-align-md="right">
                                    <b-form-radio-group
                                        id="radio-group-1"
                                        v-model="bonusSetup.active_yn"
                                        :options="activeOptions"
                                        name="radio-options"
                                    ></b-form-radio-group>
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
            <div>
                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Setup List</b-card-header>
                    <b-card-body class="border">
                        <Datatable v-bind:fields="fields" v-bind:items="items"  :perPage="perPage" :totalList="totalList">
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
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from '../../../Repository/ApiRepository';
    import Multiselect from 'vue-multiselect';

    export default {
        components: { DatePicker, Datatable,Multiselect },
        data() {
            return {
                errorMessage: {color: 'red'},
                valueType: this.dateFormatter(),
                submitBtn: 'Save',
                employeeSearch: {
                    years: '',
                    month: '',
                 },
                state :{
                    date: new Date(2016, 9,  16)
                },
                bonusSetup:{
                    years : null,
                    pr_month_id : null,
                    salary_head_id : null,
                    bonus_effective_date : null,
                    active_yn : 'Y',
                },
                selected: 'first',
                totalLength:0,
                perPage:15,
                totalList:0,
                emp_status: [],
                text: '',
                show: false,
                showButton: false,
                monthId:0,
                salaryHeadList: [],
                yearsList: [],
                monthsList: [],
                bonusHeads: [],
                months:[],
                items: [],
                activeOptions: [
                    { text: 'Yes', value: 'Y' },
                    { text: 'No', value: 'N' }
                ],
                fields: [
                    {key:'pr_months.pr_year', label:'PR Year', sortable:true},
                    {key:'pr_months.formatted_month', label:'PR Months', sortable:true},
                    {key: 'bonus_effective_date', label: 'Effective Date',formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, sortable: true, sortDirection: 'desc'},
                    {key:'salary_head', label:'Salary Head', sortable:true},
                    {key:'salary_head', label:'Salary Head', sortable:true},
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
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Bonus Process"});
            // this.$validator.attach('months', 'required');
                this.allSalarySetup();
                this.changeYear();
                this.allBonusHeads();
                this.loadData();
              },
        methods: {
            loadData() {
                // ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-setup"+'?page=' + ctx.currentPage + '&size=' + ctx.perPage+'&filter=' + ctx.filter).then(res => {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-setup").then(res => {
                    //this.items=res.data.records;
                    this.items  =res.data.bonus_data;
                    this.totalList = res.data.bonus_data.length;
                });
            },
            changeMonth(value){
                console.log(this.bonusSetup.years);
                 if (this.bonusSetup.years && value){
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
                               that.bonusSetup.months = item.value;
                               that.changeMonth(that.bonusSetup.months);
                           }
                        });
                   });
                     this.bonusSetup.years = value;
                }else{
                    this.bonusSetup.years = null;
                }
                return this.bonusSetup.years;
            },
             checkSalaryHead(value){
                  this.salaryHeadList = this.salaryHeadList.filter(e => e !== value)
                },
            addRow() {
                  this.bonusSetup.SalaryHeadInputs.push({ })
                },
                deleteRow(head_id) {
                    let currObj = this;
                    if (confirm('Are you want to delete this head!')){
                      // this.salaryHeadObj.noEveryMonthSalary.splice(head_id,1)
                        ApiRepository.callApi(ApiRepository.DELETE_COMMAND, "/payroll/salary-setup/"+head_id+'/' + this.monthId).then(res => {
                             this.monthWiseSalaryHead(this.monthId);
                             if (res.data.o_status_code == 1){
                                 currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                 currObj.bonusSetup.SalaryHeadInputs = {};
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
                    this.bonusSetup.salaryHeadBasic = res.data.salaryHeadBasic;
                    this.totalLength = res.data.salaryHeadBasic.length;
                 });
            },
            allBonusHeads() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-process-heads").then(res => {
                    this.bonusHeads = res.data.bonusHeads.filter(data=>{
                        return data.salary_head_id != 43 && data.salary_head_id != 72;
                    });
                });
            },
            monthWiseSalaryHead(value){
                this.monthId = value;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/" + value).then(res => {
                            this.bonusSetup.noEveryMonthSalary = res.data;
                             if(res.data.length > 0){
                                this.showButton = true;
                            } else if(this.bonusSetup.salaryHeadBasic.length > 0){
                                this.showButton = true;
                            }
                    });
            },
            onSubmit(evt) {
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/bonus-setup-store", this.bonusSetup).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        this.loadData();
                        this.onReset();
                    } else{
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    }
                });
            },
            onReset() {
                this.bonusSetup = {};
                this.submitBtn = 'Save';
            },
            editRow(data){
                this.changeYear(data.pr_months.pr_year);
                this.bonusSetup = data;
                this.bonusSetup.years = data.pr_months.pr_year;
                this.submitBtn = 'Update';
                this.scroll()
            },
            scroll() {
                const element = document.getElementById('setup_form');
                element.scrollIntoView({ behavior: 'smooth' });
            },
           onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            },

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
