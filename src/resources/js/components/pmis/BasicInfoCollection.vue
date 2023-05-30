<template>
    <b-container fluid class="ml-2">
        <b-card >
            <b-card-header header-bg-variant="dark" header-text-variant="white">Basic Information</b-card-header>
            <b-card-body class="border" :style="!can_update?'pointer-events:none':''">
                <b-form @submit.prevent="addBasicInfo">
                  <b-row>
                    <b-col md="10">
                      <b-row>
                        <b-col md="4">
                          <b-form-group
                            label="Employee Code"
                            label-for="emp_code"
                          >
                            <b-form-input
                              v-model="formData.emp_code"
                              id="emp_name_bng" readonly>
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Employee Name"
                            label-for="emp_name"
                          >
                            <b-form-input v-model="formData.emp_name" id="emp_name" nmae="emp_name" readonly
                                          required></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="DEPARTMENT" label-for="department_name">
                            <b-form-input
                              readonly
                              v-model="formData.department_name"
                              id="department_name"
                              name="department_name"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Designation" label-for="designation">
                            <b-form-input
                              readonly
                              v-model="formData.designation"
                              id="designation"
                              name="designation"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Employee Name (Bangla)"
                            label-for="emp_name_bng"
                          >
                            <b-form-input v-model="formData.emp_name_bng" id="emp_name_bng"></b-form-input>
                          </b-form-group>
                        </b-col>

                        <b-col md="4">
                          <b-form-group
                            label="Blood Group"
                            label-for="emp_blood_group_id">
                            <v-select v-model="bloodGroups" :options="bloodGroupList"
                                      name="emp_blood_group_id" id="emp_blood_group_id"
                                      label="text"
                                      required v-validate="'required'">
                              <template #search="{attributes, events}">
                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                              </template>
                            </v-select>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Controlling Officer"
                            label-for="reporting_officer_id">
                            <v-select
                              label="option_name"
                              v-model="selectedControllingOfficer"
                              :options="employeeList"
                              @search="searchEmployeeById"
                              id="reporting_officer_id"
                              name="reporting_officer_id"
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
                        <b-col md="4">
                          <b-form-group
                            class="requiredField"
                            label="Marital Status"
                            label-for="emp_maritial_status_id">
                            <v-select
                              class="uppercase"
                              v-model="maritalStatus"
                              :options="maritalStatusOptions"
                              v-validate="'required'"
                              label="text"
                              id="emp_maritial_status_id"
                              name="emp_maritial_status_id">
                              <template #search="{attributes, events}">
                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                              </template>
                            </v-select>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_maritial_status_id.$error && !$v.formData.emp_maritial_status_id.required}">Marital status is required!</div>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            class="requiredField"
                            label="Religion"
                            label-for="emp_religion_id">
                            <v-select
                              v-model="religions"
                              :disabled="readonlyShow"
                              :options="religionList"
                              name="emp_religion_id" id="emp_religion_id"
                              label="text"
                                v-validate="'required'">
                              <template #search="{attributes, events}">
                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                              </template>
                            </v-select>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_religion_id.$error && !$v.formData.emp_religion_id.required}">Religion is required!</div>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            class="requiredField"
                            label="Gender"
                            label-for="emp_gender_id">
                            <b-form-radio-group
                                :disabled="readonlyShow"
                              v-model.trim="$v.formData.emp_gender_id.$model"
                              :options="genderList"
                              name="emp_gender_id"
                            ></b-form-radio-group>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_gender_id.$error && !$v.formData.emp_gender_id.required}">Gender is required!</div>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Medical Book ID"
                            label-for="emp_medical_book_id"
                          >
                            <b-form-input
                              id="emp_medical_book_id"
                              v-model="formData.emp_medical_book_id"
                              type="text"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="security ID"
                            label-for="emp_security_id"
                          >
                            <b-form-input
                              id="emp_security_id"
                              v-model="formData.emp_security_id"
                              type="text"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Authentication type"
                            label-for="auth_doc_type_id">
                            <v-select v-model="authenticationTypes" :options="auth_type_ids"  class="uppercase"
                                      name="auth_doc_type_id" id="auth_doc_type_id"
                                      label="text" @input="onChangeAuthType">
                              <template #search="{attributes, events}">
                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                              </template>
                            </v-select>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="AUTHENTICATION ID" label-for="nid_no">
                            <b-form-input
                              v-model="formData.nid_no"
                              id="nid_no"
                              name="nid_no"
                              @change="uniqueAuthenticationIdentity">
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Authentication Document"
                            label-for="auth_document">
                            <div class="custom-file b-form-file">
                              <input type="file" class="custom-file-input" @change="getAuthIdDocument" aria-describedby="authentication-document-help-block" accept="application/msword,application/pdf,image/png,image/jpg,image/jpeg"  name="auth_document" />
                              <b-form-text id="authentication-document-help-block">
                                PDF, DOCX, Image only
                              </b-form-text>
                              <label data-browse="Browse" class="custom-file-label">{{formData.auth_document_name}} </label>
                              <!-- <span :style="errorMessage">{{ errors.first('auth_document') }}</span>-->
                            </div>
                            <div v-if="hasAuthenticationDocument()">
                              <a :href="getAuthenticationDownloaderUrl(formData.emp_id)" target="_blank"> {{formData.auth_document_name}} </a>
                            </div>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Emergency Contact Name"
                            label-for="emp_emergency_contact_name">
                            <b-form-input
                              id="emp_emergency_contact_name"
                              v-model="formData.emp_emergency_contact_name"
                              type="text"
                              :maxlength="200"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Emergency Contact Mobile No"
                            label-for="emp_emergency_contact_mobile">
                            <b-form-input
                              id="emp_emergency_contact_mobile"
                              v-model="formData.emp_emergency_contact_mobile"
                              type="text"
                              name="emp_emergency_contact_mobile"
                              v-validate="{ numeric: true, regex: /^01[5-9]\d{8}$/ }"
                              :maxlength="15"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Emergency Contact Relation"
                            label-for="emp_emergency_relation_id">
                            <v-select v-model="emergencyRelationTypes"
                                      :options="relationList"
                                      name="emp_emergency_relation_id"
                                      id="emp_emergency_relation_id"
                                      label="text"
                                      class="uppercase">
                              <template #search="{attributes, events}">
                                <input class="vs__search"
                                       v-bind="attributes" v-on="events"/>
                              </template>
                            </v-select>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Emergency Contact Address"
                            label-for="emp_emergency_contact_add056">
                            <b-form-input
                              id="emp_emergency_contact_address"
                              v-model="formData.emp_emergency_contact_address"
                              type="text"
                              :maxlength="500"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            class="requiredField"
                            label="Quota"
                            label-for="emp_quota_id">
                            <v-select v-model="quota" :options="quotaList"
                                      name="emp_quota_id"  id="emp_quota_id" class="uppercase"
                                      :disabled="readonlyShow"
                                      label="text">
                              <template #search="{attributes, events}">
                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                              </template>
                            </v-select>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_quota_id.$error && !$v.formData.emp_quota_id.required}">Quota is required!</div>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            class="requiredField"
                            label="Status"
                            label-for="emp_status_id">
                            <v-select v-model="status" :options="statusList"
                                      :disabled="readonlyShow"
                                      name="emp_status_id" id="emp_status_id" class="uppercase"
                                        v-validate="'required'"
                                      label="text">
                              <template #search="{attributes, events}">
                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                              </template>
                            </v-select>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_status_id.$error && !$v.formData.emp_status_id.required}">Status is required!</div>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            class="requiredField"
                            label="Tribal"
                            label-for="Tribal">
                            <b-form-radio-group
                              v-model.trim="$v.formData.tribal_yn.$model"
                              id="emp_tribal_yn"
                              :disabled="readonlyShow"
                              :options="tribal_yn_options"
                              name="emp_tribal_yn"
                            ></b-form-radio-group>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.tribal_yn.$error && !$v.formData.tribal_yn.required}">Status is required!</div>
                          </b-form-group>
                        </b-col>

                        <b-col md="4" :style="!formData.rs_promotion_id?'pointer-events: none':''">
                          <b-form-group
                            label="LAST PROMOTION DATE"
                            label-for="last_promotion_date">
                            <date-picker v-model="formData.last_promotion_date"
                                         width="100%"
                                         input-class="form-control"
                                         type="date"
                                         lang="en"
                                         format="DD-MM-YYYY"
                                         :value-type="valueType"
                                         :editable="false"
                                         name="last_promotion_date"
                            >
                            </date-picker>
                          </b-form-group>
                        </b-col>
                        <b-col md="4" :style="!formData.ts_promotion_id?'pointer-events: none':''">
                          <b-form-group
                            label="LAST TIME SCALE DATE"
                            label-for="last_time_scale_date">
                            <date-picker v-model="formData.last_time_scale_date"
                                         width="100%"
                                         input-class="form-control"
                                         type="date"
                                         lang="en"
                                         format="DD-MM-YYYY"
                                         :value-type="valueType"
                                         :editable="false"
                                         name="last_time_scale_date"
                            >
                            </date-picker>
                          </b-form-group>
                        </b-col>
                        <b-col md="4" :style="!formData.c_order_no?'pointer-events: none':''">
                          <b-form-group
                            label="LAST ADDITIONAL/CURRENT CHARGE DATE" label-for="charge_activation_date">
                            <date-picker v-model="formData.charge_activation_date"
                                         width="100%"
                                         input-class="form-control"
                                         type="date"
                                         lang="en"
                                         format="DD-MM-YYYY"
                                         :value-type="valueType"
                                         :editable="false"
                                         name="charge_activation_date"
                            >
                            </date-picker>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="CHARGE DEPARTMENT" label-for="charge_department">
                            <b-form-input
                              readonly
                              v-model="formData.charge_department"
                              id="charge_department"
                              name="charge_department"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="CHARGE DESIGNATION" label-for="charge_designation">
                            <b-form-input
                              readonly
                              v-model="formData.charge_designation"
                              id="charge_designation"
                              name="charge_designation"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="ACTUAL GRADE" label-for="actual_grade">
                            <b-form-input
                              readonly
                              v-model="formData.actual_grade"
                              id="actual_grade"
                              name="actual_grade"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="JOINING GRADE" label-for="joining_grade">
                            <b-form-input
                              readonly
                              v-model="formData.joining_grade"
                              id="joining_grade"
                              name="joining_grade"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="PAY GRADE" label-for="pay_grade">
                            <b-form-input
                              readonly
                              v-model="formData.pay_grade"
                              id="pay_grade"
                              name="pay_grade"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="BILL CODE" label-for="bill_code">
                            <b-form-input
                              readonly
                              v-model="formData.bill_code"
                              id="bill_code"
                              name="bill_code"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>


                        <b-col md="4">
                          <b-form-group
                            label="ACTIVE" label-for="emp_status_id">
                            <b-form-input
                              readonly
                              v-model="formData.emp_status_id"
                              id="emp_status_id"
                              name="emp_status_id"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Employee Class" label-for="emp_class">
                            <b-form-input
                              readonly
                              v-model="formData.emp_class"
                              id="emp_class"
                              name="emp_class"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col md="4">
                          <b-form-group
                            label="Actual Class" label-for="actual_class">
                            <b-form-input
                              readonly
                              v-model="formData.actual_class"
                              id="actual_class"
                              name="actual_class"
                            >
                            </b-form-input>
                          </b-form-group>
                        </b-col>
                      </b-row>
                    </b-col>
                    <b-col md="2" class="text-center profileImage">
                      <b-card class="m-0" style="border: 1px solid #eff1f2;">
                        <b-card-text >
                          <img id="profilepic" :src="formData.emp_photo ? formData.emp_photo : '/images/avatar.png'"  class="img-fluid" alt="...">
                        </b-card-text>
                      </b-card>
                      <label style="width:100%" class="btn btn-primary" v-if="can_update"> Upload Photo
                        <input class="uploadImage"  type="file"  name="emp_photo" @change="getPhoto" accept="image/png,image/jpg,image/jpeg"/>
                      </label>
                      <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_photo.$error && !$v.formData.emp_photo.required}">Select your profile picture</div>
                    </b-col>
                  </b-row>
                    <b-row v-if="can_update">
                        <b-col class="d-flex justify-content-end mb-2">
                            <b-button type="submit" variant="primary">Update</b-button>
                            <b-button to="/search-employee-collection" type="button" variant="warning">Back</b-button>
                        </b-col>
                    </b-row>

                </b-form>
            </b-card-body>
        </b-card>
        <address-collection v-if="id" :id="id" :can_update="can_update"></address-collection>
        <contact-collection v-if="id" :id="id" :can_update="can_update"></contact-collection>
        <family-collection v-if="id" :id="id" :can_update="can_update"></family-collection>
        <b-card>
            <b-card-text>
                <b-tabs  >
                    <b-tab title="PENSION" active>
                        <pension-nominee :id="id" used_by="pmis" :families="familiesData" @submitted="loadData" :nominees="nominees"></pension-nominee>
                    </b-tab>
                    <b-tab title="BNF"><bnf-nominee used_by="pmis" :id="id"  :families="familiesData" @submitted="loadData" :nominees="nominees"></bnf-nominee></b-tab>
                    <b-tab title="GPF"><gpf-nominee used_by="pmis" :id="id"  :families="familiesData" @submitted="loadData" :nominees="nominees"></gpf-nominee></b-tab>
                </b-tabs>
            </b-card-text>
        </b-card>
        <tour-collection v-if="id" :id="id" :can_update="can_update"></tour-collection>
        <traning-collection v-if="id" :id="id" :can_update="can_update"></traning-collection>
        <academic-collection v-if="id" :id="id" :can_update="can_update"></academic-collection>
        <others-collection v-if="id" :id="id" :can_update="can_update"></others-collection>
    </b-container>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import FamilyCollection from "./FamilyCollection";
    import ContactCollection from "./ContactCollection";
    import AddressCollection from "./AddressCollection";
    import TourCollection from "./TourCollection";
    import TraningCollection from "./TraningCollection";
    import AcademicCollection from "./AcademicCollection";
    import BNFNominee from "../../dashboard/components/BNFNominee";
    import GPFNominee from "../../dashboard/components/GPFNominee";
    import PensionNominee from "../../dashboard/components/PensionNominee";
    import OthersCollection from "./OthersCollection";
    import moment from 'moment';
    import {validationMixin} from "vuelidate"
    const { required, requiredIf, maxLength, minLength, email } = require("vuelidate/lib/validators");
    export default {
        props: ['id'],
        components: {DatePicker, Datatable, Vue, vSelect, vcss, FamilyCollection, ContactCollection, AddressCollection,OthersCollection,AcademicCollection,TraningCollection,TourCollection, 'bnf-nominee':BNFNominee,'gpf-nominee':GPFNominee, 'pension-nominee':PensionNominee},

        data() {
            return {
                can_update: false,
                readonlyShow: false,
                authenticationTypes: {text:'NATIONAL ID',value:1,auth_doc_type_id:'1'},
                auth_type_ids: [{'value': '', 'text': 'Select Authentication type'}],
                quota: {text:'Select Quota', value:''},
                status: {text:'', value:''},
                statusList: [],
                emergencyRelationTypes: {text:'',value:''},
                relationList: [],
                quotaList: [],
                selectedControllingOfficer: {option_name:'',emp_id:'', emp_name:''},
                maritalStatus: {text:'',value:''},
                religions: {text:'',value:'',religion_bng:''},
                religionList: [],
                employeeList: [],
                bloodGroups: {text:'', value:''},
                bloodGroupList: [],
                valueType: this.dateFormatter(),
                unique_code_message: '',
                errorMessage: {color: 'red'},
                unique_authentication_identity_message: '',
                formData: {
                    emp_id: '',
                    emp_code: null,
                    emp_name: null,
                    emp_name_bng: null,
                    location_id: null,
                    deputation_yn: 'N',
                    emp_blood_group_id: '',
                    reporting_officer_id: '',
                    emp_emergency_relation_id: '',
                    emp_emergency_contact_address: '',
                    emp_emergency_contact_mobile: '',
                    emp_emergency_contact_name: '',
                    dpt_division_name: '',
                    department_name: '',
                    designation: '',
                    actual_grade: '',
                    joining_grade: '',
                    pay_grade:'',
                    last_promotion_date: '',
                    last_increment_date: '',
                    last_time_scale_date: '',
                    charge_division: '',
                    charge_department: '',
                    charge_designation: '',
                    charge_activation_date: '',
                    emp_quota_id: '',
                    emp_status_id: '',
                    tribal_yn: 'N',
                    emp_maritial_status_id: '',
                    emp_religion_id: '',
                    religion_bng: '',
                    emp_gender_id: '',
                    emp_medical_book_id: '',
                    emp_security_id: '',
                    nid_no: '',
                    auth_doc_type_id: '',
                    auth_document: '',
                    auth_document_name: '',
                    auth_document_type: '',
                    ts_promotion_id: '',
                    rs_promotion_id: '',
                    emp_photo: '',
                    emp_photo_name: '',
                    emp_photo_type: '',
                    bill_code: '',
                },
                genderList: [],
                familiesData: [],
                nominees: null,
                dataLoaded: false,
                tribal_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                reportUrl: '',
                reportParams: {
                    xdo: '/~weblogic/pmis/emp.xdo',
                    type: "pdf",
                    p_emp_id: '',
                    filename: 'emp'
                },
                clubSubmitBtn: 'Add',
                loanSubmitBtn: 'Add',
                familySubmitBtn: 'Add',
                clubInfo: {deduction_yn: 'Y'},
                club: {},
                clubs: {
                    items: []
                },
                loan: {},
                gpf: {
                    emp_code: '',
                    pf_subsint_last_jun: '',
                    pf_subs_from_last_jul: '',
                    op_int_from_last_jul: ''
                },
                loans: {
                    items: []
                },
                family: {},
                families: {
                    items: []
                },
                selectedEmployee: [],
                selectClub: [],
                empIdList: [],
                locationTypeOptions: [],
                clubOptions: [],
                loanTypeOptions: [],
                relationOptions: [],
                genderOptions: [],
                maritalStatusOptions: [],
                thanaOptions: [],
                districtOptions: [],
                deputation_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                deduction_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                burnerTypes: [{text: 'Single Burner', value: '1'}, {text: 'Double Burner', value: '2'}]
            };
        },
        mixins: [validationMixin],
        validations: {
            formData: {
                emp_id: {required},
                emp_code: {required},
                emp_name: {required},
                emp_name_bng: {},
                location_id: {},
                deputation_yn: {},
                emp_blood_group_id: {},
                reporting_officer_id: {},
                emp_emergency_relation_id: {},
                emp_emergency_contact_address: {},
                emp_emergency_contact_mobile: {},
                emp_emergency_contact_name: {},
                dpt_division_name: {},
                department_name: {},
                designation: {},
                actual_grade: {},
                joining_grade: {},
                pay_grade: {},
                last_promotion_date: {},
                last_increment_date: {},
                last_time_scale_date: {},
                charge_division: {},
                charge_department: {},
                charge_designation: {},
                charge_activation_date: {},
                emp_quota_id: {required},
                emp_status_id: {required},
                tribal_yn: {required},
                emp_maritial_status_id: {required},
                emp_religion_id: {required},
                religion_bng: {},
                emp_gender_id: {required},
                emp_medical_book_id: {},
                emp_security_id: {},
                nid_no: {},
                auth_doc_type_id: {},
                auth_document: {},
                auth_document_name: {},
                auth_document_type: {},
                ts_promotion_id: {},
                rs_promotion_id: {},
                emp_photo: {},
                emp_photo_name: {},
                emp_photo_type: {}
            }
        },
        watch: {
            bloodGroups:function (val, oldVal) {
                if (val.value !== null) {
                    this.formData.emp_blood_group_id = val.value;
                } else {
                    this.formData.emp_blood_group_id ='';
                }
            },
            selectedControllingOfficer:function(val,oldVal) {
                if(val.emp_id !== null) {
                    this.formData.reporting_officer_id = val.emp_id;
                } else {
                    this.formData.reporting_officer_id = this.formData.reporting_officer_id;
                }
            },
            emergencyRelationTypes: function(val, oldVal){
                if (val.value !== null) {
                    this.formData.emp_emergency_relation_id = val.value;
                } else {
                    this.formData.emp_emergency_relation_id ='';
                }
            },
            quota: function(val, oldVal){
                if (val.value !== null) {
                    this.formData.emp_quota_id = val.value;
                } else {
                    this.formData.emp_quota_id ='';
                }
            },
            status: function(val, oldVal){
                if (val.value !== null) {
                    this.formData.emp_status_id = val.value;
                } else {
                    this.formData.emp_status_id ='';
                }
            },
            maritalStatus:function (val, oldVal) {
                if (val.value !== null) {
                    this.formData.emp_maritial_status_id = val.value;
                } else {
                    this.formData.emp_maritial_status_id ='';
                }
            },
            religions: function(val, oldVal){
                if (val.value !== null) {
                    this.formData.emp_religion_id = val.value;
                    this.formData.emp_religion_name = val.text;
                    this.formData.emp_religion_name_bng = val.religion_bng;
                } else {
                    this.formData.emp_religion_id ='';
                    this.formData.emp_religion_name = '';
                    this.formData.emp_religion_name_bng = '';
                }
            },
            authenticationTypes :function(val, oldVal){
                if (val.value !== '') {
                    this.formData.auth_doc_type_id = val.value;
                } else {
                    this.formData.auth_doc_type_id ='';
                }
            },
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Information"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Basic Information Collection"});

            this.allpreloadData();

            if (this.id > 0) {
                this.fetchBasicInfo(this.id);
                this.loadData();
                this.reportRender();
                this.formData.emp_id = this.id;
            }

            this.canUpdate()
        },
        filters: {
            dateFilter(value){
                return value ? moment(String(value)).format('DD/MM/YYYY') : null;
            }
        },
        methods: {

            loadData: function() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/specific/${this.id}`).then(res => {
                    this.nominees = res.data
                    this.dataLoaded = true;
                });
            },
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            getPhoto(event) {
                let currObj = this;
                let input = event.target;
                let reader = new FileReader();
                if (input.files && input.files.length > 0) {
                    reader.onload = (e) => {
                        currObj.formData.emp_photo = e.target.result;
                    }
                }
                reader.readAsDataURL(input.files[0]);
                this.formData.emp_photo_name = input.files[0].name;
                this.formData.emp_photo_type = input.files[0].name.split('.').pop();
            },
            onChangeAuthType(){
                this.unique_authentication_identity_message = ''
                this.formData.nid_no = "";
            },
            uniqueAuthenticationIdentity(){
                let params = {
                    'auth_id': this.formData.nid_no,
                    'auth_type': this.formData.auth_doc_type_id
                };
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/check-valid-nid/`, {params}).then(result => {
                    if(result.data.unique_message!=null){
                        this.unique_authentication_identity_message = result.data.unique_message;
                    }
                });
            },
            hasAuthenticationDocument()
            {
                return (this.formData.emp_id && this.formData.auth_document);
            },
            getAuthenticationDownloaderUrl(employeeId)
            {
                return 'pmis/basic-info/download-authentication-document/'+employeeId;
            },
            getAuthIdDocument(event) {
                let currObj = this;
                let input = event.target;
                let reader = new FileReader();
                if (input.files && input.files[0]) {
                    this.$validator.validate('auth_document', currObj.formData.auth_document).then(function() {
                        reader.onload = (e) => {
                            if(!currObj.errors.has('auth_document')) {
                                currObj.formData.auth_document = e.target.result;
                            }
                        }
                    }).catch(err => {
                        console.log('file error');
                    });
                    reader.readAsDataURL(input.files[0]);
                    this.formData.auth_document_name = input.files[0].name;
                    this.formData.auth_document_type = input.files[0].name.split('.').pop();
                }
            },

            searchEmployeeById(id){
                if(id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/controlling-officer/${id}`).then(res => {
                        this.employeeList = res.data;
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
            reportRender() {
                this.reportParams.p_emp_id = this.id;
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                this.reportUrl = '/report/render?' + queryString;
            },
            allpreloadData() {

                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.locationTypeOptions = res.data.locationType;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos').then(result => {
                    this.maritalStatusOptions = result.data.maritalStatus
                    this.bloodGroupList = result.data.bloodGroup
                    this.relationList = result.data.relations
                    this.quotaList = result.data.quota
                    this.statusList = result.data.status
                    this.religionList = result.data.religions
                    this.genderList = result.data.gender_options;
                    this.auth_type_ids = result.data.auth_type_ids;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loans/pf`).then(res => {
                    this.loanTypeOptions = res.data.loanTypes;
                });

            },
            fetchBasicInfo(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-info-collection/get-basic-info/${id}`).then(result => {
                    this.readonlyShow =true;
                    this.formData = result.data[0];
                    this.formData.emp_status_id = result.data[0].emp_status_id == 1 ? 'Yes' : 'NO';
                    this.bloodGroups = {
                        text: result.data[0].blood_group,
                        value: result.data[0].emp_blood_group_id
                    }
                    this.selectedControllingOfficer = {
                        emp_id: result.data[0].reporting_officer_id,
                        emp_name: result.data[0].reporting_officer_name,
                        option_name: result.data[0].reporting_officer_option
                    }
                    this.emergencyRelationTypes = {
                        text: result.data[0].relation_type,
                        value: result.data[0].emp_emergency_relation_id
                    }
                    this.quota = {
                        text: result.data[0].quota_name,
                        value: result.data[0].emp_quota_id
                    }
                    this.status = {
                        text: result.data[0].emp_status,
                        value: result.data[0].emp_status_id
                    }
                    this.maritalStatus = {
                        text: result.data[0].maritial_status,
                        value: result.data[0].emp_maritial_status_id
                    }
                    this.religions = {
                        text: result.data[0].religion,
                        value: result.data[0].emp_religion_id,
                        religion_bng: result.data[0].religion_bng
                    }
                    this.authenticationTypes = {
                        text:result.data[0].auth_doc_type_name,
                        value:result.data[0].auth_doc_type_id,
                        auth_doc_type_id:result.data[0].auth_doc_type_id
                    }
                    this.gpf.emp_code = result.data[0].emp_code

                });

                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-info-collection/get-club-info/${id}`).then(result => {
                    this.clubs.items = result.data;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-info-collection/get-loan-info/${id}`).then(result => {
                    this.loans.items = result.data;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-info-collection/get-family-info/${id}`).then(result => {
                    this.families.items = result.data;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/others/${id}`).then(res => {
                    this.clubOptions = res.data.clubs;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/families/specific/${id}`).then(res => {
                    console.log(res.data.data)
                    this.familiesData = res.data.data;
                    this.relationOptions = res.data.relations;
                    this.genderOptions = res.data.gender;
                    this.districtOptions = res.data.district_ids;
                    this.dataLoaded = true;
                });

            },

            geoDistrictChange(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-thanas/${id}`).then(result => {
                        this.thanaOptions = result.data;
                    });
                }
            },

            addBasicInfo() {
                this.$v.$touch()
                this.$v.formData.$touch()
                if(!this.$v.formData.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/employee/basic-info-collection/basic`, this.formData).then(resp => {
                        if (resp.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'success'})
                            this.fetchBasicInfo(this.formData.emp_id)
                            this.$v.$reset()
                        } else {
                            this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'error'})
                        }
                    });
                }
            },
            addClubInfo() {
                this.clubInfo.emp_id = this.id;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/employee/basic-info-collection/club`, this.clubInfo).then(resp => {
                    if (resp.data.o_status_code == 1) {
                        this.fetchBasicInfo(this.id);
                        this.resetClubInfo();
                        this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'success'})
                    } else {
                        this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'error'})
                    }
                });

            },

            addLoanInfo() {
                this.loan.emp_id = this.id;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/employee/basic-info-collection/loan`, this.loan).then(resp => {
                    if (resp.data.o_status_code == 1) {
                        this.fetchBasicInfo(this.id);
                        this.resetLoanInfo();
                        this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'success'})
                    } else {
                        this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'error'})
                    }
                });

            },
            addGPFInfo() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/employee/basic-info-collection/gpf-info`, this.gpf).then(resp => {
                    if (resp.data.o_status_code == 1) {
                        this.resetGPFInfo()
                        this.fetchBasicInfo(this.id)
                        this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'success'})
                    } else {
                        this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'error'})
                    }
                });
            },
            addFamilyInfo() {
                this.family.emp_id = this.id;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/employee/basic-info-collection/family`, this.family).then(resp => {
                    if (resp.data.o_status_code == 1) {
                        this.fetchBasicInfo(this.id);
                        this.resetFamilyInfo();
                        this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'success'})
                    } else {
                        this.$notify({group: 'pmis', text: resp.data.o_status_message, type: 'error'})
                    }
                });

            },
            editFamilyInfo(i) {
                console.log('family', i);
                let item = Object.assign({}, i);
                this.family = item;
                this.geoDistrictChange(item.district_id);
                this.familySubmitBtn = 'Update';
            },
            editClub(i) {
                let item = Object.assign({}, i);
                this.clubInfo = item;
                this.clubSubmitBtn = 'Update';
            },
            editloan(i) {
                let item = Object.assign({}, i);
                this.loan = item;
                this.loanSubmitBtn = 'Update';
            },
            resetLoanInfo() {
                this.show = false;
                this.loan = {};
                this.loanSubmitBtn = 'Add';
                this.$nextTick(() => {
                    this.show = true
                })
            },
            resetGPFInfo() {
                this.gpf.pf_subs_from_last_jul = ''
                this.gpf.pf_subsint_last_jun = ''
                this.gpf.op_int_from_last_jul = ''
            },
            resetClubInfo() {
                this.show = false;
                this.clubInfo = {};
                this.clubSubmitBtn='Add';
                this.$nextTick(() => {
                    this.show = true
                })
            },
            resetFamilyInfo() {
                this.show = false;
                this.family = {};
                this.familySubmitBtn = 'Add';
                this.$nextTick(() => {
                    this.show = true
                })
            },

        },
    };
</script>
<style>
    .pull-top {
        margin-top: -12px;
    }

</style>


