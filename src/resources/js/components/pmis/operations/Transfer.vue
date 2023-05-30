<template>
    <div class="content-wrapper">
        <div class="content-body">

            <b-card v-if="hasPermission('CAN_OPERATIONS_CREATE')==true">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Transfer Information
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show" class="form form-vertical col-md-12">
                        <b-row>
                            <b-col class="col-md-6 col-12">
                                <fieldset class="border pr-2 pl-2">
                                    <legend class="w-auto " style="font-weight: bold;">Transfer From</legend>
                                    <b-row class="my-1">
                                        <b-col sm="6">
                                            <b-form-group label="EMP CODE:" label-for="empCode" class="requiredField">
                                                <v-select
                                                    label="option_name"
                                                    v-model="selectedEmployee"
                                                    :options="empIdList"
                                                    @search="searchEmpCode"
                                                    id="emp_code">
                                                    <template #selected-option="{ emp_code }">
                                                        <div style="display: flex; align-items: baseline;">
                                                            {{ emp_code }}
                                                        </div>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="EMPLOYEE NAME" label-for="fromEmpName">
                                                <b-form-input
                                                    id="fromEmpName"
                                                    v-model="transfer.emp_name"
                                                    required
                                                    readonly
                                                    placeholder="Employee Name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="LOCATION TYPE" label-for="location_type_from">
                                                <b-form-input
                                                    id="location_type_from"
                                                    v-model="transfer.location_type_name"
                                                    required
                                                    readonly
                                                    placeholder="Location Type"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="LOCATION NAME" label-for="location_from">
                                                <b-form-input
                                                    id="location_from"
                                                    v-model="transfer.location_name"
                                                    required
                                                    readonly
                                                    placeholder="Location Name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="DIVISION" label-for="division_id_from">
                                                <b-form-input
                                                    id="division_id_from"
                                                    v-model="transfer.division_name"
                                                    required
                                                    readonly
                                                    placeholder="Division"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="DEPARTMENT NAME" label-for="fromDeptName">
                                                <b-form-input
                                                    id="fromDeptName"
                                                    v-model="transfer.department_name"
                                                    required
                                                    readonly
                                                    placeholder="Department Name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="Section name" label-for="fromSectionName">
                                                <b-form-input
                                                    id="fromSectionName"
                                                    v-model="transfer.dpt_section"
                                                    readonly
                                                    placeholder="Section name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="DESIGNATION" label-for="fromDesignation">
                                                <b-form-input
                                                    id="fromDesignation"
                                                    v-model="transfer.designation"
                                                    required
                                                    readonly
                                                    placeholder="Designation"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="BILL NO" label-for="fromBillNo">
                                                <b-form-input
                                                    id="fromBillNo"
                                                    v-model="transfer.bill_no_from"
                                                    placeholder="Bill No"
                                                    readonly
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col sm="6">
                                            <b-form-group label="BILL OPERATOR" label-for="fromBillOperator">
                                                <b-form-input
                                                    id="fromBillOperator"
                                                    v-model="transfer.bill_operator_from"
                                                    placeholder="Bill Operator"
                                                    readonly
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="CURRENT DEPARTMENT NAME" label-for="fromCurrentDeptName">
                                                <b-form-input
                                                    id="fromCurrentDeptName"
                                                    v-model="transfer.current_department_name"
                                                    readonly
                                                    placeholder="Current Department Name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
<!--                                        <b-col sm="6">-->
<!--                                            <b-form-group label="Check Same This To Transfer" label-for="fromDeptName">-->
<!--                                                <b-form-checkbox value="orange" v-model="transfer.current_department_id">CURRENT DEPARTMENT</b-form-checkbox>-->
<!--                                            </b-form-group>-->
<!--                                        </b-col>-->
                                    </b-row>
                                </fieldset>

                            </b-col>
                            <b-col class="col-md-6 col-12">
                                <fieldset class="border pr-2 pl-2">
                                    <legend class="w-auto " style="font-weight: bold;">Transfer To</legend>
                                    <b-row class="my-1">
                                        <b-col sm="6">
                                            <b-form-group label="TRANSFER TYPE" label-for="toTransperType" class="requiredField">
                                                <b-form-select
                                                    id="toTransperType"
                                                    v-model="transfer.transfer_type"
                                                    :options="toTransperType"
                                                    required
                                                    value-field="passing_value"
                                                    text-field="show_velue"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="EXTERNAL ORG" label-for="externalOrg" class="requiredField">
                                                <b-form-select
                                                    id="externalOrg"
                                                    v-model="transfer.external_org"
                                                    :options="externalOrg"
                                                    value-field="passing_value"
                                                    text-field="show_velue"
                                                    required
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                           <b-form-group label="LOCATION TYPE" label-for="location_type" class="requiredField">
                                               <b-form-select
                                                   id="location_type"
                                                   v-model="transfer.location_type_id_to"
                                                   value-field="location_type_id"
                                                   text-field="location_type_name"
                                                   :options="locationTypeOptions"
                                                   required
                                                   @change="getLocationList(transfer.location_type_id_to)"
                                               ></b-form-select>
                                           </b-form-group>
                                       </b-col>
                                       <b-col sm="6">
                                           <b-form-group label="LOCATIONS" label-for="location" class="requiredField">
                                               <b-form-select
                                                   id="location"
                                                   v-model="transfer.location_id_to"
                                                   :options="locationOptions"
                                                   text-field="working_location"
                                                   value-field="location_id"
                                                   required
                                               ></b-form-select>
                                           </b-form-group>

                                       </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="DIVISION NAME" label-for="division_id" class="requiredField">
                                                <b-form-select
                                                    id="division_id"
                                                    v-model="transfer.division_id_to"
                                                    :options="divisionOptions"
                                                    required
                                                    @change="getDepartments(transfer.division_id_to)"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="DEPARTMENT NAME" label-for="toDeptName" class="requiredField">
                                                <b-form-select
                                                    id="toDeptName"
                                                    v-model="transfer.department_id_to"
                                                    :options="departments"
                                                    required
                                                    value-field="value"
                                                    text-field="text"
                                                    @change="getBillCodes"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="CURRENT DEPARTMENT NAME" label-for="toDeptName" class="requiredField">
                                                <b-form-select
                                                    id="toDeptName"
                                                    v-model="transfer.current_department_id_to"
                                                    :options="departments"
                                                    required
                                                    value-field="value"
                                                    text-field="text"
                                                    @change="getDesignationsByGrade(transfer.current_department_id_to,transfer.actual_grade_id)"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
<!--                                            class="disabled"-->
                                            <input type="hidden" v-model="transfer.designation_id_to">
                                            <b-form-group label="DESIGNATION" label-for="toDesignation" class="requiredField">
                                                <v-select v-model="transfer.designation_to"
                                                         :options="designations" value="designation_id"
                                                          label="designation" required>
                                                   <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                   </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="Section name" label-for="toSectionName">
                                                <b-form-select
                                                    id="toSectionName"
                                                    v-model="transfer.section_id_to"
                                                    :options="sections"
                                                    value-field="dpt_section_id"
                                                    text-field="dpt_section"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>

                                        <b-col sm="6">
                                            <b-form-group label="BILL NO" label-for="toBillNo" class="requiredField">
                                                <b-form-select
                                                    id="toBillNo"
                                                    v-model="transfer.bill_no"
                                                    :options="bill_codes"
                                                    required
                                                    value-field="value"
                                                    text-field="text"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>

                                        <b-col sm="6" style="display: none">
                                            <b-form-group label="BILL OPERATOR" label-for="toBillOperator" >
                                                <b-form-select
                                                    id="toBillOperator"
                                                    v-model="transfer.bill_operator_to"
                                                    :options="bill_codes"
                                                    value-field="value"
                                                    text-field="text"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>

                                        <b-col sm="6">
                                            <b-form-group label="RELEASE DATE" label-for="release_date" class="requiredField">
                                                <date-picker width="100%" v-model="transfer.release_date"
                                                             input-class="form-control" type="date" lang="en"
                                                             format="DD-MM-YYYY" :editable="false"></date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="JOIN DATE" label-for="join_date" class="requiredField">
                                                <date-picker width="100%" v-model="transfer.join_date"
                                                             input-class="form-control" type="date" lang="en"
                                                             format="DD-MM-YYYY" :editable="false"></date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="12">
                                            <b-form-group
                                                label="Attachment"
                                                label-for="attachment"
                                                class="message"
                                            >
                                                <b-form-file
                                                    @change="encodeFile"
                                                    id="attachment"
                                                    placeholder="Attachment"
                                                ></b-form-file>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="12">
                                            <b-form-group label="Description" label-for="note" class="requiredField">
                                                <b-form-textarea
                                                    required
                                                    id="note"
                                                    rows="1"
                                                    max-rows="5"
                                                    v-model="transfer.note">

                                                </b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end mt-2">
                                <b-button-group>
                                    <b-button type="submit" variant="primary">{{submitBtn}}</b-button>
                                    <b-button type="reset" variant="secondary">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Transfer List</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col sm="4">
                            <b-form-group label="Department Name" label-cols-md="4" label-for="toDeptName">
                                <v-select v-model="searchParam" :options="departmentOptions" value="department_id"
                                          label="department_name" required>
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
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items">
                        <template v-slot:actions="{ rows }">
                            <a size="sm"  :disabled="hasPermission('CAN_OPERATIONS_CREATE')==false" @click="editRow(rows.item)"> <i class="bx bx-edit cursor-pointer"></i> </a>
                            <a size="sm"  :hidden="hasPermission('CAN_OPERATIONS_CREATE')==false" class="text-danger" @click="deleteRow(rows.item.transfer_id, rows.index)"> <i
                                class="bx bx-trash cursor-pointer"></i> </a>
                            <a v-b-modal.modal-center :disabled="hasPermission('CAN_OPERATIONS_PROCESS')==false" @click="renderModal(rows.item)"><i
                                class="bx bx-cog cursor-pointer"></i></a>
                            <a size="sm" @click="showAttachmnet(rows.item.attachment)"><i
                                class="bx bx-download cursor-pointer"></i> </a>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <div>
                <b-modal id="modal-center" @ok="processed()" centered ok-title="Process"
                         :title="'Transfer Processing For '+transfer.emp_name+'<br> Employee Code: '+transfer.emp_code">
                    <b-form-group>
                        <b-form-textarea
                            id="description"
                            v-model="transfer.approve_note"
                            placeholder="Remarks"
                            rows="1"
                            max-rows="6"
                        ></b-form-textarea>
                    </b-form-group>
                </b-modal>
            </div>
        </div>
    </div>

</template>

<script>
    import DatePicker from 'vue2-datepicker'
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from '../../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';

    export default {
        components: {DatePicker, Datatable, vSelect, vcss},
        data() {
            return {
                selectedEmployee: [],
                empIdList: [],
                datetime: new Date(),
                submitBtn: 'Save',
                searchParam: '',
                locationTypeOptions:[],
                locationOptions:[],
                divisionOptions:[],
                departmentOptions: [],
                transfer: {
                    emp_id: null,
                    department_id_from: null,
                    current_department_id_to: null,
                    current_department_name: null,
                    current_department_id: null,
                    section_id_from: null,
                    designation_id_from: null,
                    bill_no_from: null,
                    bill_operator_from: null,
                    transfer_type: 2,
                    external_org: null,
                    department_id_to: null,
                    section_id_to: null,
                    designation_id_to: null,
                    bill_no: null,
                    bill_operator_to: null,
                    actual_grade_id:null,
                    join_date: new Date(),
                    release_date: new Date(),
                    note: '',
                    approve_note:''
                },
                toTransperType: [],
                externalOrg: [],
                departments: [],
                sections: [],
                designations: [],
                bill_codes: [],
                show: true,
                tableData: {
                    fields: [
                        {key: 'emp_code', label: 'Employee Code', sortable: true},
                        {key: 'emp_name', label: 'Name', orderDate: true},
                        {key: 'transfer_type', sortable: true},
                        {key: 'current_department', sortable: true},
                        {key: 'external_org', label: 'External Org.', sortable: true},
                        {key: 'bill_no_from', label: 'Pevious Bill', sortable: true},
                        {key: 'bill_no', label: 'Current Bill', sortable: true},
                        {key: 'join_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true},
                        {key: 'release_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true},
                        {key: 'last_updated_by', label: 'Last Updated By', sortable: true},
                        'action'],
                    items: [],
                },

            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.transfer.emp_id = val.emp_id;
                    this.transfer.emp_code = val.emp_code;
                    this.transfer.emp_name = val.emp_name;
                    this.transfer.designation = val.designation;
                    this.transfer.designation_id_from = val.designation_id;
                    this.transfer.department_name = val.department_name;
                    this.transfer.department_id_from = val.dpt_department_id;
                    this.transfer.current_department_id = val.current_department_id;
                    this.transfer.current_department_name = val.current_department_name;
                    this.transfer.dpt_section = val.dpt_section;
                    this.transfer.section_id_from = val.section_id;
                    this.transfer.bill_no_from = val.bill_code;
                    this.transfer.bill_operator_from = val.biller_code;
                    this.transfer.location_type_name= val.location_type_name;
                    this.transfer.location_type_id_from=val.location_type_id;
                    this.transfer.location_name=val.location_name;
                    this.transfer.location_id_from=val.location_id;
                    this.transfer.division_name=val.division_name;
                    this.transfer.division_id_from=val.dpt_division_id;

                    this.transfer.external_org=1;
                    this.transfer.location_type_id_to=val.location_type_id;
                    this.getLocationList(val.location_type_id);
                    this.transfer.location_id_to=val.location_id;
                    this.transfer.division_id_to=val.dpt_division_id;
                    this.getDepartments(val.dpt_division_id);
                    this.transfer.department_id_to=val.dpt_department_id;
                    this.transfer.current_department_id_to=val.current_department_id;
                    this.transfer.actual_grade_id=val.actual_grade_id;
                    // this.getDesignations(val.dpt_department_id);
                   this.getDesignationsByGrade(val.dpt_department_id,val.actual_grade_id);
                   //  this.transfer.designation_to=val.designation;
                     this.transfer.designation_id_to=val.designation_id;
                    this.transfer.bill_no=val.bill_code;
                }
            },
            'transfer.designation_to': {
                handler: function (newVal, before) {
                    this.transfer.designation_id_to = newVal.designation_id;
                    this.getBillCodes();
                },
                deep: true
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Operations"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Transfer"});
            this.getFormData();
            this.getDivisions();
            this.fetchData();
        },
        methods: {
            onSubmit() {
                // this.transfer.designation_id_to = this.transfer.designation_id_to;
                // this.transfer.designation_id_to = this.transfer.designation_id_to.designation_id;
                let data = this.transfer;
                data.join_date = moment(data.join_date).format('YYYY-MM-DD');
                data.release_date = moment(data.release_date).format('YYYY-MM-DD');
                if (data.transfer_id != null) {
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/operation/transfers/${data.transfer_id}`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/transfers`, data).then(res => {
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
            deleteRow(transfer_id, index) {
                let currObj = this;
                if (confirm("Do you really want to delete?")) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/operation/transfers/${transfer_id}`).then(res => {
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
                this.submitBtn = 'Update';
                this.transfer = item;
                this.getLocationList(item.location_type_id_to);
                this.getDepartments(item.division_id_to);
                this.getDesignations(item.department_id_to);
                this.transfer.designation_id_to = {
                    designation_id: item.designation_id_to,
                    designation: item.designation_to
                };
                this.transfer.current_department_id_to=item.dpt_department_id;

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
                    bill_code: item.bill_no_from,
                    biller_code: item.bill_operator_from,
                    dpt_section: item.dpt_section,
                    section_id: item.section_id_from,
                    department_id_from:item.department_id_from,
                    dpt_department_id:item.dpt_department_id,
                    designation_id_from:item.designation_id_from,
                    designation_id:item.designation_id,
                    note:item.note,
                    release_date:item.release_date,
                    location_id:item.location_id_from,
                    location_name:item.location_from,
                    location_type_id:item.location_type_id_from,
                    location_type_name:item.location_type_from,
                    dpt_division_id:item.division_id_from,
                    division_name:item.division_from,
                    actual_grade_id:item.actual_grade_id

                }
            },
            renderModal(item) {
                //this.setEmployee(item);
                this.transfer.transfer_id = item.transfer_id;
                this.transfer.approve_note = item.approve_note;
            },
            processed() {
                if (this.transfer.transfer_id != null) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/transfers/process`, this.transfer).then(res => {
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
            onReset() {
                this.selectedEmployee = null;
                this.transfer={};
                this.submitBtn = 'Save';
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },

            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal.title = ''
                this.infoModal.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
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
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/transfers`).then(result => {
                    this.tableData.items = result.data;
                    console.log(result.data)
                }).catch(err => {
                    console.log('error');
                });
            },
            getFormData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/transfers/form-data').then(res => {
                    this.departmentOptions = res.data.departments;
                    this.sections = res.data.sections;
                    this.bill_codes = res.data.bill_codes;
                });

                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-lookup-data/${'TRANSFER_TYPE'}`).then(res => {
                    this.toTransperType=res.data.punishments;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-lookup-data/${'EXTERNAL_ORG'}`).then(res => {
                    this.externalOrg=res.data.punishments;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.locationTypeOptions=res.data.locationType;
                });
                this.getBillCodes();
            },
            getBillCodes() {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/transfers/bill-codes`,this.transfer).then(res => {
                        this.bill_codes=res.data.bill_codes;
                    })
            },
            getLocationList(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-locations-by-type/${id}`).then(res => {
                        this.locationOptions=res.data.locations;
                    })
                }
            },
            getDivisions(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos').then(result => {
                    this.divisionOptions= result.data.dptDivision;
                })
            },

            getDepartments(id){
                if (id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/departments/${id}`).then(res => {
                        this.departments = res.data;
                    });
                }
            },
            getDesignations(id,emp_grade_id){
                if (id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-department/${id}`).then(res => {
                        this.designations = res.data.designations;
                    });
                }
            },
            getDesignationsByGrade(id,emp_grade_id){
                if (id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-grade/${id}/${emp_grade_id}`).then(res => {
                        this.designations = res.data.designations;
                    });
                }
                this.getBillCodes();
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
                            vm.transfer.attachment = reader.result;
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
            searchByDepartment() {
                let department_id = this.searchParam.department_id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/transfers?department_id=${department_id}`).then(result => {
                    this.tableData.items = result.data;
                    console.log(result.data)
                }).catch(err => {
                    console.log('error');
                });
            },
            clear(){
                this.searchParam=null,
                    this.fetchData();
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            showAttachmnet(data) {
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

    }

</script>

<style>
    .message label:after{
        content:" (File should not exceed 2MB)";
        color:red
    }
    .disabled {
        pointer-events:none;
        color: #bfcbd9;
        cursor: not-allowed;
        background-image: none;
        background-color: #eef1f6;
        border-color: #d1dbe5;
    }
</style>
