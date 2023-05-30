<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Contact Search </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="loadContacts">
                        <b-row>
                            <b-col md="6">
                                <b-form-group label="Employee Code" label-for="emp_code" label-cols-md="4" class="requiredField">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmpCode"
                                        id="emp_code">
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">
                                    <i class="bxs bxs-search-alt"></i> Search</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pending Contact For Approval</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="showConfirmBox" class="form form-vertical col-md-12 ">
                        <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :perPage="perPage" :totalList="totalList">
                            <template v-slot:actions="{ rows }">
                                <a  @click="changeStatus(rows.item)">
                                    <i v-if="rows.item.hold_yn == 'N'" title="Keep process"  class='text-success bx bxs-checkbox-checked' ></i>
                                    <i class='bx bxs-checkbox text-danger' title="Hold" v-else ></i>
                                </a>
                            </template>
                        </Datatable>
                        <b-row class="mt-4">
                            <b-col class="d-flex justify-content-end">
                                <b-button-group>
                                    <b-button type="submit" variant="primary">Approve</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from "../../../layouts/common/datatable"
    import ApiRepository from '../../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    export default {
        name: "ContactApproval",
        components: {DatePicker, Datatable, vSelect, vcss},
        data(){
            return{
                perPage: 15,
                totalList: 1,
                selectedEmployee: {emp_id: ''},
                empIdList: [],
                formData: {
                    emp_id: ""
                },
                tableData: {
                    fields: [
                        {key: 'index', label: 'Sl', sortable: true},
                        {key: 'emp_code', label: 'Employee Code', sortable: true},
                        {key: 'emp_name', label: 'Employee Name', sortable: true},
                        {key: 'emp_contact_type', label: 'Contact Type', sortable: true},
                        {key: 'emp_contact_info', label: 'Contact Info', sortable: true},
                        {key: 'last_updated_by', label: 'Last Updated By', sortable: true},
                        'action'],
                    items: []
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Operations"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Operations Process"});
            this.loadContacts()
        },
        watch:{
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.formData.emp_id = val.emp_id
                }
            }
        },
        methods: {
            changeStatus(item) {
                let status = item.hold_yn=='Y'?'N':'Y'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/pmis/update-contact-temp/'+item.emp_contacts_id+'/'+status).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.loadContacts()
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/contacts/${item.emp_contact_id}`).then(res => {
                    this.detailFormData.photo = res.data.photo
                    this.detailFormData.auth_attachment = res.data.auth_attachment
                })

                this.$refs['detail_modal'].show()
            },

            // all employee section here


            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            onProcess() {
                let obj = {};
                obj.items = this.tableData.items.filter( i => {
                    return i.hold_yn == 'N';
                });
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/employee/approve-contacts`, obj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadContacts();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.selectedEmployee = {emp_id:''};
                this.$nextTick(() => {
                });
            },
            loadContacts() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/unapproved-contact-list`, this.formData).then(res => {
                    this.tableData.items = res.data
                    this.totalList = res.data.length
                })
            },
            showConfirmBox() {

                this.$bvModal.msgBoxConfirm('Please confirm that you want to approve the contacts.', {
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
                    if(value == true){
                        this.onProcess()
                    }
                })
                    .catch(err => {
                    })
            }
        }
    }
</script>

<style scoped>
    .bx{
        font-size: 2.2rem;
    }
</style>
