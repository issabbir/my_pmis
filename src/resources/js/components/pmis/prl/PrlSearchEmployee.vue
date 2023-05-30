<template>
    <div class="content-body">
        <div id="stacked-pill">
            <div class="col-md-12">
                <div class="card bg-transparent border">
                    <div class="card-content">
                        <div class="card-body pt-1">
                            <div class="pills-stacked">
                                <div class="">

                                    <div class="col-md-12 col-sm-12 border-right pr-md-0">

                                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">

                                            <b-card
                                                title="Search Employee"
                                            >
                                                <b-row>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="DEPARTMENT"
                                                            label-for="department"
                                                        >
                                                            <b-form-select
                                                                v-model="employeeSearch.department"
                                                                :options="e_department"
                                                                class=""
                                                                value-field="value"
                                                                text-field="text"
                                                            ></b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                                label="SECTION"
                                                                label-for="section"
                                                        >
                                                            <b-form-select
                                                                    v-model="employeeSearch.section"
                                                                    :options="e_section"
                                                                    class=""
                                                                    value-field="value"
                                                                    text-field="text"
                                                            ></b-form-select>
                                                        </b-form-group>
                                                    </b-col>

                                                    <b-col md="3">
                                                        <b-form-group
                                                                label="FROM"
                                                                label-for="from"
                                                        >
                                                            <date-picker
                                                                    v-model="employeeSearch.fromDate"
                                                                    width="100%"
                                                                    input-class="form-control"
                                                                    type="date"
                                                                    lang="en"
                                                                    format="YYYY-MM-DD" ></date-picker>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                                label="TO"
                                                                label-for="to"
                                                        >
                                                            <date-picker
                                                                    v-model="employeeSearch.toDate"
                                                                    width="100%"
                                                                    input-class="form-control"
                                                                    type="date"
                                                                    lang="en"
                                                                    format="YYYY-MM-DD" ></date-picker>

                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                                    <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>
                                                <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">Reset</b-button>

                                            </div>

                                            </b-card>


                                        </b-form>
                                        <b-row>
                                            <b-col>
                                                <b-card title="Employee Information List">
                                                    <template>
                                                        <div class="content-wrapper">
                                                            <div class="content-body">
                                                                <Datatable v-bind:fields="fields" v-bind:items="items" >
                                                                    <template v-slot:actions="{rows}" >
                                                                        <router-link :to='rows.item.id' class="text-primary"><i class="bx bx-edit cursor-pointer"></i></router-link>
                                                                        <router-link :to='rows.item.id' class="text-primary"><i class="bx bx-show cursor-pointer"></i></router-link>
                                                                        <router-link :to='rows.item.id' class="text-primary"><i class="bx bx-trash cursor-pointer"></i></router-link>
                                                                        <router-link :to='"/prl/employee-notice"' class="text-primary"><i class="bx bx-right-arrow-alt cursor-pointer"></i></router-link>
                                                                    </template>
                                                                </Datatable>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </b-card>
                                            </b-col>

                                        </b-row>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../../layouts/common/datatable';
    import Repo from '../../../Repository/ApiRepository';
    export default {
        components: { DatePicker, Datatable },
        data() {
            return {
                employeeSearch: {
                    department: 'Adminsitration',
                    section: 'Section 1'
                },
                 e_department: [
                    { value: 'Adminsitration', text: 'Adminsitration' },
                    { value: 'Finance', text: 'Finance' },
                    { value: 'IT', text: 'IT' }
                ],
                e_section: [
                    { value: 'Section 1', text: 'Section 1' },
                    { value: 'Section 2', text: 'Section 2' },
                    { value: 'Section 3', text: 'Section 3' }
                ],
                fields: [{key: 'id',label: 'SL', sortable: true}, {key: 'employeeName',label: 'Name', sortable: true}, {key: 'employeeId',label: 'Emp ID', sortable: true}, {key: 'designation',label: 'Designation', sortable: true}, {key: 'dob',label: 'DOB', sortable: true}, {key: 'joiningDate',label: 'Joining Date', sortable: true}, {key: 'prlStart',label: 'PRL Start', sortable: true}, {key: 'prlEnd',label: 'PRL End', sortable: true}, {key: 'pensionStart',label: 'Pension Start', sortable: true}, {key: 'freedomFighter',label: 'Freedom Fighter', sortable: true}, 'action'],
                items: [
                    {id: '1', employeeName: 'Mrs. Anita Prova Chowdhury', employeeId: '00012', designation: 'Metron', dob: '12/01/1965', joiningDate: '12/01/1975', prlStart: '12/01/2018', prlEnd: '12/01/2019', pensionStart: '24/01/2020', freedomFighter: 'No'},
                    {id: '2', employeeName: 'Employee 2', employeeId: '00013', designation: 'Computer Operator', dob: '12/01/1967', joiningDate: '12/01/1977', prlStart: '13/11/2018', prlEnd: '13/11/2019', pensionStart: '20/02/2019', freedomFighter: 'Yes'},
                    {id: '3', employeeName: 'Employee 3', employeeId: '00014', designation: 'System Analyst', dob: '12/01/1963', joiningDate: '12/01/1977', prlStart: '27/12/2018', prlEnd: '27/12/2019', pensionStart: '23/03/2019', freedomFighter: 'No'}
                ],
                text: '',
                foods: [{text: 'Select One', value: null}, 'Carrots', 'Beans', 'Tomatoes', 'Corn'],
                show: true,
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PRL"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Search"});
         },
        methods: {
            onSubmit(evt) {
            },
            onReset(evt) {
            },
            onFiltered(filteredItems) {
            }
        }
    }
</script>

