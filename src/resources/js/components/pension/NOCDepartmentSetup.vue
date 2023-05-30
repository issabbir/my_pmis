<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">NOC Department Setup</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="3">
                                <b-form-group label="NOC Department" label-for="department_id" class="required">
                                    <b-form-select
                                        v-model="formData.noc_department"
                                        required
                                        :options="departmentOptions"
                                        id="department_id"
                                        @input="loadSections(formData.noc_department)"
                                        value-field="noc_department"
                                        text-field="department_name"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="NOC Section" label-for="section_id" >
                                    <b-form-select
                                        v-model="formData.section_id"
                                        :options="sectionList"
                                        id="section_id"
                                        value-field="value"
                                        text-field="text"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3" :style="'pointer-events:'+ ($store.getters.user.user_name != 'admin' ?'none':'')">
                                <b-form-group label="Employee Department" label-for="emp_department_id" class="required">
                                    <b-form-select
                                        v-model="formData.emp_department_id"
                                        required
                                        :options="employeeDepartmentOptions"
                                        id="emp_department_id"
                                        value-field="noc_department"
                                        text-field="department_name"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Status" label-for="active" >
                                    <b-form-radio v-model="formData.active_yn" value="Y" id="active" name="status">Active</b-form-radio>
                                    <b-form-radio v-model="formData.active_yn" value="N" id="inactive" name="status">Inactive</b-form-radio>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12" class="text-right">
                                <b-button-group>
                                    <b-button type="submit" variant="success" >{{submitButton}}</b-button>
                                    <b-button type="reset" variant="secondary">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Department List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="groupField" :totalList="totalList" :perPage="perPage" v-bind:items="items">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="btn btn-primary btn-sm"
                                    @click="view(rows.item)">
                                Details
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <b-modal ref="detail_modal" size="xl" :title="detailItems.length > 0?detailItems[0].emp_department_name:''" @ok="onUpdate" @cancel="edit_id = null" @close="edit_id = 0">
                <Datatable v-bind:fields="fields" :totalList="detailTotalList" :perPage="perPage" v-bind:items="detailItems">
                    <template v-slot:action2="{ rows }">
                        <template v-if="rows.item.ackment_setup_id != edit_id">{{ rows.item.active_yn == 'Y'?'Active':'Inactive' }}</template>
                        <b-form-select v-else v-model="rows.item.active_yn" :options="booleanOptions"></b-form-select>
                    </template>
                    <template v-slot:actions="{ rows }">
                         <b-link ml="4" class="text-primary" @click="edit_id = rows.item.ackment_setup_id"><i class="bx bx-edit cursor-pointer"></i></b-link>
                         <b-link ml="4" class="text-danger" @click="deleteRow(rows.item)"><i class="bx bx-trash cursor-pointer"></i></b-link>
                    </template>
                </Datatable>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import groupBy from "lodash/groupBy"
    export default {
        components: {Datatable,Vue},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "NOC Department Setup"});
            this.loadData();
        },
        data() {
            return {
                booleanOptions: [
                    {text: 'Active', value: 'Y'},
                    {text: 'Inactive', value: 'N'}
                ],
                edit_id: null,
                formData: {
                    noc_department:'',
                    section_id: '',
                    active_yn:'Y',
                    emp_department_id: ''
                },
                departmentOptions:[],
                employeeDepartmentOptions: [],
                sectionList: [],
                submitButton:'Submit',
                perPage:5,
                totalList:0,
                detailTotalList:0,
                groupField: [
                    {key: 'index', label: 'SL', class:'text-center'},
                    {key: 'emp_department_name', label: 'Department Name'},
                    {key: 'action', label: 'Action', class: 'text-center'}
                ],
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'department_name', label: 'NOC Department', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'dpt_section', label: 'NOC Section', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'action2', label: 'Status', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'action', label: 'Action', class: 'text-center'}
                ],
                items: [],
                detailItems: []
            }
        },
        methods: {
            onUpdate(){
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, "/pension/update-noc-setup", this.detailItems).then(res => {
                    if (res.data == 1) {
                        this.$notify({group: 'pmis', text: 'Status updated successfully', type: 'success'});
                        this.edit_id = null
                        this.loadData();
                        this.onReset();
                    } else {
                        this.$notify({group: 'pmis', text: 'Status update unsuccessful', type: 'error'})
                    }
                });
            },
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/store-noc-setup", this.formData).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadData();
                        this.onReset();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
            },
            view(item){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/get-noc-detail-data/'+item.emp_department_id).then(res => {
                    this.detailItems = res.data
                    this.detailTotalList = this.detailItems.length;
                    this.$refs['detail_modal'].show()
                })
            },
            editRow(item){
                this.formData=item;
                this.formData.noc_department = item.noc_department;
                this.submitButton = 'Update';
            },
            deleteRow(item){
                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                }).then(value => {
                    if(value == true) {
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/pension/delete-noc', item).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                this.loadData();
                                this.$refs['detail_modal'].hide()
                                this.onReset();
                            } else {
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                            }
                        });
                    }
                }).catch(err => {

                })
            },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/get-department-search-data').then(res => {
                    this.departmentOptions = res.data;
                    if(this.$store.getters.user.user_name == 'admin'){
                        this.employeeDepartmentOptions = res.data
                    }else{
                        this.employeeDepartmentOptions = res.data.filter(a=>a.noc_department == this.$store.getters.user.department_id)
                        this.formData.emp_department_id = this.$store.getters.user.department_id

                    }
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/get-noc-data').then(res => {
                    this.items = res.data
                    this.totalList = this.items.length;
                });
            },
            loadSections(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/sections/${id}`).then(result => {
                    this.sectionList = result.data;
                });
            },
            onReset() {
                this.$nextTick(() => {
                    this.formData.noc_department = null;
                    this.formData.active_yn = 'Y';
                    this.submitButton = 'Submit';
                });
            },
        }
    }
</script>

<style scoped>

</style>
