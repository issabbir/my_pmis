<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked  pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col class="pr-md-0">
                        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                            <b-card title="Family Member">
                                <b-card-body class="border">
                                    <b-row>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Name" label-for="emp_member_name" class="requiredField">
                                                <b-form-input :maxlength="200" v-model="family.emp_member_name" class="uppercase" required v-validate="'required'" name="emp_member_name"></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('emp_member_name') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Name Bangla" label-for="emp_member_name_bng">
                                                <b-form-input  :maxlength="3000" v-model="family.emp_member_name_bng" class="uppercase" name="emp_member_name_bng"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Relation" label-for="relation_type_id" class="requiredField">
                                                <v-select v-model="relationTypes" :options="relationOptions"
                                                          name="relation_type_id" id="relation_type_id" label="text"
                                                          class="uppercase"
                                                          required v-validate="'required'">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('relation_type_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Status" label-for="family_member_status_id">
                                                <v-select v-model="memberStatus" :options="familyStatusOptions"
                                                          name="family_member_status_id" id="family_member_status_id" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('family_member_status_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Address line 1" label-for="address_line_1">
                                                <b-form-input :maxlength="500" v-model="family.address_line_1" class="uppercase" trim name="address_line_1" id="address_line_1"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Address line 2" label-for="address_line_2">
                                                <b-form-input :maxlength="500" v-model="family.address_line_2" class="uppercase" trim name="address_line_2" id="address_line_2"></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="3">
                                            <b-form-group
                                                label="District"
                                                label-for="district"
                                                class="requiredField">
                                                <v-select v-model="districts" :options="district_ids"
                                                          @input="geoDistrictChange"
                                                          name="district_id" id="district_id" label="text"
                                                          class="uppercase"
                                                          required v-validate="'required'">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('district_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                class="requiredField"
                                                label="THANA/UPAZILA"
                                                label-for="thana">
                                                <v-select v-model="thanas" :options="thana_ids"
                                                          name="thana_id" id="thana_id" label="text"
                                                          class="uppercase"
                                                          required v-validate="'required'">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('thana_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="post code"
                                                label-for="post_code">
                                                <b-form-input
                                                    id="postcode"
                                                    v-model="family.post_code"
                                                    v-validate="'numeric|length:4'"
                                                    type="text"
                                                    class="uppercase"
                                                    placeholder="Enter Postcode"
                                                    name="post_code"
                                                ></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('post_code') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Date of birth" class="requiredField"
                                                label-for="emp_member_dob">
                                                <date-picker v-model="family.emp_member_dob" width="100%" input-class="form-control"  type="date" lang="en" format="DD-MM-YYYY" :value-type="valueType" :editable="false" :not-after="notAfterToday()" required v-validate="'required'" name="emp_member_dob"></date-picker>
                                                <span :style="errorMessage">{{ errors.first('emp_member_dob') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Mobile"  label-for="emp_member_mobile">
                                                <b-form-input :maxlength="15" v-model="family.emp_member_mobile"  v-validate="{numeric: true, regex: /^01[5-9]\d{8}$/ }" name="emp_member_mobile" @keypress="isNumber($event)"></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('emp_member_mobile') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Authentication type" label-for="auth_doc_type_id">
                                                <v-select v-model="authTypes" :options="auth_type_ids"
                                                          name="auth_doc_type_id" id="auth_doc_type_id" label="text" @input="onChangeAuthenticationType"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group :class="authIdValidationRule ? 'requiredField' : ''"
                                                          label="Authentication ID" label-for="auth_id">
                                                <b-form-input v-model="family.auth_id" name="auth_id" v-validate="authIdValidationRule" @input="uniqueAuthenticationIdentity" @change="uniqueAuthenticationIdentity"></b-form-input>
                                                <span :style="errorMessage" v-if="unique_authentication_identity_message">{{ unique_authentication_identity_message }}</span>
                                                <span :style="errorMessage">{{ errors.first('auth_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Medical ID" label-for="emp_member_medical_id">
                                                <b-form-input :maxlength="50" v-model="family.emp_member_medical_id" name="emp_member_medical_id"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Gender" class="requiredField" label-for="gender_id">
                                                <v-select v-model="genders" :options="gender_ids"
                                                          name="gender_id" id="gender_id" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('gender_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group label="Education Allowance" label-for="emp_member_allowance_yn">
                                                <b-form-radio-group
                                                    id="emp_member_allowance_yn"
                                                    v-model="family.emp_member_allowance_yn"
                                                    :options="allowances"
                                                    name="emp_member_allowance_yn"
                                                ></b-form-radio-group>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group label="Is Nominee" label-for="is_nominee">
                                                <b-form-checkbox
                                                    id="is_nominee_yn"
                                                    v-model="family.is_nominee_yn"
                                                    name="is_nominee_yn"
                                                    value="Y"
                                                    unchecked-value="N">
                                                    Accept
                                                </b-form-checkbox>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3" v-if="family.is_nominee_yn=='Y'">
                                            <b-form-group
                                                label="Percentage(%)"
                                                label-for="percentage">
                                                <b-form-input
                                                    id="percentage"
                                                    v-model="family.percentage"
                                                    type="text"
                                                    placeholder="percentage(%)"
                                                    name="percentage"
                                                    :maxlength="3"
                                                    v-validate="'decimal:2|max_value:100'">
                                                </b-form-input>
                                                <span :style="errorMessage">{{ errors.first('percentage') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3" v-if="hasPermission('CAN_APPROVE_EMPLOYEE')==true">
                                            <b-form-group
                                                class="requiredField"
                                                label="Approved"
                                                label-for="approved_yn">
                                                <b-form-radio-group
                                                    v-model="family.approved_yn"
                                                    :options="approved_yn_options"
                                                    name="approved_yn" required  v-validate="'required'"
                                                ></b-form-radio-group>
                                                <span :style="errorMessage">{{ errors.first('approved_yn') }}</span>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>&nbsp;
                                            <b-button type="reset" class="btn btn-outline-dark" :disabled="keepDisable">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                </b-card-body>
                            </b-card>
                        </b-form>
                        <b-card title="Family Information List">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'emp_family_id'">
                                    <template v-slot:actions="{ rows }" >
                                        <b-link ml="4" class="text-primary"
                                                @click="editRow(rows.item.emp_family_id)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>
                                        <b-link class="text-danger" v-b-modal="'family-remove'" @click="deletedItem = rows.item">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                    </template>
                                </Datatable>
                                <b-modal :id="'family-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                                         @ok="deleteRow()" @hidden="deletedItem = null">
                                    <div>Are you sure you want to delete?</div>
                                </b-modal>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker'
    import vSelect from 'vue-select';
    import SideBar from "../partials/sidebar";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker, SideBar, Datatable,vSelect},
        props: ['id'],
        data() {
            return {
                deletedItem: null,
                unique_authentication_identity_message: '',
                keepDisable: false,
                authIdValidationRule: '',
                errorMessage: {color: 'red'},
                approved_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                districts: {'text':'','value':''},
                thanas: {'text':'','value':''},
                authTypes: {'text':'','value':''},
                memberStatus: {'text':'','value':''},
                relationTypes: {'text':'','value':''},
                genders: {'text':'','value':''},
                valueType: this.dateFormatter(),
                family: {
                    emp_member_name: '',
                    emp_member_name_bng: '',
                    relation_type_id: '',
                    family_member_status_id: '',
                    address_line_1: '',
                    address_line_2: '',
                    district_id: '',
                    thana_id: '',
                    post_code: '',
                    emp_member_dob: '',
                    emp_member_mobile: '',
                    auth_doc_type_id: '',
                    auth_id: '',
                    emp_member_medical_id: '',
                    gender_id: '',
                    emp_member_allowance_yn:"N",
                    percentage:'',
                    is_nominee_yn:'',
                    old_district_id:'',

                },
                relationOptions:[{'value': '', 'text': 'Select Relation'}],
                familyStatusOptions:[{'value': '', 'text': 'Select Status'}],
                allowances:[{"text": "YES", "value": "Y"},{"text": "NO", "value": "N"}],
                auth_type_ids: [{'value': '', 'text': 'Select Authentication type'}],
                gender_ids:[{'value': '', 'text': 'Select Gender'}],
                district_ids: [{'value': '', 'text': 'Select District'}],
                thana_ids: [{'value': '', 'text': 'Select Thana/Upazilla'}],
                medical_ids:[],
                updateIndex:-1,
                submitBtn: 'Save',
                show: true,
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'emp_member_name', label: 'Name', sortable: true},
                    {key: 'gender.gender_name', label:'Gender',  sortable: true},
                    {key: 'emp_member_dob',
                        label:'Date of birth', sortable: true, filterByFormatted: true, sortByFormatted: true,
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }
                    },
                    {key: 'relation.relation_type', label: "Relation", sortable: true},
                    {key: 'family_status.family_member_status', label:'Family status', sortable: true},
                    {
                        key: 'emp_member_allowance_yn', label:'Allowance applicable', sortable: true, filterByFormatted: true, sortByFormatted: true, formatter: (value) => {
                            if(value === 'N') {
                                return 'No';
                            } else {
                                return 'Yes';
                            }
                        }
                    },
                    {key: 'emp_member_mobile', label:"Mobile", sortable: true},'action'],
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
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Family"});
            this.family.emp_id = this.id;
            this.loadData();
        },
        watch: {
            districts:function(val,oldVal) {
                if(val !== null) {
                    this.family.district_id = val;
                } else {
                    this.family.district_id = '';
                }
            },
            thanas:function(val,oldVal) {
                if(val !== null) {
                    this.family.thana_id = val;
                } else {
                    this.family.thana_id = '';
                }
            },
            authTypes:function(val,oldVal){
                if(val !== null) {
                    this.family.auth_doc_type_id = val;
                } else {
                    this.family.auth_doc_type_id = '';
                }
            },
            genders:function(val,oldVal){
                if(val !== null) {
                    this.family.gender_id = val;
                } else {
                    this.family.gender_id = '';
                }
            },
            relationTypes:function(val,oldVal){
                if(val !== null) {
                    this.family.relation_type_id = val;
                } else {
                    this.family.relation_type_id = '';
                }
            },
            memberStatus:function(val,oldVal){
                if(val !== null) {
                    this.family.family_member_status_id = val;
                } else {
                    this.family.family_member_status_id = '';
                }
            },
            "family.auth_doc_type_id": function() {
                let auth_type = this.auth_type_ids.filter(row => {
                    return this.family.auth_doc_type_id.auth_doc_type_id == row.auth_doc_type_id;
                });
                if(auth_type) {
                    let auth_doc_type_name = auth_type[0].auth_doc_type_name;
                    if(auth_doc_type_name) {
                        auth_doc_type_name = auth_doc_type_name.toLowerCase();
                        if(auth_doc_type_name == 'birth certificate') {
                            this.authIdValidationRule = "required|birthCertificate";
                        } else if(auth_doc_type_name == 'national id') {
                            this.authIdValidationRule =  "required|nationalId";
                        }  else if(auth_doc_type_name == 'passport') {
                            this.authIdValidationRule = "required";
                        } else {
                            this.authIdValidationRule = "";
                            this.family.auth_id = "";
                        }
                    } else {
                        this.authIdValidationRule = "";
                        this.family.auth_id = "";
                    }
                } else {
                    this.authIdValidationRule = "";
                    this.family.auth_id = "";
                }
            },
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
        methods: {
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();;
                } else {
                    return true;
                }
            },
            onChangeAuthenticationType(){
                this.family.auth_id = ""
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            uniqueAuthenticationIdentity() {
                if(
                    (this.family.auth_doc_type_id && this.family.auth_id)
                ) {
                    let params = {
                        'emp_family_id': this.family.emp_family_id,
                        'auth_doc_type_id': this.family.auth_doc_type_id,
                        'auth_id': this.family.auth_id,
                        'emp_id': this.family.emp_id,
                    };
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/families/unique-family-auth-id', {params}).then(result => {
                        this.unique_authentication_identity_message = result.data.unique_message;
                    });
                }
            },
            geoDistrictChange(id){
                if(id){
                    let district_id=(typeof(id))=='string'?id:id['value'];
                    if(this.family.old_district_id){
                        if(district_id!=this.family.old_district_id){
                            this.thanas='';
                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-thanas/${district_id}`).then(result => {
                        this.thana_ids = result.data;
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
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            onSubmit() {
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any() && (this.unique_authentication_identity_message=='')) {
                        this.keepDisable = true;
                        if(this.family.is_nominee_yn=='N'){
                            this.family.percentage=''
                        }
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/families", this.family).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.onReset();
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                            } else {
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                            }
                            this.loadData();
                            this.keepDisable = false;
                        });
                    }
                });
            },
            loadData: function() {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/families/specific/${this.id}`).then(res => {
                        if(this.relationOptions.length <=1) {
                            this.relationOptions = this.relationOptions.concat(res.data.relations);
                        }

                        if(this.auth_type_ids.length <=1) {
                            this.auth_type_ids = this.auth_type_ids.concat(res.data.auth_type_ids);
                        }

                        if(this.gender_ids.length <=1) {
                            this.gender_ids = this.gender_ids.concat(res.data.gender);
                        }

                        if(this.familyStatusOptions.length <=1) {
                            this.familyStatusOptions = this.familyStatusOptions.concat(res.data.family_status);
                        }

                        if(this.district_ids.length <= 1) {
                            this.district_ids = this.district_ids.concat(res.data.district_ids);
                        }
                        this.family.address_line_1=res.data.empAddress.address_line_1;
                        this.family.address_line_2=res.data.empAddress.address_line_2;
                        this.districts=res.data.empAddress.geo_district;
                        this.thanas=res.data.empAddress.geo_thana;
                        this.family.post_code =res.data.empAddress.post_code;
                        this.items = res.data.data;
                        this.totalList = res.data.data.length;
                        this.thana_ids=res.data.selectedThanaByDefult;

                    });
                }
            },
            onReset() {
                this.thana_ids = [{'value': '', 'text': 'Select Thana/Upazilla'}];
                this.unique_authentication_identity_message = '';
                this.updateIndex = -1;
                this.deletedItem = null;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.authTypes='';
                    this.genders='';
                    this.relationTypes='';
                    this.memberStatus='';
                    this.family={};
                    this.family.emp_member_allowance_yn  = 'N';
                    this.show = true
                })
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1
            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/pmis/employee/families/${id}`).then(result=>{
                    this.submitBtn = 'Update';
                    this.family = result.data;
                    this.memberStatus=result.data.family_status;
                    this.districts=result.data.selectedFamilyMemberDistrict;
                    this.family.old_district_id=result.data.selectedFamilyMemberDistrict.geo_district_id;
                    this.thanas=result.data.selectedFamilyMemberThana;
                    this.relationTypes=result.data.relation;
                    this.genders=result.data.gender;
                    this.authTypes=result.data.selectedAuthType;
                    this.geoDistrictChange(this.family.district_id);
                    this.family.emp_family_id = id;
                });
            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/pmis/employee/families/${this.deletedItem.emp_family_id}`).then(res=> {
                        if (res.data.o_status_code == 1) {
                            this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' });
                        } else {
                            this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' });
                        }

                        this.deletedItem = null;
                        this.loadData();
                        this.onReset();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }
            }
        }
    }
</script>
<style>
    .uppercase { text-transform: uppercase; }
</style>
