<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Monthly Salary Setup</b-card-header>
                <b-card-body class="border">
                    <b-row class="d-flex justify-content-center">
                        <b-col md="2">
                            <b-form-group label="Year" label-for="year">
                                <b-form-select @change="changeYear"
                                            v-model="salaryHeadObj.years"
                                            :options="yearsList" name="years"
                                            v-validate="'required'"></b-form-select>
                                <span :style="errorMessage">{{ errors.first('years') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="2">
                            <b-form-group label="Month" label-for="month">
                                <b-form-select @change="changeMonth"
                                            v-model="salaryHeadObj.months"
                                            :options="monthsList" name="months"
                                            v-validate="'required'"></b-form-select>
                                <span :style="errorMessage">{{ errors.first('months') }}</span>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <div v-if="show">
                        <!--                                            <b-table striped   :items="tableData.items"></b-table>-->
                        <b-table-simple small responsive="sm" class="pr_month_setup">
                            <b-thead head-variant="dark">
                                <b-tr>
                                    <b-th>SL</b-th>
                                    <b-th>Salary Head</b-th>
                                    <b-th>Status</b-th>
                                    <b-th>Type</b-th>
                                    <b-th>Action</b-th>
                                </b-tr>
                            </b-thead>
                            <b-tbody>
                                <b-tr v-for="(salaryValue, index) in salaryHeadObj.salaryHeadBasic"
                                    :key="salaryValue.key">
                                    <b-td style="width: 5%">{{ index+1 }}</b-td>
                                    <b-td>{{ salaryValue.salaryHead.name }}</b-td>
                                    <b-td>Every Month Head</b-td>
                                    <b-td>{{ salaryValue.salaryHead.deduction_yn == 'Y' ?
                                        'Deduction' : 'Addition' }}
                                    </b-td>
                                    <b-td></b-td>
                                </b-tr>
                                <b-tr v-for="(salaryHeads, index) in salaryHeadObj.noEveryMonthSalary"
                                    :key="salaryHeads.key">
                                    <b-td>{{ index+totalLength+1 }}</b-td>
                                    <b-td>{{salaryHeads.salary_heads?salaryHeads.salary_heads.salary_head:''}}</b-td>
                                    <b-td>Optional Head</b-td>
                                    <b-td>{{ salaryHeads.salary_heads? (salaryHeads.salary_heads.deduction_yn == 'Y' ?
                                        'Deduction' : 'Addition'):'' }}
                                    </b-td>
                                    <b-td><a
                                            @click="deleteRow(salaryHeads.salary_heads?salaryHeads.salary_heads.salary_head_id:'')"><i
                                            class="bx bx-trash cursor-pointer text-danger"></i></a>
                                    </b-td>
                                </b-tr>
                            </b-tbody>
                        </b-table-simple>
                        <b-row>
                            <b-col md="3">
                                <multiselect
                                            :reset-after="false" style="width:350px"
                                            name="salary head" @input="checkSalaryHead"
                                            v-model="salaryHeadObj.SalaryHeadInputs.salaryHead"
                                            :options="salaryHeadList" select-label=""
                                            placeholder="Select one" label="name"
                                            track-by="name" trim></multiselect>
                                <span :style="errorMessage">{{ errors.first('salary head') }}</span>
                            </b-col>
                            <b-col md="4">
                                <button @click="saveData"
                                        class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary">
                                    Add Head And Save
                                </button>
                            </b-col>
                        </b-row>
                    </div>
                </b-card-body>
            </b-card>
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
        components: {DatePicker, Datatable, Multiselect},
        data() {
            return {
                errorMessage: {color: 'red'},
                valueType: this.dateFormatter(),
                    employeeSearch: {
                        years: '',
                    month: '',
                },
                salaryHeadObj: {
                    years: null,
                    months: null,
                    salaryHeadBasic: [],
                    noEveryMonthSalary: [],
                    SalaryHeadInputs: {},
                },
                selected: 'first',
                totalLength: 0,
                emp_status: [],

                tableData: {
                    fields: [{key: 'salaryHead', label: 'salary Head', sortable: true}, {
                        key: 'action',
                        sortable: true
                    }, {key: 'bank_name_bng', sortable: true}, 'action'],
                    items: [
                        {salaryHead: 'Basic', action: ''},
                        {salaryHead: 'Medical Allowance', action: ''},
                    ]
                },
                text: '',
                show: false,
                showButton: false,
                monthId: 0,
                salaryHeadList: [],
                oldSalaryHeadList: [],
                yearsList: [],
                monthsList: [],
                months: [],
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Monthly Salary Setup"});
            // this.$validator.attach('months', 'required');
            this.allSalarySetup();
            this.changeYear();
        },
        methods: {
            changeMonth(value) {
                console.log(this.salaryHeadObj.years);
                if (this.salaryHeadObj.years && value) {
                    this.monthWiseSalaryHead(value);
                    this.show = true;
                } else {
                    this.show = false;
                }
            },
            changeYear(value) {
                if (value) {
                    let that = this;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/months/" + value).then(res => {
                        that.monthsList = res.data;
                        that.monthsList.forEach(function (item) {
                            that.months[item.value] = item.text
                        });
                    });
                    this.salaryHeadObj.years = value;
                } else {
                    this.salaryHeadObj.years = null;
                }
                return this.salaryHeadObj.years;
            },
            checkSalaryHead(value) {
                this.salaryHeadList = this.oldSalaryHeadList.filter(e => e !== value)
            },
            addRow() {
                this.salaryHeadObj.SalaryHeadInputs.push({})
            },
            deleteRow(head_id) {
                let currObj = this;
                if (confirm('Are you want to delete this head!')) {
                    // this.salaryHeadObj.noEveryMonthSalary.splice(head_id,1)
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, "/payroll/salary-setup/" + head_id + '/' + this.monthId).then(res => {
                        this.monthWiseSalaryHead(this.monthId);
                        if (res.data.o_status_code == 1) {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            currObj.salaryHeadObj.SalaryHeadInputs = {};
                            currObj.allSalarySetup();
                        } else {
                            currObj.$notify({
                                group: 'pmis',
                                text: res.data.o_status_message ? res.data.o_status_message : 'error',
                                type: 'error'
                            })
                        }
                    }).catch(err => {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    });
                }

            },
            dateFormatter: function () {
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
                    // this.monthsList = res.data.months;
                  //  this.oldSalaryHeadList = res.data.salaryHeads;
                  //  this.salaryHeadList = this.oldSalaryHeadList
                  //  this.salaryHeadObj.salaryHeadBasic = res.data.salaryHeadBasic;
                  //  this.totalLength = res.data.salaryHeadBasic.length;
                });
            },
            monthWiseSalaryHead(value) {
                this.monthId = value;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/" + value).then(res => {
                    this.oldSalaryHeadList = res.data.salaryHeads
                    this.salaryHeadList = this.oldSalaryHeadList
                    this.salaryHeadObj.salaryHeadBasic = res.data.salaryHeadBasic;
                    this.totalLength = res.data.salaryHeadBasic.length;
                    this.salaryHeadObj.noEveryMonthSalary = res.data.salary_head;
                    if (res.data.salary_head.length > 0) {
                        this.showButton = true;
                    } else if (this.salaryHeadObj.salaryHeadBasic.length > 0) {
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
                            if (res.data.o_status_code == 1) {
                                currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                //this.salaryHeadList = [];
                                //currObj.allSalarySetup();
                                currObj.salaryHeadObj.SalaryHeadInputs = {};
                            } else {
                                currObj.$notify({
                                    group: 'pmis',
                                    text: res.data.o_status_message ? res.data.o_status_message : 'Data Already Exist',
                                    type: 'error'
                                })
                            }
                        }).catch(err => {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
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
            processPayroll: function () {

                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/salary-setup", this.salaryHeadObj).then(res => {
                    console.log('Data save success');
                });

                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/monthly-process", this.salaryHeadObj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        this.$router.push('/salary-process')
                    } else
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

    .salaryInput td {
        padding-top: 20px;
        border: 0px !important;
    }

    .process-salary {
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 12px 22px;
    }
</style>
