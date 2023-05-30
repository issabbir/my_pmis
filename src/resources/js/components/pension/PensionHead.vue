<template>
    <div class="content-wrapper">
        <div id="content-body">
            <b-card>
                <b-card-header>Pension Head Setup</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row class="d-flex justify-content-start">
                            <b-col md="3">
                                <b-form-group label="Year" id="year" label-for="year" class="requiredField">
                                    <b-form-select
                                        @change="changeYear"
                                        v-model="pensionHead.fy_id"
                                        :options="yearsList"
                                        name="years"
                                        v-validate="'required'"
                                    ></b-form-select>
                                    <span :style="errorMessage">{{ errors.first('fy_id') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Month" label-for="month" class="requiredField">
                                    <b-form-select
                                        v-model="pensionHead.pr_month_id"
                                        :options="monthsList"
                                        name="months"
                                        v-validate="'required'"
                                    ></b-form-select>
                                    <span :style="errorMessage">{{ errors.first('pr_month_id') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Allowance Head" label-for="allowance" class="requiredField">
                                    <b-form-select

                                        v-model="pensionHead.pension_head_id"
                                        :options="allowanceList"
                                        name="allowance"
                                        text-field="pension_head"
                                        value-field="pension_head_id"
                                        v-validate="'required'"
                                    ></b-form-select>

                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-row>
                                    <b-col class="mt-1 d-flex">
                                        <b-button lg="6" size="md" variant="dark" type="submit">{{submitBtn}}</b-button>
                                        &nbsp;
                                        <b-button lg="6" size="md" class="btn-outline-dark" type="reset">Cancel
                                        </b-button>
                                    </b-col>
                                </b-row>
                            </b-col>

                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>
            <section id="basic-datatable">
                <b-row>
                    <b-col>
                        <b-card class="card">
                            <b-form>
                                <b-row>
                                    <b-col sm="4">
                                        <b-form-group label="Year" label-cols-md="4" label-for="year">
                                            <b-form-select
                                                @change="searchChangeYear"
                                                v-model="searchPensionHeadYear.fy_id"
                                                :options="yearsList"
                                                name="years"
                                                v-validate="'required'"
                                            ></b-form-select>

                                        </b-form-group>
                                    </b-col>
                                    <b-col sm="4">
                                        <b-form-group label="Month" label-cols-md="4" label-for="month">
                                            <b-form-select
                                                v-model="searchPensionHeadYear.pr_month_id"
                                                :options="searchMonthsList"
                                                name="months"
                                                v-validate="'required'"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col>
                                        <div class="pr-0 d-flex justify-content-start">
                                            <b-button-group>
                                                <b-button type="button" @click="searchByYearMonth()" variant="primary">
                                                    <i
                                                        class='bx bx-search'></i>Search
                                                </b-button>
                                                <b-button type="button" @click="clear()" variant="secondary">Reset
                                                </b-button>
                                            </b-button-group>
                                        </div>
                                    </b-col>

                                </b-row>
                                <div class="card-content">
                                    <b-card-text class="card-body">

                                        <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items"
                                                   :totalList="totalList" :perPage="perPage">
                                            <template v-slot:actions="{ rows }">
                                                <b-link ml="4" class="text-danger"
                                                        @click="deleteRow(rows.item)">
                                                    <i class="bx bx-trash cursor-pointer"></i>
                                                </b-link>
                                            </template>
                                        </Datatable>
                                    </b-card-text>
                                </div>
                            </b-form>
                        </b-card>
                    </b-col>
                </b-row>
            </section>

        </div>

    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from '../../Repository/ApiRepository';
    import Multiselect from 'vue-multiselect';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';

    export default {
        components: {DatePicker, Datatable, Multiselect, vSelect, vcss},
        data() {
            return {
                errorMessage: {color: 'red'},
                searchPensionHeadYear: {},
                pensionHead: {
                    fy_id: '',
                    pr_month_id: null,
                    pension_head_id: null,
                },
                pr_month_id: 0,
                yearsList: [],
                searchMonthsList: [],
                monthsList: [],
                allowanceList: [],
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                totalList: 0,
                perPage: 5,
                tableData: {
                    fields: [
                        //{key: 'section_id'},
                        {key: 'index', label: 'SL', class: 'text-center'},
                        {key: 'fin_year', 'label': 'Year', sortable: true},
                        {key: 'month_name', label: 'Month', sortable: true},
                        {key: 'pension_head', label: 'Allowance Head', sortable: true},
                        'action'
                    ],
                    items: []
                },
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension Head Setup"});
            // this.$validator.attach('months', 'required');
            this.preLoadData();
            //this.allAllowanceHead();

        },
        methods: {
            // allAllowanceHead(){
            //     ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/pension-head-data').then(result => {
            //         console.log(result.data);
            //         this.tableData.items = result.data;
            //         this.totalList = result.data.length;
            //     }).catch(function(error) {
            //         // handle errors.
            //     });
            //
            // },
            preLoadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/pension-heads').then(res => {
                    console.log(this.res);
                    this.allowanceList = res.data;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup").then(res => {
                    this.yearsList = res.data.financialYears;
                });
            },
            changeYear() {
                if (this.pensionHead.fy_id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/months-by-year-id/" + this.pensionHead.fy_id).then(res => {
                        console.log(this.res);
                        this.monthsList = res.data;

                    });
                }


            },
            searchChangeYear() {
                if (this.searchPensionHeadYear.fy_id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/months-by-year-id/" + this.searchPensionHeadYear.fy_id).then(res => {
                        console.log(this.res);
                        this.searchMonthsList = res.data;

                    });
                }


            },
            onSubmit(evt) {
                evt.preventDefault();
                let param = this.pensionHead;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/pension/pension-head', param).then(res => {

                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.preLoadData();
                        this.searchByYearMonth();
                        this.onReset();
                    } else {
                        //alert (res.data.o_status_message);
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});

                    }
                })

            },
            onReset(evt) {
                this.pensionHead = {};
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            deleteRow(data) {
                if (confirm("Do you really want to delete?"))
                {
                    let item = Object.assign({}, data);
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/pension/delete-pension',item).then(result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'});
                            this.preLoadData();
                            this.searchByYearMonth();
                        } else {
                            //alert (res.data.o_status_message);
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'error'});

                        }
                    });
                }
            },
            searchByYearMonth() {
                let pr_month_id = this.searchPensionHeadYear.pr_month_id;
                //let param =this.searchPensionHeadYear;
                console.log(this.searchPensionHeadYear);
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/pension-head-data?pr_month_id=${pr_month_id}`).then(result => {
                    console.log(result.data);
                    this.tableData.items = result.data;

                    //console.log(result.data);
                }).catch(err => {
                    console.log('error');
                });
            },
            clear() {
                this.searchParamYear = null,
                    this.fetchData();
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
