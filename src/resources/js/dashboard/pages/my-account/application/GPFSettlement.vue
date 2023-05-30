<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Application for Settlement
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="eligible_for_loan">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Fund Type"
                                    label-for="fundType"
                                    class="requiredField">
                                    <b-form-select v-model="pfWithdraw.settlement_types"
                                                   :options="fundtypeList" id="fundType"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Bank Info"
                                    label-for="employeeId">
                                    <b-input v-model="pfWithdraw.emp_bank_info" readonly></b-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group
                                    label="Apply Date"
                                    label-for="date"
                                    class="requiredField">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="pfWithdraw.application_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD-MM-YYYY">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Attachment" label-for="goAttachment" class="message">
                                    <b-form-file
                                        @change="encodeFile"
                                        id="goAttachment"
                                        placeholder="Go Attachment"
                                    ></b-form-file>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end mt-1">
                                <b-button md="6" size="md" variant="dark" type="submit">{{submitBtn}}</b-button>&nbsp;
                                <b-button md="6" size="md" class="btn-outline-dark" type="reset">Cancel</b-button>
                            </b-col>
                        </b-row>
                        <!--</fieldset>-->
                    </b-form>
                    <p v-else class="text-danger text-center">You are not allowed to apply for GPF Settlement</p>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Settlement Information List
                </b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items"
                               :totalList="totalList" :perPage="perPage" v-bind:pageColSize="4" v-bind:searchColSize="5">
                        <template v-slot:actions="{ rows }"  >
                            <a size="sm"   @click="editRow(rows.item)"> <i class="bx bx-edit cursor-pointer"></i> </a>
                            <a size="sm" @click="showAttachmnet(rows.item.attachment)"><i
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
    import Datatable from '../../../../layouts/common/datatable';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import ApiRepository from '../../../../Repository/ApiRepository';

    export default {
        components: {DatePicker, Datatable, vSelect, vcss},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PF Settlement Application"});
            this.loadData()
            this.searchEmpCode(this.$store.getters.user.user_name)

        },
        data() {
            return {
                eligible_for_loan: false,
                applyDate: new Date(),
                selectedEmployee: {
                    account_number: "",
                    account_type: '',
                    account_type_id: null,
                    available_days: null,
                    bank_info: "",
                    branch_id: "",
                    branch_name: "",
                    department_name: "",
                    designation: "",
                    designation_id: "",
                    dpt_department_id: "",
                    emp_code: "",
                    emp_id: "",
                    emp_lpr_date: "",
                    emp_name: "",
                    emp_status: null,
                    option_name: "",
                    permanent_retirement_date: "",
                    service_period: ""
                },
                hidden: false,
                empIdList: [],
                nomineeList: [],
                submitBtn: 'Save',
                pfWithdraw: {
                    settlement_types: '',
                    emp_id: null,
                    applicant_name: null,
                    relationship_id: null,
                    applicant_type: 1,
                    application_date: new Date(),
                    bank_info: '',
                    emp_bank_info: '',
                    attachment: '',
                    file_type: '',
                    file_name: '',

                },
                errorMessage: {color: 'red'},
                fundtypeList: [{text: 'GPF', value: 1}, {text: 'CPF', value: 2}],
                applicanttypeList: [{text: 'Self', value: 1}],
                show: true,
                perPage: 5,
                totalList: 0,
                tableData: {
                    fields:[
                        {key: 'index', label:'#sl', sortable: true},
                        {key: 'settlement_types',
                            formatter: value => {
                                if(value) {
                                    return value==1?'PF':'CPF';
                                }
                            },
                            label: 'Fund Type', orderDate: true},
                        {key: 'applicant_type',
                            formatter: value => {
                                if(value) {
                                    return value==1?'Self':'Nominee';
                                }
                            },
                            label: 'Applicant Type', sortable: true},
                        {key: 'application_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, label: 'Application Date', sortable: true},
                        {key: 'settlement_approved_yn',
                            formatter: value => {
                            if(value == 'Y') {
                                return 'Approved'
                            } else if(value == 'N') {
                                return 'Not Approved'
                            } else {
                                return 'Pending'
                            }
                        }, label: 'Status', sortable: true},
                    ],
                    items: []
                }
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val) {
                    this.pfWithdraw.emp_code = val.emp_code;
                    this.pfWithdraw.emp_bank_info = val.bank_info;
                    this.loadNominee(val.emp_id)
                }
            },

        },
        methods: {
            encodeFile(e){
                let file_limit=2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='application/msword'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.pfWithdraw.attachment = reader.result;
                            vm.pfWithdraw.file_type=type;
                            vm.pfWithdraw.file_name=name;
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
            onSubmit() {
                if(this.pfWithdraw.settlement_id != null){
                    this.pfWithdraw.emp_id = this.selectedEmployee.emp_id;
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/providentFund/application/pf-with-draw-update`, this.pfWithdraw).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }else{
                    this.pfWithdraw.emp_id = this.selectedEmployee.emp_id;
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/providentFund/application/pf-with-draw`, this.pfWithdraw).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }

            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/application/pf-with-draw-list/self`).then(res => {
                    this.tableData.items= res.data;
                    this.totalList = res.data.length;
                });
            },
            onReset() {
                this.show = false;
                this.submitBtn = 'Save';
                this.pfWithdraw={'bank_info':''},
                    this.selectedEmployee={};
                this.$nextTick(() => {
                    this.show = true
                })
            },

            editRow(item) {
                this.pfWithdraw=item;
                // this.pfWithdraw.emp_bank_info=item.emp_bank_info
                // console.log(item);
                this.setEmployee(item);
                this.submitBtn='Update';
            },
            setEmployee: function (item) {
                this.selectedEmployee = {
                    option_name:item.emp_code,
                    emp_id: item.emp_id,
                    emp_code: item.emp_code,
                    emp_name: item.emp_name,
                    bank_info: item.emp_bank_info,
                }
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/gpf/settlement/emp-self/${id}`).then(res => {
                        if(res.data.length > 0){
                            this.eligible_for_loan = true
                            this.selectedEmployee = res.data[0]
                        } else {
                            this.eligible_for_loan = false
                        }

                    })
                }
            },

            loadNominee: function (id) {
                // ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications/nominee/${id}`).then(res => {
                //     this.nomineeList = res.data;
                // });
            },
            setApplicant() {
                this.applicanttypeList.forEach((item) => {
                    if (item.value == 2) {
                        this.nomineeList.forEach((i) => {
                            if (i.nominee_id == this.pfWithdraw.relationship_id) {
                                this.pfWithdraw.applicant_name = i.nominee_name;
                                this.pfWithdraw.percentage=i.percentage;
                            }
                        });
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
