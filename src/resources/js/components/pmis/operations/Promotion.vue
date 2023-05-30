<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card v-if="hasPermission('CAN_OPERATIONS_CREATE')==true">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Promotion Information
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show" class="form form-vertical col-md-12">
                        <b-row>
                            <b-col class="col-md-6 col-12">
                                <fieldset class="border pr-2 pl-2">
                                    <legend class="w-auto" style="font-weight: bold;">Promotion From</legend>
                                    <b-row class="my-1">
                                        <b-col sm="6">
                                            <b-form-group label="Employee Code" label-for="emp_code" class="requiredField">
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
                                            <b-form-group label="Employee Name" label-for="emp_name">
                                                <b-form-input
                                                    id="emp_name"
                                                    v-model="promotion.emp_name"
                                                    readonly
                                                    placeholder="Employee Name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="Division Name" label-for="division_name">
                                                <b-form-input
                                                    id="division_name"
                                                    v-model="promotion.division_name"
                                                    required
                                                    readonly
                                                    placeholder="Division"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="Department Name" label-for="department_name">
                                                <b-form-input
                                                    id="department_name"
                                                    v-model="promotion.department_name"
                                                    required
                                                    readonly
                                                    placeholder="Department"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="Designation" label-for="designation">
                                                <b-form-input
                                                    id="designation"
                                                    v-model="promotion.designation"
                                                    required
                                                    readonly
                                                    placeholder="Designation"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="Grade" label-for="fromGrade">
                                                <b-form-input
                                                    id="fromGrade"
                                                    v-model="promotion.grad_id_from"
                                                    required
                                                    readonly
                                                    placeholder="Grade"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col sm="6">
                                            <b-form-group label="Grade Step ID" label-for="grade_step_id">
                                                <b-form-input
                                                    id="grade_step_id"
                                                    v-model="promotion.grade_step_id_from"
                                                    readonly
                                                    placeholder="Grade Step ID"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="Basic" label-for="current_basic">
                                                <b-form-input
                                                    id="current_basic"
                                                    v-model="promotion.basic_amt"
                                                    readonly
                                                    class="text-right"
                                                    placeholder="Basic"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>
                            <b-col class="col-md-6 col-12">
                                <fieldset class="border pr-2 pl-2">
                                    <legend class="w-auto" style="font-weight: bold;">Promotion To</legend>
                                    <b-row class="my-1">
                                        <b-col sm="6">
                                            <b-form-group label="PROMOTION GRADE TYPE" label-for="promotionGradeType" class="requiredField">
                                                <b-form-select
                                                        id="promotionGradeType"
                                                        v-model="promotion.promotion_grad_type"
                                                        :options="gradeTypeList"
                                                        required
                                                        @change="onChangePromotionGrade(promotion.promotion_grad_type)"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="Division Name" label-for="division_id" class="requiredField">
                                                <b-form-select
                                                    :disabled="promotion.promotion_grad_type == 1 || promotion.promotion_grad_type == 3"
                                                    id="division_id"
                                                    v-model="promotion.division_id_to"
                                                    :options="divisionOptions"
                                                    required
                                                    @change="getDepartments(promotion.division_id_to)"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="Department Name" label-for="dpt_id" class="requiredField">
                                                <b-form-select
                                                    :disabled="promotion.promotion_grad_type == 1 || promotion.promotion_grad_type == 3"
                                                    id="dpt_id"
                                                    v-model="promotion.department_id_to"
                                                    :options="departmentOptions"
                                                    value-field="value"
                                                    text-field="text"
                                                    required
                                                    @change="getDesignations(promotion.department_id_to)"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="DESIGNATION" label-for="toDesignation" class="requiredField">
                                                <v-select v-model="selectedDesignationTo" :disabled="promotion.promotion_grad_type == 1 || promotion.promotion_grad_type == 3"
                                                          :options="designationOptions" value="designation_id"
                                                          @input="designationChange(selectedDesignationTo.designation_id)"
                                                          label="designation" required>
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="PAY GRADE ID" label-for="grade_id" class="requiredField">
                                                <b-form-select
                                                    id="grade_id"
                                                    v-model="promotion.grad_id_to"
                                                    :options="gradeOptions"
                                                    required
                                                    value-field="emp_grade_id"
                                                    text-field="show_grade"
                                                    @change="getGradeSteps(promotion.grad_id_to)"
                                                ></b-form-select>
                                            </b-form-group>

                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="ACTUAL GRADE ID" label-for="actual_grade_id" class="requiredField">
                                                <b-form-select
                                                    id="actual_grade_id"
                                                    v-model="promotion.actual_grade_id"
                                                    :options="actualGradsOption"
                                                    :disabled="promotion.promotion_grad_type == 1 || promotion.promotion_grad_type == 3"
                                                    required
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="GRADE STEP ID" label-for="grade_step_id" class="requiredField">
                                                <b-form-select
                                                    id="grade_step_id"
                                                    v-model="promotion.grade_step_id_to"
                                                    :options="gradeStepOptions"
                                                    required
                                                    value-field="grade_steps_id"
                                                    text-field="show_grade_step"
                                                    @input="selectBasic()"
                                                    @change="selectBasic()"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>

                                        <b-col sm="6">
                                            <b-form-group label="Basic" label-for="basic_to">
                                                <b-form-input
                                                    id="basic_to"
                                                    v-model="promotion.basic_amt_to"
                                                    readonly
                                                    class="text-right"
                                                    placeholder="Basic"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="ORDER NO" label-for="orderNo" class="requiredField">
                                                <b-form-input
                                                    id="orderNo"
                                                    v-model="promotion.order_no"
                                                    required
                                                    placeholder="Order No"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="ORDER DATE" label-for="orderDate" class="requiredField">
                                                <date-picker
                                                    width="100%"
                                                    input-class="form-control"
                                                    v-model="promotion.order_date"
                                                    type="date"
                                                    lang="en"
                                                    :editable="false"
                                                    format="DD-MM-YYYY"
                                                    required>
                                                </date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group label="EFFECTIVE DATE" label-for="effectivedate" class="requiredField">
                                                <date-picker
                                                    width="100%"
                                                    input-class="form-control"
                                                    v-model="promotion.effective_date"
                                                    type="date"
                                                    lang="en"
                                                    :editable="false"
                                                    format="DD-MM-YYYY">
                                                </date-picker>
                                            </b-form-group>
                                        </b-col>

                                        <b-col sm="12">
                                            <b-form-group class="message" label="ATTACHMENT" label-for="orderAttachment" >
                                                <b-form-file @change="encodeFile"
                                                             id="orderAttachment"
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
                                                    v-model="promotion.note">
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
                <b-card-header header-bg-variant="dark" header-text-variant="white">Promotion List</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col sm="4">
                            <b-form-group label="Department Name" label-cols-md="4" label-for="toDeptName">
                                <v-select v-model="searchParam" :options="allDepartmentOptions" value="department_id"
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
                    <Datatable :fields="tableData.fields" :items="tableData.items" :total-list="total_list" :per-page="perPage" :filter-ignored-fields="filterIgnoredFields">
                        <template v-slot:actions="{ rows }">
                            <a size="sm" v-if="rows.item.process_yn == 'N'" :disabled="hasPermission('CAN_OPERATIONS_CREATE')==false"
                               @click="editRow(rows.item)"><i class="bx bx-edit cursor-pointer"></i> </a>
                            <a v-if="rows.item.process_yn == 'N'" :hidden="hasPermission('CAN_OPERATIONS_CREATE')==false" href="javscript:;" size="sm"
                               class="text-danger"
                               @click="deleteRow(rows.item.promotion_id, rows.index)"> <i
                                class="bx bx-trash cursor-pointer"></i> </a>
                            <a v-if="rows.item.process_yn == 'N'" v-b-modal.modal-center :disabled="hasPermission('CAN_OPERATIONS_PROCESS')==false"
                               @click="renderModal(rows.item)"><i
                                class="bx bx-cog cursor-pointer"></i></a>
                            <a v-if="rows.item.order_attachment" size="sm" @click="showAttachment(rows.item.promotion_id)"><i
                                class="bx bx-download cursor-pointer"></i> </a>
                            <i v-if="rows.item.process_yn == 'Y'" class="text-success bx bx-check cursor-pointer"></i>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <div>
                <b-modal id="modal-center" @ok="processed()" centered ok-title="Approve"
                         :title="'Promotion Processing For '+promotion.emp_name+'<br> Employee Code: '+promotion.emp_code">
                    <b-form-group>
                        <b-form-textarea
                            id="description"
                            v-model="promotion.approve_note"
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
    import DatePicker from "vue2-datepicker";
    import Multiselect from 'vue-multiselect';
    import ApiRepository from '../../../Repository/ApiRepository';
    import Datatable from '../../../layouts/common/datatable';
    import vSelect from 'vue-select';
    import moment from 'moment';
    import vcss from 'vue-select/dist/vue-select.css';

    const PRIMARY_KEY = 'promotion_Id';
    export default {
        components: {DatePicker, Datatable, Multiselect, vSelect, vcss},
        data() {
            return {
                filterIgnoredFields: ['order_attachment'],
                oldData: {},
                selectedDesignationTo: {
                    designation: '',
                    designation_id: ''
                },
                searchParam: {
                    department_id: "",
                    department_name: "",
                    department_name_bng: "",
                    dept_short_name: "",
                    dpt_division_id: "",
                    dpt_division_name: "",
                    fin_code: "",
                    shift_yn: ""
                },
                datetime: new Date(),
                selectedEmployee: {

                },
                empIdList: [],
                divisionOptions:[],
                departmentOptions: [],
                allDepartmentOptions: [],
                designationOptions: [],
                gradeOptions: [],
                actualGradsOption: [],
                department_name: null,
                submitBtn: 'Save',
                gradeStepOptions:[],
                promotion: {
                    emp_name: null,
                    department_name: null,
                    grad_id_from: null,
                    actual_grade_id:null,
                    grade_step_id_to:null,
                    basic_amt_to:null,
                    department_id_to:null,
                    designation_id_to: null,
                    designation: null,
                    designation_id_from: null,
                    designation_to: null,
                    promotion_grad_type:2,
                    order_attachment: '',
                    grad_id_to: '',
                    approve_note: null,
                    basic_amt: 0,
                    department_id_from: null,
                    department_to: null,
                    designation_id: null,
                    division_from: "",
                    division_id_from: null,
                    division_id_to: null,
                    division_name: "",
                    division_to: "",
                    dpt_department_id: null,
                    effective_date: null,
                    emp_code: "",
                    emp_grade_id: null,
                    emp_id: null,
                    grade_step_id_from: null,
                    note: "",
                    option_name: "",
                    order_date: null,
                    order_no: "",
                    process_yn: null,
                    promotion_id: null
                },
                gradeTypeList: [
                    {text: "Selection Grade", value: 1},
                    {text: "Regular Promotion", value: 2},
                    {text: "Trained Promotion", value: 3}
                ],
                show: true,
                total_list: 1,
                perPage: 10,
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL', class: 'text-center'},
                        {key: 'emp_code', label: 'Employee Code ', sortable: true, class: 'text-center'},
                        {key: 'emp_name', label: 'Name', class: 'text-left'},
                        {
                            key: 'effective_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            label: 'Effective Date',
                            sortable: true,
                            class: 'text-left'
                        },
                        {key: 'designation', label: 'Previous Designation', sortable: true},
                        {key: 'designation_to', label: 'Current Designation', sortable: true},
                        {key: 'grad_id_from', label: 'Previous Grade', sortable: true, class: 'text-center'},
                        {key: 'grad_id_to', label: ' Current Grade', sortable: true, class: 'text-center'},
                        {key: 'grade_step_id_from', label: 'Previous Grade Step', sortable: true, class: 'text-center'},
                        {
                            key: 'grade_step_id_to',
                            label: ' Current Grade Step',
                            sortable: true,
                            class: 'text-center'
                        },
                        {
                            key: 'promotion_grad_type',
                            label: 'Promotion Type',
                            formatter: value => {
                                if(value == 1) {
                                    return 'Selection Grade'
                                } else if(value == 2){
                                    return 'Regular'
                                } else if(value == 3){
                                    return 'Trained'
                                } else {
                                    return ''
                                }
                            },
                            sortable: false
                        },
                        {key: 'last_updated_by', label: 'Last Updated By', sortable: true},
                        'action'],
                    items: [],
                },
            };
        },
        watch: {
            selectedDesignationTo: function(val, oldVal){
                if(val){
                    this.promotion.designation_id_to = val.designation_id
                    this.promotion.designation_to = val.designation
                }
            },
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.oldData = val
                    this.promotion.emp_id = val.emp_id;
                    this.promotion.emp_code = val.emp_code;
                    this.promotion.emp_name = val.emp_name;
                    this.promotion.designation = val.designation;
                    this.promotion.designation_id_from = val.designation_id;
                    this.promotion.grad_id_from = val.emp_grade_id;
                    this.promotion.basic_amt=val.basic_amt;
                    this.promotion.grade_step_id_from=val.grade_step_id;
                    this.promotion.division_name=val.division_name;
                    this.promotion.division_id_from=val.dpt_division_id;

                    this.promotion.division_id_to=val.dpt_division_id;
                    this.getDepartments(val.dpt_division_id)
                    this.promotion.department_id_from = val.dpt_department_id;
                    this.promotion.department_id_to = val.department_id_to ? val.department_id_to : val.dpt_department_id;
                    this.promotion.department_name = val.department_name
                    this.getDesignations(val.dpt_department_id)
                    this.selectedDesignationTo = {
                        designation: val.designation_to ? val.designation_to: val.designation,
                        designation_id: val.designation_id_to ? val.designation_id_to: val.designation_id
                    }
                    this.getGrades(this.promotion.emp_id);
                    this.promotion.grad_id_to = val.grad_id_to ? val.grad_id_to : val.emp_grade_id
                    this.getGradeSteps(val.grad_id_to ? val.grad_id_to : val.emp_grade_id)
                    this.promotion.grade_step_id_to = val.grade_step_id_to? val.grade_step_id_to: val.grade_step_id
                    this.promotion.basic_amt_to = val.basic_amt
                    this.promotion.actual_grade_id = val.actual_grade_id
                }
            },


        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Operations"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Promotion"});
            this.getAllDepartments()
            this.fetchData();
           /* this.getFormData();*/
            this.$store.getters.hasGrantAccess;
            // let isPermitCreate=this.hasPermission("CAN_OPERATIONS_CREATE");
            // let isPermitProcess=this.hasPermission("CAN_OPERATIONS_PROCESS");
            this.getDivisions();
        },
        methods: {
            onChangePromotionGrade(id){
                if(id == 1){
                    this.promotion.division_id_to=this.oldData.dpt_division_id;
                    this.getDepartments(this.oldData.dpt_division_id)
                    this.promotion.department_id_from = this.oldData.dpt_department_id;
                    this.promotion.department_id_to = this.oldData.department_id_to ? this.oldData.department_id_to : this.oldData.dpt_department_id;
                    this.promotion.department_name = this.oldData.department_name
                    this.getDesignations(this.oldData.dpt_department_id)
                    this.selectedDesignationTo = {
                        designation: this.oldData.designation_to ? this.oldData.designation_to: this.oldData.designation,
                        designation_id: this.oldData.designation_id_to ? this.oldData.designation_id_to: this.oldData.designation_id
                    }
                    this.getGrades(this.promotion.emp_id);
                    this.promotion.grad_id_to = this.oldData.emp_grade_id
                    this.getGradeSteps(this.oldData.emp_grade_id)
                    this.promotion.grade_step_id_to = this.oldData.grade_step_id_to? this.oldData.grade_step_id_to: this.oldData.grade_step_id
                    this.promotion.basic_amt_to = this.oldData.basic_amt
                }
            },
            fetchData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/promotions`).then(result => {
                    this.tableData.items = result.data;
                    this.total_list = this.tableData.items.length
                }).catch(err => {
                    console.log('error');
                });
            },
            onSubmit() {
                let data = this.promotion;
                data.effective_date = moment(data.effective_date).format('YYYY-MM-DD');
                data.order_date = moment(data.order_date).format('YYYY-MM-DD');
                if (data.promotion_id != null) {
                    data.department_id_from = this.promotion.dpt_department_id;
                    data.designation_id = this.promotion.designation_id;
                    data.designation_id_to = this.promotion.designation_id_to
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/operation/promotions/${data.promotion_id}`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                } else {
                    data.department_id_from = this.promotion.dpt_department_id;
                    data.designation_id = this.promotion.designation_id;
                    data.designation_id_to = this.promotion.designation_id_to
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/promotions`, data).then(res => {
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
            deleteRow(promotion_id, index) {
                let currObj = this;
                if (confirm("Do you really want to delete?")) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/operation/promotions/${promotion_id}`).then(res => {
                        if (res.data.o_status_code == 1) {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            currObj.tableData.items.splice(index, 1);
                            currObj.fetchData();
                            currObj.tableData.items = currObj.tableData.items;
                            currObj.total_list = currObj.tableData.items.length
                        } else {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    })
                }
            },
            editRow(item) {
                this.setEmployee(item);
                this.promotion = item;
                this.getGrades(item.emp_id);
                this.getGradeSteps(item.grad_id_to);
                this.promotion.order_date = item.order_date;
                this.promotion.effective_date = item.effective_date;
                this.promotion.division_id_to= item.division_id_to;
                this.getDepartments(item.division_id_to);
                this.getDesignations(item.department_id_to);
                this.promotion.department_id_to = item.department_id_to
                this.selectedDesignationTo = {
                    designation_id: item.designation_id_to,
                    designation: item.designation_to
                };
                this.promotion.grade_id_to = item.grade_id_to;
                //this.promotion.grade_step_id_to = item.grade_step_id_to
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/operations/promotions/${item.promotion_id}`).then(result => {
                    this.promotion.order_attachment = result.data.order_attachment
                })
                this.submitBtn = 'Update'
            },
            setEmployee: function (item) {
                this.selectedEmployee = {
                    emp_id: item.emp_id,
                    option_name: item.emp_code + ' ' + item.emp_name,
                    designation: item.designation,
                    dpt_department_id: item.department_id,
                    designation_id_from: item.designation_id_from,
                    department_name: item.department_name,
                    department_id_from: item.department_id_from,
                    department_id_to: item.department_id_to,
                    emp_grade_id: item.grad_id_from,
                    grade_id_to:item.grade_id_to,
                    emp_code: item.emp_code,
                    emp_name: item.emp_name,
                    basic_amt:item.basic_amt,
                    grade_step_id:item.grade_step_id_from,
                    grad_id_to: item.grad_id_to,
                    grade_step_id_to:item.grade_step_id_to,
                    dpt_division_id:item.division_id_from,
                    division_name:item.division_from,
                    designation_id_to: item.designation_id_to,
                    designation_to: item.designation_to,
                    actual_grade_id: item.actual_grade_id
            }
            },
            renderModal(item) {
                this.setEmployee(item);
                this.promotion.approve_note = item.approve_note;
                this.promotion.promotion_id = item.promotion_id;
            },
            processed() {
                let data = this.promotion;
                if (data.promotion_id != null) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/promotions/process`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.clear();
                            this.fetchData();
                            this.onReset();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }
            },
            onReset() {
                this.selectedEmployee = [];
                this.promotion = {};
                this.submitBtn = 'Save';
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
            designationChange(id){
                if (id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/by-designation/${id}`).then(resp => {
                       //this.promotion.grad_id_to = resp.data.grade.value
                       this.promotion.actual_grade_id = resp.data.grade.value
                       this.getGradeSteps(this.promotion.grad_id_to)

                        // this.getGradeSteps(null)
                        // this.promotion.grade_step_id_to = {
                        //     "grade_steps_id": "0",
                        //     "basic_amt": "0",
                        //     "show_grade_step": "0"
                        // };
                    })
                }
            },

            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
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
                      this.departmentOptions = res.data;
                  });
              }
            },

            getAllDepartments(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/employee-position/departments`).then(res => {
                    this.allDepartmentOptions = res.data;
                })
            },
            getDesignations(id){
                if (id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-department/${id}`).then(res => {
                        this.designationOptions = res.data.designations;
                    });
                }
            },
            getGrades(id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-emp-promotional-grades/${id}`).then(res => {
                        this.gradeOptions=res.data.promotiongrades;
                        this.actualGradsOption=res.data.actualGrads;
                    })

            },
            getGradeSteps(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-grade-steps/${id}`).then(res => {
                        this.gradeStepOptions=res.data.grads_steps;
                    })
                }
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
                            vm.promotion.order_attachment = reader.result;
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
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/promotions?department_id=${department_id}`).then(result => {
                    this.tableData.items = result.data;
                    this.total_list = this.tableData.items.length
                })
            },
            clear() {
                this.searchParam = {
                    department_id: "",
                    department_name: "",
                    department_name_bng: "",
                    dept_short_name: "",
                    dpt_division_id: "",
                    dpt_division_name: "",
                    fin_code: "",
                    shift_yn: ""
                }
                this.fetchData();
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            showAttachment(promotion_id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/operations/promotions/${promotion_id}`).then(result => {
                    if(result.data.order_attachment){
                        const win = window.open("","_blank");
                        let html = '';
                        html += '<html>';
                        html += '<body style="margin:0!important">';
                        html += '<embed width="100%" height="100%" src="'+result.data.order_attachment+'"/>';
                        html += '</body>';
                        html += '</html>';
                        setTimeout(() => {
                            win.document.write(html);
                        }, 0);
                    }

                })

            },


           selectBasic(){
               this.gradeStepOptions.forEach((item) => {
                   if (item.grade_steps_id == this.promotion.grade_step_id_to) {
                       this.promotion.basic_amt_to = item.basic_amt;
                   }
               });
            }

        }
    };
</script>
<style>
    .message label:after{
        content:" (File should not exceed 2MB)";
        color:red
    }
    .disabled, .disabled a, :disabled, :disabled a {
        color: #475F7B!important;
        opacity: 1!important;
    }
    .vs--disabled .vs__clear, .vs--disabled .vs__dropdown-toggle, .vs--disabled .vs__open-indicator, .vs--disabled .vs__search, .vs--disabled .vs__selected {
        cursor: not-allowed;
        background-color: #F2F4F4;
    }
    .vs__selected {
        color: #475F7B;
    }
</style>
