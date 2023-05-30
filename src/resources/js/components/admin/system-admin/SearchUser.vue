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

                                            <b-card title="Search User">
                                                <b-row>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="User Name"
                                                            label-for="section"
                                                        >
                                                        <b-form-input  v-model="UserSearch.userName"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                <div class="col-md-4 pr-0 d-flex justify-content-start mt-1">
                                                    <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>

                                               </div>

                                                </b-row>



                                            </b-card>


                                        </b-form>
                                        <b-row>
                                            <b-col>
                                                <b-card title="User List">
                                                    <template>
                                                        <div class="content-wrapper">
                                                            <div class="content-body">
                                                                <Datatable v-bind:fields="fields"
                                                                    v-bind:items="items" v-bind:totalList="totalRowsList" v-bind:perPage="perPage">
                                                                    <template v-slot:action2="{rows}" >
                                                                         {{rows.index + 1}}
                                                                    </template>
                                                                    <template v-slot:actions="{rows}" >
                                                                        <button @click="editUser(rows.item.user_id,rows.item.emp_id)" class="btn btn-primary"><i class="bx bx-edit cursor-pointer"></i></button>
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
                totalRowsList:0,
                departmentList: [],
                sectionList: [],
                employeeList: [],
                UserSearch: {},
                fields: [{key: 'action2', label: 'SL'},
                    {key: 'user_name', label: ' User Name'},
                    {key: 'employee.emp_name', label: ' Employee Name '},
                    {key: 'is_active', label: 'Activation Status'},
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
          },
        methods: {

            onSubmit(e) {
                e.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/search-user", this.UserSearch).then(res => {
                    this.items = res.data.users;
                    this.totalRowsList = res.data.users.length;
                });
            },
         editUser(userID,empID) {
          this.isEdit = false;
          this.changePassForm = false;
          this.show = true;
          this.title = 'Update User';
          let that = this;
          this.$router.push('/update-user/'+userID);
          ApiRepository.callApi(ApiRepository.GET_COMMAND, "/admin/system-admin/create-user/"+userID).then(res => {
                           that.CreateUser.emp_name = res.data.employee.emp_name;
                           that.CreateUser.emp_code = res.data.employee.emp_code;
                           that.CreateUser.department = res.data.employee.department.department_name;
                           that.CreateUser.division = res.data.employee.dpt_division.dpt_division_name;
                           that.CreateUser.designation = res.data.employee.designation.designation;
                           that.CreateUser.section = res.data.employee.designation.section;
                           that.CreateUser.userType = res.data.user.user_type_id;
                           that.userRolesList = res.data.rolesList;
                           that.CreateUser.userRole = res.data.roles;
                           that.CreateUser.user_id = res.data.user.user_id;
                           that.submitBtn = 'Update';
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

