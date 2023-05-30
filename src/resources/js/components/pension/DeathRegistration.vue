<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Death Registration</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="4">
                                <b-form-group label="Employee Code" label-for="emp_code" class="requiredField">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="employeeList"
                                        @search="searchEmployee"
                                        required
                                        id="emp_code">
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
                            <b-col md="4">
                                <b-form-group
                                    label="Date of Death"
                                    label-for="death_date"
                                    class="requiredField"
                                >
                                    <date-picker v-model="formData.death_date"
                                                 width="100%"
                                                 input-class="form-control"
                                                 type="date" lang="en"  required
                                                 :not-before="notBeforeJoiningDate()"
                                                 format="DD-MM-YYYY" :value-type="valueType"
                                                 :input-attr="{required:true}"
                                                 id="death_date"
                                                 name="death_date">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Death Nature"
                                    label-for="death_nature"
                                    class="requiredField"
                                >
                                    <b-form-select
                                        id="death_nature"
                                        v-model="formData.death_nature"
                                        value-field="pass_value"
                                        text-field="show_value"
                                        required
                                        :options="deathNatureOptions"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Informer Name"
                                    label-for="informer_name"
                                >
                                    <b-form-input
                                        id="informer_name"
                                        v-model="formData.informer_name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Documents"
                                    label-for="attachment"
                                >
                                    <b-form-file @change="encodeFile" ref="fileupload"
                                                 id="attachment"
                                                 placeholder="Attachment"
                                    ></b-form-file>
                                </b-form-group>
                            </b-col>
                            <b-col md="4" style="display: none">
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
                                <b-button type="submit" variant="primary" class="mr-1">{{submitButton}}</b-button>
                                <b-button type="reset" >Reset</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Death Registration List</b-card-header>
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
        name: "DeathRegistration",
        components: {Datatable, vSelect, vcss, DatePicker},
        data() {
            return {
                selectedEmployee: {},
                submitButton: 'Save',
                formData: {
                    register_id: '',
                    emp_id: '',
                    death_date: '',
                    death_nature: '1',
                    informer_name: '',
                    attachment: '',
                    attachment_type: '',
                    attachment_file_name: '',
                    remarks: '',
                    approve_status: 0,
                    emp_join_date:''
                },
                employeeList: [],
                valueType: this.dateFormatter(),
                deathNatureOptions: [],
                approveStatusOptions: [
                    { text: 'Pending', value: 0 },
                    { text: 'Approved', value: 1 },
                    { text: 'Rejected', value: -1 }
                ],
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'emp_code', label: 'Employee Code', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {
                        key: 'death_date',
                        label: 'Date of Death',
                        sortable: true,
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortDirection: 'desc',
                        class: 'text-left'},
                    {key: 'informer_name', label: 'Informer Name', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {
                        key: 'approve_status',
                        label: 'Approve Status',
                        sortable: true,
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
                        sortDirection: 'desc',
                        class: 'text-left'
                    },
                    {key: 'action', label: 'Action', class: 'text-center'}
                ],
                items: [],
                totalList: '',
                perPage: 5
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Death Register"});
            this.loadTable()
            this.deathNature()
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                this.formData.emp_id = val.emp_id;
                this.formData.emp_name = val.emp_name
                this.formData.option_name = val.option_name
                this.formData.emp_join_date = val.emp_join_date
            }
        },
        methods:{
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/death-registration`, this.formData).then(response => {
                    if (response.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: response.data.o_status_message, type: 'success'});
                        this.formData = {}
                        this.selectedEmployee = {}
                        this.loadTable()
                        this.onReset()
                    } else {
                        this.$notify({group: 'pmis', text: response.data.o_status_message, type: 'error'});
                    }
                })
            },
            onReset() {
                this.formData = {}
                this.submitButton = 'Save'
                this.formData.approve_status = 0
                this.selectedEmployee = '';
                this.$refs.fileupload.value=null

            },
            loadTable() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/death-registration-list`, this.formData).then(response => {
                    if (response.data){
                        this.items = response.data
                        this.totalList = response.data.length
                    }
                })
            },
            editRow(item){
                this.formData = item
                this.selectedEmployee = item
                this.submitButton = 'Update'
            },
            deleteRow(item){

            },
            notBeforeJoiningDate() {
                if(this.formData.emp_join_date) {
                    return moment(this.formData.emp_join_date, 'DD-MM-YYYY');
                }
            },
            searchEmployee(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/employee-for-death-registration/${id}`).then(response => {
                        this.employeeList = response.data.filter(a=>a.emp_status !== 'D');
                    })
                }
            },
            deathNature(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/death-nature`, this.formData).then(response => {
                    this.deathNatureOptions = response.data;
                })
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
            },
            encodeFile(e){
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        vm.formData.attachment_type = file.type;
                        vm.formData.attachment_file_name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.formData.attachment = reader.result;
                            console.log(vm.formData)
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }
            }
        }
    }
</script>

<style scoped>

</style>
