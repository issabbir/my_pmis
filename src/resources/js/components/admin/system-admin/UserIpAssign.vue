<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">User Ip Assign</h4>
            </div>
            <b-card-text class="card-content">
              <div class="card-body mb-2">
                <b-form @submit="onSubmit" v-if="show">
                  <b-form-input
                    v-model="updateIndex"
                    required
                    id="input-update-index"
                    type="text"
                    :style="{'display':'none'}"
                  ></b-form-input>

                    <b-row>
                        <b-col>
                            <b-row>
                                <b-col lg="4">
                                    <!-- Employee -->
                                    <b-row>
                                        <b-col lg="4">
                                            <label>Employee</label>
                                        </b-col>
                                        <b-col lg="8" class="form-group">
                                            <b-form-input
                                                v-model="UserIpAssign.emp_name"
                                                required
                                                id="input-id"
                                                type="text"
                                                disabled
                                            ></b-form-input>
                                        </b-col>
                                    </b-row>
                                    <!-- Ip Address -->
                                    <b-row>
                                        <b-col lg="4">
                                            <label>Ip Address</label>
                                        </b-col>
                                        <b-col lg="8" class="form-group">
                                            <b-form-input
                                                v-model="UserIpAssign.allowed_ip"
                                                required
                                                id="input-id"
                                                type="text"
                                            ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>

                                <b-col lg="4">
                                    <!-- Department -->
                                    <b-row>
                                        <b-col lg="4">
                                            <label>Department</label>
                                        </b-col>
                                        <b-col lg="8" class="form-group">
                                            <b-form-input
                                                v-model="UserIpAssign.department_name"
                                                required
                                                id="input-id"
                                                type="text"
                                                disabled
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
                                                v-model="UserIpAssign.designation_name"
                                                required
                                                id="input-id"
                                                type="text"
                                                disabled
                                            ></b-form-input>
                                        </b-col>
                                    </b-row>
                                    <br/>
                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button
                                                lg="6"
                                                size="md"
                                                class="btn-dark mr-1"
                                                type="submit"
                                            >
                                                <i class="bx bx-save cursor-pointer" ></i> Save
                                            </b-button>
                                            <b-button
                                                lg="6"
                                                size="md"
                                                class="btn-outline-dark"
                                                type="reset"
                                                :href="'/admin#/update-user/' + this.UserIpAssign.emp_id"
                                            >
                                                <i class="bx bx-exit cursor-pointer" ></i> Exit
                                            </b-button>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>

                </b-form>
              </div>
            </b-card-text>
          </b-card>
            <b-card>
                <b-row>
                    <b-col>
                        <b-card title="User Wise IP List">
                            <template>
                                <div class="content-wrapper">
                                    <div class="content-body">
                                        <Datatable v-bind:fields="fields"
                                                   v-bind:items="items" v-bind:totalList="totalRowsList" v-bind:perPage="perPage">
                                            <template v-slot:actions="{ rows }">
                                                <!--b-link ml="4" class="text-primary"
                                                        @click="editRow(rows.item.user_id)">
                                                    <i class="bx bx-edit cursor-pointer"></i>
                                                </b-link-->
                                                <b-link class="text-danger" @click="deleteRow(rows.item.user_id,rows.item.allowed_ip)">
                                                    <i class="bx bx-trash cursor-pointer"></i>
                                                </b-link>
                                            </template>
                                        </Datatable>
                                    </div>
                                </div>
                            </template>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import Datatable from '../../../layouts/common/datatable';
import ApiRepository from "../../../Repository/ApiRepository";
export default {
  components: {Datatable},
    props: ['id'],
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Administration" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "System Admin" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "User Ip Assign" });
    this.loadData();
  },
  data() {
    return {

        UserIpAssign: {
            user_id : null,
            emp_id : null,
        },
      show: true,
      updateIndex: -1,
      totalRowsList: 0,
      submitBtn: "Save",
        fields: [{key: 'allowed_ip', label: ' IP Address', sortable: true},, {key: 'active_yn', label: ' Status', sortable: true}, 'action'],
        items: [],
        department_name:{},
        designation_name:{},
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
    methods: {
        onSubmit(evt) {
            evt.preventDefault();
            ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/system-admin/user-ip-assign", this.UserIpAssign).then(res => {
               this.loadData();
               // this.onReset();
            });
        },
        loadData: function () {
            //let url = ((this.id !== undefined) && (this.id > 0)) ?  `/pmis/employee/academics/specific/${this.id}` : '/admin/system-admin/user-ip-assign';
            ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/system-admin/getAssignUserData/${this.id}`).then(res => {
                 this.items = res.data.ipList;
                 this.totalRowsList = res.data.ipList.length;
                 this.UserIpAssign.user_id = res.data.user.user_id ? res.data.user.user_id : '';
                 this.UserIpAssign.emp_id = res.data.user.employee.emp_id ? res.data.user.employee.emp_id : '';
                 this.UserIpAssign.emp_name = res.data.user.employee.emp_name ? res.data.user.employee.emp_name : '';
                 this.UserIpAssign.department_name = res.data.user.employee.department.department_name ? res.data.user.employee.department.department_name : '';
                 this.UserIpAssign.designation_name = res.data.user.employee.designation.designation ? res.data.user.employee.designation.designation : '';
            });

        },

        /*editRow(id) {
            alert(id);
            this.updateIndex = id;
            ApiRepository.callApi(ApiRepository.GET_COMMAND,`/pmis/employee/addresses/${id}`).then(result => {
                this.submitBtn = 'Update';
                this.address = result.data;
            });

        },*/
        deleteRow(id,ip) {
            if (id > -1) {
                if(confirm("Do you really want to delete?")){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/system-admin/user-ip-assign/${id}/${ip}`).then( result => {
                        this.loadData();
                    });
                }
            }
        }
    }
};
</script>
