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
                                                    <b-col md="4">
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
                                                                disabled-field="notEnabled"
                                                            ></b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="Employee Code"
                                                            label-for="section"
                                                        >
                                                            <b-form-select
                                                                v-model="employeeSearch.department"
                                                                :options="e_department"
                                                                class=""
                                                                value-field="value"
                                                                text-field="text"
                                                                disabled-field="notEnabled"
                                                            ></b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="Section"
                                                            label-for="job_status"
                                                        >
                                                            <b-form-select
                                                                v-model="employeeSearch.jobStatus"
                                                                :options="e_job_status"
                                                                class=""
                                                                value-field="value"
                                                                text-field="text"
                                                                disabled-field="notEnabled"
                                                            ></b-form-select>

                                                        </b-form-group>
                                                    </b-col>

                                                </b-row>

                                                <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                                    <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>

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
                                                                        <router-link :to='"/employee/basic-info/"+rows.item.ID' class="text-primary"><i class="bx bx-edit cursor-pointer"></i></router-link>
                                                                        <router-link :to='"/employee/basic-info/del/"+rows.item.ID' class="text-primary"><i class="bx bx-show cursor-pointer"></i></router-link>
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
    import Datatable from '../../layouts/common/datatable';
    import Repo from '../../Repository/ApiRepository';
    export default {
        components: { DatePicker, Datatable },
        data() {
            return {
                employeeSearch: {
                    department: 'Adminsitration',
                    payGrade: 'Grade-1',
                    jobStatus: 'Active',                },
                selected: 'first',
                options: [
                    { text: 'Male', value: '' },
                    { text: 'Female', value: 'second' },
                    { text: 'Other', value: 'third' }
                ],
                 e_department: [
                    { value: 'Adminsitration', text: 'Adminsitration' },
                    { value: 'Finance', text: 'Finance' },
                    { value: 'IT', text: 'IT' }
                ],
                 e_pay_grade: [
                    { value: 'Grade-1', text: 'Grade-1' },
                    { value: 'Grade-2', text: 'Grade-2' },
                    { value: 'Grade-3', text: 'Grade-3' }
                ],
                 e_job_status: [
                    { value: 'Active', text: 'Active' },
                    { value: 'Inactive', text: 'Inactive' }

                ],
                fields: [{key: 'ID', sortable: true},{key: 'EmployeeName', sortable: true}, {key: 'Designation', sortable: true}, {key: 'Department', sortable: true}, {key: 'Mobile', sortable: true}, {key: 'Email', sortable: true},'action'],

                items: [
                    { ID: '00012', EmployeeName: 'Mohhamad Waker Khan', Designation: 'Senior Computer Operator', Department: 'Computer Center', Mobile: '8801726969651', Email: 'wakercse@gmail.com\t'},
                    { ID: '00013', EmployeeName: 'Rahim Khan', Designation: 'Manager', Department: 'Administration', Mobile: '8801789569651', Email: 'rahim@gmail.com'},
                    { ID: '00014', EmployeeName: 'Selim Khan', Designation: 'Computer Operator', Department: 'Computer Center', Mobile: '019246815778', Email: 'selim@gmail.com' },
                ],
                text: '',
                foods: [{text: 'Select One', value: null}, 'Carrots', 'Beans', 'Tomatoes', 'Corn'],
                show: true,
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Search"});
         },
        methods: {
            allExperience() {
                ApiRepository.callApi(
                    ApiRepository.GET_COMMAND,
                    "/pmis/employee/experiences"
                ).then(result => {
                    console.log(result.data);
                    this.designationList = result.data.designations;
                    this.tableData.items = result.data.experience;
                    this.totalList = result.data.experience.length;
                });
                },
            onSubmit(evt) {
                evt.preventDefault();
                let arr = [];
                Repo.callApi(Repo.GET_COMMAND, "/pmis/employee/basic-info").then(res => {
                    res.forEach(function(item) {
                        let i ={
                                ID: item.empId,
                                EmployeeName: item.fname+" "+item.mname+ " "+item.lname,
                                Designation: item.designation,
                                Department: item.department,
                                Mobile: item.mobile,
                                Email: item.email};
                        arr.push(i);
                    });
                    this.items = arr;
                });
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.email = ''
                this.form.name = ''
                this.form.food = null
                this.form.checked = []
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        }
    }
</script>

