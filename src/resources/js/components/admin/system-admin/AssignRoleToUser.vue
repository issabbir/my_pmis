<template>
    <b-card>
        <b-card-title>
            <span class="pr-4">Assign roles to user</span>
            <b-button type="button"  @click="openModal()" id="modalBtn" class="btn btn-success shadow">Create Role</b-button>
        </b-card-title>
        <b-card-body>
            <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                <b-row>
                    <b-col md="2">
                        <b-form-group label="User" label-for="user_id">
                            <v-select label="option_name" v-model="selectedUser" :options="userList" @search="searchUserById" id="user_id" name="user_id">
                                <template #search="{attributes, events}">
                                    <input class="vs__search" v-bind="attributes" v-on="events" :required="selectedUser && selectedUser.user_id==null" />
                                </template>
                            </v-select>
                        </b-form-group>
                        <div v-if="employee" class="text-dark small">
                            <b-row v-if="employee.emp_name">
                                <b-col>Name: {{ employee.emp_name }}</b-col>
                            </b-row>
                            <b-row v-if="employee.emp_code">
                                <b-col>Code: {{ employee.emp_code }}</b-col>
                            </b-row>
                            <b-row v-if="employee.designation">
                                <b-col>Designation: {{ employee.designation.designation}}</b-col>
                            </b-row>
                            <b-row v-if="employee.department">
                                <b-col>Department: {{ employee.department.department_name}}</b-col>
                            </b-row>
                        </div>
                    </b-col>
                    <b-col md="10" v-if="userSelected">
                        <b-row class="role-container">
                            <b-col md="2" class="pr-2">
                                <b-row>
                                    <b-col md="12" class="pt-half pb-half bg-dark">
                                        <h6 class="text-white">Assigned Roles</h6>
                                    </b-col>
                                </b-row>
                                <b-row v-if="assignedRoles.length">
                                    <b-col md="12" v-for="(assignedRole, index) in assignedRoles" :key="assignedRole.role_id" class="border p-1">
                                        <strong>{{ index+1 }} . {{ assignedRole.role_name }}</strong>
                                    </b-col>
                                </b-row>
                                <b-row v-else>
                                    <b-col md="12" class="border p-1">
                                        <strong>Not assigned yet!</strong>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="10">
                                <b-form-group label-for="roles">
                                    <b-form-checkbox-group v-model="assignRolesToUser.roles" id="roles" name="roles">
                                        <b-row>
                                            <b-col md="12" class="pt-half pb-half bg-dark">
                                                <b-row>
                                                    <b-col md="8">
                                                        <h5 class="text-white">Roles</h5>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <input type="text" v-model="searchRole" placeholder="Search Role.." @input.prevent="searchRoles" @keydown.enter.prevent @change.prevent="searchRoles" class="form-control form-control-sm" />
                                                    </b-col>
                                                </b-row>
                                            </b-col>
                                            <b-col v-for="role in roleList" :key="role.role_id" class="border p-1" md="2">
                                                <b-form-checkbox :value="role.role_id"> {{ role.role_name }}</b-form-checkbox>
                                            </b-col>
                                        </b-row>
                                    </b-form-checkbox-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
                <b-row class="mt-1">
                    <b-col class="d-flex justify-content-end align-items-center">
                        <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow" v-if="userSelected"> Assign Selected Roles to User </b-button>
                    </b-col>
                </b-row>
                <template>
                    <div>
                        <b-modal id="create-role" centered v-model="modalShow" hide-footer title="Create Role">
                            <b-form @submit.stop.prevent="onSubmitModal">
                                <b-row>
                                    <b-col>
                                        <b-form-group
                                          label="Role Name"
                                          label-for="role_name"
                                          class="requiredField"
                                        >
                                            <b-form-input v-model="moreAdd.role_name" name="role" v-validate="'required'" type="text"></b-form-input>
                                            <span :style="errorMessage">{{ errors.first('role') }}</span>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col>
                                        <b-form-group
                                          label="role key"
                                          label-for="role_key"
                                          class="requiredField"
                                        >
                                            <b-form-input v-model="moreAdd.role_key" name="key" v-validate="'required'"></b-form-input>
                                            <span :style="errorMessage">{{ errors.first('key') }}</span>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col class="d-flex justify-content-end">
                                        <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Add</b-button>
                                        <b-button md="6" size="md" class="btn-outline-dark mb-1"  @click="closeModal()">Cancel</b-button>
                                    </b-col>
                                </b-row>
                            </b-form>
                        </b-modal>
                    </div>
                </template>
            </b-form>
        </b-card-body>
    </b-card>
</template>

<script>
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {vSelect},
        props:['user'],
        data() {
            return {
                tempRoleList: [],
                searchRole: '',
                errorMessage: {color: 'red'},
                moreAdd:{},
                modalShow:false,
                show: true,
                keepDisable: false,
                userSelected: false,
                assignRolesToUser: {
                    user_id: null,
                    roles: [],
                },
                employee: {},
                userList: [],
                roleList: [],
                assignedRoles: [],
                selectedUser: {'option_name':'','user_id':'', 'user_name':''},
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Assign role to user"});
            this.loadData();
            if(this.user){
                this.selectedUser = this.user;
            }
        },
        watch: {
            selectedUser:function(val,oldVal) {
                this.userSelected = true;
                if(val !== null) {
                    this.assignRolesToUser.user_id = val.user_id;
                    this.getUserByRoles(val.user_id);
                } else {
                    this.assignedRoles = [];
                }
            },
        },
        methods: {
            searchRoles() {
                this.roleList = this.tempRoleList;

                if(this.searchRole.trim()) {
                    this.roleList = this.roleList.filter(row => {
                        return row.role_name.toLowerCase().includes(this.searchRole.toLowerCase())
                    });
                }

            },
            reinitiateRoles() {
                if(this.assignRolesToUser.user_id !== undefined) {
                    this.getUserByRoles(this.assignRolesToUser.user_id);
                }
                this.$emit('reinitiate-roles', '');
            },
            openModal(){
                this.modalShow = true;
            },
            closeModal(){
                this.modalShow = false;
                this.onResetModelFields();
            },
            onSubmitModal(){
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/role", this.moreAdd).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.closeModal();
                                this.keepDisable = false;
                                this.reinitiateRoles();
                                this.onResetModelFields();
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                            } else{
                                this.keepDisable = false;
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                            }
                        });
                    }
                });
            },
            onSubmit() {
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/system-admin/roles/save-user-roles', this.assignRolesToUser).then(res => {
                            if (res.data.o_STATUS_CODE == 1) {
                                this.$notify({ group: 'pmis', text: res.data.o_STATUS_MESSAGE, type:'success' })
                            } else{
                                this.$notify({ group: 'pmis', text: res.data.o_STATUS_MESSAGE, type:'error' })
                            }
                            this.loadData();
                            this.assignedRoles = res.data.roles;
                            this.keepDisable = false;
                        });
                    }
                });

            },
            getUserByRoles(userId) {
                if(userId) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND,`/admin/system-admin/fetch-user-roles/${userId}`).then(result => {
                        /**
                         * Not to do in advance if current solution meets the requirement.
                         *
                        this.roleList = this.sortedRoles(result.data.roles, result.data.selectedUserRoles);
                        this.tempRoleList = this.sortedRoles(result.data.roles, result.data.selectedUserRoles);
                         */
                        this.roleList = result.data.roles;
                        this.tempRoleList = result.data.roles;
                        this.assignedRoles = result.data.userRoles;
                        this.assignRolesToUser.roles = result.data.selectedUserRoles;
                        this.employee = result.data.employee;
                    });
                }
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND,"/admin/system-admin/fetch-roles").then(result => {
                    /**
                     * Not to do in advance if current solution meets the requirement.
                     *
                    this.roleList = this.sortedRoles(result.data, this.assignRolesToUser.roles);
                    this.tempRoleList = this.sortedRoles(result.data, this.assignRolesToUser.roles);
                     */
                    this.roleList = result.data;
                    this.tempRoleList = result.data;
                });
            },
            sortedRoles(roles, selectedUserRoles) {
                let sortedRoles = roles.sort((a, b) => {
                    return selectedUserRoles.findIndex(p => p === b.value) - selectedUserRoles.findIndex(p => p === a.value);
                });

                return sortedRoles;
            },
            searchUserById(id){
                if(id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/system-admin/role/search-user/${id}`).then(res => {
                        this.userList = res.data;
                    });
                }
            },
            onResetModelFields() {
                this.$nextTick(() => {
                    this.moreAdd = {};
                });
            }
        }
    }
</script>
<style>
    .text-white {
        color: white!important;
    }

    .pt-half {
        padding-top: 0.5rem!important;
    }
    .pb-half {
        padding-bottom: 0.5rem!important;
    }
    .role-container {
        height: 200px;
        overflow-y: scroll;
    }
</style>
