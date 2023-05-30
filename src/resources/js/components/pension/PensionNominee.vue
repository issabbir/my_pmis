<template>
    <div>
        <b-card title="Nominee">
            <b-card-body class="border">
                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" >
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="Code"
                                label-for="nominee_code"  class="requiredField"
                            >
                                <b-form-input
                                    required
                                    id="nominee_name"
                                    name="nominee_name"
                                    v-model="nominee.nominee_code"
                                    type="text"
                                    :maxlength="200"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Name"
                                label-for="nominee_name"  class="requiredField"
                            >
                                <b-form-input
                                    id="nominee_name"
                                    name="nominee_name"
                                    v-model="nominee.nominee_name"
                                    type="text"
                                    :maxlength="200"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Relationship"
                                label-for="relationship_nominee"  class="requiredField"
                            >
                                <v-select v-model="relationships" :options="relationOptions"
                                          name="relationship_nominee" id="relationship_nominee" label="text"
                                          class="uppercase">
                                    <template #search="{attributes, events}">
                                        <input
                                            class="vs__search"
                                            v-bind="attributes"
                                            v-on="events"
                                        />
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>


                        <b-col md="3">
                            <b-form-group
                                label="Contact No."
                                label-for="contact_no"
                            >
                                <b-form-input
                                    id="contact_no"
                                    v-model="nominee.nominee_contact_no"
                                    type="text"
                                    name="nominee_contact_no"
                                    v-validate="{ numeric: true, regex: /^01[5-9]\d{8}$/ }"
                                    :maxlength="15"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="E-mail"
                                label-for="nominee_email"
                            >
                                <b-form-input
                                    id="nominee_email"
                                    v-model="nominee.nominee_email"
                                    type="text"
                                    name="nominee_email"
                                    :maxlength="50"
                                    v-validate="'email'"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Date of Birth"
                                label-for="nominee_dob" class="requiredField"
                            >
                                <date-picker
                                    v-model="nominee.nominee_dob"
                                    width="100%"
                                    name="nominee_dob"
                                    input-class="form-control"
                                    type="date" lang="en"
                                    format="DD-MM-YYYY"
                                    :value-type="valueType"
                                    :editable="false"
                                    :not-after="notAfterToday()">
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Account No"
                                label-for="nominee_acc_no">
                                <b-form-input
                                    id="nominee_acc_no"
                                    v-model="nominee.nominee_acc_no"
                                    type="text"
                                    name="nominee_acc_no"
                                    :maxlength="500"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Percentage(%)"
                                label-for="percentage"
                                class="requiredField"
                            >
                                <b-form-input
                                    id="percentage"
                                    v-model="nominee.percentage"
                                    type="text"
                                    name="percentage"
                                    :maxlength="3"
                                    v-validate="'decimal:2|max_value:100'"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3"  >
                            <b-form-group
                                label="Pension Start Date"
                                label-for="pension_start_date"
                            >
                                <date-picker
                                    width="100%"
                                    input-class="form-control"
                                    v-model="nominee.nominee_pension_start_date"
                                    type="date"
                                    lang="en"
                                    :editable="false"
                                    format="DD-MM-YYYY"
                                    required>
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" >
                            <b-form-group
                                label="Pension End Date"
                                label-for="pension_end_date"
                            >
                                <date-picker
                                    width="100%"
                                    input-class="form-control"
                                    v-model="nominee.nominee_pension_end_date"
                                    type="date"
                                    lang="en"
                                    :editable="false"
                                    format="DD-MM-YYYY"
                                    required>
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Pension amount"
                                label-for="nominee_pension_amount"
                            >
                                <b-form-input
                                    id="nominee_pension_amount"
                                    v-model="nominee.nominee_pension_amount"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Medical Amount"
                                label-for="nominee_medical_amount"
                            >
                                <b-form-input
                                    id="nominee_medical_amount"
                                    v-model="nominee.nominee_medical_amount"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Total"
                                label-for="nominee_total"
                            >
                                <b-form-input
                                    id="nominee_total"
                                    v-model="nominee.nominee_total"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>

                    </b-row>
                    <b-row>
                        <b-col class="d-flex justify-content-end">
                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>&nbsp;
                            <b-button type="reset" class="btn btn-outline-dark" :disabled="keepDisable">Cancel</b-button>
                        </b-col>
                    </b-row>
                </b-form>
                <b-table small responsive :items="temp_item" :fields="temp_fields" responsive>
                    <template v-slot:cell(percentage)="{ value, item, field: { key }}">
                        <template v-if="item.edit_yn == 'N'">{{ value }}</template>
                        <b-form-input class="text-right" v-else v-model="item[key]" />
                    </template>
                    <template v-slot:cell(action)="{ item, index }">
                        <b-link class="text-primary" @click="item.edit_yn = item.edit_yn == 'N'?'Y':'N'" ml="4"><i class="bx cursor-pointer" :class="item.edit_yn == 'N'?'bx-edit':'bx-detail'"></i></b-link>
                        <b-link class="text-danger" v-if="item.edit_yn == 'N' && item.percentage == 0"  @click="onDelete(item.nominee_id, item.emp_family_id, index)"><i class="bx bx-trash cursor-pointer"></i></b-link>
                    </template>
                </b-table>
                <div >Total Percentage: <strong>{{totalPercentage}}</strong></div>
                <b-row>
                    <b-col class="d-flex justify-content-end align-items-end">
                        <b-button @click="finalSubmit" type="button">Save</b-button>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import moment from 'moment';
    import SideBar from "../pmis/partials/sidebar";
    import Datatable from '../../layouts/common/datatable';
    import DatePicker from 'vue2-datepicker';
    import ApiRepository from "../../Repository/ApiRepository";
    import vSelect from 'vue-select';
    const {required, requiredIf, maxLength, minLength, email, maxValue, decimal} = require("vuelidate/lib/validators");
    export default {
        components: {DatePicker, SideBar,Datatable, vSelect},
        name: 'PensionNominee',
        props: ['id', 'used_by', 'relationOptions', 'nominees'],
        data() {
            return {
                can_update: false,
                edit: null,
                totalPercentage:0,
                temp_item: [],
                temp_fields: [
                    {key: 'nominee_name', sortable: true},
                    {
                        key: 'percentage',
                        label: 'Percentage',
                        sortable: true,
                        filterByFormatted: true,
                        sortByFormatted: true,
                        formatter: (value) => {
                            if(value) {
                                return value+"%";
                            }
                            return value;
                        },
                        class:'text-right'
                    },
                    {key: 'relationship.text', label: 'Relationship', sortable: true},
                    {key: 'nominee_pension_amount', label: 'Pension Amount', sortable: true},
                    {key: 'nominee_medical_amount', label: 'Medical Amount', sortable: true},
                    {key: 'nominee_total', label: 'Total Amount', sortable: true},
                ],
                familyOptions: [],
                selectedFamily: {text: '', value: '',emp_member_name:''},
                alternateNominee: [],
                relationships: {text:'',value:'', gender_id: ''},
                maritalStatus: {'text':'','value':''},
                genders: {text:'',value:''},
                districts: {'text':'','value':''},
                thana: {'text':'','value':''},
                authenticationTypes: {'text':'','value':''},
                banks: {'text':'','value':''},
                branches: {'text':'','value':''},
                deletedItem: null,
                unique_authentication_identity_message: '',
                keepDisable: false,
                authIdValidationRule: '',
                errorMessage: {color: 'red'},
                approved_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                autisticOptions: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                valueType: this.dateFormatter(),
                nominee: {
                    active_yn: 'Y',
                    emp_id: this.id,
                    emp_family_id: null,
                    edit_yn: 'N',
                    autistic_yn: 'N',
                    approved_yn: 'N',
                    nominee_for_id: 2,
                    nominee_name: '',
                    relationship_id: '',
                    relationship: {},
                    percentage: '',
                    address_line_1: '',
                    address_line_2: '',
                    district_id: '',
                    thana_id: '',
                    post_code: '',
                    nominee_contact_no: '',
                    nominee_email: '',
                    nominee_dob: '',
                    nominee_marital_status_id: '',
                    marital_status: {},
                    nominee_photo: null,
                    nominee_photo_name: null,
                    nominee_photo_type: null,
                    auth_type_id: '',
                    nominee_auth_id: '',
                    nominee_auth_id_photo: null,
                    nominee_auth_id_photo_name: null,
                    nominee_auth_id_photo_type: null,
                    nominee_acc_no: '',
                    medical_id: '',
                    bank_id: '',
                    branch_id: '',
                    nominee_gender_id: '',
                    old_district_id: '',
                    nominee_id: '',
                    pension_start_date: '',
                    pension_end_date: '',
                    pension_amt: '',
                    medical_allow: '',
                    nominee_total: '',
                },
                relationshipWithNomineeList: [{'value': '', 'text': 'Select Relationship with Nominee'}],
                maritalStatusList:[{'value': '', 'text': 'Select Marital status'}],
                authTypeList:[{'value': '', 'text': 'Select Authentication Type'}],
                bankList:[{'value': '', 'text': 'Select Bank'}],
                branchList:[{'value': '', 'text': 'Select Branch'}],
                genderList:[{value: null, text: 'Select Gender'}],
                district_ids: [{'value': '', 'text': 'Select District'}],
                thana_ids: [{'value': '', 'text': 'Select Thana/Upazilla'}],
                updateIndex:-1,
                submitBtn: 'Add',
                items: [],
                totalList: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
            }
        },
        watch: {
            can_update: function(val, oldVal){
                if(val){
                    this.temp_fields.push({key: 'action', class: 'text-center'})
                }
            },
            totalPercentage:function(val, oldVal){
                if(val > 100){
                    this.$notify({ group: 'pmis', text: 'Your total percentage cannot exceed 100', type:'error' })
                }
            },
            temp_item: {
                deep: true,
                handler(val, oldVal){
                    this.totalPercentage = 0
                    this.temp_item.filter(a => a.active_yn == 'Y').forEach(this.calculatePercentage)
                }
            },
            alternateNominee: {
                handler(newValue, oldValue) {
                    this.nominee.alternate_nominee = newValue
                    this.nominee.alternate_nominee_names = ''
                    newValue.forEach(a=>{
                        this.nominee.alternate_nominee_names = this.nominee.alternate_nominee_names +=  (this.nominee.alternate_nominee_names ? ', '+a.emp_member_name: a.emp_member_name)
                    })
                },
                deep: true
            },
            selectedFamily: function(val, oldVal){
                if(val !== null){
                    this.relationships = {text: val.relation.text, value: val.relation.value, gender_id: val.relation.gender_id}
                    this.genders = {text: val.gender?val.gender.gender_name:'Select Gender', value: val.gender?val.gender.gender_id:null}
                    this.districts = {text: val.district?val.district.text:'', value: val.district?val.district.value:''}
                    if(val.district){
                        this.geoDistrictChange(val.district.value)
                    }
                    this.thana = {text: val.thana?val.thana.text:'', value: val.thana?val.thana.value:null}
                    this.authenticationTypes = val.auth_doc_type
                    this.nominee = {
                        active_yn: 'Y',
                        emp_id: this.id,
                        edit_yn: 'N',
                        autistic_yn: 'N',
                        approved_yn: 'N',
                        nominee_for_id: 2,
                        emp_family_id: val.emp_family_id,
                        nominee_name: val.emp_member_name,
                        relationship_id: val.relation_type_id,
                        relationship: {
                            text: val.relation.text,
                            value: val.relation.value
                        },
                        percentage: val.percentage,
                        address_line_1: val.address_line_1,
                        address_line_2: val.address_line_2,
                        district_id: val.district_id,
                        thana_id: val.thana_id,
                        post_code: val.post_code,
                        nominee_contact_no: val.emp_member_mobile,
                        nominee_email: '',
                        nominee_dob: val.emp_member_dob,
                        nominee_marital_status_id: '',
                        marital_status: {
                            marital_status: '',
                            marital_status_id: ''
                        },
                        nominee_photo: null,
                        nominee_photo_name: null,
                        nominee_photo_type: null,
                        auth_type_id: val.auth_doc_type_id,
                        nominee_auth_id: val.auth_id,
                        nominee_auth_id_photo: null,
                        nominee_auth_id_photo_name: null,
                        nominee_auth_id_photo_type: null,
                        nominee_acc_no: '',
                        medical_id: '',
                        bank_id: '',
                        branch_id: '',
                        nominee_gender_id: val.gender_id,
                        old_district_id: '',
                        nominee_id: '',
                        alternate_nominee: [],
                        alternate_nominee_names: '',
                        alternate_nominee_ids: ''
                    }
                    this.alternateNominee = []

                } else {

                }
            },
            relationships:function(val,oldVal) {
                if(val !== null) {
                    this.nominee.relationship_id = val.value;
                    this.nominee.relationship = val;
                    if(val.gender_id == 1){
                        this.genders = {
                            text: 'MALE',
                            value: 1
                        }
                    } else if(val.gender_id == 2) {
                        this.genders = {
                            text: 'FEMALE',
                            value: 2
                        }
                    } else {
                        this.genders = {
                            text: 'SELECT GENDER',
                            value: null
                        }
                    }
                } else {
                    this.nominee.relationship_id = '';
                }
            },
            maritalStatus:function(val,oldVal) {
                if(val !== null) {
                    this.nominee.nominee_marital_status_id = val;
                    this.nominee.marital_status = val;
                } else {
                    this.nominee.nominee_marital_status_id = '';
                }
            },
            genders:function(val,oldVal) {
                if(val !== null) {
                    this.nominee.nominee_gender_id = val;
                } else {
                    this.nominee.nominee_gender_id = '';
                }
            },
            districts:function(val,oldVal) {
                if(val !== null) {
                    this.nominee.district_id = val;
                } else {
                    this.nominee.district_id = '';
                }
            },
            thana:function(val,oldVal) {
                if(val !== null) {
                    this.nominee.thana_id = val;
                } else {
                    this.nominee.thana_id = '';
                }
            },
            authenticationTypes: function (val, oldVal) {
                if (val !== null){
                    this.nominee.auth_type_id = val;
                } else {
                    this.nominee.auth_type_id = '';
                }
            },
            banks: function (val, oldVal) {
                if (val !== null){
                    this.nominee.bank_id = val;
                } else {
                    this.nominee.bank_id = '';
                }
            },
            branches: function (val, oldVal) {
                if (val !== null){
                    this.nominee.branch_id = val;
                } else {
                    this.nominee.branch_id = '';
                }
            }
        },
        created() {
            this.$validator.extend(
                'nationalId',{
                    getMessage: (field) =>  {
                        return 'The given value is incorrect.';
                    },
                    validate: (value) => {
                        let givenValue = value.trim();
                        if(givenValue) {
                            let isNumeric = /^\d+$/.test(givenValue);
                            if(!isNumeric) {
                                return false;
                            }
                            return (givenValue.length === 10) || (givenValue.length === 13) || (givenValue.length === 17);
                        } else {
                            return true;
                        }
                    }
                });
            this.$validator.extend(
                'birthCertificate',{
                    getMessage: (field) =>  {
                        return 'The given value is incorrect.';
                    },
                    validate: (value) => {
                        let givenValue = value.trim();
                        if(givenValue) {
                            let isNumeric = /^\d+$/.test(givenValue);
                            if(!isNumeric) {
                                return false;
                            }
                            return (givenValue.length === 17);
                        } else {
                            return true;
                        }
                    }
                });
        },
        mounted() {
            this.nominee.emp_id = this.id
            if(this.families.length > 0 && this.nominees){
                this.loadData()
            }
            this.canUpdate()
        },
        methods: {
            canUpdate(){
                if(this.used_by === 'pmis'){
                    this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
                } else {
                    this.can_update = true
                }
            },
            onEdit(id) {
                this.edit = this.edit !== id ? id : null;
            },
            onDelete(nominee_id, emp_family_id, index){
                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(response=> {
                        let fid = this.temp_item.emp_family_id;
                        if(response == true){
                            if(nominee_id){
                                ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/pmis/employee/nominees/${nominee_id}`).then(result => {
                                    if (result.data.o_status_code == 1){
                                        this.temp_item = this.temp_item.filter(a=>a.nominee_id != nominee_id)
                                        this.filterFamilies();
                                        this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                                    } else {
                                        this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                                    }
                                })
                            } else {
                                this.temp_item = this.temp_item.filter(a=>a.emp_family_id != emp_family_id)
                                this.filterFamilies();
                            }
                        }
                    })
            },

            geoDistrictChange(id){
                if(id){
                    if(this.nominee.old_district_id){
                        if(id!=this.nominee.old_district_id){
                            this.thana='';
                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-thanas/${id}`).then(result => {
                        this.thana_ids = result.data;

                    });
                }
            },
            bankChange(id){
                if(id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/branches/${id}`).then(result => {
                        this.branchList = result.data;
                    });
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
            },
            notAfterToday() {
                return moment().subtract(1, 'days');
            },
            hasEmpId() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            loadData() {
                if(this.hasEmpId()) {
                    if(this.relationshipWithNomineeList.length <=1) {
                        this.relationshipWithNomineeList = this.relationshipWithNomineeList.concat(this.nominees.relationships);
                    }

                    if(this.authTypeList.length <=1) {
                        this.authTypeList = this.authTypeList.concat(this.nominees.authdocs);
                    }

                    if(this.bankList.length <=1) {
                        this.bankList = this.bankList.concat(this.nominees.banks);
                    }

                    if(this.genderList.length <=1) {
                        this.genderList = this.genderList.concat(this.nominees.genders);
                    }

                    if(this.district_ids.length <= 1) {
                        this.district_ids = this.district_ids.concat(this.nominees.district_ids);
                    }

                    //this.branchList = this.branchList.concat(res.data.branches);
                    this.items = this.nominees.data.filter(a=> a.nominee_for_id == 2);
                    this.temp_item = this.items
                    this.filterFamilies();
                    this.totalList = this.items.length;
                    /* ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/specific/${this.id}`).then(res => {
                         if(this.relationshipWithNomineeList.length <=1) {
                             this.relationshipWithNomineeList = this.relationshipWithNomineeList.concat(res.data.relationships);
                         }

                         if(this.maritalStatusList.length <=1) {
                             this.maritalStatusList = this.maritalStatusList.concat(res.data.maritalStatuses);
                         }

                         if(this.authTypeList.length <=1) {
                             this.authTypeList = this.authTypeList.concat(res.data.authdocs);
                         }

                         if(this.bankList.length <=1) {
                             this.bankList = this.bankList.concat(res.data.banks);
                         }

                         if(this.genderList.length <=1) {
                             this.genderList = this.genderList.concat(res.data.genders);
                         }

                         if(this.district_ids.length <= 1) {
                             this.district_ids = this.district_ids.concat(res.data.district_ids);
                         }

                         //this.branchList = this.branchList.concat(res.data.branches);
                         this.items = res.data.data.filter(a=> a.nominee_for_id == 2);
                         this.temp_item = this.items;

                        this.filterFamilies();

                         this.totalList = this.items.length;
                     });*/
                }
            },
            filterFamilies() {
                this.familyOptions = this.families.filter(a => {
                    let item = this.temp_item.filter(v => v.emp_family_id == a.emp_family_id);
                    if (item.length > 0)
                        return false;
                    else
                        return true;
                });
            },
            calculatePercentage(item, index) {
                if (item.percentage)
                    this.totalPercentage = parseFloat(this.totalPercentage) + parseFloat(item.percentage)
            },
            onSubmit() {
                // this.$touch()
                // this.nominee.$touch()
               // if (!this.nominee.$invalid){
                    if((this.totalPercentage + parseFloat(this.nominee.percentage)) >100){
                        this.$notify({ group: 'pmis', text: 'Your total percentage cannot exceed 100', type:'error' })
                    } else {
                        this.temp_item.unshift(this.nominee)
                        this.filterFamilies()
                        this.modelClear()
                    }
                //}
            },
            finalSubmit() {
                if(this.totalPercentage == 100){
                    let currObj = this;
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/nominees/2", this.temp_item).then(result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                            this.$emit('submitted')
                            currObj.loadData();
                            currObj.onReset();
                        } else{
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                        }

                        this.keepDisable = false;
                    });
                } else {
                    this.$notify({ group: 'pmis', text: 'Total percentage should be 100%', type:'error' })
                }
            },
            onReset() {
                this.thana_ids = [{'value': '', 'text': 'Select Thana/Upazilla'}];
                this.updateIndex = -1;
                this.deletedItem = null;
                this.unique_authentication_identity_message = '';
                this.submitBtn = 'Add';
                this.$nextTick(() => {
                    this.modelClear()

                })
            },
            modelClear(){
                this.nominee = {
                    active_yn: 'Y',
                    emp_id: this.id,
                    emp_family_id:'',
                    autistic_yn: 'N',
                    approved_yn: 'N',
                    nominee_for_id: 2,
                    nominee_name: '',
                    relationship_id: '',
                    relationship: {},
                    percentage: '',
                    address_line_1: '',
                    address_line_2: '',
                    district_id: '',
                    thana_id: '',
                    post_code: '',
                    nominee_contact_no: '',
                    nominee_email: '',
                    nominee_dob: '',
                    nominee_marital_status_id: '',
                    marital_status: {},
                    nominee_photo: null,
                    nominee_photo_name: null,
                    nominee_photo_type: null,
                    auth_type_id: '',
                    nominee_auth_id: '',
                    nominee_auth_id_photo: null,
                    nominee_auth_id_photo_name: null,
                    nominee_auth_id_photo_type: null,
                    nominee_acc_no: '',
                    medical_id: '',
                    bank_id: '',
                    branch_id: '',
                    nominee_gender_id: '',
                    old_district_id: '',
                    nominee_id: '',
                    alternate_nominee: [],
                    alternate_nominee_names: '',
                    alternate_nominee_ids: ''
                }
                this.selectedFamily = null
                this.alternateNominee = []
                this.relationships = {text:'',value:'', gender_id: ''}
                this.maritalStatus = {'text':'','value':''}
                this.genders = {'text':'','value':''}
                this.districts = {'text':'','value':''}
                this.thana = {'text':'','value':''}
                this.authenticationTypes = {text:'',value:''}
                this.banks = {'text':'','value':''}
                this.branches = {'text':'','value':''}
               // this.$reset()
            }
        }
    }
</script>

<style>
    .file-upload-form, .image-preview {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        padding: 20px;
    }
    img.preview {
        width: 200px;
        background-color: white;
        border: 1px solid #DDD;
        padding: 5px;
    }
    #nomineepic, #nomineedoc{
        height: 180px !important;
        width: 100%;
    }
    .d-block{
        display: none;
    }
</style>
