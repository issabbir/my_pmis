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

                                            <b-card title="Search Employee">
                                                <b-row>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="DEPARTMENT"
                                                            label-for="department"
                                                        >
                                                            <b-form-select
                                                                v-model="employeeSearch.department_id"
                                                                :options="departmentList"
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
                                                                v-model="employeeSearch.dpt_section_id"
                                                                :options="sectionList"
                                                                class=""
                                                                value-field="value"
                                                                text-field="text"
                                                                disabled-field="notEnabled"
                                                            >
                                                                <template v-slot:first>
                                                                    <option value="">-- Please select section --</option>
                                                                 </template>
                                                            </b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="Employee Code"
                                                            label-for="section"
                                                        >
                                                        <b-form-input  v-model="employeeSearch.emp_code"></b-form-input>
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
                                                                <Datatable v-bind:fields="fields" v-bind:items="items" v-bind:perPage="perPage" v-bind:totalList="totalList">
                                                                    <template v-slot:actions="{rows}" >
                                                                        <router-link :to='"/create-user/"+rows.item.emp_id' class="btn btn-primary">Create User</router-link>
<!--                                                                        <router-link :to='"/user-ip-assign/"+rows.item.emp_id' class="btn btn-primary">User Ip Assign</router-link>-->
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
    import ApiRepository from '../../../Repository/ApiRepository';
    export default {
        components: { DatePicker, Datatable },
        data() {
            return {
                perPage:5,
                totalList:0,
                departmentList: [],
                sectionList: [],
                employeeList: [],
                employeeSearch: {},
                fields: [{key: 'emp_code', sortable: true},
                    {key: 'emp_name', sortable: true},
                    {key: 'designation', label:'Designation', sortable: true},
                    {key: 'department_name', label:'Department', sortable: true},
                    'action'],

                items: [ ],
                text: '',
                show: true,
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "ADMINISTRATION"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "System Admin"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Search User"});
            this.allSearchUser();
         },
        methods: {
             allSearchUser() {
                 ApiRepository.callApi(
                     ApiRepository.GET_COMMAND,"/admin/system-admin/search-users" ).then(result => {
                     this.departmentList = result.data.departments;
                     this.sectionList = result.data.sections;
                 });
               },

            onSubmit(e) {
                e.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/search-employee", this.employeeSearch).then(res => {
                    this.items = res.data.employees;
                    this.totalList = res.data.employees.length;
                });
            },

                onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.experience.designation = "";
                this.experience.work_from = new Date();
                this.experience.work_to = new Date();
                this.experience.employer_name = "";
                this.experience.employer_address = "";
                this.experience.responsibility = "";
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
                },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        }
    }
</script>

