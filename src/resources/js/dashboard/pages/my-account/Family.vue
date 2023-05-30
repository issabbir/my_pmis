<template>
    <div class="content-body">
        <b-row>
            <b-col md="12" sm="12" class="pr-md-0">
                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                    <b-card title="Family Members">
                        <b-card-body class="border">
                            <b-row>
                                <b-col md="10">
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Name" label-for="emp_member_name" class="requiredField">
                                                <b-form-input
                                                    v-model.trim="$v.family.emp_member_name.$model"
                                                    class="uppercase"
                                                    name="emp_member_name">
                                                </b-form-input>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.emp_member_name.$error && !$v.family.emp_member_name.required}">Member name is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Name Bangla"
                                                label-for="emp_member_name_bng">
                                                <b-form-input
                                                    v-model="$v.family.emp_member_name_bng.$model"
                                                    class="uppercase"
                                                    name="emp_member_name_bng">
                                                </b-form-input>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.emp_member_name_bng.$error && !$v.family.emp_member_name_bng.required}">Member name in Bengali is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Relation"
                                                label-for="relation_type_id"
                                                class="requiredField">
                                                <v-select
                                                    v-model="relationTypes"
                                                    :options="relationOptions"
                                                    name="relation_type_id"
                                                    id="relation_type_id"
                                                    label="text"
                                                    class="uppercase"
                                                    required>
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.relation_type_id.$error && !$v.family.relation_type_id.required}">Relation type is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Status"
                                                label-for="family_member_status_id">
                                                <v-select
                                                    v-model="memberStatus"
                                                    :options="familyStatusOptions"
                                                    name="family_member_status_id"
                                                    id="family_member_status_id"
                                                    label="text"
                                                    class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.family_member_status_id.$error && !$v.family.family_member_status_id.required}">Status is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Address line 1"
                                                label-for="address_line_1"
                                                class="requiredField"
                                            >
                                                <b-form-input
                                                    v-model="$v.family.address_line_1.$model"
                                                    class="uppercase"
                                                    trim
                                                    name="address_line_1"
                                                    id="address_line_1"
                                                ></b-form-input>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.address_line_1.$error && !$v.family.address_line_1.required}">Address line 1 is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Address line 2" label-for="address_line_2">
                                                <b-form-input
                                                    :maxlength="500"
                                                    v-model="family.address_line_2"
                                                    class="uppercase"
                                                    trim name="address_line_2"
                                                    id="address_line_2"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="4">
                                            <b-form-group
                                                label="District"
                                                label-for="district"
                                                class="requiredField">
                                                <v-select
                                                    v-model="districts"
                                                    :options="district_ids"
                                                    @input="geoDistrictChange(districts.value)"
                                                    name="district_id"
                                                    id="district_id"
                                                    label="text"
                                                    class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.district_id.$error && !$v.family.district_id.required}">District is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                class="requiredField"
                                                label="THANA/UPAZILA"
                                                label-for="thana">
                                                <v-select
                                                    v-model="thanas"
                                                    :options="thana_ids"
                                                    name="thana_id"
                                                    id="thana_id"
                                                    label="text"
                                                    class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.thana_id.$error && !$v.family.thana_id.required}">Thana/Upazila is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="post code"
                                                label-for="post_code">
                                                <b-form-input
                                                    id="postcode"
                                                    v-model="family.post_code"
                                                    type="text"
                                                    class="uppercase"
                                                    placeholder="Enter Postcode"
                                                    name="post_code"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Date of birth"
                                                class="requiredField"
                                                label-for="emp_member_dob">
                                                <date-picker
                                                    v-model="$v.family.emp_member_dob.$model"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date" lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :not-after="notAfterToday()"
                                                    name="emp_member_dob">
                                                </date-picker>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.emp_member_dob.$error && !$v.family.emp_member_dob.required}">Date of birth is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Mobile"
                                                label-for="emp_member_mobile">
                                                <b-form-input
                                                    :maxlength="15"
                                                    v-model="$v.family.emp_member_mobile.$model"
                                                    name="emp_member_mobile"
                                                    @keypress="isNumber($event)">
                                                </b-form-input>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.emp_member_mobile.$error && !$v.family.emp_member_mobile.required}">Mobile number is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Authentication type"
                                                class="requiredField"
                                                label-for="auth_doc_type_id">
                                                <v-select
                                                    v-model="authTypes"
                                                    :options="auth_type_ids"
                                                    name="auth_doc_type_id" id="auth_doc_type_id"
                                                    label="text"
                                                    @input="onChangeAuthenticationType"
                                                    class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.auth_doc_type_id.$error && !$v.family.auth_doc_type_id.required}">Authentication type is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                class="requiredField"
                                                label="Authentication ID"
                                                label-for="auth_id">
                                                <b-form-input
                                                    v-model="$v.family.auth_id.$model"
                                                    name="auth_id"
                                                    @input="uniqueAuthenticationIdentity"
                                                    @change="uniqueAuthenticationIdentity">
                                                </b-form-input>
                                                <div :class="{'invalid-feedback':true ,'d-block':unique_authentication_identity_message}">{{ unique_authentication_identity_message }}!</div>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.auth_id.$error && !$v.family.auth_id.required && family.auth_doc_type_id == 1}">National id is required!</div>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.auth_id.$error && !$v.family.auth_id.required && family.auth_doc_type_id == 2}">Passport number is required!</div>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.auth_id.$error && !$v.family.auth_id.required && family.auth_doc_type_id == 3}">Birth certificate number is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="8">
                                            <b-input-group>
                                                <b-form-group :style="family.emp_family_id && family.auth_attachment?'width: 90%;':'width: 100%;'"
                                                              label="Authentication Document"
                                                              label-for="auth_attachment">
                                                    <div class="custom-file b-form-file">
                                                        <input
                                                            type="file"
                                                            class="custom-file-input"
                                                            @change="authAttachment"
                                                            accept="application/msword, application/pdf, image/png, image/jpg, image/jpeg"
                                                            v-validate="'size:500'"
                                                            id="auth_attachment"
                                                            name="auth_attachment"/>
                                                        <label data-browse="Browse" class="custom-file-label">{{family.auth_attach_file_name }} </label>
                                                    </div>
                                                </b-form-group>
                                                <b-input-group-append v-if="family.emp_family_id && family.auth_attachment" style="width: 10%">
                                                    <b-form-group
                                                        label=""
                                                        class="w-100"

                                                    >
                                                        <b-button style="margin-top: 20px" class="btn btn-primary w-100" @click="showAttachment(family.auth_attachment)"> <i class="fa fa-download"></i> </b-button>
                                                    </b-form-group>

                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Medical ID" label-for="emp_member_medical_id">
                                                <b-form-input :maxlength="50" v-model="family.emp_member_medical_id"
                                                              name="emp_member_medical_id"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" :style="family.relation_type_id != 19 && family.relation_type_id != 22 ?'pointer-events:none':''">
                                            <b-form-group
                                                label="Gender"
                                                class="requiredField"
                                                label-for="gender_id">
                                                <v-select
                                                    v-model="genders"
                                                    :options="gender_ids"
                                                    name="gender_id"
                                                    id="gender_id"
                                                    label="text"
                                                    class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.gender_id.$error && !$v.family.gender_id.required}">Gender is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" v-if="education_allowance_yn=='Y'">
                                            <b-form-group
                                                label="Education Allowance"
                                                label-for="emp_member_allowance_yn">
                                                <b-form-radio-group
                                                    id="emp_member_allowance_yn"
                                                    v-model="family.emp_member_allowance_yn"
                                                    :options="allowances"
                                                    name="emp_member_allowance_yn"
                                                ></b-form-radio-group>
                                            </b-form-group>
                                        </b-col>
                                        <!--<b-col md="4">
                                            <b-form-group
                                                label="Is Nominee"
                                                label-for="is_nominee">
                                                <b-form-checkbox
                                                    id="is_nominee_yn"
                                                    v-model="family.is_nominee_yn"
                                                    name="is_nominee_yn"
                                                    value="Y"
                                                    unchecked-value="N">
                                                    Accept
                                                </b-form-checkbox>
                                            </b-form-group>
                                        </b-col>-->
                                        <b-col md="4" v-if="family.is_nominee_yn=='Y'">
                                            <b-form-group
                                                label="Nominee For"
                                                label-for="nominee_for_id"
                                                class="requiredField"
                                            >
                                                <v-select
                                                    v-model="nomineeFor"
                                                    :options="nomineeForOptions"
                                                    name="nominee_for_id"
                                                    id="nominee_for_id"
                                                    label="nominee_for_name"
                                                    class="uppercase"
                                                >
                                                    <template #search="{attributes, events}">
                                                        <input
                                                            class="vs__search"
                                                            v-bind="attributes"
                                                            v-on="events"
                                                        />
                                                    </template>
                                                </v-select>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.nominee_for_id.$error && !$v.family.nominee_for_id.required}">Nominee for is required!</div>
                                            </b-form-group>
                                        </b-col>


                                        <b-col md="4" v-if="family.is_nominee_yn=='Y'">
                                            <b-form-group
                                                label="Percentage(%)"
                                                label-for="percentage"
                                                class="requiredField"
                                            >
                                                <b-form-input
                                                    id="percentage"
                                                    v-model="$v.family.percentage.$model"
                                                    type="text"
                                                    placeholder="Percentage"
                                                    name="percentage"
                                                    :maxlength="3"
                                                ></b-form-input>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.percentage.$error && !$v.family.percentage.required}">Percentage is required!</div>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.percentage.$error && !$v.family.percentage.maxValue}">Max value is 100!</div>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="4" v-if="family.is_nominee_yn=='Y'">
                                            <b-form-group
                                                label="E-mail"
                                                label-for="nominee_email"
                                            >
                                                <b-form-input
                                                    id="nominee_email"
                                                    v-model="family.nominee_email"
                                                    type="text"
                                                    name="nominee_email"
                                                    placeholder="E-mail"
                                                    :maxlength="50"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="4" v-if="family.is_nominee_yn=='Y'">
                                            <b-form-group
                                                label="Authentication Document"
                                                label-for="auth_id_document">
                                                <div class="custom-file b-form-file">
                                                    <input
                                                        type="file"
                                                        class="custom-file-input"
                                                        @change="getAuthIdDocument"
                                                        accept="application/msword, application/pdf, image/png, image/jpg, image/jpeg"
                                                        name="nominee_auth_doc"/>
                                                    <label data-browse="Browse" class="custom-file-label">{{family.nominee_auth_id_photo_name }} </label>
                                                </div>
                                                <div v-if="hasAuthenticationDocument()">
                                                    <a :href="getAuthenticationDownloaderUrl(nominee.nominee_id)" target="_blank"> {{family.nominee_auth_id_photo_name }} </a>
                                                </div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" v-if="family.is_nominee_yn=='Y'">
                                            <b-form-group
                                                label="Bank"
                                                label-for="nominee_bank">
                                                <v-select v-model="banks" :options="bankList"
                                                          name="nominee_bank" id="nominee_bank" label="text"
                                                          @input="bankChange(banks.value)"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes"
                                                               v-on="events"/>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" v-if="family.is_nominee_yn=='Y'">
                                            <b-form-group
                                                label="Branch"
                                                label-for="nominee_branch">
                                                <v-select v-model="branches" :options="branchList"
                                                          name="nominee_branch" id="nominee_branch" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes"
                                                               v-on="events"/>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" v-if="family.is_nominee_yn=='Y'">
                                            <b-form-group
                                                label="Account No"
                                                label-for="nominee_acc_no">
                                                <b-form-input
                                                    id="nominee_acc_no"
                                                    v-model="family.nominee_acc_no"
                                                    type="text"
                                                    name="nominee_acc_no"
                                                    placeholder="Acc No"
                                                    :maxlength="500"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" v-if="family.is_nominee_yn=='Y'">
                                            <b-form-group
                                                label="Autistic"
                                                label-for="autistic_yn"
                                                class="requiredField"
                                            >
                                                <b-form-radio-group
                                                    id="autistic_yn"
                                                    v-model="$v.family.autistic_yn.$model"
                                                    :options="autisticOptions"
                                                    name="autistic_yn"
                                                >
                                                </b-form-radio-group>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.autistic_yn.$error && !$v.family.autistic_yn.required}">Autistic status is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" :style="marriedRelations.indexOf(family.relation_type_id) !== -1 ? 'pointer-events:none':''">
                                            <b-form-group
                                                label="Marital Status"
                                                label-for="marital_status_id"
                                                class="requiredField"
                                            >
                                                <v-select v-model="maritalStatus" :options="maritalStatusList"
                                                          name="marital_status_id" id="marital_status_id" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.family.marital_status_id.$error && !$v.family.marital_status_id.required}">Marital status is required!</div>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col md="2" class="text-center profileImage">
                                    <b-card class="m-0" style="border: 1px solid #eff1f2;">
                                        <b-card-text>
                                            <img
                                                id="nomineepic"
                                                :src="family.photo ? family.photo : '/images/avatar.png'"
                                                class="img-fluid">
                                        </b-card-text>
                                    </b-card>
                                    <label style="width:100%" class="btn btn-primary"> Upload Photo
                                        <input class="uploadImage" hidden type="file" @change="getNomineePhoto" name="nominee_photo"/>
                                    </label>
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
                            <template v-slot:actions="{ rows }">
                                <b-link ml="4" class="text-primary" @click="editRow(rows.item)"><i class="bx bx-edit cursor-pointer"></i></b-link>
                                <b-link class="text-danger" v-b-modal="'family-remove'" @click="deletedItem = rows.item"><i class="bx bx-trash cursor-pointer"></i></b-link>
                                <a v-if="rows.item.auth_attach_file_name" size="sm" @click="showAttachment(rows.item.emp_family_id)"><i
                                    class="fa fa-download cursor-pointer"></i> </a>
                            </template>
                            <template v-slot:action2="{ rows }">
                                <span v-if="rows.item.approved_yn == 'Y'" class="text-success text-center">Approved</span>
                                <span class="text-danger text-center" v-else>Pending</span>
                            </template>
                        </Datatable>
                        <b-modal :id="'family-remove'" :centered="true" title="Please Confirm" size="sm"
                                 buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"
                                 :hideHeaderClose="false"
                                 @ok="deleteRow()" @hidden="deletedItem = null">
                            <div>Are you sure you want to delete?</div>
                        </b-modal>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker'
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    const {required, requiredIf, maxLength, minLength, email, maxValue, decimal} = require("vuelidate/lib/validators");
    const marriedRelations = [1, 2, 3, 4, 9, 10, 17, 18]
    export default {
        components: {DatePicker, Datatable, vSelect},
        props: ['id'],
        data() {
            return {
                education_allowance_yn: 'N',
                marriedRelations: marriedRelations,
                nomineeForOptions: [],
                nomineeFor: {'nominee_for_name': '', 'nominee_for_id': ''},
                relationships: {'text': '', 'value': ''},
                maritalStatus: {'text': '', 'value': '', maritial_status_id: ''},
                thana: {'text': '', 'value': ''},
                authenticationTypes: {'text': '', 'value': ''},
                banks: {'text': '', 'value': ''},
                branches: {'text': '', 'value': ''},
                relationshipWithNomineeList: [{'value': '', 'text': 'Select Relationship with Nominee'}],
                maritalStatusList: [{'value': '', 'text': 'Select Marital Status'}],
                authTypeList: [{'value': '', 'text': 'Select Authentication Type'}],
                bankList: [{'value': '', 'text': 'Select Bank'}],
                branchList: [{'value': '', 'text': 'Select Branch'}],
                genderList: [{'value': '', 'text': 'Select Gender'}],
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
                districts: {'text': '', 'value': ''},
                thanas: {'text': '', 'value': ''},
                authTypes: {'text': '', 'value': ''},
                memberStatus: {'text': '', 'value': ''},
                relationTypes: {'text': '', 'value': '',education_allowance_yn: ''},
                genders: {'text': '', 'value': ''},
                valueType: this.dateFormatter(),
                family: {
                    emp_family_id: '',
                    emp_member_name: '',
                    emp_member_name_bng: '',
                    relation_type_id: '',
                    address_line_1: '',
                    address_line_2: '',
                    emp_member_dob: '',
                    emp_member_mobile: '',
                    auth_doc_type_id: '',
                    emp_member_medical_id: '',
                    gender_id: '',
                    family_member_status_id: '',
                    emp_member_allowance_yn: "N",
                    auth_id: '',
                    district_id: '',
                    thana_id: '',
                    post_code: '',
                    is_nominee_yn: '',
                    percentage: '',
                    nominee_for_id: '',
                    nominee_marital_status_id: '',
                    nominee_email: '',
                    nominee_photo: '',
                    nominee_auth_id_photo: '',
                    nominee_acc_no: '',
                    bank_id: '',
                    branch_id: '',
                    nominee_photo_name: '',
                    nominee_photo_type: '',
                    nominee_auth_id_photo_name: '',
                    nominee_auth_id_photo_type: '',
                    autistic_yn: 'N',
                    approved_yn: 'N',
                    auth_attachment: '',
                    auth_attach_file_type: '',
                    auth_attach_file_name: '',
                    marital_status_id: '',
                    photo: ''
                },
                relationOptions: [{'value': '', 'text': 'Select Relation'}],
                familyStatusOptions: [{'value': '', 'text': 'Select Status'}],
                allowances: [{"text": "YES", "value": "Y"}, {"text": "NO", "value": "N"}],
                auth_type_ids: [{'value': '', 'text': 'Select Authentication type'}],
                gender_ids: [{'value': '', 'text': 'Select Gender'}],
                district_ids: [{'value': '', 'text': 'Select District'}],
                thana_ids: [{'value': '', 'text': 'Select Thana/Upazilla'}],
                medical_ids: [],
                updateIndex: -1,
                submitBtn: 'Save',
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'emp_member_name', label: 'Name', sortable: true},
                    {key: 'gender.gender_name', label: 'Gender', sortable: true},
                    {
                        key: 'emp_member_dob',
                        label: 'Date of birth', sortable: true, filterByFormatted: true, sortByFormatted: true,
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }
                    },
                    {key: 'relation.relation_type', label: "Relation", sortable: true},
                    {key: 'family_status.family_member_status', label: 'Family status', sortable: true},
                    {
                        key: 'emp_member_allowance_yn',
                        label: 'Allowance applicable',
                        sortable: true,
                        filterByFormatted: true,
                        sortByFormatted: true,
                        formatter: (value) => {
                            if (value === 'Y') {
                                return 'Yes';
                            } else {
                                return 'No';
                            }
                        }
                    },
                    {
                        key: 'action2', label: 'Status'
                    },
                    // {
                    //     key: 'approved_yn',
                    //     label: 'Status',
                    //     sortable: true,
                    //     filterByFormatted: true,
                    //     sortByFormatted: true,
                    //     formatter: (value) => {
                    //         if (value === 'Y') {
                    //             return 'Approved';
                    //         } else {
                    //             return 'Pending';
                    //         }
                    //     }
                    // },
                    {key: 'emp_member_mobile', label: "Mobile", sortable: true}, 'action'],
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
        validations: {
            family: {
                emp_family_id: {},
                emp_member_name: {required},
                emp_member_name_bng: {},
                relation_type_id: {required},
                address_line_1: {required},
                address_line_2: {},
                emp_member_dob: {required},
                emp_member_mobile: {},
                auth_doc_type_id: {required},
                emp_member_medical_id: {},
                gender_id: {required},
                family_member_status_id: {},
                emp_member_allowance_yn: {},
                auth_id: {required},
                district_id: {required},
                thana_id: {required},
                post_code: {},
                is_nominee_yn: {},
                percentage: {
                    required: requiredIf(function () {
                        return this.family.is_nominee_yn == 'Y' ? true : false
                    }),
                    maxValue: maxValue(100),
                    decimal
                },
                nominee_for_id: {
                    required: requiredIf(function () {
                        return this.family.is_nominee_yn == 'Y' ? true : false
                    })
                },
                nominee_marital_status_id: {},
                nominee_email: {email},
                nominee_photo: {},
                nominee_auth_id_photo: {},
                nominee_acc_no: {},
                bank_id: {},
                branch_id: {},
                nominee_photo_name: {},
                nominee_photo_type: {},
                nominee_auth_id_photo_name: {},
                nominee_auth_id_photo_type: {},
                autistic_yn: {
                    required: requiredIf(function () {
                        return this.family.is_nominee_yn == 'Y' ? true : false
                    })
                },
                approved_yn: {required},
                auth_attachment: {},
                auth_attach_file_type: {},
                auth_attach_file_name: {},
                marital_status_id: {required}
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Family"});
            this.loadData();
            this.nomineePage();
            this.nomineeForList();
        },
        watch: {
            maritalStatus: function(val, oldVal){
                if(val.maritial_status_id !== null) {
                    this.family.marital_status_id = val.maritial_status_id;
                } else {
                    this.family.marital_status_id = '';
                }
            },
            nomineeFor: function(val, oldVal){
                if (val !== null) {
                    this.family.nominee_for_id = val.nominee_for_id;
                } else {
                    this.family.nominee_for_id = '';
                }
            },
            banks: function(val, oldVal){
                if (val !== null) {
                    this.family.bank_id = val.value;
                } else {
                    this.family.bank_id = '';
                }
            },
            branches: function(val, oldVal){
                if (val !== null) {
                    this.family.branch_id = val.value;
                } else {
                    this.family.branch_id = '';
                }
            },
            districts: function (val, oldVal) {
                if (val !== null) {
                    this.family.district_id = val.value;
                } else {
                    this.family.district_id = '';
                }
            },
            thanas: function (val, oldVal) {
                if (val !== null) {
                    this.family.thana_id = val.value;
                } else {
                    this.family.thana_id = '';
                }
            },
            authTypes: function (val, oldVal) {
                if (val !== null) {
                    this.family.auth_doc_type_id = val.value;
                } else {
                    this.family.auth_doc_type_id = '';
                }
            },
            genders: function (val, oldVal) {
                if (val !== null) {
                    this.family.gender_id = val.value;
                } else {
                    this.family.gender_id = '';
                }
            },
            relationTypes: function (val, oldVal) {
                if (val !== null) {
                    this.education_allowance_yn = val.education_allowance_yn
                    this.family.relation_type_id = val.value;
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
                        this.genders = this.genders
                    }

                    if(this.marriedRelations.indexOf(val.value) !== -1){
                        this.maritalStatus = {
                            text: 'MARRIED',
                            value: 2,
                            maritial_status_id: 2,
                            maritial_status: 'MARRIED'
                        }
                    }

                } else {
                    this.family.relation_type_id = '';
                    this.education_allowance_yn = 'N'
                }
            },
            memberStatus: function (val, oldVal) {
                if (val !== null) {
                    this.family.family_member_status_id = val.value;
                } else {
                    this.family.family_member_status_id = '';
                }
            }
        },
        created() {
            this.$validator.extend(
                'nationalId', {
                    getMessage: (field) => {
                        return 'The given value is incorrect.';
                    },
                    validate: (value) => {
                        let givenValue = value.trim();
                        if (givenValue) {
                            let isNumeric = /^\d+$/.test(givenValue);
                            if (!isNumeric) {
                                return false;
                            }
                            return (givenValue.length === 10) || (givenValue.length === 13) || (givenValue.length === 17);
                        } else {
                            return true;
                        }
                    }
                });
            this.$validator.extend(
                'birthCertificate', {
                    getMessage: (field) => {
                        return 'The given value is incorrect.';
                    },
                    validate: (value) => {
                        let givenValue = value.trim();
                        if (givenValue) {
                            let isNumeric = /^\d+$/.test(givenValue);
                            if (!isNumeric) {
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
            authAttachment(event) {
                let currObj = this
                if (event.target.files && event.target.files[0]) {
                    let file = event.target.files[0]
                    let reader = new FileReader()
                    this.family.auth_attach_file_type = file.type;
                    this.family.auth_attach_file_name = file.name;
                    reader.readAsDataURL(file);

                    reader.onload = (e) => {
                        currObj.family.auth_attachment = e.target.result;
                    };
                }
            },
            showAttachment(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/family-files/${id}`).then(res => {
                    const win = window.open("","_blank");
                    let html = '';
                    html += '<html>';
                    html += '<body style="margin:0!important">';
                    html += '<embed width="100%" height="100%" src="'+res.data.auth_attachment+'"/>';
                    html += '</body>';
                    html += '</html>';
                    setTimeout(() => {
                        win.document.write(html);
                    }, 0);
                })


            },
            getNomineePhoto(event) {
                let currObj = this;
                if (event.target.files.length > 0) {
                    let file = event.target.files[0]
                    let reader = new FileReader();
                    this.family.nominee_photo_name = file.name
                    this.family.nominee_photo_type = file.type
                    reader.readAsDataURL(file);
                    reader.onload = (e) => {
                        currObj.family.photo = e.target.result;
                    };
                }
            },
            getAuthIdDocument(event) {
                let currObj = this
                if (event.target.files && event.target.files[0]) {
                    let file = event.target.files[0]
                    let reader = new FileReader()

                    this.family.nominee_auth_id_photo_type = file.type;
                    this.family.nominee_auth_id_photo_name = file.name;

                    reader.readAsDataURL(file);

                    reader.onload = (e) => {
                        currObj.family.nominee_auth_id_photo = e.target.result;
                    };
                }
            },
            hasAuthenticationDocument() {
                return (this.family.nominee_id && this.family.nominee_auth_id_photo);
            },
            getAuthenticationDownloaderUrl(nomineeId) {
                return 'pmis/nominee/download-authentication-document/' + nomineeId;
            },
            isNumber: function (evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                    ;
                } else {
                    return true;
                }
            },
            onChangeAuthenticationType() {
                this.family.auth_id = ""
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            uniqueAuthenticationIdentity() {
                if (this.family.auth_doc_type_id && this.family.auth_id) {
                    let params = {
                        'emp_family_id': this.family.emp_family_id,
                        'auth_doc_type_id': this.family.auth_doc_type_id,
                        'auth_id': this.family.auth_id
                    };
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/families/my-family-unique-family-auth-id', {params}).then(result => {
                        this.unique_authentication_identity_message = result.data.unique_message;
                    });
                }
            },
            geoDistrictChange(id) {
                if (id) {
                    let district_id =  id
                    if (this.family.old_district_id) {
                        if (district_id != this.family.old_district_id) {
                            this.thanas = '';
                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-thanas/${district_id}`).then(result => {
                        this.thana_ids = result.data;
                    });
                }
            },
            dateFormatter: function () {
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
            onSubmit() {
                this.$v.$touch();
                this.$v.family.$touch();
                if (!this.$v.family.$invalid){
                    this.keepDisable = true;
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/my-families", this.family).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.loadData()
                            this.onReset();
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                        this.keepDisable = false;
                    })

                }

            },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/families/my-family`).then(res => {
                    if (this.relationOptions.length <= 1) {
                        this.relationOptions = this.relationOptions.concat(res.data.relations);
                    }

                    if (this.auth_type_ids.length <= 1) {
                        this.auth_type_ids = this.auth_type_ids.concat(res.data.auth_type_ids);
                    }

                    if (this.gender_ids.length <= 1) {
                        this.gender_ids = this.gender_ids.concat(res.data.gender);
                    }

                    if (this.familyStatusOptions.length <= 1) {
                        this.familyStatusOptions = this.familyStatusOptions.concat(res.data.family_status);
                    }

                    if (this.district_ids.length <= 1) {
                        this.district_ids = this.district_ids.concat(res.data.district_ids);
                    }
                    this.family.address_line_1 = res.data.empAddress.address_line_1;
                    this.family.address_line_2 = res.data.empAddress.address_line_2;
                    this.districts = res.data.empAddress.geo_district;
                    this.thanas = res.data.empAddress.geo_thana;
                    this.family.post_code = res.data.empAddress.post_code;
                    this.items = res.data.data;
                    this.totalList = res.data.data.length;
                    this.thana_ids = res.data.selectedThanaByDefult;

                });
            },
            nomineePage() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/my-nominee`).then(res => {
                    if (this.relationshipWithNomineeList.length <= 1) {
                        this.relationshipWithNomineeList = this.relationshipWithNomineeList.concat(res.data.relationships);
                    }

                    if (this.maritalStatusList.length <= 1) {
                        this.maritalStatusList = this.maritalStatusList.concat(res.data.maritalStatuses);
                    }

                    if (this.authTypeList.length <= 1) {
                        this.authTypeList = this.authTypeList.concat(res.data.authdocs);
                    }

                    if (this.bankList.length <= 1) {
                        this.bankList = this.bankList.concat(res.data.banks);
                    }

                    if (this.genderList.length <= 1) {
                        this.genderList = this.genderList.concat(res.data.genders);
                    }

                });
            },
            bankChange(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/branches/${id}`).then(result => {
                        this.branchList = result.data;
                    });
                }
            },
            nomineeForList() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominee-for-list`).then(result => {
                    this.nomineeForOptions = result.data;
                }).catch(err => {
                    console.log(err);
                });

            },
            onReset() {
                this.thana_ids = [{'value': '', 'text': 'Select Thana/Upazilla'}];
                this.unique_authentication_identity_message = '';
                this.updateIndex = -1;
                this.deletedItem = null;
                this.submitBtn = 'Save';
                this.$nextTick(() => {

                    this.districts = {
                        text: '',
                        value: ''
                    }
                    this.banks = {
                        text: '',
                        value: ''
                    }
                    this.branches = {
                        text: '',
                        value: ''
                    }
                    this.authTypes = {
                        text: '',
                        value: ''
                    }
                    this.thanas = {
                        text: '',
                        value: ''
                    }
                    this.genders = {
                        text: '',
                        value: ''
                    }
                    this.relationTypes = {
                        text: '',
                        value: '',
                        education_allowance_yn: ''
                    };
                    this.memberStatus = {
                        text: '',
                        value: ''
                    }
                    this.maritalStatus = {
                        text: '',
                        value: ''
                    }
                    this.nomineeFor = {
                        nominee_for_name: '',
                        nominee_for_id: ''
                    }
                    this.family = {
                        emp_family_id: '',
                        emp_member_name: '',
                        emp_member_name_bng: '',
                        relation_type_id: '',
                        address_line_1: '',
                        address_line_2: '',
                        emp_member_dob: '',
                        emp_member_mobile: '',
                        auth_doc_type_id: '',
                        emp_member_medical_id: '',
                        gender_id: '',
                        family_member_status_id: '',
                        emp_member_allowance_yn: "N",
                        auth_id: '',
                        district_id: '',
                        thana_id: '',
                        post_code: '',
                        is_nominee_yn: '',
                        percentage: '',
                        nominee_for_id: '',
                        nominee_marital_status_id: '',
                        nominee_email: '',
                        nominee_photo: '',
                        nominee_auth_id_photo: '',
                        nominee_acc_no: '',
                        bank_id: '',
                        branch_id: '',
                        nominee_photo_name: '',
                        nominee_photo_type: '',
                        nominee_auth_id_photo_name: '',
                        nominee_auth_id_photo_type: '',
                        autistic_yn: 'N',
                        approved_yn: 'N',
                        auth_attachment: '',
                        auth_attach_file_type: '',
                        auth_attach_file_name: '',
                        marital_status_id: ''
                    }
                    this.family.emp_member_allowance_yn = 'N';
                    this.$v.$reset()
                })
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1
            },
            editRow(item) {
                this.submitBtn = 'Update'
                /*this.family = item*/
                this.family=  {
                    emp_family_id: item.emp_family_id,
                    photo: '',
                    emp_id: item.emp_id,
                    emp_member_name: item.emp_member_name,
                    emp_member_name_bng: item.emp_member_name_bng,
                    relation_type_id: item.relation_type_id,
                    address_line_1: item.address_line_1?item.address_line_1:this.family.address_line_1,
                    address_line_2: item.address_line_2?item.address_line_2:this.family.address_line_2,
                    emp_member_dob: item.emp_member_dob,
                    emp_member_mobile: item.emp_member_mobile,
                    auth_doc_type_id: item.auth_doc_type_id,
                    emp_member_medical_id: item.emp_member_medical_id,
                    gender_id: item.gender ? item.gender_id: '',
                    auth_attachment: '',
                    auth_attach_file_name: item.auth_attach_file_name,
                    auth_attach_file_type: item.auth_attach_file_type,
                    family_member_status_id: item.family_member_status_id,
                    emp_member_allowance_yn: item.emp_member_allowance_yn,
                    auth_id: item.auth_id,
                    district_id: item.district_id ? item.district_id : this.family.district_id,
                    thana_id: item.thana_id ? item.thana_id : this.family.thana_id,
                    post_code: item.post_code,
                    is_nominee_yn: item.is_nominee_yn,
                    percentage: item.percentage,
                    nominee_for_id: item.nominee_info ? item.nominee_info.nominee_for_id:'',
                    nominee_marital_status_id: item.nominee_info ? item.nominee_info.nominee_marital_status_id:'',
                    nominee_email: item.nominee_info ? item.nominee_info.nominee_email:'',
                    nominee_photo: item.nominee_info ? item.nominee_info.nominee_photo:'',
                    nominee_auth_id_photo: item.nominee_info ? item.nominee_info.nominee_auth_id_photo:'',
                    nominee_acc_no: item.nominee_info ? item.nominee_info.nominee_acc_no:'',
                    bank_id: item.nominee_info ? item.nominee_info.bank_id:'',
                    branch_id: item.nominee_info ? item.nominee_info.branch_id:'',
                    nominee_photo_name: item.nominee_info ? item.nominee_info.nominee_photo_name:'',
                    nominee_photo_type: item.nominee_info ? item.nominee_info.nominee_photo_type:'',
                    nominee_auth_id_photo_name: item.nominee_info ? item.nominee_info.nominee_auth_id_photo_name:'',
                    nominee_auth_id_photo_type: item.nominee_info ? item.nominee_info.nominee_auth_id_photo_type:'',
                    autistic_yn: item.nominee_info ? item.nominee_info.autistic_yn:'N',
                    approved_yn: item.nominee_info ? item.nominee_info.approved_yn:'N'
                }
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/family-files/${item.emp_family_id}`).then(res => {
                    this.family.photo = res.data.photo
                    this.family.auth_attachment = res.data.auth_attachment
                })
                this.relationTypes = {
                    text: item.relation ? item.relation.text : '',
                    value: item.relation ? item.relation.value : '',
                    education_allowance_yn: item.relation ? item.relation.education_allowance_yn: ''
                }
                this.memberStatus = item.family_status
                this.authTypes = item.auth_doc_type
                this.genders = item.gender
                this.maritalStatus ={
                    text: item.marital_status?item.marital_status.text: '',
                    value: item.marital_status?item.marital_status.value: '',
                    maritial_status_id: item.marital_status?item.marital_status.maritial_status_id: ''
                }
                if(item.nominee_info){
                    this.nomineeFor = item.nominee_info.nominee_for
                    this.family.nominee_email = item.nominee_info.nominee_email
                    //this.maritalStatus = item.nominee_info.marital_status
                    this.banks = item.nominee_info.bank
                    this.branches = item.nominee_info.branch
                    this.family.autistic_yn = item.nominee_info.autistic_yn
                    this.family.nominee_acc_no = item.nominee_info.nominee_acc_no
                    this.family.nominee_auth_id_photo = item.nominee_info.nominee_auth_id_photo
                    this.family.nominee_auth_id_photo_name = item.nominee_info.nominee_auth_id_photo_name
                    this.family.nominee_auth_id_photo_type = item.nominee_info.nominee_auth_id_photo_type
                    this.family.nominee_photo = item.nominee_info.nominee_photo
                    this.family.nominee_photo_name = item.nominee_info.nominee_photo_name
                    this.family.nominee_photo_type = item.nominee_info.nominee_photo_type
                }
                this.districts = item.district ? item.district: this.districts
                if(this.family.district_id){
                    this.geoDistrictChange(this.family.district_id);
                }
                this.thanas = item.thana


            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/pmis/employee/families/${this.deletedItem.emp_family_id}`).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
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
    .uppercase {
        text-transform: uppercase;
    }

</style>
