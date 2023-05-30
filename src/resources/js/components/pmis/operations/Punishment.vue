<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card v-if="hasPermission('CAN_OPERATIONS_CREATE')==true">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Punishment Information
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show" class="form form-vertical col-md-12">
                        <b-row>
                            <b-col sm="4" class="mt-1">
                                <b-form-group label="PUNISHMENT TYPE" label-for="punishmentType" class="requiredField">
                                    <b-form-select
                                        id="punishmentType"
                                        v-model="punishment.punishment_type_id"
                                        :options="typeList"
                                        value-field="passing_value"
                                        text-field="show_velue"
                                        required
                                        :disabled="punishment.punishment_id>0?true:false"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4" class="mt-1">
                                <b-form-group label="EMPLOYEE CODE" label-for="empCode" class="requiredField">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        :disabled="punishment.punishment_id>0?true:false"
                                        @search="searchEmpCode"
                                        id="emp_code">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events" :required="selectedEmployee && !selectedEmployee.emp_id "/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4" class="mt-1">
                                <b-form-group label="EMPLOYEE NAME" label-for="empName">
                                    <b-form-input
                                        id="empName"
                                        v-model="punishment.emp_name"
                                        required
                                        readonly
                                        placeholder="Emp Name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row >
                            <b-col :md="punishment.punishment_type_id==4 || punishment.punishment_type_id==2?12:6" :style="punishment.process_yn=='Y'?'pointer-events:none':''">
                                <fieldset class="border pr-2 pl-2">
                                    <legend class="w-auto">Punishment Start Order</legend>
                                    <b-row class="">
                                        <b-col :md="punishment.punishment_type_id==4 || punishment.punishment_type_id==2?4:6" class="mt-1">
                                            <b-form-group label="OFFICE ORDER NUMBER" label-for="goNo" class="requiredField">
                                                <b-form-input
                                                    id="goNo"
                                                    v-model="punishment.order_ref_number"
                                                    required
                                                    placeholder="Office Order Number"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col :md="punishment.punishment_type_id==4 || punishment.punishment_type_id==2?4:6" class="mt-1">
                                            <b-form-group label="OFFICE ORDER DATE" label-for="goDate" class="requiredField">
                                                <date-picker
                                                    v-model="punishment.order_date"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :editable="false"
                                                    :value-type="valueType"
                                                    width="100%"
                                                    input-class="form-control"
                                                ></date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col :md="punishment.punishment_type_id==4 || punishment.punishment_type_id==2?4:6" class="mt-1">
                                            <b-form-group :label="punishment.punishment_type_id==4?'Terminate Date':punishment.punishment_type_id==2?'Warning Date':'Start Date'" label-for="startDate" class="requiredField">
                                                <date-picker
                                                    v-model="punishment.start_date"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :editable="false"
                                                    :value-type="valueType"
                                                    width="100%"
                                                    input-class="form-control"
                                                ></date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col :md="punishment.punishment_type_id==4 || punishment.punishment_type_id==2?6:6" class="mt-1">
                                            <b-form-group label="Attachment" label-for="attachment" class="message">
                                                <b-form-file
                                                    @change="encodeFile"
                                                    id="attachment"
                                                    placeholder="Attachment"
                                                ></b-form-file>
                                            </b-form-group>
                                        </b-col>
                                        <b-col :md="punishment.punishment_type_id==4 || punishment.punishment_type_id==2?6:12" class="mt-1">
                                            <b-form-group label="Description" label-for="note">
                                                <b-form-textarea
                                                    id="note"
                                                    rows="1"
                                                    v-model="punishment.note">
                                                </b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>

                            </b-col>
<!--                            <b-col md="6" v-if="punishment.punishment_type_id!=4 && punishment.punishment_type_id!=2" :style="punishment.process_yn=='Y'?'pointer-events:none':''">-->
                            <b-col md="6" v-if="punishment.punishment_type_id!=4 && punishment.punishment_type_id!=2">
                                <fieldset class="border pr-2 pl-2">
                                    <legend class="w-auto">Punishment End Order</legend>
                                    <b-row>
                                        <b-col sm="6" class="mt-1">
                                            <b-form-group label="OFFICE ORDER NUMBER" label-for="goNo">
                                                <b-form-input
                                                    id="goNo"
                                                    v-model="punishment.end_order_ref_no"
                                                    placeholder="Office Order Number"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col sm="6" class="mt-1">
                                            <b-form-group label="OFFICE ORDER DATE" label-for="goDate">
                                                <date-picker
                                                    v-model="punishment.end_order_date"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :editable="false"
                                                    :value-type="valueType"
                                                    width="100%"
                                                    input-class="form-control"
                                                ></date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6"  class="mt-1">
                                            <b-form-group label="END DATE" label-for="startDate">
                                                <date-picker
                                                    v-model="punishment.end_date"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    width="100%"
                                                    input-class="form-control"
                                                ></date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6" class="mt-1">
                                            <b-form-group label="Attachment" label-for="attachment" class="message">
                                                <b-form-file
                                                    @change="encodeFileEnd"
                                                    id="attachment"
                                                    placeholder="Attachment"
                                                ></b-form-file>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="12" class="mt-1">
                                            <b-form-group label="Description" label-for="note">
                                                <b-form-textarea
                                                    id="note"
                                                    rows="1"
                                                    v-model="punishment.end_note">
                                                </b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class=" d-flex justify-content-end">
                                <b-button-group>
                                    <b-button class="mt-2" type="submit" variant="primary">{{submitBtn}}</b-button>
                                    <b-button class="mt-2" type="reset" variant="secondary">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Punishment List</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col sm="4">
                            <b-form-group label="Department Name" label-cols-md="4" label-for="toDeptName">
                                <v-select v-model="selectedDepartment" :options="departmentOptions" value="department_id"
                                          label="department_name" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col sm="4">
                            <b-form-group label="Approval Status" label-cols-md="4" label-for="process_yn">
                                <v-select v-model="approvalProcess" :options="approveOptions" value="approve_status"
                                          label="approve_status_name" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col>
                            <div class="pr-0 d-flex justify-content-start">
                                <b-button-group>
                                    <b-button type="button" @click="searchByDepartment()" variant="primary"><i
                                        class='bx bx-search'></i>Search
                                    </b-button>
                                    <b-button type="button" @click="clear()" variant="secondary">Reset</b-button>
                                </b-button-group>
                            </div>
                        </b-col>

                    </b-row>
                    <Datatable
                      :fields="tableData.fields"
                      :items="tableData.items"
                      :perPage="perPage"
                      :totalList="totalList"
                      :filter-ignored-fields="filterIgnoredFields"
                    >
                        <template v-slot:actions="{ rows }">
<!--                            <a  size="sm" v-if="rows.item.process_yn == 'N'" :disabled="hasPermission('CAN_OPERATIONS_CREATE')==false" @click="editRow(rows.item)"> <i class="bx bx-edit cursor-pointer"></i> </a>-->
                            <span v-if="rows.item.punishment_type_id!=4">
                                <a  size="sm" v-if="(rows.item.process_yn == 'N' || rows.item.end_date == null)" :disabled="hasPermission('CAN_OPERATIONS_CREATE')==false" @click="editRow(rows.item)"> <i class="bx bx-edit cursor-pointer"></i> </a>
                                <a size="sm" :hidden="hasPermission('CAN_OPERATIONS_CREATE')==false" class="text-danger" @click="deleteRow(rows.item.punishment_id, rows.index)"> <i
                                 class="bx bx-trash cursor-pointer"></i> </a>
                            </span>


                            <a size="sm" @click="showAttachment(rows.item.attachment)"><i
                                class="bx bx-download cursor-pointer"></i> </a>
                        </template>
                    </Datatable>
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
        components: {DatePicker, Datatable, vSelect, vcss},
        data() {
            return {
                filterIgnoredFields: ['attachment', 'end_attachment'],
                valueType: this.dateFormatter(),
                perPage:5,
                totalList:1,
                selectedEmployee: [],
                empIdList: [],
                datetime: new Date(),
                departmentOptions: [],
                approveOptions: [
                    {approve_status_name:'Approved', approve_status: 'Y'},
                    {approve_status_name:'Pending', approve_status: 'P'},
                    {approve_status_name:'Rejected', approve_status:'N'}
                ],
                processOptions: [
                    {process_name:'Approved', process_yn: 'Y'},
                    {process_name:'Pending', process_yn: 'P'},
                    {process_name:'Rejected', process_yn:'N'}
                ],
                submitBtn: 'Save',
                searchParam: {
                    department_id: '',
                    approve_status: ''
                },
                selectedDepartment: '',
                approvalProcess: '',
                punishment: {
                    punishment_id: null,
                    emp_name: "",
                    emp_code: null,
                    emp_id: null,
                    department_id: null,
                    punishment_type_id: null,
                    order_ref_number: null,
                    end_order_ref_no: null,
                    end_order_date: null,
                    order_date: new Date(),
                    start_date: new Date(),
                    end_date: null,
                    note: null,
                    end_note: null,
                    process_yn: 'N',
                    approve_status: 'P',
                    approve_note:null,
                    attachment: null,
                    end_attachment: null
                },
                typeList: [],
                show: true,
                tableData: {
                    fields: [
                        {key: 'emp_code', label: 'Employee Code', sortable: true},
                        {key: 'emp_name', label: 'Employee Name', sortable: true},
                        {key: 'punishment_type', sortable: true},
                        {key: 'order_ref_number', label: 'Office Order Number', sortable: true},
                        {
                            key: 'order_date',
                            label: 'Office Order Date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            sortable: true
                        },
                        {
                            key: 'start_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            sortable: true
                        },
                        {
                            key: 'end_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            sortable: true
                        },
                        {
                            key: 'process_yn',
                            label: 'Process Status',
                            sortable: true,
                            formatter: value => {
                                if(value == 'Y') {
                                    return 'Processed'
                                } else if (value == 'N') {
                                    return 'Not Processed'
                                } else {
                                    return ''
                                }
                            }
                        },
                        {key: 'last_updated_by', label: 'Last Updated By', sortable: true},
                        'action'
                    ],
                    items: []
                }
            };
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.punishment.emp_name = val.emp_name;
                    this.punishment.emp_id = val.emp_id;
                    this.punishment.emp_code = val.emp_code;

                }
            },
            selectedDepartment: function (val, oldVal) {
                if (val !== null){
                    this.searchParam.department_id = val.department_id
                } else {
                    this.searchParam.department_id = ''
                }
            },
            approvalProcess: function (val, oldVal) {
                if (val !== null){
                    this.searchParam.approve_status = val.approve_status
                } else {
                    this.searchParam.approve_status = ''
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Operations"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Punishment"});
            this.fetchData();
            this.getFormData();
        },
        methods: {
            onSubmit() {
                let data = this.punishment;
                data.start_date = moment(data.start_date).format('YYYY-MM-DD');
                data.order_date = moment(data.order_date).format('YYYY-MM-DD');
                //data.process_yn = this.punishment.process_yn == 'Y' && this.punishment.end_date ? 'N' : 'Y';
                if (data.punishment_id != null) {
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/operation/punishments/${data.punishment_id}`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                        console.log(res.data)
                    });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/punishments`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                        console.log(res.data)
                    });
                }

            },
            deleteRow(punishment_id, index) {
                let currObj = this;
                if (confirm("Do you really want to delete?")) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/operation/punishments/${punishment_id}`).then(res => {
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
            editRow(item) {
                this.setEmployee(item)
                this.punishment = item;
                this.submitBtn = 'Update';
            },
            setEmployee: function (item) {
                this.selectedEmployee = {
                    emp_id: item.emp_id,
                    option_name: item.emp_code + ' ' + item.emp_name,
                    designation: item.designation,
                    designation_id_from: item.designation_id,
                    department_name: item.department_name,
                    department_id_from: item.dpt_department_id,
                    emp_grade_id: item.grad_id_from,
                    emp_code: item.emp_code,
                    emp_name: item.emp_name
                }
            },
            renderModal(item) {
                this.setEmployee(item)
                this.punishment.punishment_id = item.punishment_id;
                this.punishment.note = item.note;
            },
            onReset() {
                this.selectedEmployee = null;
                this.punishment = {};
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
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                        console.log(res.data);
                    })
                }
            },
            fetchData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/punishments`).then(result => {
                    this.tableData.items = result.data;
                    this.totalList = result.data.length
                }).catch(err => {
                    console.log('error');
                });
            },
            encodeFile(e) {
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.punishment.attachment = reader.result;
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

            encodeFileEnd(e){
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.punishment.end_attachment = reader.result;
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

            getFormData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.departmentOptions = res.data.departments;
                    console.log(res.data)
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-lookup-data/${'PUNISHMENT'}`).then(res => {
                    this.typeList=res.data.punishments;
                });
            },
            searchByDepartment() {
                let department_id = this.searchParam.department_id;
                let process_yn = this.approvalProcess.approve_status;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/punishments?department_id=${department_id}&process_yn=${process_yn}`).then(result => {
                    this.tableData.items = result.data
                    this.totalList = result.data.length
                }).catch(err => {
                    console.log('error');
                });
            },
            clear(){
                this.searchParam= null
                this.approvalProcess = null
                this.fetchData();
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
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            showAttachment(data) {
                const win = window.open("","_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="'+data+'"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);
            }
        }
    };
</script>

<style>
    .message label:after{
        content:" (File should not exceed 2MB)";
        color:red
    }
    .custom-select:disabled{
        background-color: #F2F4F4
    }
    legend{
        font-size: 1rem;
    }
</style>
