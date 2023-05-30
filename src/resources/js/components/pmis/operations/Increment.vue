<template>
        <div class="content-wrapper">
            <div class="content-body">
                <b-card v-if="hasPermission('CAN_OPERATIONS_CREATE')==true">
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Increment Information</b-card-header>
                    <b-card-body class="border">
                        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show" class="form form-vertical col-md-12 ">
                            <b-row>
                                <b-col class="col-md-6 col-12">
                                    <fieldset class="border pr-2 pl-2">
                                        <legend class="w-auto " style="font-weight: bold;">Increment From</legend>
                                        <b-row class="my-1">
                                            <b-col sm="6">
                                                <b-form-group label="EMPLOYEE CODE" label-for="emp_code" class="requiredField">
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
                                            <b-col sm="6">
                                                <b-form-group label="DEPARTMENT NAME" label-for="deptName">
                                                    <b-form-input
                                                        id="deptName"
                                                        v-model="increment.department_name"
                                                        required
                                                        readonly
                                                        placeholder="Department Name"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col sm="6">
                                                <b-form-group label="DESIGNATION" label-for="designation">
                                                    <b-form-input
                                                        id="designation"
                                                        v-model="increment.designation"
                                                        required
                                                        readonly
                                                        placeholder="Designation"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <b-col sm="6">
                                                <b-form-group label="CURRRENT GRADE" label-for="currentGrade">
                                                    <b-form-input
                                                        id="currentGrade"
                                                        v-model="increment.grad_id_from"
                                                        required
                                                        readonly
                                                        placeholder="Current Grade"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col sm="6">
                                                <b-form-group label="CURRENT GRADE STEP" label-for="currentGradeStep">
                                                    <b-form-input
                                                        id="currentGradeStep"
                                                        v-model="increment.grade_step_id_from"
                                                        required
                                                        readonly
                                                        placeholder="Current Grade Step"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col sm="6">
                                                <b-form-group label="CURRENT BASIC" label-for="currentBasic">
                                                    <b-form-input
                                                        id="currentBasic"
                                                        v-model="increment.basic_from"
                                                        required
                                                        readonly
                                                        placeholder="Current Basic"
                                                        style="text-align:right"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    </fieldset>
                                </b-col>
                                <b-col class="col-md-6 col-12">
                                    <fieldset class="border pr-2 pl-2">
                                        <legend class="w-auto " style="font-weight: bold;">Increment To</legend>
                                        <b-row class="my-1">
                                            <b-col sm="6">
                                                <b-form-group label="GRADE ID" label-for="grade_id" class="requiredField">
                                                    <b-form-select
                                                        id="grade_id"
                                                        v-model="increment.grad_id_to"
                                                        :options="gradeOptions"
                                                        text-field="emp_grade_id"
                                                        required
                                                        @change="getGradeSteps(increment.grad_id_to)"
                                                    ></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col sm="6">
                                                <b-form-group label="GRADE STEP ID" label-for="grade_step_id" class="requiredField">
                                                    <b-form-select
                                                        id="grade_step_id"
                                                        v-model="increment.grade_step_id_to"
                                                        :options="gradeStepOptions"
                                                        value-field="grade_steps_id"
                                                        text-field="grade_steps_id"
                                                        @change="selectBasic()"
                                                        required
                                                    ></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col sm="6">
                                                <b-form-group  label="CHANGE BASIC" label-for="changedBasic" class="requiredField">
                                                    <b-form-input
                                                        id="changedBasic"
                                                        v-model="increment.basic_to"
                                                        required
                                                        placeholder="Changed Basic"
                                                        style="text-align:right"
                                                        type="number"
                                                        readonly
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col sm="6">
                                                <b-form-group label="GOVERNMENT ORDER NUMBER" label-for="goNumber" class="requiredField">
                                                    <b-form-input
                                                        id="goNumber"
                                                        v-model="increment.reference_number"
                                                        required
                                                        placeholder="Order number"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col sm="6">
                                                <b-form-group label="ORDER DATE" label-for="orderDate" class="requiredField">
                                                    <date-picker width="100%" input-class="form-control" v-model="increment.order_date"  type="date" lang="en" format="DD-MM-YYYY" :editable="false" id="orderDate"></date-picker>
                                                </b-form-group>
                                            </b-col>
                                            <b-col sm="6">
                                                <b-form-group label="EFFECTIVE DATE" label-for="effectiveDate" class="requiredField">
                                                    <date-picker width="100%"  input-class="form-control" v-model="increment.effective_date"  type="date" lang="en" format="DD-MM-YYYY" :editable="false" id="effectiveDate"></date-picker>
                                                </b-form-group>
                                            </b-col>
                                            <b-col sm="12">
                                                <b-form-group label="Attachment" label-for="goAttachment" class="message">
                                                    <b-form-file
                                                        @change="encodeFile"
                                                        id="goAttachment"
                                                        placeholder="Go Attachment"
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
                                                        v-model="increment.note">
                                                    </b-form-textarea>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    </fieldset>
                                </b-col>
                            </b-row>
                            <b-row >
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
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Increment List</b-card-header>
                    <b-card-body class="border">
                        <b-row >
                            <b-col sm="4">
                                <b-form-group label="Department Name" label-cols-md="4" label-for="toDeptName">
                                    <v-select v-model="searchParam" :options="departmentOptions" value="department_id" label="department_name" required>
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
                        <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" >
                            <template v-slot:actions="{ rows }"  >
                                <a size="sm"  :disabled="hasPermission('CAN_OPERATIONS_CREATE')==false" @click="editRow(rows.item)"> <i class="bx bx-edit cursor-pointer"></i> </a>
                                <a size="sm"  :hidden="hasPermission('CAN_OPERATIONS_CREATE')==false" class="text-danger"  @click="deleteRow(rows.item.increment_id, rows.index)"> <i class="bx bx-trash cursor-pointer"></i> </a>
                                <a v-b-modal.modal-center :disabled="hasPermission('CAN_OPERATIONS_PROCESS')==false" @click="renderModal(rows.item)"><i class="bx bx-cog cursor-pointer"></i></a>
                                <a size="sm" @click="showAttachmnet(rows.item.attachment)"><i
                                    class="bx bx-download cursor-pointer"></i> </a>
                            </template>
                        </Datatable>
                    </b-card-body>
                </b-card>
                <div>
                    <b-modal id="modal-center" @ok="processed()" centered ok-title="Process" :title="'Increment Processing For '+increment.emp_name+'. Employee Code: '+increment.emp_code">
                    <b-form-group>
                        <b-form-textarea
                            id="description"
                            v-model="modal.approve_note"
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
        components: { DatePicker, Datatable, vSelect, vcss },
        data(){
            return {
                selectedEmployee:[],
                empIdList: [],
                submitBtn: 'Save',
                searchParam:'',
                departmentOptions:[],
                gradeOptions:[],
                gradeStepOptions:[],
                increment: {
                    emp_code: null,
                    emp_id:null,
                    emp_name: '',
                    department_name: '',
                    designation: '',
                    basic_from: '',
                    basic_to: null,
                    goNumber: '',
                    note:'',
                    approve_note:'',
                    reference_number:'',
                    attachment:null,
                    order_date: new Date(),
                    effective_date: new Date(),
                    grade_step_id_to:null,
                    grade_step_id_from:null,
                    grad_id_to:null,
                    grad_id_from:null
                },
                modal:{ },
                promotionGradeType: [{ text: 'Select One', value: null },  'Time Scale', 'Regular Promotion'],
                show: true,
                tableData: {
                    fields:[
                        {key: 'emp_code', label:'Employee Code', sortable: true},
                        {key: 'emp_name', label:'Employee Name', sortable: true},
                        {key: 'reference_number', label: 'GO No', orderDate: true},
                        {key: 'order_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            label:'Order Date', sortable: true},
                        {key: 'effective_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            label: 'Effective From', sortable: true},
                        {key: 'basic_from', label: 'Previous Basic', sortable: true},
                        {key: 'basic_to', label: 'Current Basic', sortable: true},
                        'action'],
                    items: []
                }
            }
        },
         watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.increment.emp_id=val.emp_id;
                    this.increment.emp_code=val.emp_code;
                    this.increment.emp_name=val.emp_name;
                    this.increment.designation = val.designation;
                    this.increment.department_name=val.department_name;
                    this.increment.grad_id_from=val.emp_grade_id;
                    this.increment.basic_from=val.basic_amt;
                    this.increment.grad_id_from=val.emp_grade_id;
                    this.increment.grade_step_id_from=val.grade_step_id;

                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "PMIS" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Operations" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Increment" });
            this.fetchData();
            this.getFormData();
         },
        methods: {
            onSubmit() {
                let data=this.increment;
                data.effective_date = moment(data.effective_date).format('YYYY-MM-DD');
                data.order_date = moment(data.order_date).format('YYYY-MM-DD');
                if(data.increment_id != null){
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND,`/operation/increments/${data.increment_id}`, data).then(res => {
                        if (res.data.o_status_code == 1){
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        }
                        else{
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }
                else{
                    ApiRepository.callApi(ApiRepository.POST_COMMAND,`/operation/increments`, data).then(res => {
                        if (res.data.o_status_code == 1){
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        }
                        else{
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }
            },
            deleteRow(increment_id, index) {
                let currObj = this;
                if(confirm("Do you really want to delete?")){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/operation/increments/${increment_id}`).then(res => {
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
                this.setEmployee(item);
                this.increment=item;
                this.getGradeSteps(item.grad_id_to);
                this.submitBtn='Update';
            },
            setEmployee:function(item) {
                this.selectedEmployee = {
                    emp_id: item.emp_id,
                    option_name: item.emp_code+' '+item.emp_name,
                    designation: item.designation,
                    department_name:item.department_name,
                    basic_amt:item.basic_from,
                    emp_code:item.emp_code,
                    emp_name:item.emp_name,
                    emp_grade_id:item.grad_id_from,
                    grade_step_id:item.grade_step_id_from

                }
            },
            renderModal(item){
                this.setEmployee(item)
                this.modal.increment_id=item.increment_id;
                this.modal.note=item.note;
            },
            processed(){
                if(this.modal.increment_id != null){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND,`/operation/increments/process`, this.modal).then(res => {
                    if (res.data.o_status_code == 1){
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset();
                        this.fetchData();
                    }
                    else{
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                    });
                }
            },
            onReset() {
                this.selectedEmployee={emp_id:null};
                this.increment={};
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
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/increments`).then(result => {
                this.tableData.items = result.data;
                this.tableData.items.effective_date=moment(this.tableData.items.effective_date).format('YYYY-MM-DD');
                this.tableData.items.order_date=moment(this.tableData.items.order_date).format('YYYY-MM-DD');
                    console.log(result.data)
                }).catch(err => {
                    console.log('error');
                });
            },
            encodeFile(e){
                let file_limit=2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                   if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                       let file = e.target.files[0];
                       let reader = new FileReader();
                       let type = file.type;
                       let name = file.name;
                       reader.readAsDataURL(file);
                       reader.onload = (file)=>{
                           vm.increment.attachment = reader.result;
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
                    this.gradeOptions= res.data.grades;
                   /* this.gradeStepOptions= res.data.grades_steps;*/
                });
            },
            searchByDepartment() {
                let department_id= this.searchParam.department_id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/increments?department_id=${department_id}`).then(result => {
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
            },

            getGradeSteps(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-grade-steps/${id}`).then(res => {
                        this.gradeStepOptions=res.data.grads_steps;
                    })
                }
            },
            selectBasic(){
                this.gradeStepOptions.forEach((item) => {
                    if (item.grade_steps_id == this.increment.grade_step_id_to) {
                        this.increment.basic_to = item.basic_amt;
                    }
                });
            }
        }

    }

</script>

<style>
    .message label:after{
        content:" (File should not exceed 2MB)";
        color:red
    }
</style>
