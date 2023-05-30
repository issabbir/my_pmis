<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">{{title}}</h4>
            </div>
            <b-card-text class="card-content updatedUser">
              <div class="card-body mb-2">
                <b-form @submit.prevent="onSubmit('createUser')"  v-if="show" data-vv-scope="createUser">
                 <b-row>
                     <b-col lg="4">
                         <b-row>
                            <b-col lg="4">
                              <label>User Type</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                               <b-form-select
                                        @change="empTypeWiseForm($event)"
                                        v-model="CreateUser.userType"
                                        :options="userTypesList"
                                        class=""
                                        disabled
                                        text-field="text"
                                    ></b-form-select>
                            </b-col>
                          </b-row>
                     </b-col>
                     <b-col lg="4">
                         <b-row>
                            <b-col lg="4">
                              <label>User Name</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                                <b-form-input
                                    v-model="CreateUser.user_name"
                                    required
                                    type="text"
                                    name="user name"
                                    readonly
                                 ></b-form-input>
                                <span :style="errorMessage">{{ errors.first('createUser.user name') }}</span>
                            </b-col>
                          </b-row>
                     </b-col>

                     <b-col lg="4">
                         <b-row>
                            <b-col lg="4">
                              <label>Email</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                               <b-form-input
                                        v-model="CreateUser.email"
                                         class=""
                                     ></b-form-input>
                            </b-col>
                          </b-row>
                     </b-col>
<!--                     <b-col lg="4">-->
<!--                         <b-row v-if="isEdit">-->
<!--                                <b-col lg="4">-->
<!--                                    <label>User Password</label>-->
<!--                                </b-col>-->
<!--                                <b-col lg="8" class="form-group ">-->
<!--                                    <b-form-input-->
<!--                                        v-model="CreateUser.UserPassword"-->
<!--                                        type="password"-->
<!--                                        v-validate="'required'" ref="password"  :allow-empty="false" :reset-after="false" name="new password"-->
<!--                                    ></b-form-input>-->
<!--                                    <span :style="errorMessage">{{ errors.first('createUser.new password') }}</span>-->
<!--                                </b-col>-->
<!--                            </b-row>-->
<!--                     </b-col>-->
<!--                     <b-col lg="4">-->
<!--                         &lt;!&ndash; Retype Password &ndash;&gt;-->
<!--                            <b-row v-if="isEdit">-->
<!--                                <b-col lg="4">-->
<!--                                    <label>Retype Password</label>-->
<!--                                </b-col>-->
<!--                                <b-col lg="8" class="form-group">-->
<!--                                    <b-form-input-->
<!--                                        v-model="CreateUser.RetypePassword"-->
<!--                                        type="password"-->
<!--                                        v-validate="'required|confirmed:password'"  data-vv-as="password" :allow-empty="false" :reset-after="false" name="retype password"-->
<!--                                    ></b-form-input>-->
<!--                                    <span :style="errorMessage">{{ errors.first('createUser.retype password') }}</span>-->
<!--                                </b-col>-->
<!--                            </b-row>-->
<!--                     </b-col>-->
                     <b-col lg="4">
                         <b-row>
                            <b-col lg="4">
                              <label>Status</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                               <b-form-select @change="onStatusChange" v-model="CreateUser.status" :options="statusList" ></b-form-select>
                            </b-col>
                          </b-row>
                     </b-col>
                 </b-row>
                <div class="externalUser row" v-if="externalUser">
                    <b-col lg="4">
                         <b-row>
                            <b-col lg="4">
                              <label>Reference</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                                  <b-form-input
                                    v-model="CreateUser.referance"
                                    required
                                    type="text"
                               ></b-form-input>
                            </b-col>
                          </b-row>
                     </b-col>
                 </div>
                 <div class="internalUser row" v-if="internalUser">
                     <b-col lg="4">
                         <b-row>
                            <b-col lg="4">
                              <label>Employee</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                                 <v-select
                                   label="option_name"
                                                    v-model="selectedEmployee"
                                                    :options="empIdList"
                                                    @search="searchempcods">
                                                    <template #search="{attributes, events}">
                                                        <input
                                                            class="vs__search"
                                                            :required="selectedEmployee && selectedEmployee.emp_id==null"
                                                            v-bind="attributes"
                                                            v-on="events"
                                                        />
                                                    </template>
                                     </v-select>
                            </b-col>
                          </b-row>
                     </b-col>
                      <b-col lg="4">
                          <b-row>
                            <b-col lg="4">
                              <label>Section</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="CreateUser.section"
                                required
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>
                     </b-col>
                      <b-col lg="4">
                         <b-row>
                            <b-col lg="4">
                              <label>Member Department</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="CreateUser.department"
                                required
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>
                     </b-col>
                      <b-col lg="4">
                         <b-row>
                            <b-col lg="4">
                              <label>Designation</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="CreateUser.designation"
                                required
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>
                     </b-col>
                      <b-col lg="4">
                         <b-row>
                            <b-col lg="4">
                              <label>Division</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="CreateUser.division"
                                required
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>
                     </b-col>
 </div>

                  <b-row>
                    <b-col>
                      <b-row>
                        <b-col lg="12">
                          <!-- Search Button -->
                          <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                              <b-button
                                lg="6"
                                size="md"
                                class="btn-dark mr-1"
                                type="submit"
                              >
                                <i class="bx bx-save cursor-pointer" ></i> {{submitBtn}}
                              </b-button>
                                <b-button
                                    lg="6"
                                    size="md"
                                    class="btn-outline-dark"
                                    type="reset"
                                    href="/admin#/create-user"
                                >
                                    <i class="bx bx-exit cursor-pointer" ></i> New User
                                </b-button>
<!--                                 <a-->
<!--                                    lg="6"-->
<!--                                    size="md"-->
<!--                                    class="btn-outline-dark"-->
<!--                                    type="reset"-->
<!--                                    href="/admin#/create-user"-->
<!--                                >-->
<!--                                    <i class="bx bx-exit cursor-pointer" ></i> Exit-->
<!--                                </a>-->
                            </b-col>
                          </b-row>
                        </b-col>
                      </b-row>
                    </b-col>
                  </b-row>
                </b-form>
                  <b-form @submit.prevent="onPassChangeSubmit"  v-if="changePassForm">
                      <b-row>
                        <b-col lg="4">
                          <!-- Employee -->
                            <b-row>
                            <b-col lg="4">
                              <label>New Password</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                                <b-form-input
                                    v-model="changePass.newPassword"
                                    type="password"
                                     v-validate="'required'" ref="password" :allow-empty="false" :reset-after="false" name="new password"
                                 ></b-form-input>
                                <span :style="errorMessage">{{ errors.first('new password') }}</span>
                            </b-col>
                          </b-row>
                            <b-row>
                            <b-col lg="4">
                              <label>Confirm Password</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                                <b-form-input
                                    v-model="changePass.confirmPassword"
                                    type="password"
                                    v-validate="'required|confirmed:password'"  data-vv-as="password"  :allow-empty="false" :reset-after="false" name="confirm password"
                                 ></b-form-input>
                                <span :style="errorMessage">{{ errors.first('confirm password') }}</span>
                            </b-col>
                          </b-row>
                            <b-row align-h="end">
                            <b-col lg="12" class="form-group">
                                <b-button
                                lg="6"
                                size="md"
                                class="btn-dark mr-1"
                                type="submit"
                              >
                                <i class="bx bx-save cursor-pointer" ></i> {{submitBtn}}
                              </b-button>
                            </b-col>
                          </b-row>

                        </b-col>
                      </b-row>
                  </b-form>
              </div>
            </b-card-text>
          </b-card>
<!--            <b-card>-->
<!--                <b-row>-->
<!--                    <b-col>-->
<!--                        <b-card title="User Role Assign">-->
<!--                             <b-form @submit.prevent="onSubmitAssignRoles('roleAssign')"  v-if="show" data-vv-scope="roleAssign">-->
<!--                                 <b-row v-for="(role, index) in createUserRole.roles" :key="index">-->
<!--                                     <b-col lg="1">-->
<!--                                                    {{ index+1 }}-->
<!--                                     </b-col>-->
<!--                                     <b-col lg="3">-->
<!--                                        <b-row>-->
<!--                                            <b-col lg="4">-->
<!--                                              <label>User Role</label>-->
<!--                                            </b-col>-->
<!--                                            <b-col lg="8" class="form-group">-->
<!--                                              <multiselect v-model="role.userRole" v-validate="'required'" :allow-empty="false" :reset-after="false" name="user role"  select-label="" tag-placeholder="Add this as new role" placeholder="Search or add a role" label="role_name" track-by="role_id" :options="userRolesList" ></multiselect>-->
<!--                                              <span :style="errorMessage">{{ errors.first('roleAssign.user role') }}</span>-->
<!--                                            </b-col>-->
<!--                                       </b-row>-->
<!--                                     </b-col>-->
<!--                                      <b-col lg="3">-->
<!--                                        <b-row>-->
<!--                                            <b-col lg="4">-->
<!--                                              <label>From Date</label>-->
<!--                                            </b-col>-->
<!--                                            <b-col lg="8" class="form-group">-->
<!--                                                <date-picker-->
<!--                                                :required="requiredFrom"-->
<!--                                                v-validate="requiredFrom ? 'required' : ''"-->
<!--                                                :allow-empty="false" :reset-after="false"-->
<!--                                                name="from date"-->
<!--                                                v-model="role.fromDate"-->
<!--                                                width="100%"-->
<!--                                                input-class="form-control"-->
<!--                                                type="date"-->
<!--                                                lang="en"-->
<!--                                                format="YYYY-MM-DD"></date-picker>-->
<!--                                                <span v-if="requiredFrom" :style="errorMessage">{{ errors.first('roleAssign.from date') }}</span>-->
<!--                                            </b-col>-->
<!--                                       </b-row>-->
<!--                                     </b-col>-->
<!--                                      <b-col lg="3">-->
<!--                                        <b-row>-->
<!--                                            <b-col lg="4">-->
<!--                                              <label>To Date</label>-->
<!--                                            </b-col>-->
<!--                                            <b-col lg="8" class="form-group">-->
<!--                                                <date-picker-->
<!--                                                v-model="role.toDate"-->
<!--                                                v-validate="requiredFrom ? 'required' : ''"-->
<!--                                                :allow-empty="false" :reset-after="false"-->
<!--                                                width="100%"-->
<!--                                                input-class="form-control"-->
<!--                                                type="date"-->
<!--                                                lang="en"-->
<!--                                                :required="requiredFrom"-->
<!--                                                name="to date"-->
<!--                                                format="YYYY-MM-DD"></date-picker>-->
<!--                                                <span v-if="requiredFrom" :style="errorMessage">{{ errors.first('roleAssign.to date') }}</span>-->
<!--                                            </b-col>-->
<!--                                       </b-row>-->
<!--                                     </b-col>-->
<!--                                     <b-col lg="2">-->
<!--                                        <b-row>-->
<!--                                            <b-col lg="12" class="form-group">-->
<!--                                               <button type="button" @click.prevent="removeRoleAssign(index)" class="btn btn-danger mr-1">-->
<!--                                                        <i class="bx bx-trash cursor-pointer"></i>-->
<!--                                               </button>-->
<!--                                            </b-col>-->
<!--                                       </b-row>-->
<!--                                     </b-col>-->
<!--                                 </b-row>-->
<!--                                          <b-row align-h="end">-->
<!--                                            <b-col lg="12" class="form-group">-->
<!--                                               <b-button-->
<!--                                             @click.prevent="addRoleAssign"-->
<!--                                             size="md"-->
<!--                                            class="btn-dark mr-1"-->
<!--                                            type="submit"-->
<!--                                          > Add </b-button>-->
<!--                                            </b-col>-->
<!--                                       </b-row>-->
<!--                                 <b-row>-->
<!--                            <b-col class="mt-2 d-flex justify-content-end">-->
<!--                              <b-button-->
<!--                                lg="6"-->
<!--                                size="md"-->
<!--                                class="btn-dark mr-1"-->
<!--                                disabled-->
<!--                                type="submit"-->
<!--                              >-->
<!--                                <i class="bx bx-save cursor-pointer" ></i> {{submitBtn}}-->
<!--                              </b-button>-->
<!--                                <b-button-->
<!--                                    lg="6"-->
<!--                                    size="md"-->
<!--                                    class="btn-outline-dark"-->
<!--                                    type="reset"-->
<!--                                    href="/admin#/create-user"-->
<!--                                >-->
<!--                                    <i class="bx bx-exit cursor-pointer" ></i> Exit-->
<!--                                </b-button>-->
<!--                            </b-col>-->
<!--                          </b-row>-->
<!--                              </b-form>-->
<!--                        </b-card>-->
<!--                    </b-col>-->
<!--                </b-row>-->
<!--            </b-card>-->

        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import Multiselect from 'vue-multiselect';
export default {
  components: {DatePicker,Datatable,Vue,vSelect,vcss,Multiselect},
    props: ['id'],
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Administration" });
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "System Admin"
    });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Update User" });
    this.loadData();
  },
  data() {
    return {
        errorMessage: {color: 'red'},
        selectedEmployee:{},
        CreateUser:{
            emp_id:this.id,
            user_id:null,
            user_name:null,
            department_name:null,
            member_deptname:null,
            designation:null,
            division:null,
            section:null,
            userRole:null,
            userType:null,
            status:'Y',
            referance:null,
        },
        changePass:{
            user_id:null,
        },
        userTypesList: [
            // {text:'Select Type', value:null},
            // {text:'Internal', value:'Internal'},
            // {text:'External', value:'External'},
         ],
        userRolesList: [],
        empIdList: [],
        role:{ userRole: '', fromDate: '', toDate: ''},
        createUserRole: {
                    roles: [
                        { user_id: null, userRole: '', fromDate: '', toDate: ''},
                    ]
                },
        statusList:[{text:'Active',value:'Y'},{text:'Inactive',value:'N'}],
        externalUser: false,
        internalUser: false,
        requiredFrom: false,
        show: true,
        changePassForm: false,
        isEdit: true,
        updateIndex: -1,
        submitBtn: "Update",
        title:'Update User',
        fields: [{key: 'action2', label: 'SL'},
            {key: 'user_name', label: ' User Name'},
            {key: 'employee.emp_name', label: ' Employee Name '},
            {key: 'is_active', label: 'Activation Status'},
            'action'],
        items: [],
        totalRowsList: 0,
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
        }
    };
  },
    watch: {
            selectedEmployee:function(val,oldVal) {
                if(val !== null) {
                    this.CreateUser.user_name=  val.emp_code;
                    this.CreateUser.emp_id=  val.emp_id;
                    if ( val.section)
                        this.CreateUser.section=  val.section.dpt_section;
                    if ( val.department)
                        this.CreateUser.department=  val.department.department_name;
                    if(val.designation)
                        this.CreateUser.designation=  val.designation.designation;
                    if(val.dpt_division)
                        this.CreateUser.division=  val.dpt_division.dpt_division_name;
                }
            }

        },
  methods: {
      empTypeWiseForm: function(value){
           if(value == '2'){
              this.externalUser = true
              this.internalUser = false
          }else if(value == '1'){
              this.externalUser = false
              this.internalUser = true
          }else{
               this.externalUser = false
               this.internalUser = false
           }
      },
      onStatusChange: function(value){
          console.log(value);
           if(value == 'N'){
              this.requiredFrom = true
           } else{
               this.requiredFrom = false
            }
      },
       searchempcods(id){
                if(id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/leave/leave-entry/emp-info/${id}`, this.LeaveEntry).then(res => {
                        this.empIdList = res.data.empcodeList;
                        //this.emp_name=res.data.empcodeList.emp_name;

                    })
                }
            },
      addRoleAssign: function () {
                this.createUserRole.roles.push(Vue.util.extend({}, this.roles));
                if(this.createUserRole.roles.length > 8) {
                    this.disabled = true;
                } else {
                    this.disabled = false;
                }
            },
       removeRoleAssign: function(index) {
                Vue.delete(this.createUserRole.roles, index);
                if(this.createUserRole.roles.length < 9) {
                    this.disabled = false;
                } else {
                    this.disabled = true;
                }
            },
    loadData: function () {
          //let url = ((this.id !== undefined) && (this.id > 0)) ?  `/pmis/employee/academics/specific/${this.id}` : '/admin/system-admin/user-ip-assign';
          let that = this;
         ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/system-admin/update-user/${this.id}`).then(res => {
             console.log(res);
                           that.CreateUser.userType = res.data.user.user_type_id;
                           that.CreateUser.user_name = res.data.user.user_name;
                           that.CreateUser.user_id = res.data.user.user_id;
                           that.CreateUser.email = res.data.user.email;
                           that.CreateUser.status = res.data.user.is_active;
                           that.userRolesList = res.data.rolesList;
                           that.userTypesList = res.data.userTypes;
                           //that.CreateUser.userRole = res.data.roles;
                           that.CreateUser.roles = res.data.roles;
                           that.CreateUser.emp_name = res.data.employee.emp_name;
                           that.CreateUser.emp_code = res.data.employee.emp_code;
                           that.CreateUser.department = res.data.employee.department.department_name;
                           that.CreateUser.division = res.data.employee.dpt_division.dpt_division_name;
                           that.CreateUser.designation = res.data.employee.designation.designation;
                           that.CreateUser.section = res.data.employee.designation.section;
                           that.submitBtn = 'Update';

          });
      },

    onSubmit(createUser) {
          let currObj = this;
            ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/update-user",currObj.CreateUser).then(result => {
                        if(result.data.o_STATUS_CODE == 1) {
                            currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'success'});
                            this.loadData();
                        }else{
                            currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'error'});
                        }
                        //window.location = "#/search-user";
                    });
    },
    onSubmitAssignRoles(roleAssign) {
          let currObj = this;
          // this.$validator.validateAll(roleAssign).then(() => {
          //  if (!this.errors.any()) {
               ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/create-user-role-assign", currObj.createUserRole.roles).then(result => {
                   if (result.data.o_STATUS_CODE == 1) {
                       currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'success'});
                       //currObj.loadData();
                      // this.$router.push('/update-user/'+currObj.id);
                   } else {
                       currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'error'});
                   }
                   //window.location = "#/search-user";
               });
           // } else {
           //          console.log('here', currObj.errors);
           //       }
           //   });
    },
    editUser(userID,empID) {
          this.isEdit = false;
          this.changePassForm = false;
          this.show = true;
          this.title = 'Update User';
          let that = this;
          this.$router.push('/update-user/'+empID);
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
      this.CreateUser = {

      };

    },

      changePassword($user_id, $user_name){
        this.changePassForm = true;
        this.show = false;
        this.title = 'Change Password For user Id : ' + $user_name;
        this.changePass.user_id = $user_id;

      },

      onPassChangeSubmit(){
        let currObj = this;
        this.$validator.validateAll().then(() => {
           if (!this.errors.any()) {
             ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/update-user-password", this.changePass).then(result => {
                        if(result.data.o_STATUS_CODE == 1) {
                            currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'success'});
                            this.loadData();
                        }else{
                            currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'error'});
                        }
                     });
                } else {
                        console.log('here', currObj.errors);
                    }
             });
      },

  }
};
</script>

<style>
    .updatedUser .custom-select:disabled {
    color: #475F7B;
    background-color: #f2f4f4;
}
</style>
