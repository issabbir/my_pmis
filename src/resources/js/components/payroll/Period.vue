<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card >
                <b-card-header>
                    <!-- <h4>Financial Year: {{staticFiscalYearName}}</h4> -->
                    <b-form @submit.prevent="onSearchSubmit('search')" name="search" data-vv-scope="search">
                        <b-row>
                            <b-col lg="2" class="form-group">
                                <label>Financial Years</label>
                            </b-col>
                            <b-col lg="3" class="form-group">
                                <b-form-select
                                        v-model="fiscalYear"
                                        :options="fiscalYearOptions"
                                        class=""
                                        value-field="value"
                                        text-field="text"
                                        disabled-field="notEnabled" name="fiscalYear" required  v-validate="'required'"  data-vv-scope="search"
                                ></b-form-select>
                                <span :style="errorMessage">{{ errors.first('search.fiscalYear') }}</span>
                            </b-col>
                            <b-col>
                                <b-button lg="6" size="md" class="btn-dark shadow mr-1 mb-1 btn-secondary" type="submit">
                                    <i class="bx bx-search cursor-pointer"></i>Search
                                </b-button>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-header>
                <b-card-body class="border" v-if="staticFiscalYearName">
                    <b-form @submit.prevent="onSubmit('creationForm')" @reset.prevent="onReset" name="creationForm" data-vv-scope="creationForm" v-if="show">
                        <b-table-simple>
                            <b-thead head-variant="dark">
                                <b-tr>
                                    <b-th>SL</b-th>
                                    <b-th>Status</b-th>
                                    <b-th>Month</b-th>
                                    <b-th>From Date</b-th>
                                    <b-th>To Date</b-th>
                                    <b-th>Current month?</b-th>
                                    <b-th>Bonus applicable?</b-th>
                                    <b-th>Action</b-th>
                                </b-tr>
                                <b-tr>
                                    <b-td>SL</b-td>
                                    <b-td>
                                        <b-form-select v-model="period.open_yn" name="open_yn" required  v-validate="'required'" data-vv-scope="creationForm">
                                            <option value="N" v-if="updateIndex < 1">Not Open</option>
                                            <option value="O" v-if="updateIndex > 1">Open</option>
                                            <option value="C" v-if="updateIndex > 1">Close</option>
                                        </b-form-select>
                                        <span :style="errorMessage">{{ errors.first('creationForm.open_yn') }}</span>
                                    </b-td>
                                    <b-td>
                                        <b-form-select v-model="period.pr_month" name="pr_month" required  v-validate="'required'" :options="fiscal_months" value-field="pr_month" text-field="text" data-vv-scope="creationForm">
                                        </b-form-select>
                                        <span :style="errorMessage">{{ errors.first('creationForm.pr_month') }}</span>
                                    </b-td>
                                    <b-td>
                                        <date-picker
                                                v-model="period.calculation_start_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                format="YYYY-MM-DD"
                                                name="calculation_start_date"
                                                :value-type="valueType" :editable="false"
                                                :disabled="period.pr_month ? false : true"
                                                required  v-validate="'required'" data-vv-scope="creationForm" :not-before="notBeforeGivenMonth()" :not-after="notAfterGivenMonth()"
                                        ></date-picker>
                                        <span :style="errorMessage">{{ errors.first('creationForm.calculation_start_date') }}</span>
                                    </b-td>
                                    <b-td>
                                        <date-picker
                                                v-model="period.calculation_end_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                format="YYYY-MM-DD"
                                                name="calculation_end_date"
                                                :disabled="period.pr_month ? false : true"
                                                :value-type="valueType" :editable="false"
                                                required  v-validate="'required'" data-vv-scope="creationForm" :not-before="notBeforeGivenMonth()" :not-after="notAfterGivenMonth()"
                                        ></date-picker>
                                        <span :style="errorMessage">{{ errors.first('creationForm.calculation_end_date') }}</span>
                                    </b-td>
                                    <b-td>
                                        <b-form-checkbox v-model="period.current_yn" name="current_yn" value="Y"></b-form-checkbox>
                                    </b-td>
                                    <b-td>
                                        <b-form-checkbox v-model="period.bonus_applicable_yn" name="bonus_applicable_yn" value="Y"></b-form-checkbox>
                                    </b-td>
                                    <b-td>
                                        <b-button type="submit" id="basic_sub_btn"
                                                    class="btn btn-dark shadow mr-1 mb-1">{{submitBtn}}
                                        </b-button>
                                        <b-button type="reset" id="basic_sub_btn"
                                                    class="btn-outline-dark mb-1" v-if="updateIndex > 1">Cancel
                                        </b-button>
                                    </b-td>
                                </b-tr>
                            </b-thead>
                            <b-tbody>

                                <b-tr v-for="(period, index) in periods.items" :key="period.pr_month_id">
                                    <b-td>{{index+1}}</b-td>
                                    <b-td>{{period.open_yn}}</b-td>
                                    <b-td>{{period.pr_month}}</b-td>
                                    <b-td>{{period.calculation_start_date | formatDate}}</b-td>
                                    <b-td>{{period.calculation_end_date | formatDate}}</b-td>
                                    <b-td>{{period.current_yn}}</b-td>
                                    <b-td>{{period.bonus_applicable_yn}}</b-td>

                                    <b-td>
                                        <b-link ml="4" class="text-primary"
                                                @click="editRow(period.pr_month_id)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>
                                    </b-td>
                                </b-tr>

                            </b-tbody>
                        </b-table-simple>
                    </b-form>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import ApiRepository from '../../Repository/ApiRepository';

    export default {
        components: {
            DatePicker
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Period"});
            this.populateFiscalYear();
        },
        data() {
            return {
                selectedFiscalYear: null,
                fiscal_months: [],
                valueType: this.dateFormatter(),
                errorMessage: {color: 'red'},
                staticFiscalYear: null,
                staticFiscalYearName: '',
                fiscalYearOptions: [],
                fiscalYear: null,
                currentPage: null,
                period: {
                    open_yn: 'N',
                    pr_month: null,
                    calculation_start_date: null,
                    calculation_end_date: null,
                    current_yn: 'N',
                    bonus_applicable_yn: 'N',
                    action: null,
                },
                updateIndex: -1,
                submitBtn: "Add",
                show: true,
                periods: {
                    items: []
                }
            };
        },
        filters: {
            formatDate: function (value) {
                if(value) {
                    return moment(value).format('DD-MM-YYYY');
                }
            }
        },
        watch: {
            "period.pr_month": function() {
                if(this.notBeforeGivenMonth()) {
                    console.log('calculation_start_date', this.notBeforeGivenMonth());
                    this.period.calculation_start_date = this.notBeforeGivenMonth().format('YYYY-MM-DD');
                } else {
                    this.period.calculation_start_date = '';
                }

                if(this.notAfterGivenMonth()) {
                    console.log('calculation_end_date', this.notAfterGivenMonth());
                    this.period.calculation_end_date = this.notAfterGivenMonth().format('YYYY-MM-DD');
                } else {
                    this.period.calculation_end_date = '';
                }
            },
        },
        methods: {
            getDesiredMonth()
            {
                let desiredDate = moment();

                let year = moment().year();
                let month = null;
                let integerYear = null;

                if(this.period.pr_month > 6) {
                    month = parseInt(this.period.pr_month)-7;
                    integerYear = parseInt(this.selectedFiscalYear) + 1;
                    desiredDate.year(integerYear).month(month);
                } else {
                    month = parseInt(this.period.pr_month)+5;
                    integerYear = parseInt(this.selectedFiscalYear);
                    desiredDate.year(integerYear).month(month);
                }

                return desiredDate;
            },
            notBeforeGivenMonth()
            {
                if(this.period.pr_month) {
                    return moment(this.getDesiredMonth(this.period.pr_month), 'YYYY-MM-DD').startOf('month');
                }

                return '';
            },
            notAfterGivenMonth()
            {
                if(this.period.pr_month) {
                    return moment(this.getDesiredMonth(this.period.pr_month), 'YYYY-MM-DD').endOf('month');
                }

                return '';
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
            populateFiscalYear: function() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/payroll/periods').then(resp => {
                    this.fiscalYearOptions = resp.data.fecialYearList;
                    this.periods.items = resp.data.list;
                }).catch(err => {
                    this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'error'});
                });
            },
            onSearchSubmit(scope) {
                let currObj = this;
                this.$validator.validateAll(scope).then(() => {
                    if (!this.errors.any()) {
                        ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/periods/search-fiscal-year/${this.fiscalYear}`).then(resp => {
                            this.onReset();

                            this.periods.items = resp.data.pr_months;

                            this.fiscal_months = resp.data.fiscal_months;
                            this.staticFiscalYear = JSON.parse(JSON.stringify(this.fiscalYear));

                            let selectedFiscalYear = this.fiscalYearOptions.find(function(row) {
                                return row.fy_id == currObj.staticFiscalYear;
                            });

                            this.selectedFiscalYear = moment(selectedFiscalYear.start_date, 'YYYY-MM-DD').year();
                            this.staticFiscalYearName = selectedFiscalYear.fy_name;
                        }).catch(err => {
                            console.log(err);
                        });
                    }
                });
            },
            searchByFiscalYear(fiscalYear) {
                if(fiscalYear) {
                    let currObj = this;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/periods/search-fiscal-year/${fiscalYear}`).then(resp => {
                        this.periods.items = resp.data.pr_months;
                        this.fiscal_months = resp.data.fiscal_months;
                        this.staticFiscalYear = JSON.parse(JSON.stringify(fiscalYear));
                        let selectedFiscalYear = this.fiscalYearOptions.find(function(row) {
                            return row.fy_id == currObj.staticFiscalYear;
                        });

                        this.staticFiscalYearName = selectedFiscalYear.fy_name;
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },
            onSubmit(scope) {
                this.$validator.validateAll(scope).then(() => {
                    if (!this.errors.any()) {
                        this.period.fy_id = this.staticFiscalYear;
                        this.period.pr_year = this.staticFiscalYearName;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, `/payroll/periods`, this.period).then(resp => {
                            if (resp.data.o_status_code == 1) {
                                this.$notify({ group: 'pmis', text: resp.data.o_status_message, type:'success' })
                            } else{
                                this.$notify({ group: 'pmis', text: resp.data.o_status_message, type:'error' })
                            }
                            this.searchByFiscalYear(this.staticFiscalYear);
                            this.onReset();
                        }).then(resp=> {
                            this.$validator.reset();
                        }).catch(err => {
                            console.log(err);
                        });
                    }
                });

            },
            onReset() {
                this.updateIndex = -1;
                this.submitBtn = "Add";
                this.show = false;
                this.$nextTick(() => {
                    this.period.open_yn = 'N';
                    this.period.pr_month = null;
                    this.period.calculation_start_date = null;
                    this.period.calculation_end_date = null;
                    this.period.current_yn = 'N';

                    this.show = true
                })
            },
            editRow(id) {
                let confirmation = confirm('Are you sure you want to edit this item?');
                if(confirmation) {
                    this.updateIndex = id;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND,`/payroll/periods/${id}`).then(result => {
                        this.submitBtn = 'Update';
                        this.period = result.data;
                    });
                }
            },
        }
    };
</script>
<style scoped>
    .mx-input-icon__calendar {
        background-image: none;
    }
</style>
