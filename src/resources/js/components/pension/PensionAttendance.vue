<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Attendance</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="3">
                                <b-form-group label="Employee" label-for="emp_code" class="requiredField">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="employeeList"
                                        @search="searchEmployee"
                                        required
                                        id="emp_code"
                                        name="emp_code"
                                    >
                                        <template #selected-option="{ option_name }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ option_name }}
                                            </div>
                                        </template>
                                        <template #search="{attributes, events}">
                                            <input
                                                class="vs__search"
                                                :required="!formData.emp_id"
                                                v-bind="attributes"
                                                v-on="events"
                                            />
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3" v-if="isDead == true">
                                <b-form-group label="Nominee" label-for="nominee_name" class="requiredField">
                                    <v-select
                                    label="nominee_name"
                                    v-model="formData.nominee_id"
                                    :options="nomineeList"
                                    :reduce="nominee => nominee.nominee_id"
                                    required
                                    id="nominee_name"
                                    name="nominee_name"
                                    >
                                        <template #selected-option="{ nominee_name }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ nominee_name }}
                                            </div>
                                        </template>
                                        <template #search="{attributes, events}">
                                            <input
                                                class="vs__search"
                                                :required="!formData.nominee_id"
                                                v-bind="attributes"
                                                v-on="events"
                                            />
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Attendance Date" label-for="attendance_date" class="requiredField">
                                    <date-picker v-model="formData.attendance_date"
                                                 width="100%"
                                                 input-class="form-control"
                                                 type="date" lang="en"  required
                                                 format="DD-MM-YYYY" :value-type="valueType"
                                                 :input-attr="{required:true}"
                                                 id="attendance_date"
                                                 name="attendance_date">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="3" style="display: none">
                                <b-form-group
                                    label="Approval Status"
                                    label-for="approve_status"
                                    class="requiredField"
                                >
                                    <b-form-radio-group
                                        id="approve_status"
                                        v-model="formData.approve_status"
                                        :options="approveStatusOptions"
                                        name="approve_status"
                                        required
                                    >
                                    </b-form-radio-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Remarks"
                                    label-for="remarks"
                                >
                                    <b-form-textarea
                                        id="remarks"
                                        v-model="formData.remarks"
                                    ></b-form-textarea>
                                </b-form-group>
                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button variant="primary" type="submit" v-html="submitButton" class="mr-1"></b-button>
                                <b-button type="reset" >Reset</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Attendance List</b-card-header>
                <b-card-body class="border">
                    <Datatable :fields="fields" :totalList="totalList" :perPage="perPage" :items="items">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary" @click="editRow(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                            <!--<b-link ml="4" class="text-primary"
                                    @click="deleteRow(rows.item)">
                                <i class="bx bx-trash cursor-pointer"></i>
                            </b-link>-->
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from "moment";
    export default {
        name: "pension-attendance",
        components: {DatePicker, Datatable, vSelect, vcss},
        data() {
            return {
                selectedEmployee: {
                    emp_id: '',
                    emp_name: '',
                    emp_status: '',
                    option_name: ''
                },
                submitButton: 'Save',
                isDead:'',
                formData: {
                    emp_id: '',
                    attendance_id: '',
                    nominee_id: '',
                    remarks: '',
                    approve_status: 1,
                    attendance_date: moment(new Date()).format("YYYY-MM-DD")
                },
                employeeList: [],
                nomineeList: [],
                approveStatusOptions: [
                    { text: 'Pending', value: 0 },
                    { text: 'Approved', value: 1 },
                    { text: 'Rejected', value: -1 }
                ],
                valueType: this.dateFormatter(),
                items: [],
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'nominee_name', label: 'Nominee Name', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {
                        key: 'attendance_date',
                        label: 'Attendance Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-left'
                    },
                    {
                        key: 'approve_status',
                        label: 'Approve Status',
                        formatter: value => {
                            if(value == 0) {
                                return 'Pending'
                            } else if(value == -1) {
                                return  'Rejected'
                            } else if(value == 1) {
                                return 'Approved'
                            } else {
                                return ''
                            }
                        },
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-left'},
                    {key: 'action', label: 'Actions', class: 'text-center'}
                ],
                totalList: '',
                perPage: 5
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                this.formData.emp_id = val.emp_id;
                this.formData.emp_name = val.emp_name
                this.formData.emp_status = val.emp_status
                this.formData.option_name = val.option_name
                this.formData.nominee_name = ""
                this.formData.nominee_id = ''
                if (this.formData.emp_status == 'D')
                {
                    this.isDead = true
                    this.loadNominee(val.emp_id)
                } else {
                    this.isDead = false
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension Attendance"});
            this.loadTable()
        },
        methods: {
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/pension-attendance`, this.formData).then(response => {
                    if (response.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: response.data.o_status_message, type: 'success'})
                        this.formData = {}
                        this.selectedEmployee = {}
                        this.onReset()
                        this.loadTable()
                    } else {
                        this.$notify({group: 'pmis', text: response.data.o_status_message, type: 'error'})
                    }
                })
            },
            editRow(item){
                this.formData = item
                this.selectedEmployee = item

                this.submitButton = 'Update'
            },
            onReset() {
                this.formData = {}
                this.formData.approve_status = 0
                this.submitButton = 'Save'
                this.isDead = ''
            },
            loadTable() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/pension-attendance`, this.formData).then(response => {
                    if (response.data){
                        this.items = response.data
                        this.totalList = response.data.length
                    }
                })
            },
            searchEmployee(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/employee-search/${id}`).then(response => {
                        this.employeeList = response.data
                    })
                }
            },
            loadNominee(id){
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/pension-nominee/${id}`).then(response => {
                        this.nomineeList = response.data
                    })
                }
            },
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
