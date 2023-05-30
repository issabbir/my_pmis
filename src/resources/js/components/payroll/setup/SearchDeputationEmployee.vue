<template>
    <div class="content-body">
        <div class="col-md-12 col-sm-12 border-right pr-md-0">
            <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" method="post">
                <b-card title="Search Employee">
                    <b-card-body class="border">
                        <b-row>
                            <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="department"
                                        label="Bill Code"
                                        label-for="department">
                                        <b-form-select v-model="employeeSearch.bill_code" :options="bilerCodes"></b-form-select>
                                    </b-form-group>
                            </b-col>
<!--                            <b-col md="3">-->
<!--                                    <b-form-group-->
<!--                                        class="requiredField"-->
<!--                                        id="department"-->
<!--                                        label="DEPARTMENT"-->
<!--                                        label-for="department">-->
<!--                                        <v-select v-model="department" :options="departments"-->
<!--                                                  name="department" id="department" label="text"-->
<!--                                                  v-validate="'required'"-->
<!--                                                  class="uppercase required">-->
<!--                                            <template #search="{attributes, events}">-->
<!--                                                <input class="vs__search" v-bind="attributes" v-on="events"/>-->
<!--                                            </template>-->
<!--                                        </v-select>-->
<!--                                    </b-form-group>-->
<!--                            </b-col>-->
<!--                            <b-col md="3">-->
<!--                                <b-form-group-->
<!--                                    class="requiredField"-->
<!--                                    id="section"-->
<!--                                    label="Section"-->
<!--                                    label-for="department">-->
<!--                                    <v-select v-model="section" :options="sections"-->
<!--                                              name="section"  label="text"-->
<!--                                              v-validate="'required'"-->
<!--                                              class="uppercase required">-->
<!--                                        <template #search="{attributes, events}">-->
<!--                                            <input class="vs__search" v-bind="attributes" v-on="events"/>-->
<!--                                        </template>-->
<!--                                    </v-select>-->
<!--                                </b-form-group>-->
<!--                            </b-col>-->

                            <b-col md="3">
                                <b-form-group
                                    id="emp_code"
                                    label="Employee Code"
                                    label-for="emp_code">
                                    <b-form-input v-model="employeeSearch.emp_code">
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mt-1">
                                    Search
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-form>

            <b-card v-if="dataUrl">
                <b-card-body class="border">
                    <b-row>
                        <b-col>
                            <data-table class="table-default"
                                        :columns="columns"
                                        :url="dataUrl" :classes='classess'>
                                <div slot="filters" slot-scope="{ tableData, perPage }">
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <select class="form-control" v-model="tableData.length">
                                                <option :key="page" v-for="page in perPage">{{ page }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <input
                                                name="name"
                                                class="form-control"
                                                v-model="tableData.search"
                                                placeholder="Search Table">
                                        </div>
                                    </div>
                                </div>
                            </data-table>
                        </b-col>
                    </b-row>
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
    import ViewButton from '../ViewButton';
    import axios from 'axios';
    import vSelect from 'vue-select';

    export default {
        components: {DatePicker, ViewButton, vSelect},
        watch: {
            dataUrl: function (url) {
                console.log(url);
            },
            // department: function (val, oldVal) {
            //     if (val !== null) {
            //         this.employeeSearch.department_id = val.department_id;
            //     } else {
            //         this.employeeSearch.department_id = '';
            //     }
            // },
            bilerCodes: function (val, oldVal) {
                if (val !== null) {
                    this.employeeSearch.bill_code = val.value;
                } else {
                    this.employeeSearch.bill_code = '';
                }
            },
            section: function (val, oldVal) {
                if (val !== null) {
                    this.employeeSearch.dpt_section_id = val.dpt_section_id;
                } else {
                    this.employeeSearch.dpt_section_id = '';
                }
            }

        },
        data() {
            return {
                department: {'text': '', 'value': ''},
                section: {'text': '', 'value': ''},
                dataUrl: '',
                employeeSearch: {bill_code: 'null', emp_code: null},
                reportUrl: '',
                reportParams: {
                    xdo: '/~weblogic/employee_list.xdo',
                    type: "pdf",
                    department_id: '',
                    filename: 'Employee'
                },
                selected: 'first',
                emp_status: [],
                sections: [],
                departments: [],
                bilerCodes: [
                    {'text': 'Select One', 'value': ''},
                    {'text': '402', 'value': 402}
                ],
                text: '',
                columns: [
                    {label: 'SL#', name: 'rn', filterable: false,},
                    {label: 'Employee code', name: 'emp_code', filterable: true,},
                    {label: 'Employee Name', name: 'emp_name', filterable: true, width: 20,},
                    {label: 'Designation', name: 'designation.designation', filterable: true, width: 20,},
                    {label: 'Join Date', name: 'emp_join_date', filterable: true,},
                    {label: 'PRL Date', name: 'emp_lpr_date', filterable: true,},
                    {
                        label: '',
                        name: 'Setup Head',
                        filterable: false,
                        classes: {'btn': true, 'btn-primary': true, 'btn-sm': true,},
                        event: "click",
                        handler: this.displayRow,
                        component: ViewButton,
                    },
                ],
                classess: {
                    "table-container": {
                        "table-responsive": true,
                    },
                    "table": {
                        "table": true,
                        "table-striped": true,
                        "table-dark": false,
                    },
                    "t-head": {},
                    "t-body": {},
                    "t-head-tr": {},
                    "t-body-tr": {},
                    "td": {},
                    "th": {},
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Deputation Employee Salary Allocation"});
            this.searchLookups();
        },
        methods: {
            displayRow(data) {
                this.$router.push('/salary-setup/deputation-employee-salary/' + data.emp_id);
            },
            searchLookups() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/search-deputation-employees").then(res => {
                    this.sections = res.data.sections;
                    this.departments = res.data.departments;
                    this.bilerCodes = res.data.bill_codes;
                });
            },
            onSubmit() {
                let params = this.employeeSearch;
                console.log(params)
                let queryString = Object.keys(params).map(function (key) {
                    return params[key]
                }).join('/');
                this.renderPdf();
                this.dataUrl = "/v1/pmis/employee-for-manual-setup/" + queryString;

            },
            onReset() {
                this.employeeSearch = {};
                this.dataUrl = "/v1/pmis/employee-for-manual-setup";
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            renderPdf: function () {
                this.reportParams.department_id = this.employeeSearch.department_id;
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');

                this.reportUrl = '/report/render?' + queryString;
            },
        }
    }
</script>

<style>
    @media only screen and (max-width: 600px) {
        .multiselect {
            width: 100% !important;
            padding-bottom: 14px;
        }
    }
</style>
