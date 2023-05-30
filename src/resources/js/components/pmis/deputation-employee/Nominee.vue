<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked  pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0">
                        <b-card title="Nominee">
                            <b-card-body class="border">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                                    <b-row>
                                        <b-col md="2" class="text-center profileImage">
                                            <b-card class="m-0" style="border: 1px solid #eff1f2;">
                                                <b-card-text >
                                                    <img id="nomineepic" :src="nominee.nominee_photo ? nominee.nominee_photo : '/images/avatar.png'"  class="img-fluid" >
                                                </b-card-text>
                                            </b-card>
                                            <label style="width:100%" class="btn btn-primary"> Upload Photo
                                                <input class="uploadImage" type="file"  @change="getNomineePhoto" accept="image/png,image/jpg,image/jpeg" name="nominee_photo" v-validate.reject="'image|size:100'" />
                                            </label>
                                            <span :style="errorMessage">{{ errors.first('nominee_photo') }}</span>
                                        </b-col>
                                        <b-col>
                                            <b-row>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Nominee For"
                                                        label-for="nominee_for_id"  class="requiredField"
                                                    >
                                                        <v-select v-model="nomineeFor" :options="nomineeForOptions"
                                                                  name="nominee_for_id" id="nominee_for_id" label="nominee_for_name"
                                                                  class="uppercase"
                                                                  required v-validate="'required'">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                            <template #search="{attributes, events}">
                                                                <input
                                                                    class="vs__search"
                                                                    :required="!nominee.nominee_for_id"
                                                                    v-bind="attributes"
                                                                    v-on="events"
                                                                />
                                                            </template>
                                                        </v-select>
                                                        <span :style="errorMessage">{{ errors.first('nominee_for_id') }}</span>
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
                                                            v-validate="'required'" required
                                                            placeholder="Name"
                                                        ></b-form-input>
                                                        <span :style="errorMessage">{{ errors.first('nominee_name') }}</span>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Relationship"
                                                        label-for="relationship_nominee"  class="requiredField"
                                                    >
                                                        <v-select v-model="relationships" :options="relationshipWithNomineeList"
                                                                  name="relationship_nominee" id="relationship_nominee" label="text"
                                                                  class="uppercase"
                                                                  required v-validate="'required'">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                        </v-select>
                                                        <span :style="errorMessage">{{ errors.first('relationship_id') }}</span>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Percentage(%)"
                                                        label-for="percentage"
                                                    >

                                                        <b-form-input
                                                            id="percentage"
                                                            v-model="nominee.percentage"
                                                            type="text"
                                                            placeholder="percentage(%)"
                                                            name="percentage"
                                                            :maxlength="3"
                                                            v-validate="'decimal:2|max_value:100'"
                                                        ></b-form-input>
                                                        <span :style="errorMessage">{{ errors.first('percentage') }}</span>
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
                                                            placeholder="Contact No."
                                                        ></b-form-input>
                                                        <span :style="errorMessage">{{ errors.first('nominee_contact_no') }}</span>
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
                                                            placeholder="E-mail"
                                                            :maxlength="50"
                                                            v-validate="'email'"
                                                        ></b-form-input>
                                                        <span :style="errorMessage">{{ errors.first('nominee_email') }}</span>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Date of Birth"
                                                        label-for="nominee_dob" class="requiredField"
                                                    >
                                                        <date-picker v-model="nominee.nominee_dob" width="100%" required v-validate="'required'" name="nominee_dob" input-class="form-control"  type="date" lang="en" format="DD-MM-YYYY" :value-type="valueType" :editable="false" :not-after="notAfterToday()"> Nominee DOB</date-picker>
                                                        <span :style="errorMessage">{{ errors.first('nominee_dob') }}</span>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Marital Status"
                                                        label-for="nominee_marital_status_id"
                                                    >
                                                        <v-select v-model="maritalStatus" :options="maritalStatusList"
                                                                  name="nominee_marital_status_id" id="nominee_marital_status_id" label="text"
                                                                  class="uppercase">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                        </v-select>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Gender"
                                                        label-for="nominee_gender"
                                                    >
                                                        <v-select v-model="genders" :options="genderList"
                                                                  name="nominee_gender" id="nominee_gender" label="text"
                                                                  class="uppercase"
                                                        >
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                        </v-select>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Address Line 1"
                                                        label-for="address_line_1">
                                                        <b-form-input
                                                            id="address_line_1"
                                                            v-model="nominee.address_line_1"
                                                            type="text"
                                                            placeholder="Address Line 1"
                                                            name="address_line_1"
                                                            :maxlength="500"
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Address Line 2"
                                                        label-for="address_line_2">
                                                        <b-form-input
                                                            id="address_line_2"
                                                            v-model="nominee.address_line_2"
                                                            type="text"
                                                            placeholder="Address Line 2"
                                                            name="address_line_2"
                                                            :maxlength="500"
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="District"
                                                        label-for="district"
                                                        class="requiredField">
                                                        <v-select v-model="districts" :options="district_ids"
                                                                  name="district_id" id="district_id" label="text"
                                                                  class="uppercase"
                                                                  @input="geoDistrictChange(districts.value)"
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
                                                        label-for="thana_id">
                                                        <v-select v-model="thana" :options="thana_ids"
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
                                                            v-model="nominee.post_code"
                                                            v-validate="'numeric|length:4'"
                                                            type="text"
                                                            placeholder="Enter Postcode"
                                                            name="post_code"
                                                            :maxlength="4"
                                                        ></b-form-input>
                                                        <span :style="errorMessage">{{ errors.first('post_code') }}</span>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Authentication Type"
                                                        label-for="auth_type_id">
                                                        <v-select v-model="authenticationTypes" :options="authTypeList"
                                                                  name="auth_type_id" id="auth_type_id" label="text"
                                                                  class="uppercase">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                        </v-select>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3" v-if="nominee.auth_type_id">
                                                    <b-form-group
                                                        :class="authIdValidationRule ? 'requiredField' : ''"
                                                        label="Authentication Identification"
                                                        label-for="nominee_auth_id">
                                                        <b-form-input
                                                            id="nominee_auth_id"
                                                            v-model="nominee.nominee_auth_id"
                                                            type="text"
                                                            placeholder="Enter Auth Identification"
                                                            name="nominee_auth_id"
                                                            :maxlength="17"
                                                            v-validate="authIdValidationRule"
                                                            @input="uniqueAuthenticationIdentity"
                                                            @change="uniqueAuthenticationIdentity"
                                                        ></b-form-input>
                                                        <span :style="errorMessage" v-if="unique_authentication_identity_message">{{ unique_authentication_identity_message }}</span>
                                                        <span :style="errorMessage">{{ errors.first('nominee_auth_id') }}</span>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Authentication Document"
                                                        label-for="auth_id_document">
                                                        <div class="custom-file b-form-file">
                                                            <input type="file" class="custom-file-input" @change="getAuthIdDocument" accept="application/msword, application/pdf, image/png, image/jpg, image/jpeg" v-validate="'size:500'" name="nominee_auth_doc" />
                                                            <label data-browse="Browse" class="custom-file-label">{{nominee.nominee_auth_id_photo_name }} </label>
                                                            <span :style="errorMessage">{{ errors.first('nominee_auth_doc') }}</span>
                                                        </div>
                                                        <div v-if="hasAuthenticationDocument()">
                                                            <a :href="getAuthenticationDownloaderUrl(nominee.nominee_id)" target="_blank"> {{nominee.nominee_auth_id_photo_name }} </a>
                                                        </div>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Medical ID" label-for="medical_id">
                                                        <b-form-input :maxlength="20" id="medical_id" v-model="nominee.medical_id" name="medical_id"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Bank"
                                                        label-for="nominee_bank">
                                                        <v-select v-model="banks" :options="bankList"
                                                                  name="nominee_bank" id="nominee_bank" label="text"
                                                                  @input="bankChange(banks.value)"
                                                                  class="uppercase">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                        </v-select>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Branch"
                                                        label-for="nominee_branch">
                                                        <v-select v-model="branches" :options="branchList"
                                                                  name="nominee_branch" id="nominee_branch" label="text"
                                                                  class="uppercase">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                            </template>
                                                        </v-select>
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
                                                            placeholder="Acc No"
                                                            :maxlength="500"
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Autistic"
                                                        label-for="autistic_yn"
                                                        class="requiredField"
                                                    >
                                                        <b-form-radio-group
                                                            id="autistic_yn"
                                                            v-model="nominee.autistic_yn"
                                                            :options="autisticOptions"
                                                            name="autistic_yn"
                                                            required
                                                        >
                                                        </b-form-radio-group>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3" v-if="hasPermission('CAN_APPROVE_EMPLOYEE')==true">
                                                    <b-form-group
                                                        class="requiredField"
                                                        label="Approved"
                                                        label-for="approved_yn">
                                                        <b-form-radio-group
                                                            v-model="nominee.approved_yn"
                                                            :options="approved_yn_options"
                                                            name="approved_yn" required  v-validate="'required'"
                                                        ></b-form-radio-group>
                                                        <span :style="errorMessage">{{ errors.first('approved_yn') }}</span>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>&nbsp;
                                            <b-button type="reset" class="btn btn-outline-dark" :disabled="keepDisable">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </b-card-body>
                        </b-card>
                        <b-card title="Nominee List">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'nominee_id'">
                                    <template v-slot:actions="{ rows }">
                                        <b-link ml="4" class="text-primary"
                                                @click="editRow(rows.item.nominee_id)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>
                                        <b-link class="text-danger" v-b-modal="'nominee-remove'" @click="deletedItem = rows.item">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                    </template>
                                </Datatable>
                                <b-modal :id="'nominee-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
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
    import SideBar from "../partials/sidebar";
    import Datatable from '../../../layouts/common/datatable';
    import DatePicker from 'vue2-datepicker';
    import ApiRepository from "../../../Repository/ApiRepository";
    import vSelect from 'vue-select';

    export default {
        components: {DatePicker,SideBar, Datatable, vSelect},
        props: ['id'],
        data() {
            return {
                nomineeForOptions: [],
                nomineeFor: {'nominee_for_name':'','nominee_for_id':''},
                relationships: {'text':'','value':''},
                maritalStatus: {'text':'','value':''},
                genders: {'text':'','value':''},
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
                    autistic_yn: 'N',
                    nominee_for_id: '',
                    nominee_name: '',
                    relationship_id: '',
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
                    old_district_id: ''
                },
                relationshipWithNomineeList: [{'value': '', 'text': 'Select Relationship with Nominee'}],
                maritalStatusList:[{'value': '', 'text': 'Select Marital status'}],
                authTypeList:[{'value': '', 'text': 'Select Authentication Type'}],
                bankList:[{'value': '', 'text': 'Select Bank'}],
                branchList:[{'value': '', 'text': 'Select Branch'}],
                genderList:[{'value': '', 'text': 'Select Gender'}],
                district_ids: [{'value': '', 'text': 'Select District'}],
                thana_ids: [{'value': '', 'text': 'Select Thana/Upazilla'}],
                updateIndex:-1,
                submitBtn: 'Save',
                show: true,
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'nominee_name', sortable: true},
                    {key: 'gender.gender_name', label: 'Gender', sortable: true},
                    {key: 'nominee_dob',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {key: 'percentage', label: 'Percentage', sortable: true, filterByFormatted: true, sortByFormatted: true, formatter: (value) => {
                            if(value) {
                                return value+"%";
                            }

                            return value;
                        }
                    },
                    {key: 'marital_status.maritial_status', label: 'Marital Status', sortable: true},
                    {key: 'relationship.relation_type', label: 'Relationship', sortable: true},
                    {key: 'district.geo_district_name', label: 'District', sortable: true},
                    {key: 'post_code', label: 'Post code', sortable: true},
                    {key: 'nominee_contact_no', sortable: true},
                    'action'
                ],

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
            nomineeFor:function(val,oldVal) {
                if(val !== null) {
                    this.nominee.nominee_for_id = val;
                } else {
                    this.nominee.nominee_for_id = '';
                }
            },
            relationships:function(val,oldVal) {
                if(val !== null) {
                    this.nominee.relationship_id = val;
                } else {
                    this.nominee.relationship_id = '';
                }
            },
            maritalStatus:function(val,oldVal) {
                if(val !== null) {
                    this.nominee.nominee_marital_status_id = val;
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
            },
            /*"nominee.auth_type_id": function() {
                let auth_type = this.authTypeList.find(row => {
                    return row.auth_doc_type_id == this.nominee.auth_type_id;
                });

                if(auth_type) {
                    let auth_doc_type_name = auth_type.auth_doc_type_name;
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
                            this.nominee.nominee_auth_id = "";
                        }
                    } else {
                        this.authIdValidationRule = "";
                        this.nominee.nominee_auth_id = "";
                    }
                } else {
                    this.authIdValidationRule = "";
                    this.nominee.nominee_auth_id = "";
                }

                console.log(this.authIdValidationRule);
            },*/
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
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Nominee"});
            this.nominee.emp_id = this.id;
            this.loadData();
            this.nomineeForList()
        },
        methods: {
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            hasAuthenticationDocument()
            {
                return (this.nominee.nominee_id && this.nominee.nominee_auth_id_photo);
            },
            getAuthenticationDownloaderUrl(nomineeId)
            {
                return 'pmis/nominee/download-authentication-document/'+nomineeId;
            },
            uniqueAuthenticationIdentity() {
                if(
                    (this.nominee.auth_type_id && this.nominee.nominee_auth_id)
                ) {
                    let params = {
                        'nominee_id': this.nominee.nominee_id,
                        'auth_type_id': this.nominee.auth_type_id,
                        'nominee_auth_id': this.nominee.nominee_auth_id,
                        'emp_id': this.nominee.emp_id,
                    };
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/nominees/unique-nominee-auth-id', {params}).then(result => {
                        this.unique_authentication_identity_message = result.data.unique_message;
                    });
                }
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
            getNomineePhoto(event) {
                let currObj = this;
                let input = event.target;
                if (input.files && input.files[0]) {
                    this.$validator.validate('nominee_photo', currObj.nominee.nominee_photo).then(function() {
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            currObj.nominee.nominee_photo = e.target.result;
                        };
                        reader.readAsDataURL(input.files[0]);
                        currObj.nominee.nominee_photo_name = input.files[0].name;
                        currObj.nominee.nominee_photo_type = input.files[0].name.split('.').pop();
                        console.log('name: ', currObj.nominee.nominee_photo_name);
                        console.log('type: ', currObj.nominee.nominee_photo_type);
                    }).catch(err => {
                        console.log('image error');
                    });

                }
            },
            getAuthIdDocument(event) {
                let input = event.target;
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.nominee.nominee_auth_id_photo = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                    this.nominee.nominee_auth_id_photo_name = input.files[0].name;
                    this.nominee.nominee_auth_id_photo_type = input.files[0].name.split('.').pop();
                    console.log('name: ', this.nominee.nominee_auth_id_photo_name);
                    console.log('type: ', this.nominee.nominee_auth_id_photo_type);
                }
            },
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            loadData: function() {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/specific/${this.id}`).then(res => {
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
                        this.items = res.data.data;
                        this.totalList = res.data.data.length;
                    });
                }
            },
            onSubmit(evt) {
                let currObj = this;
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any() && (this.unique_authentication_identity_message=='')) {
                        this.keepDisable = true;
                        if(this.updateIndex > 0) {
                            ApiRepository.callApi(ApiRepository.PUT_COMMAND,`/pmis/employee/nominees/${this.updateIndex}`,this.nominee).then(result => {
                                if (result.data.o_status_code == 1) {
                                    currObj.onReset();
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                                } else{
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                                }
                                currObj.loadData();
                                this.keepDisable = false;
                            });
                        }else {
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/nominees", this.nominee).then(result => {
                                if (result.data.o_status_code == 1) {
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                                } else{
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                                }
                                currObj.loadData();
                                currObj.onReset();
                                this.keepDisable = false;
                            });
                        }
                    }
                });
            },
            onReset() {
                this.thana_ids = [{'value': '', 'text': 'Select Thana/Upazilla'}];
                this.updateIndex = -1;
                this.deletedItem = null;
                this.unique_authentication_identity_message = '';
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.nominee.nominee_id = '';
                    this.nominee.nominee_name = '';
                    this.nominee.relationship_id = '';
                    this.nominee.percentage = '';
                    this.nominee.address_line_1 = '';
                    this.nominee.address_line_2 = '';
                    this.nominee.district_id = '';
                    this.nominee.thana_id = '';
                    this.nominee.post_code = '';
                    this.nominee.nominee_contact_no = '';
                    this.nominee.nominee_email = '';
                    this.nominee.nominee_dob = '';
                    this.nominee.nominee_marital_status_id = '';
                    this.nominee.nominee_photo = null;
                    this.nominee.nominee_photo_name = null;
                    this.nominee.nominee_photo_type = null;
                    this.nominee.auth_type_id = '';
                    this.nominee.nominee_auth_id = '';
                    this.nominee.nominee_auth_id_photo = null;
                    this.nominee.nominee_auth_id_photo_name = null;
                    this.nominee.nominee_auth_id_photo_type = null;
                    this.nominee.nominee_acc_no = '';
                    this.nominee.medical_id = '';
                    this.nominee.bank_id = '';
                    this.nominee.branch_id = '';
                    this.nominee.nominee_gender_id = '';

                    this.show = true
                })
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1;
            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/pmis/employee/nominees/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.relationships = result.data.relationship;
                    this.maritalStatus = result.data.marital_status;
                    this.genders = result.data.gender;
                    this.districts = result.data.district;
                    this.thana = result.data.selectedFamilyMemberThana;
                    this.authenticationTypes = result.data.selectedAuthType;
                    this.banks = result.data.selectedBank;
                    this.branches = result.data.selectedBranch;
                    this.nominee = result.data;
                    this.nominee.old_district_id=result.data.district.geo_district_id;
                    this.nomineeFor = result.data.selectedNomineeFor;
                    this.bankChange(result.data.bank_id);
                    this.geoDistrictChange(result.data.district_id);
                });

            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/pmis/employee/nominees/${this.deletedItem.nominee_id}`).then( result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                        } else{
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                        }
                        this.deletedItem = null;
                        this.loadData();
                        this.onReset();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }
            },
            nomineeForList(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/pmis/employee/nominee-for-list`).then( result => {
                    this.nomineeForOptions = result.data;
                }).catch(err => {
                    console.log(err);
                });

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
</style>
