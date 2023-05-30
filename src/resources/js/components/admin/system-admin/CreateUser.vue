<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card v-if="showSearch || showCreateUser || changePassForm">
                <b-card-header header-bg-variant="dark" header-text-variant="white">{{title}}</b-card-header>
                <b-card-body class="border">
                    <div v-if="showSearch">
                        <b-form @submit.prevent="onSubmitSearch" @reset="onReset" v-if="show">
                            <b-row>

                                <b-col md="3">
                                    <b-form-group
                                        label="User Type"
                                        label-for="userType"
                                    >
                                        <b-form-select
                                            @change="empTypeWiseSearchInput($event)"
                                            v-model="UserSearch.userType"
                                            :options="userTypesList"
                                            class=""
                                            text-field="text"
                                        ></b-form-select>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        label="User Status"
                                        label-for="status"
                                    >
                                        <b-form-select @change="onStatusChange"
                                                       v-model="UserSearch.status"
                                                       :options="statusList"></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="User Name"
                                        label-for="section"
                                    >
                                        <b-form-input
                                            v-model="UserSearch.userName"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3" v-if="departmentShow">
                                    <b-form-group
                                        label="Department"
                                        label-for="Department"
                                    >
                                        <b-form-select
                                            v-model="UserSearch.department"
                                            :options="departmentList"
                                            class=""
                                            value-field="value"
                                            text-field="text"
                                            disabled-field="notEnabled"
                                        >
                                            <template v-slot:first>
                                                <b-form-select-option :value="null">-- Please
                                                    select a department --
                                                </b-form-select-option>
                                            </template>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                    <b-button class="btn btn-dark shadow mr-1 mb-1"
                                              @click="createUserChange">Create User
                                    </b-button>
                                    <b-button type="submit" id="basic_sub_btn"
                                              class="btn btn-dark shadow mr-1 mb-1">Search
                                    </b-button>
                                    <b-button type="button" id="sd" @click="clearSearch"
                                              class="btn btn-dark shadow mr-1 mb-1">Clear
                                    </b-button>

                                </div>

                            </b-row>


                        </b-form>
                    </div>
                    <div v-if="showCreateUser">
                        <b-form @submit.prevent="onSubmit('createUser')" v-if="show" data-vv-scope="createUser">
                            <b-row>
                                <b-col lg="4">
                                    <b-form-group
                                        label="User Type"
                                        label-for="userType"
                                        label-cols-md="4"
                                    >
                                        <b-form-radio-group
                                            id="userType"
                                            v-model="CreateUser.userType"
                                            :options="userTypesList"
                                            name="userType"
                                            @change="empTypeWiseForm"
                                            :disabled="isEditUser"
                                        ></b-form-radio-group>
                                    </b-form-group>
                                </b-col>

                                <b-col lg="4" v-if="internalUser">
                                    <b-form-group
                                        label="Employee"
                                        label-for="emp_id"
                                        label-cols-md="4"
                                    >
                                        <v-select
                                            label="option_name"
                                            v-model="selectedEmployee"
                                            :disabled="isEditUser"
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
                                    </b-form-group>
                                </b-col>
                                <b-col lg="4">
                                    <b-form-group
                                        label="User Name"
                                        label-for="user_name"
                                        label-cols-md="4"
                                    >
                                        <b-form-input
                                            v-model="CreateUser.user_name"
                                            v-validate="{min:6, max:15}"
                                            required
                                            type="text"
                                            name="user name"
                                            id="user_name"
                                            :disabled="isEditUser"
                                            :readonly="internalUser"
                                        ></b-form-input>
                                        <span :style="errorMessage">{{ errors.first('createUser.user name') }}</span>
                                    </b-form-group>
                                </b-col>
                                <b-col lg="4" v-if="isEdit">
                                    <b-form-group
                                        label="User Password"
                                        label-for="UserPassword"
                                        label-cols-md="4"
                                    >
                                        <b-form-input
                                            v-model="CreateUser.UserPassword"
                                            type="password"
                                            :disabled="isEditUser"
                                            v-validate="'required'" ref="password" :allow-empty="false"
                                            name="password"
                                            id="UserPassword"
                                        ></b-form-input>
                                        <span :style="errorMessage">{{ errors.first('createUser.password') }}</span>
                                    </b-form-group>
                                </b-col>
                                <b-col lg="4" v-if="isEdit">
                                    <b-form-group
                                        label="Retype Password"
                                        label-for="RetypePassword"
                                        label-cols-md="4"
                                    >
                                        <b-form-input
                                            v-model="CreateUser.RetypePassword"
                                            type="password"
                                            id="RetypePassword"
                                            :disabled="isEditUser"
                                            v-validate="'required|confirmed:password'"
                                            data-vv-as="password" :allow-empty="false"
                                            name="retype password"
                                        ></b-form-input>
                                        <span :style="errorMessage">{{ errors.first('createUser.retype password') }}</span>
                                    </b-form-group>
                                </b-col>

                                <b-col lg="4">
                                    <b-form-group
                                        label="Email"
                                        label-for="email"
                                        label-cols-md="4"
                                    >
                                        <b-form-input
                                            v-model="CreateUser.email"
                                            type="email"
                                            class=""
                                            id="email"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col lg="4" v-if="internalUser">
                                    <b-form-group
                                        label="Section"
                                        label-for="section"
                                        label-cols-md="4"
                                    >
                                        <b-form-input
                                            v-model="CreateUser.section"
                                            required
                                            type="text"
                                            readonly
                                            id="section"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col lg="4" v-if="internalUser">
                                    <b-form-group
                                        label="Department"
                                        label-for="department"
                                        label-cols-md="4"
                                    >
                                        <b-form-input
                                            v-model="CreateUser.department"
                                            required
                                            type="text"
                                            readonly
                                            id="department"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col lg="4" v-if="internalUser">
                                    <b-form-group
                                        label="Designation"
                                        label-for="designation"
                                        label-cols-md="4"
                                    >
                                        <b-form-input
                                            v-model="CreateUser.designation"
                                            required
                                            type="text"
                                            readonly
                                            id="designation"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>



                                <b-col lg="4" v-if="internalUser">
                                    <b-form-group
                                        label="Division"
                                        label-for="division"
                                        label-cols-md="4"
                                    >
                                        <b-form-input
                                            v-model="CreateUser.division"
                                            required
                                            type="text"
                                            readonly
                                            id="division"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4" v-if="CreateUser.userType == 3">
                                    <b-form-group
                                        label="Bank"
                                        label-for="bank_id"
                                        label-cols-md="4"
                                    >
                                        <v-select
                                            @input="bankChange(banks)"
                                            v-model="banks"
                                            :options="bankList"
                                            name="bank_id"
                                            id="bank_id"
                                            label="text"
                                            class="uppercase">
                                            <template #search="{attributes, events}">
                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                            </template>
                                        </v-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4" v-if="CreateUser.userType == 3">
                                    <b-form-group
                                        label="Branch"
                                        label-for="branch_id"
                                        label-cols-md="4"
                                    >
                                        <v-select v-model="branches"
                                                  :options="branchList"
                                                  name="branch_id"
                                                  id="branch_id"
                                                  label="text"
                                                  class="uppercase">
                                            <template #search="{attributes, events}">
                                                <input class="vs__search"
                                                       v-bind="attributes" v-on="events"/>
                                            </template>
                                        </v-select>
                                        <div :class="{'invalid-feedback':true ,'d-block':errors.first('branch_id')}">{{ errors.first('branch_id') }}!</div>
                                    </b-form-group>
                                </b-col>

                                <b-col lg="4">
                                    <b-form-group
                                        label="Status"
                                        label-for="statusList"
                                        label-cols-md="4"
                                    >
                                        <b-form-radio-group
                                            id="statusList"
                                            v-model="CreateUser.status"
                                            :options="statusList"
                                            name="statusList"
                                        ></b-form-radio-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4" v-if="CreateUser.userType == 3">
                                    <b-form-group label="Signature" label-for="signature" label-cols-md="4">
                                        <b-form-file @change="encodeFile"
                                                     id="signature"
                                                     placeholder="Attachment"
                                        ></b-form-file>
                                    </b-form-group>
                                </b-col>
                                <b-col offset-md="9" md="3" class="text-right" v-if="CreateUser.userType == 3">
                                    <b-img :src="CreateUser.signature" fluid alt="signature" style="width: 300px; height: 80px"></b-img>
                                </b-col>
                            </b-row>

                            <div class="externalUser row" v-if="externalUser">
                                <b-col lg="4">
                                    <b-form-group
                                        label="Organization"
                                        label-for="referenceId"
                                        label-cols-md="4"
                                    >
                                        <b-form-select
                                            @change="othersReference($event)"
                                            v-model="CreateUser.referenceId"
                                            id="referenceId"
                                            :options="referenceList"
                                            text-field="text"
                                            :required="externalUser"
                                        ></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col lg="4" v-if="showOthersReference">
                                    <b-form-group
                                        label="Reference"
                                        label-for="reference"
                                        label-cols-md="4"
                                    >
                                        <b-form-input
                                            v-model="CreateUser.reference"
                                            type="text"
                                            id="reference"
                                            :required="externalUser"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </div>


                            <b-row>
                                <b-col>
                                    <b-row>
                                        <b-col lg="12">
                                            <!-- Search Button -->
                                            <b-row>
                                                <b-col class="mt-2 d-flex justify-content-end">
                                                    <b-button size="md" class="btn-dark mr-1"
                                                              @click="filterUserChange">Search User
                                                    </b-button> &nbsp;
                                                    <b-button
                                                        lg="6"
                                                        size="md"
                                                        class="btn-dark mr-1"
                                                        type="submit"
                                                    >
                                                        <i class="bx bx-save cursor-pointer"></i>
                                                        {{submitBtn}}
                                                    </b-button>
                                                    <b-button
                                                        lg="6"
                                                        size="md"
                                                        class="btn-outline-dark"
                                                        type="reset"
                                                        @click="filterUserChange"
                                                    >
                                                        <i class="bx bx-exit cursor-pointer"></i> Exit
                                                    </b-button>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>
                        </b-form>
                    </div>
                    <div v-if="changePassForm">
                        <b-form @submit.prevent="onPassChangeSubmit">
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
                                                v-validate="'required'" ref="password" :allow-empty="false"
                                                :reset-after="false" name="new password"
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
                                                v-validate="'required|confirmed:password'" data-vv-as="password"
                                                :allow-empty="false" :reset-after="false" name="confirm password"
                                            ></b-form-input>
                                            <span
                                                :style="errorMessage">{{ errors.first('confirm password') }}</span>
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
                                                <i class="bx bx-save cursor-pointer"></i> {{submitBtn}}
                                            </b-button>
                                            <b-button
                                                lg="6"
                                                size="md"
                                                class="btn-outline-dark"
                                                type="reset"
                                                @click="filterUserChange"
                                            >
                                                <i class="bx bx-exit cursor-pointer"></i> Exit
                                            </b-button>
                                        </b-col>
                                    </b-row>

                                </b-col>
                            </b-row>
                        </b-form>
                    </div>
                </b-card-body>
            </b-card>
            <assign-role v-if="userAssignModal" :user="selectedUser" @reinitiate-roles="loadRole" :key="selectedUser.user_id"></assign-role>
            <!----------------------- User List--------------------->
            <b-card v-if="userList">
                <b-card-header header-bg-variant="dark" header-text-variant="white">User List</b-card-header>
                <b-card-body class="border">
                    <template>
                        <div class="datatatbleBtn">
                            <Datatable v-bind:fields="fields"
                                       v-bind:items="items" v-bind:totalList="totalRowsList" v-bind:perPage="perPage">
                                <template v-slot:action2="{rows}">
                                    {{rows.index + 1}}
                                </template>
                                <template v-slot:actions="{rows}">
                                    <button @click="editUser(rows.item.user_id,rows.item.user_name,rows.item.emp_name)"
                                            class="text-primary" title="Edit User"><i
                                        class="bx bx-edit cursor-pointer"></i></button>
                                    <!--                                                                        <button @click="editUser(rows.item.user_id,rows.item.emp_id)" class="btn btn-primary">Deactive</button>-->
                                    <button
                                        @click="changePassFormAdmin(rows.item.user_id,rows.item.user_name,rows.item.emp_name)"
                                        class="text-primary" title="Password Change"><i
                                        class="bx bx-lock cursor-pointer"></i></button>
                                    <button @change="showModalUserAssign(rows.item.user_id,rows.item.user_name)"
                                            @click="showModalUserAssign(rows.item.user_id,rows.item.user_name)"
                                            class="text-primary" title="Assign role"><i
                                        class="bx bx-user-check cursor-pointer"></i></button>
                                    <!--                                                                        <button @click="editUser(rows.item.user_id,rows.item.emp_id)" class="text-danger"><i class="bx bx-trash cursor-pointer"></i></button>-->
                                </template>
                            </Datatable>
                        </div>
                    </template>
                </b-card-body>
            </b-card>
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
    import AssignRole from './AssignRoleToUser';

    export default {
        components: {DatePicker, Datatable, Vue, vSelect, vcss, Multiselect, AssignRole},
        props: ['id'],
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {
                link: "#",
                label: "System Admin"
            });
            this.$store.commit("setBreadcrumb", {link: "#", label: "Create User"});
            this.loadData();
            this.loadBank()
        },
        data() {
            return {
                mainProps: {
                    center: true,
                    width: 300,
                    height: 25,
                    class: 'my-1'
                },
                banks: {text:'',value:''},
                bankList: [],
                branches: {text: '', value: ''},
                branchList: [],
                selectedUser: {},
                errorMessage: {color: 'red'},
                selectedEmployee: {},
                UserSearch: {userType: 1},
                CreateUser: {
                    user_id: null,
                    user_name: null,
                    department_name: null,
                    member_deptname: null,
                    designation: null,
                    division: null,
                    section: null,
                    userRole: null,
                    userType: 1,
                    status: 'Y',
                    email: '',
                    bank_id: '',
                    branch_id: '',
                    referenceId: '',
                    reference: '',
                    signature: '',
                    signature_type: ''
                },
                changePass: {
                    user_id: null,
                },
                userTypesList: [],
                userRolesList: [],
                empIdList: [],
                referenceList: [],
                role: {userRole: '', fromDate: '', toDate: ''},
                createUserRole: {
                    roles: [
                        {user_id: null, userRole: '', fromDate: '', toDate: ''},
                    ]
                },
                statusList: [{text: 'Active', value: 'Y'}, {text: 'Inactive', value: 'N'}],
                externalUser: false,
                internalUser: true,
                departmentShow: true,
                showOthersReference: false,
                requiredFrom: false,
                show: true,
                showCreateUser: true,
                showSearch: false,
                changePassForm: false,
                isEdit: true,
                isEditUser: false,
                userAssignModal: false,
                userList: false,
                updateIndex: -1,
                submitBtn: "Save",
                title: 'Create User',
                fields: [{key: 'action2', label: 'SL'},
                    {key: 'user_name', label: ' User Name'},
                    {key: 'user_type_name', label: ' User Type'},
                    {key: 'emp_name', label: ' Employee Name '},
                    {key: 'department_name', label: ' Department '},
                    {key: 'designation', label: ' Designation '},
                    {key: 'email', label: ' Email '},
                    {
                        key: 'is_active', label: 'Activation Status', formatter: value => {
                            return value == 'Y' ? 'Active' : 'Inactive'
                        }
                    },
                    'action'],
                items: [],
                departmentList: [],
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
        computed: {

        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.CreateUser.user_name = val.emp_code;
                    this.CreateUser.emp_id = val.emp_id;
                    this.CreateUser.section = val.dpt_section;
                    this.CreateUser.department = val.department_name;
                    this.CreateUser.designation = val.designation;
                    this.CreateUser.division = val.dpt_division_name;
                }
            },
            banks:function (val, oldVal) {
                if (val.value !== null) {
                    this.CreateUser.bank_id = val.value;
                } else {
                    this.CreateUser.bank_id ='';
                }
            },
            branches:function (val, oldVal) {
                if (val.value !== null) {
                    this.CreateUser.branch_id = val.value;
                } else {
                    this.CreateUser.branch_id ='';
                }
            }

        },
        methods: {
            loadBank() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos').then(result => {
                    this.bankList = result.data.banks;
                })
            },
            encodeFile(e) {
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg' || e.target.files[0].type=='image/png'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.CreateUser.signature = reader.result;
                            vm.CreateUser.signature_type = type;
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }

            },
            bankChange(bank){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/branches/${bank.value}`).then(result => {
                    this.branchList = result.data;
                });
            },
            loadRole() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/admin/system-admin/role").then(result => {
                    this.roleList = result.data.roles;
                });
            },
            othersReference: function (id) {
                this.showOthersReference = true;
            },
            showModalUserAssign: function (userId, emp_code) {
                this.userAssignModal = true;
                this.showSearch = false;
                this.showCreateUser = false;
                this.changePassForm = false;
                this.selectedUser = {option_name: emp_code, user_id: userId, user_name: emp_code};
            },
            changePassFormAdmin: function (userId, emp_code, emp_name) {
                this.changePassForm = true;
                this.userAssignModal = false;
                this.showSearch = false;
                this.showCreateUser = false;
                this.changePass.user_id = userId;
                this.title = "Password change for " + emp_name + " (" + emp_code + ")";
            },
            filterUserChange: function () {
                this.title = 'Search User';
                this.showSearch = true;
                this.userList = true;
                this.showCreateUser = false;
                this.userAssignModal = false;
                this.changePassForm = false;
                this.CreateUser = {
                    user_id: null,
                    user_name: null,
                    department_name: null,
                    member_deptname: null,
                    designation: null,
                    division: null,
                    section: null,
                    userRole: null,
                    userType: 1,
                    status: 'Y',
                    email: '',
                    bank_id: '',
                    branch_id: '',
                    referenceId: '',
                    reference: '',
                    signature: '',
                    signature_type: ''
                };
                this.selectedEmployee = {};
            },
            createUserChange: function () {
                this.title = 'Create User';
                this.submitBtn = 'Save';
                this.isEditUser = false;
                this.showCreateUser = true;
                this.showSearch = false;
                this.userAssignModal = false;
                this.changePassForm = false;
                this.userList = false;
                this.CreateUser = {
                    user_id: null,
                    user_name: null,
                    department_name: null,
                    member_deptname: null,
                    designation: null,
                    division: null,
                    section: null,
                    userRole: null,
                    userType: 1,
                    status: 'Y',
                    email: '',
                    bank_id: '',
                    branch_id: '',
                    referenceId: '',
                    reference: '',
                    signature: '',
                    signature_type: ''
                };
                this.selectedEmployee = {};
            },
            empTypeWiseForm: function (value) {
                if (value == '2') {
                    this.externalUser = true;
                    this.internalUser = false;
                    this.selectedEmployee = '';
                    this.CreateUser = {userType: value, status: 'Y'};
                } else if (value == '1') {
                    this.externalUser = false
                    this.internalUser = true
                    this.CreateUser = {userType: value, status: 'Y'};
                } else {
                    this.externalUser = false
                    this.internalUser = false
                }
            },
            empTypeWiseSearchInput: function (value) {
                this.UserSearch.department = null;
                if (value == '1') {
                    this.departmentShow = true;
                } else {
                    this.departmentShow = false;
                }
            },
            onStatusChange: function (value) {
                if (value == 'N') {
                    this.requiredFrom = true
                } else {
                    this.requiredFrom = false
                }
            },
            searchempcods(id) {
                if (id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/system-admin/create-users/emp-info/${id}`, this.LeaveEntry).then(res => {
                        this.empIdList = res.data.empcodeList;
                        //this.emp_name=res.data.empcodeList.emp_name;
                    })
                }
            },
            addRoleAssign: function () {
                this.createUserRole.roles.push(Vue.util.extend({}, this.roles));
                if (this.createUserRole.roles.length > 8) {
                    this.disabled = true;
                } else {
                    this.disabled = false;
                }
            },
            removeRoleAssign: function (index) {
                Vue.delete(this.createUserRole.roles, index);
                if (this.createUserRole.roles.length < 9) {
                    this.disabled = false;
                } else {
                    this.disabled = true;
                }
            },
            loadData: function () {
                //let url = ((this.id !== undefined) && (this.id > 0)) ?  `/pmis/employee/academics/specific/${this.id}` : '/admin/system-admin/user-ip-assign';
                let that = this;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/system-admin/create-users/`).then(res => {
                    that.userRolesList = res.data.roles;
                    that.userTypesList = res.data.userTypes;
                    that.departmentList = res.data.departments;
                    that.referenceList = res.data.references;
                });
            },

            onSubmit(createUser) {
                let currObj = this;
                if (currObj.CreateUser.user_id) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/update-user", currObj.CreateUser).then(result => {
                        if (result.data.o_STATUS_CODE == 1) {
                            currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'success'});
                            this.loadData();
                            this.onSubmitSearch()
                        } else {
                            currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'error'});
                        }
                        //window.location = "#/search-user";
                    });
                } else {
                    this.$validator.validateAll(createUser).then(() => {
                        if (!this.errors.any()) {
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/create-user", currObj.CreateUser).then(result => {
                                if (result.data.o_STATUS_CODE == 1) {
                                    currObj.$notify({
                                        group: 'pmis',
                                        text: result.data.o_STATUS_MESSAGE,
                                        type: 'success'
                                    });
                                    this.onReset();
                                } else {
                                    currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'error'});
                                }
                                //window.location = "#/search-user";
                            });
                        } else {
                            console.log('here', currObj.errors);
                        }
                    });
                }
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
            onSubmitSearch() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/search-user", this.UserSearch).then(res => {
                    this.items = res.data.users;
                    this.totalRowsList = res.data.users.length;
                });
            },
            editUser(userID, emp_code, emp_name) {
                this.isEditUser = true;
                this.changePassForm = false;
                this.userAssignModal = false;
                this.show = true;
                this.showSearch = false;
                this.showCreateUser = true;
                this.title = 'Update user for ' + emp_name + " (" + emp_code + ")";
                let that = this;
                //this.$router.push('/update-user/'+userID);
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/admin/system-admin/create-user/" + userID).then(res => {
                    that.empTypeWiseForm(res.data.user.user_type_id);
                    that.CreateUser.userType = res.data.user.user_type_id;
                    that.CreateUser.status = res.data.user.is_active;
                    that.CreateUser.user_name = res.data.user.user_name;
                    that.CreateUser.user_id = res.data.user.user_id;
                    that.CreateUser.email = res.data.user.email;
                    that.CreateUser.signature = res.data.user.signature
                    that.CreateUser.signature_type = res.data.user.signature_type
                    this.banks = res.data.user.bank
                    this.bankChange(res.data.user.bank)
                    this.branches = res.data.user.branch
                    that.selectedEmployee = {
                        option_name: res.data.user.user_name,
                        user_id: res.data.user.user_id,
                        user_name: res.data.user.user_name
                    };
                    that.CreateUser.emp_name = res.data.employee.emp_name;
                    that.CreateUser.department = res.data.employee.department.department_name;
                    that.CreateUser.division = res.data.employee.dpt_division.dpt_division_name;
                    that.CreateUser.designation = res.data.employee.designation.designation;
                    that.CreateUser.section = res.data.employee.designation.section;

                    that.submitBtn = 'Update';
                });
            },

            onReset() {
                this.CreateUser = {
                    user_id: null,
                    user_name: null,
                    department_name: null,
                    member_deptname: null,
                    designation: null,
                    division: null,
                    section: null,
                    userRole: null,
                    userType: 1,
                    status: 'Y',
                    email: '',
                    bank_id: '',
                    branch_id: '',
                    referenceId: '',
                    reference: '',
                    signature: '',
                    signature_type: ''
                };
                this.selectedEmployee = {};
            },
            clearSearch() {
                this.UserSearch = {};
            },

            changePassword($user_id, $user_name) {
                this.changePassForm = true;
                this.show = false;
                this.title = 'Change Password For user Id : ' + $user_name;
                this.changePass.user_id = $user_id;

            },

            onPassChangeSubmit() {
                let currObj = this;
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/update-user-password", this.changePass).then(result => {
                            if (result.data.o_STATUS_CODE == 1) {
                                currObj.$notify({group: 'pmis', text: result.data.o_STATUS_MESSAGE, type: 'success'});
                                this.loadData();
                            } else {
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
    .datatatbleBtn button:not(:disabled) {
        cursor: pointer;
        border: 0;
    }
</style>
