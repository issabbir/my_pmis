<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Searching Roster Month (To Change Status)</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                        <b-row>
                            <b-col>
                                <b-row class="row">
                                    <b-col lg="4">
                                        <b-row>
                                            <b-col lg="4">
                                                <label>Year</label>
                                            </b-col>
                                            <b-col lg="8">
                                                <div class="form-group">
                                                    <b-form-select v-model="rosterMonth.ot_year"
                                                                    :options="rosterYears"
                                                                    required></b-form-select>
                                                </div>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                    <b-col lg="4">
                                        <b-row>
                                            <b-col lg="4">
                                                <label>Month</label>
                                            </b-col>
                                            <b-col lg="8">
                                                <div class="form-group">
                                                    <b-form-select v-model="rosterMonth.ot_month"
                                                                    :options="months"></b-form-select>
                                                </div>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                    <b-col lg="4">
                                        <b-row>
                                            <b-col lg="4">
                                                <label>Status</label>
                                            </b-col>
                                            <b-col lg="8">
                                                <div class="form-group">
                                                    <b-form-select v-model="rosterMonth.open_yn"
                                                                    :options="status"></b-form-select>
                                                </div>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                </b-row>

                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-start">
                                <b-button type="button" v-bind:href="'overtime#/roster-month-setup'" variant="info">Create New</b-button>
                            </b-col>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button-group>
                                    <b-button lg="6" size="md" variant="primary" type="submit">Search</b-button>
                                    <b-button lg="6" size="md" variant="secondary" type="reset">Cancel</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Roster Month List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList"
                                :perPage="perPage">
                        <template v-slot:action4="{ rows }">
                                <!--<b-form-select  v-if="rows.item.open_yn != 'C'"-->
                                <!-- v-model="rows.item.edit_open_yn"-->
                                <!-- :options="status"></b-form-select>-->
                                <!-- <label v-else-if="rows.item.open_yn == 'C'">Closed</label>-->
                            <a @click="rows.toggleDetails" href="javascript:void(0)">
                                <span>
                                    <i v-if="rows.detailsShowing" class='bx bxs-comment-detail' ></i>
                                    <i  v-else class='bx bxs-detail'></i>
                                </span>
                            </a>
                        </template>
                        <template v-slot:row-details="{ rows }">
                            <b-card>
                                <b-card-body>
                                    <b-row class="d-flex justify-content-center">
                                        <b-col md="6">
                                            <b-form inline >
                                                <label class="mr-sm-2" for="inline-form-custom-select-pref">Status</label>
                                                    <b-form-select v-model="rows.item.edit_open_yn"
                                                            class="mb-2 mr-sm-2 mb-sm-0"
                                                            :value="null"
                                                            :options="status"
                                                            id="inline-form-custom-select-pref">
                                                    <template v-slot:first>
                                                        <option :value="null">Choose...</option>
                                                    </template>
                                                </b-form-select>
                                                <b-form-checkbox v-model="rows.item.current_yn" value="Y" unchecked-value="N" class="mb-2 mr-sm-2 mb-sm-0">Current month</b-form-checkbox>
                                                <b-button variant="primary" type="button" @click="updateStatus(rows.item)" >Save</b-button>
                                            </b-form>
                                        </b-col>
                                    </b-row>
                                </b-card-body>
                            </b-card>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>


<script>
    import DatePicker from "vue2-datepicker";
    import moment from 'moment';
    //import Datatable from '../../../layouts/common/datatable';
    import Datatable from '../../../layouts/common/datatable_store';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker, Datatable},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Month Searching"});
            this.loadData();
            this.rosterMonth.ot_year = moment().format("YYYY");
            this.rosterMonth.ot_month = moment().format("M");
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
                rosterMonth: {},
                rosterYears: [],
                status: [{'text': 'Open', value: 'O'}, {'text': 'Closed', value: 'C'}],
                months: [{'text': 'Select All', value: ''},
                    {'text': 'January', value: 1},
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
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                perPage: 5,
                totalList: 0,
                fields: [{key: 'index', label: 'SL'}, {key: 'ot_year', label: 'year', sortable: true},
                    {
                        key: 'ot_month',
                        formatter: value => {
                            if (value) {
                                return moment(value, "MM").format('MMMM');
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
                    {
                        key: 'open_yn',
                        formatter: value => {
                            if (value && value.toUpperCase()=='O') {
                                return "Open"
                            }
                            else if (value && value.toUpperCase()=='C') {
                                return "Closed"
                            }
                            else {
                                return "Not Open"
                            }
                        },
                        label: 'Status', sortable: true
                    },
                    {
                        key: 'current_yn',
                        formatter: value => {
                            if (value && value.toUpperCase()=='Y') {
                                return "YES"
                            }
                            if (value && value.toUpperCase()=='N') {
                                return "NO"
                            }
                        },
                        label: 'Current Month', sortable: true
                    },

                    {key: 'action4', label: 'Action', sortable: false}],
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
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/roster-years", this.rosterMonth).then(res => {
                    this.rosterYears = res.data.rosterYears;

                });
            },
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/search-roster-months', this.rosterMonth).then(res => {
                    this.items = res.data.otmonts;
                    this.totalList = res.data.otmonts.length;
                });
            },
            RosterMonterSubmit(evt) {
                evt.preventDefault();
                let currObj = this;
                let param = this.items;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-roster-month-closed', param).then(res => {
                    if (res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onSubmit();
                    } else {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                    if(this.items){
                        this.items=[];
                    }
                    this.rosterMonth={};
                });

            },

            updateStatus:function (row) {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-roster-month-closed', row).then(res => {
                    if (res.data.o_status_code == 1) {
                        row.open_yn=row.edit_open_yn;
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        //this.onSubmit();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            }
        }
    }
</script>

