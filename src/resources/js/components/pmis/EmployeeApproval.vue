<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pending Employees For Approval</b-card-header>
                <b-card-body class="border">
                    <b-form
                        @submit.prevent="showConfirmBox"
                        class="form form-vertical col-md-12 ">
                        <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :perPage="perPage" :totalList="totalList">
                            <template v-slot:actions="{ rows }">
                                <a  @click="changeStatus(rows.item)">
                                    <i v-if="rows.item.emp_hold_yn == 'N'" title="Keep process"  class='text-success bx bxs-checkbox-checked' ></i>
                                    <i class='bx bxs-checkbox text-danger' title="Hold" v-else ></i>
                                </a>
                            </template>
                            <template v-slot:action2="{ rows }">
                                <a href="javascript:void(0)"   @click="showModal(rows.item)">
                                    {{rows.item.emp_code}}
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
        <b-modal ref="comparison-modal" size="lg" hide-footer  title="Changes Information">
                <b-row>
                    <b-col md="12">
                         <table class="table table-bordered">
                             <tr>
                                 <th>LABEL</th>
                                 <th>PREVIOUS VALUE</th>
                                 <th>CURRENT VALUE</th>
                             </tr>
                             <tr v-for="(previousValue, index) in previous_changes">
                                 <td>{{emp_label[index]}}</td>
                                 <td>
                                     <img style="width:50px" v-if="emp_label[index] == 'EMPLOYEE PHOTO'" :src="previousValue" alt="">
                                     <p v-else>{{previousValue}}</p>
                                 </td>
                                 <td class="current_changes">
                                     <img  style="width:50px" v-if="emp_label[index] == 'EMPLOYEE PHOTO'" :src="current_changes[index]" alt="">
                                     <p v-else>{{current_changes[index]}}</p>
                                 </td>
                             </tr>

                         </table>
                    </b-col>
                    <b-col md="12" class="d-flex justify-content-end">
                        <b-button-group>
                            <b-button type="button" @click="singleApproveEmployee(empData)" variant="primary">Approve</b-button>
                        </b-button-group>
                    </b-col>
                </b-row>
        </b-modal>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from "../../layouts/common/datatable"
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';

    export default {
        name: "employee-approval",
        components: {DatePicker, Datatable, vSelect, vcss},
        data(){
            return{
                perPage: 15,
                totalList: 1,
                selectedEmployee: [],
                empData: [],
                empIdList: [],
                departmentList: [],
                disabled: false,
                datetime: new Date(),
                departmentOptions: [],
                searchParam: '',
                submitBtn: 'Save',
                current_changes: [],
                previous_changes: [],
                emp_label: [],
                formData: {
                    emp_id: "",
                    emp_code: "",
                    emp_name: "",
                    department_id: null,

                },
                show: true,
                tableData: {
                    fields: [
                        {key: 'index', label: 'Sl', sortable: true},
                        {key: 'action2', label: 'EMP Code', sortable: true},
                        {key: 'emp_name', label: 'Employee Name', sortable: true},
                        {key: 'designation', label: 'Designation', sortable: true},
                        {key: 'department_name', label: 'Department Name', sortable: true},
                        {key: 'last_updated_by', label: 'Last Updated By', sortable: true},
                        {key: 'modify_date', label: 'Modification Date', sortable: true, class:'text-right'},
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
            this.loadEmployees()
        },
        computed:{

        },
        watch:{
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.formData.emp_id = val.emp_id;
                    this.formData.emp_code = val.emp_code;
                    this.formData.emp_name = val.emp_name;
                    this.formData.department_id = val.dpt_department_id;
                }
            }
        },
        methods: {
            showModal(item) {
                this.$refs['comparison-modal'].show()
                this.comparisonEmployeeUpdate(item);
            },
            closeModal(item) {
                this.$refs['comparison-modal'].hide()
            },
            onSubmit() {
                let data = this.formData;
                if (data.increment_id != null) {
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/operation/increment-tmp/add/${data.increment_id}`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadEmployees();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/increment-tmp/add`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadEmployees();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }
            },
            deleteRow(tour_id, index) {
                let currObj = this;
                if (confirm("Do you really want to delete?")) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/operation/tours/${tour_id}`).then(res => {
                        if (res.data.o_status_code == 1) {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            currObj.tableData.items.splice(index, 1);
                            this.loadEmployees();
                            this.tableData.items = currObj.tableData.items;
                            this.totalList = currObj.tableData.items.length;
                        } else {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    })
                }
            },
            changeStatus(item) {
                let status = item.emp_hold_yn=='Y'?'N':'Y'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/pmis/update-employee-hold-yn/'+item.emp_id+'/'+status).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.loadEmployees()
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
            },
            comparisonEmployeeUpdate(item) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/comparison-employee-update/' + item.emp_id).then(res => {
                        this.current_changes = res.data.current_changes;
                        this.previous_changes = res.data.previous_changes;
                        this.emp_label = res.data.emp_label;
                        this.empData = item;
                });
            },
            setEmployee: function (item) {
                this.selectedEmployee = {
                    emp_id: item.emp_id,
                    option_name: item.emp_code + ' ' + item.emp_name,
                    designation: item.designation,
                    department_name: item.department_name,
                    basic_amt: item.basic_from,
                    emp_code: item.emp_code,
                    emp_name: item.emp_name,
                    department_id: item.department_id,
                    dpt_department_id:item.dpt_department_id,
                    designation_id: item.designation_id,
                }
            },
            renderModal(item) {
                this.setEmployee(item)
                this.tour.tour_id = item.tour_id;
                this.tour.approve_note = item.approve_note;
            },
            onProcess() {
                let obj = {};
                obj.items = this.tableData.items.filter( i => {
                    return i.emp_hold_yn == 'N';
                });
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/approve-employee`,obj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadEmployees();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            singleApproveEmployee(obj) {
                 if (obj){
                     this.changeStatus(obj);
                 }
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/approve-employee-single`,obj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadEmployees();
                        this.$refs['comparison-modal'].hide();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.selectedEmployee = {emp_id:null};
                this.tour={};
                this.submitBtn = 'Save';
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`;
                this.infoModal.content = JSON.stringify(item, null, 2);
                this.$root.$emit("bv::show::modal", this.infoModal.id, button);
            },
            resetInfoModal() {
                this.infoModal.title = "";
                this.infoModal.content = "";
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
            loadEmployees() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/unapproved-employees`).then(res => {
                    this.tableData.items = res.data
                    this.totalList = res.data.length
                })
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            showConfirmBox() {

                this.$bvModal.msgBoxConfirm('Please confirm that you want to approve the employees.', {
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
    .current_changes{
        background-color: #23bd7036;
    }
    .table tr th:nth-child(3){
        background-color: #13b96675;
    }
</style>
