<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">House Interchange Request</b-card-header>
                <b-card-body v-if="self_information.allot_id" class="border">
                    <h6>MY HOUSE INFORMATION</h6>
                    <b-card-text class="border">
                        <b-row class="m-1">
                            <b-col md="4">
                                <b-form-group
                                    label="House Name"
                                    label-for="house_name"
                                >
                                    <b-form-input id="house_name" disabled :value="self_information.house_name"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="House Code"
                                    label-for="house_code"
                                >
                                    <b-form-input id="house_code" disabled :value="self_information.house_code"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="House Size"
                                    label-for="house_size"
                                >
                                    <b-form-input id="house_size" disabled :value="self_information.house_size"></b-form-input>
                                </b-form-group>
                            </b-col>


                            <b-col md="4">
                                <b-form-group
                                    label="Floor Number"
                                    label-for="floor_number"
                                >
                                    <b-form-input id="floor_number" disabled :value="self_information.floor_number"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Water Tap"
                                    label-for="water_tap"
                                >
                                    <b-form-input id="water_tap" disabled :value="self_information.water_tap"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Sanitary Fittings"
                                    label-for="sanitary_fittings"
                                >
                                    <b-form-input id="sanitary_fittings" disabled :value="self_information.sanitary_fittings"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="House Details"
                                    label-for="house_details"
                                >
                                    <b-form-input id="house_details" disabled :value="self_information.house_details"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-card-text>
                    <h6>REQUEST RECEIVER'S HOUSE INFORMATION</h6>
                    <b-card-text class="border">
                        <b-row class="m-1">
                            <b-col md="4">
                                <b-form-group
                                    label="Request To"
                                    label-for="request_to"
                                >
                                    <v-select
                                        label="option_name"
                                        v-model="selectedRequestReceiver"
                                        :options="requestReceiverOptions"
                                        @search="employeesFromHouseAllotment"
                                        id="emp_code">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Request Receiver Name"
                                    label-for="emp_name"
                                >
                                    <b-form-input id="emp_name" disabled :value="requestReceiverInformation.emp_name"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Designation"
                                    label-for="designation"
                                >
                                    <b-form-input id="designation" disabled :value="requestReceiverInformation.designation"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Department"
                                    label-for="department_name"
                                >
                                    <b-form-input id="department_name" disabled :value="requestReceiverInformation.department_name"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Section"
                                    label-for="dpt_section"
                                >
                                    <b-form-input id="dpt_section" disabled :value="requestReceiverInformation.dpt_section"></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="House Name"
                                    label-for="house_name"
                                >
                                    <b-form-input id="house_name" disabled :value="requestReceiverInformation.house_name"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="House Code"
                                    label-for="house_code"
                                >
                                    <b-form-input id="house_code" disabled :value="requestReceiverInformation.house_code"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="House Size"
                                    label-for="house_size"
                                >
                                    <b-form-input id="house_size" disabled :value="requestReceiverInformation.house_size"></b-form-input>
                                </b-form-group>
                            </b-col>


                            <b-col md="4">
                                <b-form-group
                                    label="Floor Number"
                                    label-for="floor_number"
                                >
                                    <b-form-input id="floor_number" disabled :value="requestReceiverInformation.floor_number"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Water Tap"
                                    label-for="water_tap"
                                >
                                    <b-form-input id="water_tap" disabled :value="requestReceiverInformation.water_tap"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Sanitary Fittings"
                                    label-for="sanitary_fittings"
                                >
                                    <b-form-input id="sanitary_fittings" disabled :value="requestReceiverInformation.sanitary_fittings"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="House Details"
                                    label-for="house_details"
                                >
                                    <b-form-input id="house_details" disabled :value="requestReceiverInformation.house_details"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Remarks"
                                    label-for="remarks"
                                >
                                    <b-form-input id="remarks" v-model="formData.remarks"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <!--<b-col sm="4">
                                <b-form-group label="Attachment" label-for="req_doc_file" class="message">
                                    <b-form-file
                                        @change="encodeFile"
                                        id="req_doc_file"
                                        placeholder="Attachment"
                                    ></b-form-file>
                                </b-form-group>
                            </b-col>-->
                        </b-row>
                    </b-card-text>
                    <b-row>
                        <b-col>
                            <b-button class="float-right" variant="primary" @click="request">Request</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
                <b-card-body v-else class="border">
                    <p  class="text-danger text-center">You are not allowed to request for house interchange!</p>

                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Request List</b-card-header>
                <b-card-body class="border">
                    <b-table
                        :items="items"
                        :fields="fields"
                        small
                        hover
                        striped
                        responsive
                    >
                        <template #cell(actions)="row">
                            <b-button v-if="row.item.sent_received != 'REQUEST SENT' && row.item.accept_yn == 'N'" size="sm" variant="success"  @click="accept(row.item)" class="mr-1">
                                Accept/Deny
                            </b-button>
                        </template>
                    </b-table>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker'
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    import Datatable from '../../../../layouts/common/datatable';
    import ApiRepository from "../../../../Repository/ApiRepository";
    const {required, requiredIf, maxLength, minLength, email, maxValue, decimal} = require("vuelidate/lib/validators");
    export default {
        components: {DatePicker, Datatable, vSelect},
        data() {
            return {
                selectedRequestReceiver: {
                    option_name: '',
                    allot_id: '',
                },
                requestReceiverOptions: [],
                self_information: {
                    allot_id: "",
                    department_name: "",
                    designation: "",
                    dpt_section: "",
                    emp_code: null,
                    emp_name: "",
                    floor_number: null,
                    house_code: "",
                    house_details: '',
                    house_name: "",
                    house_size: "",
                    option_name: '',
                    sanitary_fittings: "",
                    take_over_date: null,
                    water_tap: ""
                },
                requestReceiverInformation: {
                    allot_id: "",
                    department_name: "",
                    designation: "",
                    dpt_section: "",
                    emp_code: null,
                    emp_name: "",
                    floor_number: null,
                    house_code: "",
                    house_details: '',
                    house_name: "",
                    house_size: "",
                    sanitary_fittings: "",
                    take_over_date: null,
                    water_tap: ""
                },
                formData: {
                    int_request_id: '',
                    req_from_allot_id: '',
                    req_to_allot_id: '',
                    accept_yn: 'N',
                    remarks: '',
                    req_doc_file: '',
                    req_doc_name: '',
                    req_doc_type: '',
                    user_id: ''
                },
                items: [],
                fields: [
                    {
                        key: 'sent_received',
                        label: 'Request'
                    },
                    {
                        key: 'int_request_date',
                        label: 'Request Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                    },
                    {
                        key: 'request_sender'
                    },
                    {
                        key: 'request_receiver'
                    },
                    {
                        key: 'accept_yn',
                        label: 'Accept Status',
                        formatter: value => {
                            if(value == 'Y') {
                                return 'ACCEPTED'
                            } else if(value == 'N'){
                                return 'PENDING'
                            } else if ( value == 'D') {
                                return 'DENIED'
                            } else {
                                return ''
                            }
                        },
                    },
                    'actions'
                ]
            }
        },
        mounted() {
            this.selfAllotmentInformation()
            this.request_list()
        },
        watch: {
            selectedRequestReceiver: function (val, oldVal) {
                if(val){
                    this.formData.req_to_allot_id = val.allot_id
                    this.formData.user_id = val.user_id
                    this.requestReceiverInformation = val
                } else {
                    this.formData.req_to_allot_id = ""
                    this.requestReceiverInformation = {
                        allot_id: "",
                        department_name: "",
                        designation: "",
                        dpt_section: "",
                        emp_code: null,
                        emp_name: "",
                        floor_number: null,
                        house_code: "",
                        house_details: '',
                        house_name: "",
                        house_size: "",
                        sanitary_fittings: "",
                        take_over_date: null,
                        water_tap: ""
                    }
                }
            }
        },
        methods: {
            selfAllotmentInformation(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/house-allotment/self-allotment-information`).then(res => {
                    if(res.data.length > 0){
                        this.self_information = res.data[0]
                        this.formData.req_from_allot_id = res.data[0].allot_id
                    }
                })
            },
            employeesFromHouseAllotment(params){
                if(params){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/house-allotment/employees-from-house-allotment/${params}`).then(res => {
                        this.requestReceiverOptions = res.data
                    });
                }
            },
            request_list(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/house-allotment/request-list`).then(res => {
                    this.items = res.data
                });
            },
            request(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/house-allotment/create`, this.formData).then(res => {
                    if(res.data.o_status_code == 1){
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset()
                        this.request_list()
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }

                })
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
                            vm.formData.req_doc_file = reader.result;
                            vm.formData.req_doc_name = name;
                            vm.formData.req_doc_type = type;
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
            accept(item){
                this.$bvModal.msgBoxConfirm('Please confirm that you want to accept or deny', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'Accept',
                    cancelTitle: 'Deny',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(value => {
                        if(value == true) {
                            item.accept_yn = 'Y'
                            ApiRepository.callApi(ApiRepository.POST_COMMAND,`/house-allotment/create`, item).then( res => {
                                if (res.data.o_status_code == 1) {
                                    this.request_list()
                                    this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                                } else {
                                    this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                }
                            })
                        } else if(value == false) {
                            item.accept_yn = 'D'
                            ApiRepository.callApi(ApiRepository.POST_COMMAND,`/house-allotment/create`, item).then( res => {
                                if (res.data.o_status_code == 1) {
                                    this.request_list()
                                    this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                                } else {
                                    this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                }
                            })
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            onReset(){
                this.formData = {
                    int_request_id: '',
                    req_from_allot_id: this.formData.req_from_allot_id,
                    req_to_allot_id: '',
                    remarks: '',
                    req_doc_file: '',
                    req_doc_name: '',
                    req_doc_type: '',
                    accept_yn: 'N'
                }
            }
        }
    }
</script>

<style scoped>
    .form-control:disabled, .form-control[readonly] {
        background-color: #F2F4F4!important;
        opacity: 1;
    }
</style>
