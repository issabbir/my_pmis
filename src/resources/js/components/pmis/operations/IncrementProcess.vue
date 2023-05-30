<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card v-if="hasPermission('CAN_OPERATIONS_CREATE')==true">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Operation Increment Add
                </b-card-header>
                <b-card-body class="border">
                    <b-form
                        @submit.prevent="onSubmit"
                        @reset.prevent="onReset"
                        v-if="show"
                        class="form form-vertical col-md-12 ">
                        <b-row>
                            <b-col sm="3">
                                <b-form-group label="EMPLOYEE CODE" label-for="empCode">
                                    <v-select
                                        :disbled="disabled"
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmpCode"
                                        @change="increment.department_id = selectedEmployee.dpt_department_id"
                                        id="emp_code">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="EMPLOYEE NAME" label-for="empName">
                                    <b-form-input
                                        id="empName"
                                        v-model="increment.emp_name"
                                        required
                                        readonly
                                        placeholder="Employee Name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="Department Name" label-for="department_name" class="requiredField">
                                    <b-form-select
                                        id="department_name"
                                        v-model="increment.department_id"
                                        :options="departmentList"
                                        value-field="department_id"
                                        text-field="department_name"
                                        required
                                        placeholder="Department"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button-group>
                                    <b-button type="submit" variant="primary">Add</b-button>
                                    <b-button type="reset" variant="secondary">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Selected Employee For Increment
                    <b-button size="sm" @click="delData" variant="success" class="float-right">Clear</b-button>
                </b-card-header>
                <b-card-body class="border">
                    <b-form
                        @submit.prevent="onProcess"
                        class="form form-vertical col-md-12 ">
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
                                <b-button type="submit" variant="primary">Process</b-button>
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
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from '../../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';

    export default {
        name: "increment-process",
        components: {DatePicker, Datatable, vSelect, vcss},
        data(){
            return{
                perPage: 15,
                totalList: 1,
                selectedEmployee: [],
                empIdList: [],
                departmentList: [],
                disabled: false,
                datetime: new Date(),
                departmentOptions: [],
                searchParam: '',
                submitBtn: 'Save',
                increment: {
                    emp_id: "",
                    emp_name: "",
                    department_id: null,
                },
                show: true,
                tableData: {
                    fields: [
                        {key: 'sl', label: 'Sl', sortable: true},
                        {key: 'emp_code', label: 'Employee Code', sortable: true},
                        {key: 'emp_name', label: 'Employee Name', sortable: true},
                        {key: 'designation', label: 'Designation', sortable: true},
                        {key: 'department_name', label: 'Department Name', sortable: true},
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
            this.delData();
            this.fetchData();

         },
        computed:{

        },
        watch:{
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.increment.emp_id = val.emp_id;
                    this.increment.emp_code = val.emp_code;
                    this.increment.emp_name = val.emp_name;
                    this.increment.department_id = val.dpt_department_id;
                }
            }
        },
        methods: {
            onSubmit() {
                let data = this.increment;
                if (data.increment_id != null) {
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/operation/increment-tmp/add/${data.increment_id}`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/increment-tmp/add`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
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
                            this.fetchData();
                            this.tableData.items = currObj.tableData.items;
                            this.totalList = currObj.tableData.items.length;
                        } else {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    })
                }
            },
            changeStatus(item) {
                let currObj = this;
                let id = item.increment_temp_id;
                let holdYN = (item.hold_yn == 'Y')?'N':'Y';
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/operation/increment-tmp/pause/'+id+'/'+holdYN).then(res => {
                    if (res.data.o_status_code == 1) {
                        item.hold_yn = holdYN;
                    } else {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
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
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/increment-tmp/process`, this.tableData.items).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            //this.fetchData();
                            this.onReset();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
            },
            onReset() {
                this.selectedEmployee = {emp_id:null};
                this.tour={};
                this.tableData.items = []
                this.totalList = 1
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
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/increment/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                        console.log(res.data);
                    })
                }
            },
            fetchData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/increment-tmp/get`).then(result => {
                    this.tableData.items = result.data.data
                    this.totalList = result.data.data.length
                    this.departmentList = result.data.departments
                }).catch(err => {
                    console.log('error');
                });
            },
            delData() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/increment-tmp/del`).then(result => {
                    this.tableData.items = []
                    this.totalList = 1
                }).catch(err => {
                    console.log('error');
                });
            },
            // getFormData: function () {
            //     ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/tours/form-data').then(res => {
            //         this.countries = res.data.countries;
            //     });
            // },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
        }
    }
</script>

<style scoped>
.bx{
    font-size: 2.2rem;
}
</style>
