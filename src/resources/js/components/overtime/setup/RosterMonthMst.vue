<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Roster Month Setup</b-card-header>
                    <b-card-body class="border">
                        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                            <b-row>
                                <b-col lg="4">
                                    <b-form-group
                                    label-cols-sm="4"
                                    label-cols-lg="4"
                                    label="Year"
                                    label-for="year"
                                    >
                                        <b-form-select required v-model="rosterMonth.ot_year"
                                        :options="rosterYears"
                                        v-on:change="changed"
                                        id="year">
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col lg="4">
                                    <b-form-group
                                    label-cols-sm="4"
                                    label-cols-lg="4"
                                    label="Month"
                                    label-for="month"
                                    >
                                        <b-form-select required v-model="rosterMonth.ot_month"
                                        :options="months"
                                        v-on:change="changed" id="month">
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col lg="4">
                                    <b-form-group
                                    label-cols-sm="4"
                                    label-cols-lg="4"
                                    label="Status"
                                    label-for="status"
                                    >
                                        <b-form-select required v-model="rosterMonth.open_yn"
                                        :options="status" id="status">
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col lg="4">
                                    <b-form-group
                                    label-cols-sm="4"
                                    label-cols-lg="4"
                                    label="Effective Start Date"
                                    label-for="e_startDate"
                                    >
                                        <b-form-input v-model="rosterMonth.effective_start_date" disabled id="e_startDate"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col lg="4">
                                    <b-form-group
                                        label-cols-sm="4"
                                        label-cols-lg="4"
                                        label="Effective End Date"
                                        label-for="e_endDate"
                                        >
                                        <b-form-input v-model="rosterMonth.effective_end_date" disabled id="e_endDate"></b-form-input>
                                        <b-form-input v-model="rosterMonth.ot_month_id" hidden></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col class="d-flex justify-content-end">
                                    <b-button-group>
                                        <b-button lg="6" size="md"  variant="primary" type="submit">{{submitBtn}}</b-button>
                                        <b-button lg="6" size="md" variant="secondary" type="reset">Cancel</b-button>
                                        <b-button lg="6" size="md" variant="warning" v-bind:href="'overtime#/search-roster-month'" type="reset">Exit</b-button>
                                    </b-button-group>
                                </b-col>
                            </b-row>
                        </b-form>
                    </b-card-body>
            </b-card>
            <section id="basic-datatable">
                <b-card class="card">
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Roster Month List</b-card-header>
                    <b-card-body class="border">
                        <Datatable v-bind:fields="fields" v-bind:items="items"  :totalList="totalList"
                                    :perPage="perPage">
                            <!--template v-slot:actions="{ rows }">
                                <b-link ml="4" class="text-primary"
                                        @click="editRow(rows.item.ot_month_id)">
                                    <i class="bx bx-edit cursor-pointer"></i>
                                </b-link>
                            </template-->
                        </Datatable>
                    </b-card-body>
                </b-card>
            </section>
        </div>
    </div>
</template>


<script>
    import DatePicker from "vue2-datepicker";
    import moment from 'moment';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker, Datatable},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Month Setup"});
            this.loadData();
        },
        data() {
            return {
                unique_code_message: '',
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                momentFormatYear: {
                    stringify: (year) => {
                        return year ? moment(year).format('YYYY') : ''
                    },
                    parse: (year) => {
                        return year ? moment(year, 'YYYY').toDate() : null
                    }
                },
                rosterMonth: {
                    ot_year: null,
                    ot_month: null,
                    open_yn: 'N',
                    effective_start_date: null,
                    effective_end_date: null

                },
                status: [{'text': 'Not Open', value: 'N'}],
                months: [{'text': 'January', value: 1},
                    {'text': 'February', value: 2},
                    {'text': 'March', value: 3},
                    {'text': 'April', value: 4},
                    {'text': 'May', value: 5},
                    {'text': 'June', value: 6},
                    {'text': 'July', value: 7},
                    {'text': 'August', value: 8},
                    {'text': 'September', value: 9},
                    {'text': 'October', value: 10},
                    {'text': 'November', value: 11},
                    {'text': 'December', value: 12}],
                rosterYears: [],
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                perPage: 5,
                totalList: 0,
                fields: [{key: 'index', label: 'SL', sortable:true}, {key: 'ot_year', label: 'year', sortable: true},
                    {
                        key: 'ot_month',
                        formatter: value => {
                            if (value) {
                                return moment(value,"MM").format('MMMM');
                            }
                        }, label: 'Month', sortable: true
                    },
                    {
                        key: 'effective_start_date',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, label: 'effective start date', sortable: true
                    },
                    {
                        key: 'effective_end_date',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, label: 'effective end date', sortable: true
                    },
                    {key: 'open_yn', label: 'status', sortable: true}],
                items: [],

            }
        },
        methods: {
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
            changed: function (event) {
                let year = this.rosterMonth.ot_year.toString();
                let getmonth = this.rosterMonth.ot_month.toString();
                let startDate = '01';
                let padMonth = getmonth.padStart(2, '0');
                let month = '';
                let effectivestartDate = padMonth.concat('-', startDate, '-', year);
                let setEffectDate = startDate.concat('-', padMonth, '-', year);
                let effectiveEndDate = moment(setEffectDate,"DD-MM-YYYY").endOf('month').format('DD-MM-YYYY');
                let formatetEffectiveStartDate=moment(effectiveEndDate).format('YYYY-MMM-DD');
                this.rosterMonth.effective_start_date = setEffectDate;
                this.rosterMonth.effective_end_date = effectiveEndDate;

            },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/ot-roster-months", this.rosterMonth).then(res => {
                    this.items = res.data.otmonts;
                    this.rosterYears = res.data.rosterYears;
                    this.totalList = res.data.otmonts.length;

                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/ot-lastyearmonths", this.rosterMonth).then(res => {
                    this.rosterMonth.open_yn = 'N';
                    this.rosterMonth.ot_year = res.data.otNextYearMonth[0].next_ot_year;
                    this.rosterMonth.ot_month = res.data.otNextYearMonth[0].next_month;
                    this.changed();

                });

            },
            onSubmit() {
                let currObj = this;
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        let id = this.rosterMonth.ot_month_id;
                        console.log(id);
                        if (id > 0) {
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, `/overtime/ot-roster-month/${id}`, this.rosterMonth).then(res => {
                                if (res.data.o_status_code == 1) {
                                    currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                    this.loadData();
                                    this.onReset();
                                } else {
                                    currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                }

                            });
                        } else {
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-roster-month', this.rosterMonth).then(res => {
                                if (res.data.o_status_code == 1) {
                                    currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                    this.loadData();
                                    this.onReset();
                                } else {
                                    currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                }


                            });
                        }
                    }
                });
            },
            onReset() {
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                    this.rosterMonth.ot_year = '';
                    this.rosterMonth.ot_month = '';
                    this.rosterMonth.ot_month_id = '';
                    this.rosterMonth.open_yn = '';
                    this.rosterMonth.effective_start_date = null;
                    this.rosterMonth.effective_end_date = null;
                });

            },
            editRow(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-roster-month/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.rosterMonth = result.data;
                });

            },

        }
    }
</script>

