<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Leave Approval</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">

                            <b-row>
                                 <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Department</label>
                                            </b-col>
                                            <b-col md="8">
                                               <b-form-select
                                                                v-model="searchEmployee.department_id"
                                                                :options="departments"
                                                                class=""
                                                                required
                                                                value-field="value"
                                                                text-field="text"
                                                                disabled-field="notEnabled"
                                                            ></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Employee</label>
                                            </b-col>
                                            <b-col md="8">
                                                <v-select
                                                 label="option_name"
                                                      v-model="selectedEmployee"
                                                                    :options="empIdList"
                                                                    @search="searchEmployeeCodes">
                                                              <template #search="{attributes, events}">
                                                                   <input
                                                                      class="vs__search"
                                                                       v-bind="attributes"
                                                                       v-on="events"
                                                                       name="employee"
                                                                     />
                                                             </template>
                                                   </v-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                     <b-button md="6"  size="md" variant="dark" type="submit" >Search</b-button>&nbsp;
                                     <b-button md="6"  size="md" variant="dark" type="reset" >Reset</b-button>&nbsp;
                                 </b-col>

                            </b-row>
                            <!--</fieldset>-->
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>
            <b-card class="card">
                <b-row>
                    <b-col>
                        <b-card title="Leave Application Data">
                            <b-form @submit.prevent="onSubmitLeave" @reset.prevent="onResetLeave" v-if="show">
                               <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage" v-bind:items="items"  v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'roster_date'">
                                    <template  v-slot:action2="{ rows }">
                                              {{rows.index + 1}}
                                    </template>
                                   <template  v-slot:action3="{ rows }">
                                        <b-form-select
                                                 v-model="rows.item.approve_status"
                                                 :options="statusList"
                                                  class=""
                                                  required
                                                  value-field="value"
                                                  text-field="text"
                                                  disabled-field="notEnabled"
                                              ></b-form-select>
<!--                                             <a href="#" @click.prevent="leaveApproved(rows.item.leave_id)"><i class="bx bx-check cursor-pointer"></i></a>-->
<!--                                             <a href="#" @click.prevent="leaveReject(rows.item.leave_id)" class="text-danger"><i class="bx bx-x cursor-pointer"></i></a>-->
                                    </template>
                                </Datatable>
                                <b-row>
                                  <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                         <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Submit</b-button>
                                  </div>
                                </b-row>
                                </b-form>
                        </b-card>
                    </b-col>

                </b-row>
            </b-card>
        </div>


    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import ApiRepository from '../../Repository/ApiRepository';
    import Datatable from '../../layouts/common/datatable';
    import moment from 'moment';
    export default {
        components: {DatePicker,vSelect,Datatable,vcss},
        data() {
            return {
                interviwdate: new Date(),
                searchEmployee: {
                    department_id: '',
                },
                selectedEmployee: {'option_name':'','emp_id':'', 'emp_name':''},
                empIdList: [],
                empNameList: [{text: 'Waker', value: 1}, {text: 'Jamil', value: 2}],
                show: true,
                statusList: [
                    // {text: 'Select Status', value: null},
                    {text: 'Approved', value: 1},
                    {text: 'Reject', value: -1}
                    ],
                boardactionlist: [{text: 'Interview', value: 1}, {text: 'Reject', value: 2}],
                fields: [{key: 'action2', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'leave_type', label: 'Leave Type', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'leave_start_date', label: 'Start Date',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'leave_end_date', label: 'End Date',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'leave_days', label: 'Date Received', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'action3', label: 'Action'}],
                items: [],
                departments: [],
                totalList: 0,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },
            }
        },
          mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Leave"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval Leave"});
            this.loadData();
        },
        watch: {
            selectedEmployee:function(val,oldVal) {
                 if(val != null){
                    this.searchEmployee.emp_id = val.emp_id;
                    if ( val.department) {
                          this.searchEmployee.department_name =  val.department.department_name;
                          this.searchEmployee.department_id =  val.department.department_id;
                    }else {
                        this.department_id = '';
                    }

                    if(val.designation) {
                        this.designation_name =  val.designation.designation;
                    }

                    if(val.section) {
                        this.section_name = val.section.section_name;
                    }
                }
            }
          },
        methods: {
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/leave-approval").then(res => {
                     this.departments = res.data.departments;
                });
            },
            searchEmployeeCodes(id){
                id = id.trim();
                if(id.length > 0) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/leave/leave-entry/emp-info/${id}`).then(res => { // This url seems inaccurate! but employee data should be same so using this url.
                        this.empIdList = res.data.empcodeList;
                        this.emp_name=res.data.empcodeList.emp_name;
                    })
                }
            },
            onSubmit(evt) {
                evt.preventDefault();
                 this.searchEmployee.selectedEmployee = this.selectedEmployee;
                 ApiRepository.callApi(ApiRepository.POST_COMMAND, "/leave/leave-approval/search", this.searchEmployee).then(res => {
                     this.items = res.data.leaveData;
                     this.totalList = res.data.leaveData.length;
                });
             },
            onSubmitLeave() {
                 let currObj = this;
                  ApiRepository.callApi(ApiRepository.POST_COMMAND, `/leave/leave-approval/approve/`,this.items).then(res => {
                      if(res.data.o_status_code == 1) {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.loadData();
                        }else{
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                });
             },

            onReset(evt) {
                evt.preventDefault();
               this.searchEmployee = {department_id: '',};
               this.selectedEmployee = '';

            },
            editRow(i, code) {
                this.submitBtn = 'Update';
                this.updateIndex = i;
                let data = this.tableData.items[i];

                console.log(data);

                this.form.employee_id = data.employee_id;
                this.form.department_name = data.department_name;
                this.form.designation = data.designation;
                this.form.division_name = data.division_name;
                this.form.financial_code = data.financial_code;
                this.form.shift = data.shift;

                console.log(this.form);

            },
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }

        }
    }
</script>

