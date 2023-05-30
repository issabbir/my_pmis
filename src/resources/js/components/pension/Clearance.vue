<template>
    <div class="content-wrapper">
        <div class="content-body">
            <template>
                <b-modal
                    id="modal-center"
                    scrollable
                    size="xl"
                    body-bg="light"
                    :title="message+' '+auth_dept_name.toLowerCase()+' '+'department' "
                    ok-title="Submit"
                    @ok="onSubmit('C')"
                    @cancel="onSubmit('N')"
                    @hide="onReset()"
                    cancel-title="Close"
                >
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Employee Code"
                                label-for="emp_code"
                            >
                                <b-form-input v-model="formData.emp_code" readonly></b-form-input>
                                <b-form-input v-model="formData.emp_id" hidden></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group label="Employee Name" label-for="emp_name">
                                <b-form-input v-model="formData.emp_name" readonly id="emp_name" ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group label="Department" label-for="department_name">
                                <b-form-input v-model="formData.department_name" readonly id="department_name" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group label="Designation" label-for="designation">
                                <b-form-input v-model="formData.designation" readonly id="designation" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group label="PRL Date"  label-for="prl_date">
                                <b-form-input v-model="formData.emp_lpr_date" readonly id="emp_lpr_date" ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group label="Retirement Date" label-for="retirement_date" >
                                <b-form-input v-model="formData.perm_retd_date" readonly id="perm_retd_date" ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group label="Contact Info" label-for="contact_info" >
                                <b-form-input v-model="formData.contact_info" readonly id="contact_info" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="12">
                            <b-row>
                                <b-col>
                                    <b-card>
                                        <b-card-text>
                                            <b-row>
                                                <b-col md="6">
                                                    <b-form-group label="Personal Debt Amount" label-for="amount" >
                                                        <b-form-input v-model="formData.personal_debt"  id="amount" ></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col md="6">
                                                    <b-form-group class="message" label="Personal Debt Attachment" label-for="attachment" >
                                                        <b-form-file
                                                            @change="encodeFile"
                                                            id="attachment"
                                                            placeholder="Attachment"
                                                        ></b-form-file>
                                                        <a size="sm" :hidden="formData.personal_debt_attachment==null" @click="showAttachmnet(formData.personal_debt_attachment)"><i class="bx bx-download cursor-pointer"></i>Show Attachment</a>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="12">
                                                    <b-form-group label="Personal Debt Remarks" class="required" label-for="remarks">
                                                        <b-textarea v-model="formData.personal_debt_remarks" id="leave_reason" required ></b-textarea>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </b-card-text>
                                    </b-card>
                                </b-col>
                                <b-col>
                                    <b-card>
                                        <b-card-text>
                                            <b-row>
                                                <b-col md="6">
                                                    <b-form-group label="Institutional Debt Amount" label-for="amount" >
                                                        <b-form-input v-model="formData.institutional_debt"  id="amount" ></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col md="6">
                                                    <b-form-group class="message" label="Institutional Debt Attachment" label-for="attachment" >
                                                        <b-form-file
                                                            @change="encodeInstitutionalFile"
                                                            id="attachment"
                                                            placeholder="Attachment"
                                                        ></b-form-file>
                                                        <a size="sm" :hidden="formData.institutional_debt_attachment==null" @click="showInstitutionalAttachmnet(formData.institutional_debt_attachment)"><i class="bx bx-download cursor-pointer"></i>Show Attachment</a>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col md="12">
                                                    <b-form-group label="Institutional Debt Remarks" class="required" label-for="remarks">
                                                        <b-textarea v-model="formData.institutional_debt_remarks" id="leave_reason" ></b-textarea>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </b-card-text>
                                    </b-card>
                                </b-col>
                            </b-row>
                        </b-col>






                    </b-row>
                    <template v-slot:modal-footer="{ ok, cancel, hide }">
                        <b-button  type="submit" size="sm" variant="success" @click="ok()">
                            Cleared
                        </b-button>
                        <b-button  type="submit" size="sm" variant="danger" @click="cancel()">
                            Denied
                        </b-button>
                        <b-button type="button" size="sm" variant="secondary" @click="hide()">
                            Close
                        </b-button>
                    </template>
                </b-modal>
            </template>
            <b-card >
                <b-card-header header-bg-variant="dark" header-text-variant="white">Clearance List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage"
                               v-bind:items="items">
                        <template v-slot:actions="{ rows }">
                            <a :href="reportUrl" @click="renderPdf(rows.item.emp_code)" target="_blank">
                                <i class="bx bx-file cursor-pointer"></i>
                            </a>
                            <b-link ml="4" class="text-primary" v-b-modal.modal-center @click="editRow(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
<!--                            <b-link size="sm" variant="primary" v-b-modal.modal-center @click="renderModal(rows.item.emp_code)">-->
<!--                                <i class="bx bx-show cursor-pointer"></i>-->
<!--                            </b-link>-->
                        </template>
                        <template v-slot:action2="{ rows }">
                            <span v-if="rows.item.dependency_yn=='C'" class="btn btn-success">Cleared</span>
                            <span class="btn btn-danger" v-if="rows.item.dependency_yn=='N'">Denied</span>
                            <span class="btn btn-warning" v-if="rows.item.dependency_yn=='Y'">Pending</span>

                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>

        </div>


    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    export default {
        components: {DatePicker,Datatable,Vue,vSelect,vcss},
        watch: {
            selectedEmployee:function(val,oldVal) {
                if(val !== null) {
                    this.formData.emp_name =  val.emp_name;
                    this.formData.emp_id =  val.emp_id;
                    this.formData.department_name =  val.department_name;
                    this.formData.designation =  val.designation;
                    this.formData.emp_lpr_date = val.emp_lpr_date;
                    this.formData.perm_retd_date = val.perm_retd_date;
                    this.formData.contact_info = val.contact_info;
                }
            }

        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Clearance From Department"});
            this.loadData();
        },
        data() {
            return {
                reportUrl:'',
                reportParams: {
                    xdo:'/~weblogic/Pension/Employee_details.xdo',
                    type:"pdf",
                    P_EMP_CODE:'',
                    filename:'Employee Details'
                },
                unique_code_message: '',
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                auth_dept_name:' ',
                clerenceTitle:' ',
                formData: {
                    dept_ackment_id: '',
                    emp_id:'',
                    emp_code: '',
                    personal_debt: '',
                    personal_debt_attachment: '',
                    personal_debt_remarks: '',
                    institutional_debt: '',
                    institutional_debt_attachment: '',
                    institutional_debt_remarks: '',
                    dependency_yn: '',
                    emp_name :  '',
                    department_name : '',
                    designation : '',
                    emp_lpr_date : '',
                    perm_retd_date : '',
                    contact_info : ''
                },
                dependency_yn_List:[
                    { value: 'Y', text: 'Yes' },
                    { value: 'N', text: 'No' },
                ],
                message:'',
                selectedEmployee:{},
                selected:{},
                updateIndex: -1,
                submitBtn: 'Submit',
                empIdList: [],
                emp_code: {},
                perPage:5,
                totalList:0,
                file: '',
                show: true,
                fields: [
                    {label: 'SL', key: 'index', sortable: false},
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'department_name', label: 'Department', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'designation', label: 'Designation', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {
                        key: 'application_type',
                        label: 'Application Type',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-left',
                        formatter: value => {
                            if (value == 'AFD') {
                                return 'Application by Nominee'
                            }else{
                                return 'Application by Employee'
                            }
                        }
                    },
                    {key: 'action2', label: 'Status'},
                    'action'],
                items: []
            }
        },
        computed:{
        },
        methods: {
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
            searchempcods(id){
                if(id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/clearance-emp-search/${id}`, this.formData).then(res => {
                       console.log(res.data);
                        this.empIdList = res.data;
                    })
                }
            },

            onSubmit(value) {
                let currObj = this;
                this.formData.dependency_yn = value
                this.formData.emp_id=this.selectedEmployee.emp_id;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/store-acknowledgement", this.formData).then(res => {
                    if (res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadData();
                        this.onReset();
                    } else {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
            },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/get-acknowledgement-data`).then(res => {
                    this.items=res.data;
                    this.totalList = res.data.length;
                });
            },
            renderModal(item) {
                let id = item.emp_id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/get-pension-clearance-status/${id}`).then(res => {
                    this.pensionItems = res.data;
                    this.clearanceEmp=res.data[0].emp_name;
                    this.totalPension = res.data.length;

                });
            },
            renderPdf(emp_code) {
                this.reportParams.P_EMP_CODE = emp_code
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function(key) {
                    return  key+"="+params[key]
                }).join('&');

                this.reportUrl = '/report/render?'+queryString;
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
                            vm.formData.personal_debt_attachment = reader.result;
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
            encodeInstitutionalFile(e) {
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
                            vm.formData.institutional_debt_attachment = reader.result;
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
            showInstitutionalAttachmnet(data) {
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
            onReset() {
                this.show = false;
                this.$nextTick(() => {
                    this.selectedEmployee={};
                    this.formData = {};
                    this.updateIndex = -1;
                    //this.submitBtn = 'Save';
                    this.show = true;
                });
            },
            editRow(item) {
                this.message='Pension clearance from';
                this.auth_dept_name=item.auth_department_name;
                this.selectedEmployee = item;
                this.formData = item;
                this.clerenceTitle=item.auth_department_name;
                console.log(item);
                $(document).scrollTop(0);
                this.submitBtn = 'CLEARED'
            },


        },

    }
</script>

<style>
    img {
        height: auto;
        max-width: 2.5rem;
        margin-right: 1rem;
    }
    .required label:after{
        content:"*";
        color:red;
    }
    .d-center {
        display: flex;
        align-items: center;
    }

    .selected img {
        width: auto;
        max-height: 23px;
        margin-right: 0.5rem;
    }

    .v-select .dropdown li {
        border-bottom: 1px solid rgba(112, 128, 144, 0.1);
    }

    .v-select .dropdown li:last-child {
        border-bottom: none;
    }

    .v-select .dropdown li a {
        padding: 10px 20px;
        width: 100%;
        font-size: 1.25em;
        color: #3c3c3c;
    }

    .v-select .dropdown-menu .active > a {
        color: #fff;
    }
</style>
