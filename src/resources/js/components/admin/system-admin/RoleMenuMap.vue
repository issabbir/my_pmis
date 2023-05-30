<template>
    <div class="content-wrapper">
        <div id="content-body">
          <assign-role @reinitiate-roles="loadRole"></assign-role>
          <b-card title="Application Access Control Management" class="bg-transparent" >
            <b-card-body>
              <b-card>
                <b-card-body>
                  <b-row>
                    <b-col md="4">
                      <b-form-group
                        label="Please select a role"
                        label-for="role_name"
                        class="requiredField"
                      >
                        <v-select
                          label="text"
                          v-model="selectedRole"
                          :options="roleList"
                          @input="getControl"
                          name="role_id"
                          id="role_id">
                          <template #selected-option="{ text }">
                            <div style="display: flex; align-items: baseline;">
                              {{ text }}
                            </div>
                          </template>
                        </v-select>
                        <span :style="errorMessage">{{ errors.first('role_name') }}</span>
                      </b-form-group>
                    </b-col>
                  </b-row>
                </b-card-body>
              </b-card>
              <b-row v-if='show'>
                <b-col md="3" sm="12" class="pr-md-0">
                  <b-card class="h-100">
                    <b-card-body>
                      <ul class="nav nav-pills flex-column text-center text-md-left">
                        <li class="nav-item">
                          <a href="javascript:void(0)" @click="tab='menu'" :class="{active:tab=='menu'}"  class="nav-link d-flex align-items-center">
                            <i class="bx bx-cog"></i>
                            <span> Application Menus </span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="javascript:void(0)" @click="tab='permission'" :class="{active:tab=='permission'}"  class="nav-link d-flex align-items-center">
                            <i class="bx bx-cog"></i>
                            <span> Permissions </span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="javascript:void(0)"  @click="tab='report'" :class="{active:tab=='report'}" class="nav-link d-flex align-items-center">
                            <i class="bx bx-cog"></i>
                            <span> Reports </span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="javascript:void(0)"   @click="tab='user'" :class="{active:tab=='user'}" class="nav-link d-flex align-items-center">
                            <i class="bx bx-cog"></i>
                            <span> Users </span>
                          </a>
                        </li>
                      </ul>
                    </b-card-body>
                  </b-card>

                </b-col>
                <b-col md="9" sm="12">
                  <b-card v-if="tab=='menu'" class="h-100">
                    <h4>Application Menus <button type="button" class="btn btn-success btn-sm" @click="postMenuControl">Save</button></h4>
                    <tree-menu :menus="menuTree"></tree-menu>
                  </b-card>
                  <b-card v-if="tab=='permission'" class="h-100">
                    <div class="card-content">
                      <h4>Resource Permission <button type="button" class="btn btn-success btn-sm" @click="postPermission">Save</button></h4>
                      <div v-for="module in permissions">
                        <div>
                          <div class="headerModule">{{module.module_name}}</div>
                          <b-form-group>
                            <div v-for="permission in module.permissions">
                              <b-form-checkbox
                                :id="'p_'+permission.permission_id"
                                v-model="permission.permitted"
                                :name="'p_'+permission.permission_id"
                                value=true
                                unchecked-value=""
                              > {{ permission.permission_name }}</b-form-checkbox>
                            </div>
                          </b-form-group>
                        </div>
                      </div>
                    </div>
                  </b-card>
                  <b-card v-if="tab=='report'" class="h-100">
                    <div class="card-content">
                      <h4>Report Permission <button type="button" class="btn btn-success btn-sm" @click="postReport">Save</button></h4>
                      <div v-for="module in reports">
                        <div>
                          <div class="headerModule">{{module.module_name}}</div>
                          <b-form-group>
                            <div v-for="report in module.reports">
                              <b-form-checkbox
                                :id="'p_'+report.report_id"
                                v-model="report.permitted"
                                :name="'p_'+report.report_id"
                                value=true
                                unchecked-value=""
                              > {{ report.report_name }}</b-form-checkbox>
                            </div>
                          </b-form-group>
                        </div>
                      </div>
                    </div>
                  </b-card>
                  <b-card v-if="tab=='user'" title="Assigned Users" class="h-100">
                    <Datatable
                      :fields="roleUser.fields"
                      :items="roleUser.items"
                      :pageOptions="pageOptions"
                      :totalList="totalList"
                      :perPage="perPage">
                      <template v-slot:actions="{rows}" >
                        <button @click="userUnAssign(rows.item.user_id)"  class="btn btn-primary btn-sm">Unassign</button>
                      </template>
                    </Datatable>
                  </b-card>
                </b-col>
              </b-row>
            </b-card-body>
          </b-card>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import ApiRepository from "../../../Repository/ApiRepository";
    import TreeMenu from './Pertials/TreeMenu.vue';
    import AssignRole from './AssignRoleToUser';
    import Datatable from '../../../layouts/common/datatable';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';

    export default {
        props: ['id'],
        components: {TreeMenu,AssignRole,Datatable,vSelect, vcss },
        data() {
            return {
                show:false,
                selectedRole:{},
                dt:'',
                errorMessage: {color: 'red'},
                tree_data:{},
                keepDisable: false,
                role:{roles:{role_name:'Select Role'}},
                roleList:[],
                permissions:[],
                reports:[],
                permission:{},
                module:[],
                totalList:0,
                perPage:10,
                pageOptions:[5,10,15],
                roleUser:{
                    fields: [
                        {key: 'index', label: 'SL'},
                        {key: 'employee.emp_name', label: 'Employee Name'},
                        {key: 'employee.current_department.department_name', label: 'Department Name'},
                        {
                            key: 'employee.charge_designation.designation',
                            label: 'Designation',
                            formatter: (value, key, item) => {
                                if(value) {
                                    return value
                                } else {
                                    return  item.employee?item.employee.designation.designation:''
                                }
                            },
                        },
                        {key: 'user_name', label: ' User Id'},
                        {key: 'action',class: 'text-center'}
                    ],
                    items: [],
                },
                modalShow:false,
                submitBtn:'Save',
                menuTree: [],
                permissionTree:[],
                reportTree:[],
                userTree:[],
                tab:'menu'
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Access Control"});
            this.onReset();
        },

        methods: {
            loadRole(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,"/admin/system-admin/role" ).then(result => {
                    this.roleList = result.data.roles;

                });
            },
            onReset(){
                this.loadRole();
            },
            getControl: function() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/admin/system-admin/acl/"+this.selectedRole.value.role_id, this.selectedRole).then(res => {
                    this.show = true;
                    this.menuTree = res.data.resources;
                    this.roleUser.items = res.data.users;
                    this.totalList = res.data.users.length;
                    this.permissions=res.data.permissions;
                    this.reports = res.data.reports;
                });
            },
            userUnAssign: function(id){
               if (confirm('Do You want to unassign this user')) {
                   ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/roles/unassign-user-roles/" + this.selectedRole.value.role_id + '/' + id).then(res => {
                       if (res.data.o_status_code == 1){
                           this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                           this.getControl();
                       }else{
                           this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                       }
                   });
               }
            },
            postMenuControl: function() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/acl/"+this.selectedRole.value.role_id, this.menuTree).then(res => {
                    if (res.data.o_status_code == 1)
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                    else
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                });
            },
            postPermission: function() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/acl/permission/"+this.selectedRole.value.role_id, this.permissions).then(res => {
                    if (res.data.o_status_code == 1)
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                    else
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                });
            },
            postReport: function() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/acl/report/"+this.selectedRole.value.role_id, this.reports).then(res => {
                    if (res.data.o_status_code == 1)
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                    else
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                });
            }
        }
    }

    // var toggler = document.getElementsByClassName("caret");
    // var i;
    //
    // for (i = 0; i < toggler.length; i++) {
    //     toggler[i].addEventListener("click", function() {
    //         this.parentElement.querySelector(".nested").classList.toggle("active");
    //         this.classList.toggle("caret-down");
    //     });
    // }
</script>
<!--<style>
    .folder_icon,.folder_icon_active{display: none}
    .modal-position-change{margin-top: 10px;margin-right: -30px;}
    .capitalize.selected {
        color: #727E8C !important;
        font-weight: 400 !important;
    }
</style>-->
<style scoped>

     .headerModule {
        font-size: 16px !important;
        color: #000 !important;
        background-color:#eee !important;
        padding: 5px 12px !important;
        margin: 15px 0px !important;
        font-weight: 400;
        letter-spacing: 2px;
    }
</style>
