<template>
    <div class="content-body">
        <b-card class="bg-transparent basicinfo">
            <b-card-header class="m-0" style="padding-top:0px;">
                <b-form-checkbox class="float-left" vertical v-model="hidenseek" name="check-button" switch size="lg"></b-form-checkbox>
                <p class="float-right ml-2">
                    <b-badge  v-if="basicInfo.approved_yn == 'N'" variant="danger">NOT APPROVED</b-badge>
                </p>
                <p class="float-right">
                    <b-badge  v-if="basicInfo.emp_id" variant="success">{{basicInfo.emp_name}} ({{basicInfo.emp_code}})</b-badge>
                </p>
            </b-card-header>
            <b-card-body class="pills-stacked" >

                <b-row >
                    <b-col md="2" sm="12" class="border pr-md-0" :class="{'d-none':!hidenseek}">
                        <SideBar :empId="id" class="mt-1" ></SideBar>
                    </b-col>
                    <b-col md="10" sm="12"  :class="{'col-md-12':!hidenseek}" class="pr-md-0">
                        <b-card>
                            <form-wizard @on-complete="onSubmit" title subtitle color="#394C62" shape="square" ref="basicinfo" :finish-button-text="id?'Update':'Submit'">
                                <tab-content v-if="can_update" title="General" icon="ti-user"  class="mb-1 mt-0" :before-change="validateGeneral">
                                    <b-card-text class="">
                                        <b-row>
                                            <b-col md="2" class="text-center profileImage">
                                                <b-card class="m-0" style="border: 1px solid #eff1f2;">
                                                    <b-card-text >
                                                        <img id="profilepic" :src="basicInfo.emp_photo ? basicInfo.emp_photo : '/images/avatar.png'"  class="img-fluid" alt="...">
                                                    </b-card-text>
                                                </b-card>
                                                <label style="width:100%" class="btn btn-primary"> Upload Photo
                                                    <input class="uploadImage"  type="file"  name="emp_photo" @change="getPhoto" accept=".jpg"/>
                                                </label>
                                                <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_photo')}">{{ errors.first('emp_photo') }}!</div>
                                            </b-col>

                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Deputation"
                                                    label-for="deputation_yn"
                                                >
                                                    <b-form-radio-group
                                                        v-model="basicInfo.deputation_yn"
                                                        :options="deputation_yn_options" required  v-validate="'required'"
                                                        name="deputation_yn"
                                                        @change="checkDeputation()"
                                                    ></b-form-radio-group>
                                                    <span :style="errorMessage">{{ errors.first('deputation_yn') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Previous Workplace"
                                                    label-for="previous_workplace"
                                                    :class="req_deputation_yn"
                                                >
                                                    <b-form-input
                                                        id="previous_workplace"
                                                        v-model="basicInfo.previous_workplace"
                                                        :disabled="basicInfo.deputation_yn == 'N'"
                                                        type="text"
                                                        :maxlength="500"
                                                        name="previous_workplace"
                                                        placeholder="Enter Previous Workplace"  v-validate="'required'"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('previous_workplace') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Previous Workplace designation"
                                                    label-for="previous_designation"
                                                    :class="req_deputation_yn"
                                                >
                                                    <b-form-input
                                                        id="previous_designation"
                                                        v-model="basicInfo.previous_designation"
                                                        :disabled="basicInfo.deputation_yn == 'N'"
                                                        type="text"
                                                        :maxlength="500"
                                                        name="previous_designation"
                                                        placeholder="Enter Previous Workplace designation"  v-validate="'required'"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('previous_designation') }}</span>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Previous Workplace Office Address"
                                                    label-for="previous_office_address"
                                                    :class="req_deputation_yn"
                                                >
                                                    <b-form-input
                                                        id="previous_office_address"
                                                        v-model="basicInfo.previous_office_address"
                                                        :disabled="basicInfo.deputation_yn == 'N'"
                                                        type="text"
                                                        :maxlength="1000"
                                                        name="previous_office_address"
                                                        placeholder="Enter Previous Workplace Office Address"  v-validate="'required'"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('previous_office_address') }}</span>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="3">
                                                <b-form-group
                                                    label="Salutation"
                                                    label-for="title">
                                                    <v-select v-model="salutations" :options="salutationList"
                                                              name="salutation_id" id="salutation_id"
                                                              label="text"
                                                              class="uppercase"
                                                              required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('salutation_id')}">{{ errors.first('salutation_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <!--<b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Full Name"
                                                    label-for="emp_name">
                                                    <b-form-input
                                                        id="emp_name"
                                                        v-model="basicInfo.emp_name"
                                                        type="text"
                                                        required
                                                        class="uppercase"
                                                        placeholder="Enter Full Name"
                                                        v-validate="'required'"
                                                        name="emp_name"
                                                        :maxlength="250"
                                                    ></b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_name')}">{{ errors.first('emp_name') }}!</div>
                                                </b-form-group>
                                            </b-col>-->
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Full Name"
                                                    label-for="emp_name"
                                                >
                                                    <b-form-input
                                                        id="emp_name"
                                                        v-model="basicInfo.emp_name"
                                                        type="text"
                                                        required
                                                        class="uppercase"
                                                        :maxlength="250"
                                                        placeholder="Enter Full Name"  v-validate="'required'"
                                                        name="emp_name"
                                                        onChange="this.value=this.value.toUpperCase();"
                                                    ></b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_name')}">{{ errors.first('emp_name') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Full Name Bangla"
                                                    label-for="emp_name_bng"
                                                >
                                                    <b-form-input
                                                        id="emp_name_bng"
                                                        v-model="basicInfo.emp_name_bng"
                                                        type="text"
                                                        class="uppercase"
                                                        :maxlength="3000"
                                                        placeholder="Enter Full Name Bangla"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Father Name"
                                                    label-for="emp_father_name"
                                                >
                                                    <b-form-input
                                                        id="emp_father_name"
                                                        v-model="basicInfo.emp_father_name"
                                                        type="text"
                                                        required
                                                        class="uppercase"
                                                        :maxlength="250"
                                                        placeholder="Enter Father Name"  v-validate="'required'"
                                                        name="emp_father_name"
                                                        :readonly="basicInfo.emp_id ? true : false"
                                                        onChange="this.value=this.value.toUpperCase();"
                                                    ></b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_father_name')}">{{ errors.first('emp_father_name') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Father Name Bangla"
                                                    label-for="title"
                                                >
                                                    <b-form-input
                                                        id="emp_father_name_bangla"
                                                        v-model="basicInfo.emp_father_name_bng"
                                                        type="text"
                                                        class="uppercase"
                                                        :maxlength="3000"
                                                        :readonly="basicInfo.emp_id ? true : false"
                                                        placeholder="Father Name Bangla"
                                                    ></b-form-input>

                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Mother Name"
                                                    label-for="emp_mother_name">
                                                    <b-form-input
                                                        id="emp_mother_name"
                                                        v-model="basicInfo.emp_mother_name"
                                                        type="text"
                                                        required
                                                        class="uppercase"
                                                        :maxlength="250"
                                                        :readonly="basicInfo.emp_id ? true : false"
                                                        placeholder="Enter Mother Name" v-validate="'required'"
                                                        name="emp_mother_name"
                                                        onChange="this.value=this.value.toUpperCase();"
                                                    ></b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_mother_name')}">{{ errors.first('emp_mother_name') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Mother Name Bangla"
                                                    label-for="emp_mother_name_bng">
                                                    <b-form-input
                                                        id="emp_mother_name_bng"
                                                        v-model="basicInfo.emp_mother_name_bng"
                                                        type="text"
                                                        class="uppercase"
                                                        :maxlength="3000"
                                                        :readonly="basicInfo.emp_id ? true : false"
                                                        placeholder="Enter Mother Name Bangla"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
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
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_blood_group_id')}">{{ errors.first('emp_blood_group_id') }}!</div>
                                                </b-form-group>

                                            </b-col>

                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Date of Birth"
                                                    label-for="emp_dob">
                                                    <date-picker v-model="basicInfo.emp_dob"
                                                                 width="100%"
                                                                 input-class="form-control"
                                                                 type="date" lang="en"
                                                                 required  v-validate="'required'"
                                                                 format="DD-MM-YYYY" :value-type="valueType" :editable="false" :default-value="defaultBirthDate()" :not-after="birthDateNotAfterYears()" name="emp_dob">
                                                    </date-picker>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_dob')}">{{ errors.first('emp_dob') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Age"
                                                    label-for="Age">
                                                    <b-form-input
                                                        id="age"
                                                        v-model="basicInfo.age"
                                                        type="text"
                                                        readonly
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Gender"
                                                    label-for="emp_gender_id">
                                                    <b-form-radio-group
                                                        v-model="basicInfo.emp_gender_id"
                                                        :options="genderList"
                                                        name="emp_gender_id"
                                                        required  v-validate="'required'"
                                                    ></b-form-radio-group>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_gender_id')}">{{ errors.first('emp_gender_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Marital Status"
                                                    label-for="emp_maritial_status_id">
                                                    <v-select
                                                        class="uppercase"
                                                        v-model="maritalStatus"
                                                        :options="maritalStatusList"
                                                        v-validate="'required'"
                                                        label="text"
                                                        id="emp_maritial_status_id"
                                                        name="emp_maritial_status_id">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_maritial_status_id')}">{{ errors.first('emp_maritial_status_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Nationality "
                                                    label-for="emp_nationality_id">
                                                    <v-select v-model="nationality" :options="nationalityList"
                                                              name="emp_nationality_id" id="emp_nationality_id" class="uppercase"
                                                              required v-validate="'required'"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_nationality_id')}">{{ errors.first('emp_nationality_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Religion"
                                                    label-for="emp_religion_id">
                                                    <v-select v-model="religions" :options="religionList"
                                                              name="emp_religion_id" id="emp_religion_id"
                                                              label="text"
                                                              required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_religion_id')}">{{ errors.first('emp_religion_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Identity symbol"
                                                    label-for="identity_symbol">
                                                    <b-form-input
                                                        id="identity_symbol"
                                                        name="identity_symbol"
                                                        v-model="basicInfo.identity_symbol"
                                                        type="text"
                                                        :maxlength="250"
                                                        placeholder="Enter Identity Symbol"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Identity symbol bangla"
                                                    label-for="identity_symbol_bng">
                                                    <b-form-input
                                                        id="identity_symbol_bng"
                                                        name="identity_symbol_bng"
                                                        v-model="basicInfo.identity_symbol_bng"
                                                        type="text"
                                                        :maxlength="3000"
                                                        placeholder="Enter Identity Symbol Bangla"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Authentication type"
                                                    class="requiredField"
                                                    label-for="auth_doc_type_id">
                                                    <v-select v-model="authenticationTypes" :options="auth_type_ids"  class="uppercase"
                                                              name="auth_doc_type_id" id="auth_doc_type_id"
                                                              label="text" @input="onChangeAuthType"
                                                              required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('auth_doc_type_id')}">{{ errors.first('auth_doc_type_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="AUTHENTICATION ID" label-for="nid_no">
                                                    <b-form-input
                                                        v-model="basicInfo.nid_no"
                                                        id="nid_no"
                                                        name="nid_no"
                                                        @change="uniqueAuthenticationIdentity"
                                                        required v-validate="'required'">
                                                    </b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':unique_authentication_identity_message}">{{ unique_authentication_identity_message }}!</div>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('nid_no')}">This {{authenticationTypes.text.toLowerCase() }} is required!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Authentication Document"
                                                    label-for="auth_document">
                                                    <div class="custom-file b-form-file">
                                                        <input type="file" class="custom-file-input" @change="getAuthIdDocument" aria-describedby="authentication-document-help-block" accept="application/msword,application/pdf,image/png,image/jpg,image/jpeg" name="auth_document" />
                                                        <b-form-text id="authentication-document-help-block">
                                                            Document must be PDF,DOCX,Image only.
                                                        </b-form-text>
                                                        <label data-browse="Browse" class="custom-file-label">{{basicInfo.auth_document_name}} </label>
                                                        <span :style="errorMessage">{{ errors.first('auth_document') }}</span>
                                                    </div>
                                                    <div v-if="hasAuthenticationDocument()">
                                                        <a :href="getAuthenticationDownloaderUrl(basicInfo.emp_id)" target="_blank"> {{basicInfo.auth_document_name}} </a>
                                                    </div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Tribal"
                                                    label-for="Tribal">
                                                    <b-form-radio-group
                                                        v-model="basicInfo.tribal_yn"
                                                        id="emp_tribal_yn"
                                                        :options="tribal_yn_options" required  v-validate="'required'"
                                                        name="emp_tribal_yn"
                                                    ></b-form-radio-group>
                                                </b-form-group>
                                                <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_tribal_yn')}">{{ errors.first('emp_tribal_yn') }}!</div>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Active"
                                                    label-for="emp_active_yn">
                                                    <b-form-radio-group
                                                        v-model="basicInfo.emp_active_yn"
                                                        :disabled="basicInfo.emp_id ? false : true"
                                                        :options="emp_active_yn_options"
                                                        id="emp_active_yn"
                                                        name="emp_active_yn"
                                                    ></b-form-radio-group>
                                                </b-form-group>
                                            </b-col>

                                        </b-row>
                                    </b-card-text>
                                </tab-content>
<!--                                <tab-content v-if="can_update"  title=" General Preview" icon="ti-eye" class="mb-1 mt-0">-->
<!--                                    <b-card-text>-->
<!--                                        <GeneralPreview :employee="basicInfo" ></GeneralPreview>-->
<!--                                    </b-card-text>-->
<!--                                </tab-content>-->
                                <tab-content v-if="can_update" title="Position" icon="ti-settings" class="mb-1 mt-0" :before-change="validatePosition">
                                    <div col="md-12">
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Division"
                                                    label-for="dpt_division_id">
                                                    <v-select  v-model="divisions" :options="dptDivisionList"
                                                               name="dpt_division_id" id="dpt_division_id"
                                                               label="text" class="uppercase"
                                                               @input="divisionChange(divisions.value)"
                                                               required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('dpt_division_id')}">{{ errors.first('dpt_division_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="DEPARTMENT"
                                                    label-for="dpt_department_id">
                                                    <v-select v-model="departments" :options="departmentList"
                                                              name="dpt_department_id" id="dpt_department_id"
                                                              label="text" class="uppercase"
                                                              @input="departmentChange(departments.value)"
                                                              required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('dpt_department_id')}">{{ errors.first('dpt_department_id') }}!</div>
                                                </b-form-group>
                                            </b-col>


                                            <b-col md="3">
                                                <b-form-group
                                                    label="SECTION"
                                                    label-for="section_id">
                                                    <v-select v-model="sections" :options="sectionList"
                                                              name="section_id" id="section_id" class="uppercase"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="DESIGNATION"
                                                    label-for="designation_id">
                                                    <v-select v-model="designations" :options="designationList"
                                                              name="designation_id" id="designation_id" label="text"
                                                              class="uppercase"
                                                              @input="designationChange(designations.designation_id)"
                                                              required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('designation_id')}">{{ errors.first('designation_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="CURRENT DEPARTMENT"
                                                    label-for="current_department_id">
                                                    <v-select v-model="current_departments"
                                                              :options="currentDepartmentList"
                                                              name="current_department_id" id="current_department_id"
                                                              label="text" class="uppercase"
                                                              :disabled="basicInfo.emp_id ? false : true"
                                                              @input="departmentChange(departments.value)"
                                                              required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
<!--                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('current_department_id')}">{{ errors.first('current_department_id') }}!</div>-->
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Employee type"
                                                    label-for="emp_type_id">
                                                    <v-select v-model="employeeTypes" :options="empTypeList"
                                                              name="emp_type_id" id="emp_type_id" label="text"
                                                              class="uppercase"
                                                              :disabled="(payGrades.emp_grade_id == 10 || payGrades.emp_grade_id == 11)?false:true"
                                                              required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_type_id')}">{{ errors.first('emp_type_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="PAY GRADE"
                                                    label-for="emp_grade_id">
                                                    <v-select v-model="payGrades" :options="payGradeList"
                                                              @input="payGradeChange(payGrades.emp_grade_id)"
                                                              name="emp_grade_id" id="emp_grade_id" label="text"
                                                              class="uppercase"
                                                              :disabled="true"
                                                              required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_grade_id')}">{{ errors.first('emp_grade_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="ACTUAL GRADE"
                                                    label-for="actual_grade_id">
                                                    <v-select
                                                        disabled
                                                        v-model="actualGrades"
                                                        :options="actualGradeList"
                                                        @input="actualGradeChange()"
                                                        name="actual_grade_id"
                                                        id="actual_grade_id"
                                                        label="text"
                                                        class="uppercase">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                </b-form-group>
                                            </b-col>
                                            <!--<b-col md="3">
                                                <b-form-group
                                                        label="JOINING GRADE" label-for="joiningGrade">
                                                    <b-form-input
                                                            disabled
                                                            v-model="joiningGrade"
                                                            id="joiningGrade"
                                                            name="joiningGrade"
                                                            >
                                                    </b-form-input>
                                                </b-form-group>
                                            </b-col>-->
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Joining GRADE"
                                                    label-for="joiningGrade">
                                                    <v-select
                                                        disabled
                                                        v-model="actualGrades"
                                                        :options="actualGradeList"
                                                        @input="actualGradeChange()"
                                                        name="joiningGrade"
                                                        id="joiningGrade"
                                                        label="text"
                                                        class="uppercase">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="ACTUAL CLASS"
                                                    label-for="emp_actual_class">
                                                    <b-form-input
                                                        v-model="emp_actual_class"
                                                        type="text"
                                                        placeholder="Actual Class"
                                                        readonly
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="CLASS"
                                                    label-for="emp_class">
                                                    <b-form-input
                                                        v-model="basicInfo.emp_class"
                                                        type="text"
                                                        placeholder="Class"
                                                        readonly
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="PAY GRADE Step"
                                                    label-for="grade_step_id">
                                                    <v-select v-model="gradeSteps" :options="gradeStepList"
                                                              name="grade_step_id" id="grade_step_id" label="text"
                                                              class="uppercase"
                                                              required v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('grade_step_id')}">{{ errors.first('grade_step_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Joining Date"
                                                    label-for="emp_join_date">
                                                    <date-picker v-model="basicInfo.emp_join_date"
                                                                 width="100%"
                                                                 input-class="form-control"
                                                                 type="date" lang="en"  required  v-validate="'required'"
                                                                 format="DD-MM-YYYY" :value-type="valueType" :editable="false"
                                                                 name="emp_join_date">
                                                    </date-picker>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_join_date')}">{{ errors.first('emp_join_date') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Office Order"
                                                    label-for="emp_go_number">
                                                    <b-form-input
                                                        id="emp_go_number"
                                                        v-model="basicInfo.emp_go_number"
                                                        type="text"
                                                        :maxlength="50"
                                                        placeholder="Office Order"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="3">
                                                <b-form-group
                                                    label="Order Date"
                                                    label-for="emp_go_date">
                                                    <date-picker v-model="basicInfo.emp_go_date"
                                                                 width="100%"
                                                                 input-class="form-control"
                                                                 name="emp_go_date"
                                                                 type="date" lang="en"
                                                                 :not-after="notAfterJoiningDate()"
                                                                 format="DD-MM-YYYY" :value-type="valueType" :editable="false">
                                                    </date-picker>

                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Quota"
                                                    label-for="emp_quota_id">
                                                    <v-select v-model="quota" :options="quotaList"
                                                              name="emp_quota_id" id="emp_quota_id" class="uppercase"
                                                              required v-validate="'required'"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_quota_id')}">{{ errors.first('emp_quota_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="PRL Date"
                                                    label-for="emp_lpr_date">
                                                    <b-form-input
                                                        id="emp_lpr_date"
                                                        v-model="basicInfo.emp_lpr_date"
                                                        type="text"
                                                        placeholder="PRL date"
                                                        name="emp_lpr_date"
                                                        :disabled="true"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Status"
                                                    label-for="emp_status_id">
                                                    <v-select v-model="status" :options="statusList"
                                                              name="emp_status_id" id="emp_status_id" class="uppercase"
                                                              required v-validate="'required'"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
<!--                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_status_id')}">{{ errors.first('emp_status_id') }}!</div>-->
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Post Type"
                                                    label-for="post_type_id">
                                                    <v-select v-model="postType" :options="postTypeList"
                                                              name="post_type_id" id="post_type_id" class="uppercase"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="3">
                                                <b-form-group
                                                    :class="otCategoryValidationRule ? 'requiredField' : ''"
                                                    label="OT Category"
                                                    label-for="ot_category_id">
                                                    <v-select v-model="otCategory" :options="otCategoryList"
                                                              name="ot_category_id" id="ot_category_id" class="uppercase"
                                                              v-validate="otCategoryValidationRule"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('ot_category_id')}">{{ errors.first('ot_category_id') }}!</div>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Controlling Officer"
                                                    label-for="reporting_officer_id">
                                                    <v-select
                                                        label="option_name"
                                                        v-model="selectedEmployee"
                                                        :options="basicInfo.emp_id ? allEmployeeList : employeeList"
                                                        @search="searchEmployeeById"
                                                        id="reporting_officer_id"
                                                        name="reporting_officer_id"
                                                        required  v-validate="'required'"
                                                        class="uppercase">
                                                        <template #search="{attributes, events}">
                                                            <input
                                                                class="vs__search"
                                                                v-bind="attributes"
                                                                v-on="events"
                                                            />
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('reporting_officer_id')}">{{ errors.first('reporting_officer_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Appointment Type"
                                                    label-for="appointment_type_id">
                                                    <v-select v-model="appointmentTypes" :options="appointmentTypeList"
                                                              name="appointment_type_id" id="appointment_type_id" class="uppercase"
                                                              required  v-validate="'required'"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('appointment_type_id')}">{{ errors.first('appointment_type_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Active date"
                                                    label-for="emp_join_date">
                                                    <date-picker v-model="basicInfo.emp_join_date"
                                                                 width="100%"
                                                                 input-class="form-control"
                                                                 type="date" lang="en"
                                                                 format="DD-MM-YYYY" :value-type="valueType" :editable="false"
                                                                 name="emp_join_date"
                                                    ></date-picker>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                  class=""
                                                  label="Merit Position"
                                                  label-for="merit_position">
                                                    <b-form-input id="merit_position"
                                                                  name="merit_position"
                                                                  v-model="basicInfo.merit_position"
                                                                  placeholder="Merit Position"
                                                                  type="number">
                                                    </b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Circular No"
                                                    label-for="circular_no">
                                                    <b-form-input id="circular_no"
                                                                  name="circular_no"
                                                                  :disabled="basicInfo.emp_id ? true : false"
                                                                  v-model="basicInfo.circular_no"
                                                                  placeholder="Circular No"
                                                                  type="number">
                                                    </b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Salary process"
                                                    label-for="salary_process">
                                                    <b-form-radio-group
                                                        v-model="basicInfo.salary_process_type"
                                                        :options="salary_process_options"
                                                        id="salary_process_type"
                                                        name="salary_process_type"
                                                    ></b-form-radio-group>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                  class="mt-2"
                                                  label=""
                                                  label-for="academic_yn">
                                                    <b-form-checkbox
                                                      id="academic_yn"
                                                      v-model="basicInfo.academic_yn"
                                                      name="academic_yn"
                                                      value="Y"
                                                      unchecked-value="N"
                                                    >
                                                        Academic
                                                    </b-form-checkbox>
                                                </b-form-group>
                                            </b-col>

                                        </b-row>
                                        <div v-if="basicInfo.emp_id && chargeItems.length > 0 ? true : false" >
                                            <h5>Additional/Current Charge</h5>
                                            <b-table
                                                :items="chargeItems"
                                                :fields="chargeFields"
                                                sort-icon-left
                                                responsive="md"
                                                :small="small"
                                                hover
                                                border
                                            >
                                                <template v-slot:cell(index)="data">
                                                    {{ data.index + 1 }}
                                                </template>
                                            </b-table>
                                            <!--<template>
                                                <div>
                                                    <b-table striped sort-icon-left
                                                             responsive="md"
                                                             :small="small"  hover :items="chargeItems" :fields="chargeFields" v-slot:cell(index)="data"></b-table>
                                                </div>
                                            </template>-->
                                        </div>
                                    </div>
                                </tab-content>
                                <!--<tab-content v-if="can_update"  title="Position Preview" icon="ti-eye" class="mb-1 mt-0">
                                    <b-card-text>
                                        <PositionPreview :employee="basicInfo" ></PositionPreview>
                                    </b-card-text>
                                </tab-content>-->
                                <tab-content v-if="can_update" title="Others" icon="ti-check" class="mb-1 mt-0" :before-change="validateOthers">
                                    <b-card-text>
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="gpf"
                                                    label-for="gpf_yn">
                                                    <b-form-input disabled v-model="modifiedGPF"></b-form-input>
                                                    <!--<b-form-radio-group
                                                        v-model="basicInfo.gpf_yn"
                                                        :options="gpf_yn_options"
                                                        name="gpf_yn"
                                                    ></b-form-radio-group>-->
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="GPF ID"
                                                    label-for="emp_pf_id">
                                                    <b-form-input
                                                        id="emp_pf_id"
                                                        :disabled="basicInfo.gpf_yn == 'N'"
                                                        v-model="basicInfo.emp_pf_id"
                                                        type="text" readonly
                                                        :maxlength="20"
                                                        placeholder="Provident Fund"
                                                        name="emp_pf_id"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Current Workplace"
                                                    label-for="location_id"
                                                    class="requiredField">
                                                    <v-select v-model="locations"
                                                              :options="locationList"
                                                              name="location_id"
                                                              label="text" required
                                                              class="uppercase"
                                                              v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"
                                                                   v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('location_id')}">{{ errors.first('location_id') }}!</div>
                                                </b-form-group>
                                            </b-col>

                                            <!--<b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Bank"
                                                    label-for="bank_name">
                                                    <v-select @input="bankChange"
                                                              v-model="banks"
                                                              :options="bankList"
                                                              name="bank_id"
                                                              :reduce="opt => opt.value"
                                                              id="bank_id"
                                                              label="text" required
                                                              class="uppercase"
                                                              v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"
                                                                   v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('bank_id')}">{{ errors.first('bank_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Branch"
                                                    label-for="branch_id">
                                                    <v-select v-model="branchs"
                                                              :options="branchList"
                                                              name="branch_id"
                                                              :reduce="opt => opt.value"
                                                              id="branch_id"
                                                              label="text" required
                                                              class="uppercase"
                                                              v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"
                                                                   v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('branch_id')}">{{ errors.first('branch_id') }}!</div>
                                                </b-form-group>
                                            </b-col>-->

                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Bank"
                                                    label-for="bank_id">
                                                    <v-select @input="bankChange"
                                                              v-model="banks"
                                                              :options="bankList"
                                                              name="bank_id"
                                                              id="bank_id"
                                                              label="text" required
                                                              class="uppercase"
                                                              v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"
                                                                   v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('bank_id')}">{{ errors.first('bank_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Branch"
                                                    label-for="branch_id">
                                                    <v-select v-model="branchs"
                                                              :options="branchList"
                                                              name="branch_id"
                                                              id="branch_id"
                                                              label="text" required
                                                              class="uppercase"
                                                              v-validate="'required'">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"
                                                                   v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('branch_id')}">{{ errors.first('branch_id') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Bank Account No"
                                                    label-for="emp_bank_acc_no">
                                                    <b-form-input
                                                        id="emp_bank_acc_no"
                                                        v-model="basicInfo.emp_bank_acc_no"
                                                        type="text" required  v-validate="'required'"
                                                        placeholder="Enter Bank Account No"
                                                        :max-length="15"
                                                        name="emp_bank_acc_no">
                                                    </b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_bank_acc_no')}">{{ errors.first('emp_bank_acc_no') }}!</div>
                                                    <div :class="{'invalid-feedback':true ,'d-block':basicInfo.emp_bank_acc_no.length < 13 || basicInfo.emp_bank_acc_no.length > 15}">Account number must be 13 to 15 characters!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Bcs batch No"
                                                    label-for="emp_bcs_batch_no"
                                                >
                                                    <b-form-input
                                                        id="emp_bcs_batch_no"
                                                        v-model="basicInfo.emp_bcs_batch_no"
                                                        :disabled="basicInfo.emp_grade_id>9"
                                                        type="text"
                                                        :maxlength="20"
                                                        placeholder="Enter BCS Batch No"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Tin Number"
                                                    label-for="tin_id"
                                                >
                                                    <b-form-input
                                                        id="tin_number"
                                                        v-model="basicInfo.emp_tin_no"
                                                        type="text"
                                                        :maxlength="15"
                                                        placeholder="Enter TIN Number"
                                                        name="emp_tin_no"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Pension"
                                                    label-for="on_pension_yn">
                                                    <b-form-radio-group
                                                        v-model="basicInfo.on_pension_yn"
                                                        :options="on_pension_yn_options"
                                                        name="on_pension_yn" required  v-validate="'required'"
                                                    ></b-form-radio-group>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('on_pension_yn')}">{{ errors.first('on_pension_yn') }}!</div>
                                                </b-form-group>
                                            </b-col>

<!--                                            <b-col md="3">-->
<!--                                                <b-form-group-->
<!--                                                    label="Deceased"-->
<!--                                                    label-for="deceased_yn">-->
<!--                                                    <b-form-radio-group-->
<!--                                                        v-model="basicInfo.deceased_yn"-->
<!--                                                        :options="deceased_yn_options"-->
<!--                                                        name="deceased_yn"-->
<!--                                                    ></b-form-radio-group>-->
<!--                                                </b-form-group>-->
<!--                                            </b-col>-->
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Bill Code"
                                                    label-for="bill_code">
                                                    <b-form-input
                                                        id="bill_code"
                                                        v-model="basicInfo.bill_code" required  v-validate="'required|numeric'"
                                                        type="text"
                                                        name="bill_code"
                                                        placeholder="Enter Bill Code"
                                                        :maxlength="10"
                                                    ></b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('bill_code')}">{{ errors.first('bill_code') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Emergency Contact Name"
                                                    :class="{'requiredField': !basicInfo.emp_id}"
                                                    label-for="emp_emergency_contact_name">
                                                    <b-form-input
                                                        id="emp_emergency_contact_name"
                                                        v-model="basicInfo.emp_emergency_contact_name"
                                                        :required="!basicInfo.emp_id"
                                                        v-validate="!basicInfo.emp_id ? 'required' : ''"
                                                        type="text"
                                                        :maxlength="200"
                                                        placeholder="Enter Emergency Contact Name"
                                                        onChange="this.value=this.value.toUpperCase();"
                                                    ></b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_emergency_contact_name')}">{{ errors.first('emp_emergency_contact_name') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Emergency Contact Mobile No"
                                                    :class="{'requiredField': !basicInfo.emp_id}"
                                                    label-for="emp_emergency_contact_mobile">
                                                    <b-form-input
                                                        id="emp_emergency_contact_mobile"
                                                        :required="!basicInfo.emp_id"
                                                        v-model="basicInfo.emp_emergency_contact_mobile"
                                                        v-validate="!basicInfo.emp_id ? 'required|numeric' : 'numeric'"
                                                        type="text"
                                                        name="emp_emergency_contact_mobile"
                                                        :maxlength="15"
                                                        placeholder="Enter Emergency Contact Mobile"
                                                    ></b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_emergency_contact_mobile')}">{{ errors.first('emp_emergency_contact_mobile') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
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
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Emergency Contact Address"
                                                    label-for="emp_emergency_contact_add056">
                                                    <b-form-input
                                                        id="emp_emergency_contact_address"
                                                        v-model="basicInfo.emp_emergency_contact_address"
                                                        type="text"
                                                        :maxlength="500"
                                                        placeholder="Enter Emergency Contact Address"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="3">
                                                <b-form-group
                                                    label="Confirmation B"
                                                    label-for="emp_confirmation_date">
                                                    <date-picker
                                                        v-model="basicInfo.emp_confirmation_date"
                                                        width="100%" input-class="form-control"
                                                        type="date" lang="en"
                                                        :not-before="notBeforeJoiningDate()"
                                                        format="DD-MM-YYYY" :value-type="valueType" :editable="false"></date-picker>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Medical Book ID"
                                                    label-for="emp_medical_book_id"
                                                >
                                                    <b-form-input
                                                        id="emp_medical_book_id"
                                                        v-model="basicInfo.emp_medical_book_id"
                                                        type="text"
                                                        :maxlength="50"
                                                        placeholder="Enter Medical Book ID"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="security ID"
                                                    label-for="emp_security_id"
                                                >
                                                    <b-form-input
                                                        id="emp_security_id"
                                                        v-model="basicInfo.emp_security_id"
                                                        placeholder="Security ID"
                                                        :maxlength="50"
                                                        type="text"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="3">
                                                <b-form-group
                                                    label="hbl"
                                                    label-for="hbl_yn"
                                                >
                                                    <b-form-input disabled v-model="modifiedHBL"></b-form-input>
                                                    <!--<b-form-radio-group
                                                        v-model="basicInfo.hbl_yn"
                                                        :options="hbl_yn_options"
                                                        name="hbl_yn"
                                                    ></b-form-radio-group>-->
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Allowance"
                                                    label-for="allowance_yn"
                                                >
                                                    <b-form-radio-group
                                                        disabled
                                                        v-model="basicInfo.allowance_yn"
                                                        :options="allowance_yn_options"
                                                        name="allowance_yn" required  v-validate="'required'"
                                                    ></b-form-radio-group>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('allowance_yn')}">{{ errors.first('allowance_yn') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Selection Grade"
                                                    label-for="selection_grade_yn"
                                                >
                                                    <b-form-input disabled v-model="modifiedSelectionGrade"></b-form-input>
                                                    <!--<b-form-radio-group
                                                        v-model="basicInfo.selection_grade_yn"
                                                        :options="selection_grade_yn_options"
                                                        name="selection_grade_yn" required  v-validate="'required'"
                                                    ></b-form-radio-group>-->
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('selection_grade_yn')}">{{ errors.first('selection_grade_yn') }}!</div>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Mobile Allowance"
                                                    label-for="mobile_allowance">
                                                    <v-select v-model="selectedMobileAllowance"
                                                              :options="mobileAllowances"
                                                              name="mobile_allowance"
                                                              :disabled="basicInfo.emp_id ? false : true"
                                                              id="mobile_allowance"
                                                              label="text"
                                                              class="uppercase">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"
                                                                   v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                </b-form-group>
                                            </b-col>


                                            <!--<b-col md="3">

                                                <b-form-group
                                                    id="empCode"
                                                    class="requiredField"
                                                    label="Employee Code"
                                                    label-for="empid">
                                                    <b-form-input id="empId"
                                                                  name="emp_code"
                                                                  v-model="basicInfo.emp_code"
                                                                  placeholder="Employee Code"
                                                                  required
                                                                  :maxlength="6"
                                                                  trim v-validate="'required|max:6'"
                                                                  @input="uniqueEmployeeCode"
                                                                  @change="uniqueEmployeeCode"></b-form-input>
                                                    <input v-model="generatedCode" type="hidden"></input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':unique_code_message}">{{ unique_code_message }}!</div>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_code')}">{{ errors.first('emp_code') }}!</div>
                                                </b-form-group>
                                            </b-col>-->

                                            <b-col md="3">

                                                <b-form-group
                                                    id="empCode"
                                                    class="requiredField"
                                                    label="Employee Code"
                                                    label-for="empid">
                                                    <b-form-input id="empId"
                                                                  name="emp_code"
                                                                  disabled
                                                                  v-model="basicInfo.emp_code"
                                                                  placeholder="Employee Code"
                                                                  required
                                                                  trim v-validate="'required|max:6'"></b-form-input>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('emp_code')}">{{ errors.first('emp_code') }}!</div>
                                                </b-form-group>
                                            </b-col>

                                            <!--<b-col md="3" v-if="hasPermission('CAN_APPROVE_EMPLOYEE')==true">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Approved"
                                                    label-for="approved_yn"
                                                >
                                                    <b-form-radio-group
                                                        v-model="basicInfo.approved_yn"
                                                        :options="approved_yn_options"
                                                        name="approved_yn" required  v-validate="'required'"
                                                    ></b-form-radio-group>
                                                    <div :class="{'invalid-feedback':true ,'d-block':errors.first('approved_yn')}">{{ errors.first('approved_yn') }}!</div>
                                                </b-form-group>
                                            </b-col>-->
                                        </b-row>
                                    </b-card-text>
                                </tab-content>
                                <tab-content :title="can_update? 'Final Preview':'Preview'" icon="ti-eye" class="mb-1 mt-0">
                                    <b-card-text>
                                        <EmployeePreview :employee="basicInfo" ></EmployeePreview>
                                    </b-card-text>
                                </tab-content>
                                <div slot="finish" scope="props" v-if="!can_update"></div>
                                <div slot="next" scope="props" v-if="!can_update"></div>
                                <div slot="prev" scope="props" v-if="!can_update"></div>
                            </form-wizard>
                            <b-row>
                                <input type="hidden" v-model="basicInfo.emp_gender_name">
                                <input type="hidden" v-model="basicInfo.salutation_bng">
                                <input type="hidden" v-model="basicInfo.emp_gender_name_bng">
                                <input type="hidden" v-model="basicInfo.emp_religion_name">
                                <input type="hidden" v-model="basicInfo.ot_category_name">
                                <input type="hidden" v-model="basicInfo.emp_religion_name_bng">
                            </b-row>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    import SideBar from "../partials/sidebar";
    import ApiRepository from "../../../Repository/ApiRepository";
    import { FormWizard, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    import EmployeePreview from "./EmployeePreview";
    import PositionPreview from "./PositionPreview";
    import GeneralPreview from "./GeneralPreview";
    const {required, maxLength, minLength, email} = require("vuelidate/lib/validators");
    //import employee from '../../../json/json'; //data edit
    export default {
        components: {DatePicker, SideBar, FormWizard, TabContent, vSelect, EmployeePreview, PositionPreview, GeneralPreview},
        props: ['id'],
        data() {
            return {
                hidenseek: true,
                generatedCode: '',
                renderEmployeePreview:false,
                hideWizard: false,
                authName: '',
                emp_actual_class: '',
                charge_division: '',
                charge_department: '',
                charge_designation: '',
                charge_type: '',
                unique_authentication_identity_message:'',
                otCategoryValidationRule: '',
                selectedEmployee: {'option_name':'','emp_id':'', 'emp_name':''},
                designations: {'grade':'','designation_id':'','designation':'','text':'','value':''},
                locations: {'text':'','value':''},
                payGrades: {'text':'','value':'', emp_grade_id: ''},
                actualGrades: {'text':'','value':'',actual_grade_id:''},
                joiningGrades: {'text':'','value':'',actual_grade_id:''},
                gradeSteps: {'text':'','value':''},
                salutations: {'text':'','value':''},
                bloodGroups: {'text':'','value':''},
                maritalStatus: {'text':'','value':''},
                religions: {'text':'','value':'','religion_bng':''},
                divisions: {'text':'','value':''},
                selectedMobileAllowance: {text:null,value:null},
                departments: {'text':'','value':''},
                current_departments: {'text':'','value':''},
                sections: {'text':'','value':''},
                quota: {'text':'Select Quota','value':''},
                status: {'text':'','value':''},
                nationality: {'text':'','value':''},
                otCategory: {'text':'','value':''},
                postType: {'text':'','value':''},
                billerCodes: {'text':'','value':''},
                employeeTypes: {'text':'','value':''},
                appointmentTypes: {'text':'','value':''},
                emergencyRelationTypes: {'text':'','value':''},
                authenticationTypes: {'text':'NATIONAL ID','value':1,'auth_doc_type_id':'1'},
                banks:{'text':'SONALI BANK LIMITED','value': 37},
                // banks:null,
                branchs:{'text':'PORT BRANCH','value': 21},
                employeeList: [],
                allEmployeeList: [],
                unique_code_message: '',
                req_deputation_yn:'',
                authIdValidationRule: '',
                errorMessage: {color: 'red'},
                valueType: this.dateFormatter(),
                can_update: true,
                basicInfo: {
                    mobile_allowance: '',
                    designation_name:'',
                    deputation_yn:'N',
                    emp_grade_id: null,
                    actual_grade_id: null,
                    dpt_division_id: {
                        text: '',
                        value: '',
                    },
                    emp_bank_acc_no: '',
                    dpt_department_id: null,
                    // current_department_id: null,
                    section_id: null,
                    designation_id: null,
                    emp_type_id: null,
                    post_type_id: null,
                    ot_category_id: null,
                    location_id: {
                        text: '',
                        value: ''
                    },
                    grade_step_id: null,
                    workplace_id: null,
                    bank_id: {
                        text: 'SONALI BANK LIMITED',
                        value: 37
                    },
                    branch_id: {
                        text: 'PORT BRANCH',
                        value: 21
                    },
                    emp_class: '',
                    emp_religion_id: '',
                    emp_quota_id: {
                        text: '',
                        value: ''
                    },
                    emp_status_id: null,
                    emp_blood_group_id: null,
                    emp_nationality_id: 1,
                    emp_maritial_status_id: null,
                    reporting_officer_id: null,
                    reporting_officer: null,
                    salutation_id: null,
                    appointment_type_id: null,
                    emp_emergency_relation_id: null,
                    salutation: null,
                    random_emp_code: null,
                    emp_gender_name: null,
                    salutation_bng: null,
                    emp_gender_name_bng: null,
                    emp_religion_name: null,
                    ot_category_name: null,
                    emp_religion_name_bng: null,
                    emp_photo: null,
                    emp_photo_name: null,
                    emp_photo_type: null,
                    tribal_yn: 'N',
                    gpf_yn: 'N',
                    // deceased_yn: 'N',
                    on_pension_yn: 'N',
                    hbl_yn: 'N',
                    allowance_yn: 'Y',
                    selection_grade_yn: 'N',
                    approved_yn: 'N',
                    nid_no: '',
                    auth_document: null,
                    auth_document_name: '',
                    auth_document_type: '',
                    emp_active_yn: 'Y',
                    emp_dob: null,
                    age: null,
                    biller_code: '',
                    emp_go_date: '',
                    old_dpt_division_id:'',
                    old_department_id:'',
                    old_section_id:'',
                    old_designation_id:'',
                    old_emp_type_id:'',
                    old_pay_grade_id:'',
                    old_bank_id:'',
                    merit_position: '',
                    academic_yn: '',
                    salary_process_type:'A',
                    emp_emergency_contact_name: null,
                    emp_emergency_contact_mobile:null,
                    circular_no: null
                },
                prevDepartmentId: null,
                billerCodeList: [],
                bankList: [],
                mobileAllowances: [],
                bloodGroupList: [],
                branchList: [],
                departmentList: [],
                currentDepartmentList: [],
                designationList: [],
                dptDivisionList: [],
                empTypeList: [],
                locationList: [],
                maritalStatusList: [],
                nationalityList: [],
                payGradeList: [],
                actualGradeList: [],
                joiningGradeList: [],
                postTypeList: [],
                quotaList: [],
                salutationList: [],
                statusList: [],
                sectionList: [],
                gradeStepList: [],
                religionList: [],
                otCategoryList: [],
                reportingOfficerList: [],
                genderList: [],
                appointmentTypeList: [],
                relationList: [],
                chargeItems: [],
                classList: [
                    {text: 'Select Class', value: 'null'},
                    {text: 'Class 1', value: 'Class 1'},
                    {text: 'Class 2', value: 'Class 2'},
                    {text: 'Class 3', value: 'Class 3'},
                    {text: 'Class 4', value: 'Class 4'}
                ],
                selected: 'first',
                gpf_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                deputation_yn_options:[
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                hbl_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                allowance_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                selection_grade_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'}
                ],
                approved_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                tax_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                on_pension_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                /*deceased_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],*/
                emp_active_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                salary_process_options: [
                    {text: 'Automatic', value: 'A'},
                    {text: 'Manual', value: 'M'},
                ],
                tribal_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                auth_type_ids: [{'value': '', 'text': 'Select Authentication type'}],
                show: true,
                selectedIndex: 0,
                chargeFields: [
                    {label: 'SL', key: 'index'},
                    {label: 'Charge Division', key: 'division' },
                    {label: 'Charge Department', key: 'department' },
                    {label: 'Charge Designation', key: 'designation' },
                    {label: 'Charge Type', key: 'charge_type_name' },

                ]
            }
        },
        validations: {
            basicInfo: {
                emp_bank_acc_no: {
                    required,
                    minLength: minLength(13),
                    maxLength: maxLength(15)
                }
            }
        },
        mounted() {
            this.allBasicInfo();
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Basic info"});
            this.formWidgetActiveAll();
            // this.allpreloadData();
            if (this.id > 0) {
                this.basicInfo.emp_id = this.id;
                this.fetchBasicInfo(this.id);
                this.chargeEntryInfo(this.id)
            }
            this.canUpdate()
        },
        computed: {
            modifiedHBL:function () {
                if(this.basicInfo.hbl_yn == 'Y'){
                    return 'Yes'
                } else {
                    return 'No'
                }
            },
            modifiedGPF:function () {
                if(this.basicInfo.gpf_yn == 'Y'){
                    return 'Yes'
                } else {
                    return 'No'
                }
            },
            modifiedSelectionGrade:function () {
                if(this.basicInfo.selection_grade_yn == 'Y'){
                    return 'Yes'
                } else {
                    return 'No'
                }
            },
        },
        watch: {
            generatedCode : function (val, oldVal) {
                if(val !== null){
                    this.basicInfo.emp_code = val
                }
            },
            '$route': function(value, oldvalue){
                this.$router.go(value.fullPath);
            },
            selectedEmployee:function(val,oldVal) {
                if(val !== null) {
                    this.basicInfo.reporting_officer_id = val.emp_id;
                    this.basicInfo.reporting_officer = val;
                } else {
                    this.basicInfo.reporting_officer_id = '';
                }
            },
            designations:function(val,oldVal) {
                if(val !== null) {
                    this.basicInfo.designation_id = val.designation_id;
                    this.basicInfo.designation_name = val;
                } else {
                    this.basicInfo.designation_id = '';
                }
            },

            locations:function(val,oldVal) {
                if(val !== null) {
                    this.basicInfo.location_id = val;
                } else {
                    this.basicInfo.location_id = '';
                }
            },
            payGrades: function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.emp_grade_id = val;
                } else {
                    this.basicInfo.emp_grade_id ='';
                }
            },
            actualGrades: function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.actual_grade_id = val.value;
                } else {
                    this.basicInfo.actual_grade_id ='';
                }
            },
            joiningGrades: function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.actual_grade_id = val.value;
                } else {
                    this.basicInfo.actual_grade_id ='';
                }
            },
            gradeSteps: function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.grade_step_id = val;
                } else {
                    this.basicInfo.grade_step_id ='';
                }
            },
            salutations: function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.salutation_id = val.value;
                } else {
                    this.basicInfo.salutation_id ='';
                }
            },
            bloodGroups:function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.emp_blood_group_id = val;
                } else {
                    this.basicInfo.emp_blood_group_id ='';
                }
            },
            maritalStatus:function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.emp_maritial_status_id = val;
                } else {
                    this.basicInfo.emp_maritial_status_id ='';
                }
            },
            religions: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.emp_religion_id = val.value;
                    this.basicInfo.emp_religion_name = val.text;
                    this.basicInfo.emp_religion_name_bng = val.religion_bng;
                } else {
                    this.basicInfo.emp_religion_id ='';
                    this.basicInfo.emp_religion_name = '';
                    this.basicInfo.emp_religion_name_bng = '';
                }
            },
            appointmentTypes: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.appointment_type_id = val;
                } else {
                    this.basicInfo.appointment_type_id ='';
                }
            },
            divisions: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.dpt_division_id = val;
                } else {
                    this.basicInfo.dpt_division_id ='';
                }
            },
            departments: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.dpt_department_id = val;
                    this.current_departments = val ;
                } else {
                    this.basicInfo.dpt_department_id ='';
                    this.current_departments = '' ;
                }
            },
            current_departments: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.current_department_id = val;
                } else {
                    this.basicInfo.current_department_id ='';
                }
            },
            sections: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.section_id = val;
                } else {
                    this.basicInfo.section_id ='';
                }
            },
            quota: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.emp_quota_id = val;
                } else {
                    this.basicInfo.emp_quota_id ='';
                }
            },
            status: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.emp_status_id = val;
                } else {
                    this.basicInfo.emp_status_id ='';
                }
            },
            authenticationTypes :function(val, oldVal){
                if (val.value !== '') {
                    this.basicInfo.auth_doc_type_id = val;
                } else {
                    this.basicInfo.auth_doc_type_id ='';
                }
            },
            employeeTypes: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.emp_type_id = val;
                } else {
                    this.basicInfo.emp_type_id ='';
                }
            },
            nationality: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.emp_nationality_id = val;
                } else {
                    this.basicInfo.emp_nationality_id ='';
                }
            },
            otCategory: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.ot_category_id = val;
                } else {
                    this.basicInfo.ot_category_id ='';
                }
            },
            postType: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.post_type_id = val;
                } else {
                    this.basicInfo.post_type_id ='';
                }
            },
            billerCodes: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.biller_code = val;
                } else {
                    this.basicInfo.biller_code ='';
                }
            },
            emergencyRelationTypes: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.emp_emergency_relation_id = val;
                } else {
                    this.basicInfo.emp_emergency_relation_id ='';
                }
            },
            selectedMobileAllowance: function(val, oldVal){
                if (val !== null) {
                    this.basicInfo.mobile_allowance = val.text
                } else {
                    this.basicInfo.mobile_allowance = null
                }
            },
            banks:function (val, oldVal) {
                console.log(val, oldVal)
                if (val !== null) {
                    this.basicInfo.bank_id = val;
                    this.bankChange(val);
                } else {
                    this.basicInfo.bank_id ='';
                }
            },
            branchs:function (val, oldVal) {
                console.log(val, oldVal)
                if (val !== null) {
                    this.basicInfo.branch_id = val;
                } else {
                    this.basicInfo.branch_id ='';
                }
            },
            "basicInfo.emp_type_id": function() {
                if(this.basicInfo.emp_type_id) {
                    let selectedEmployeeType = this.empTypeList.find(row => {
                        return row.value == this.basicInfo.emp_type_id;
                    });
                    /*this.fetchPayGradeList();*/
                    if(selectedEmployeeType) {
                        let employeeTypeName = selectedEmployeeType.text;

                        if(employeeTypeName) {
                            employeeTypeName = employeeTypeName.toLowerCase();

                            if(employeeTypeName == 'staff') {
                                this.otCategoryValidationRule = ""; // Its not required at this moment.
                                //this.otCategoryValidationRule = "required";
                            } else {
                                this.otCategoryValidationRule = "";
                            }
                        } else {
                            this.otCategoryValidationRule = "";
                        }
                    } else {
                        this.otCategoryValidationRule = "";
                    }
                }
            },
            "basicInfo.emp_dob": function() {
                if(this.basicInfo.emp_dob) {
                    this.basicInfo.age = this.getAge(this.basicInfo.emp_dob);
                } else {
                    this.basicInfo.age = '';
                }

                this.calculateLprDate();
            },
            "basicInfo.emp_quota_id": function() {
                this.calculateLprDate();
            },
           "basicInfo.auth_doc_type_id": function() {
                let auth_type = this.auth_type_ids.filter(row => {
                    // return this.basicInfo.auth_doc_type_id.auth_doc_type_id.value === 1 && row.auth_doc_type_id.value === 1;
                    return this.basicInfo.auth_doc_type_id.auth_doc_type_id == row.auth_doc_type_id
                });
                if(!auth_type) {
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
                        }
                    } else {
                        this.authIdValidationRule = "";
                    }
                } else {
                    this.authIdValidationRule = "";
                }

            },
        },
        methods: {
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            onChangeAuthType(){
                this.unique_authentication_identity_message = ''
                this.basicInfo.nid_no = "";
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            // allpreloadData(){
            //     ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/charge-entry').then(result => {
            //         this.chargeTypeList = result.data.charge.filter(a=> a.charge_type_id != 3)
            //         this.departmentList = result.data.department;
            //         this.sectionList = result.data.section;
            //         this.designationList = result.data.designation;
            //         this.divisionList = result.data.division;
            //         this.gradeList = result.data.grade;
            //     });
            // },
            uniqueAuthenticationIdentity(){
                let params = {
                    'auth_id': this.basicInfo.nid_no,
                    'auth_type': this.basicInfo.auth_doc_type_id.value
                };
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/check-valid-nid/`, {params}).then(result => {
                    if(result.data.unique_message!=null){
                        this.unique_authentication_identity_message = result.data.unique_message;
                    }
                });
            },
            notAfterJoiningDate() {
                if(this.basicInfo.emp_join_date) {
                    return moment(this.basicInfo.emp_join_date, 'YYYY-MM-DD').subtract('1', 'days');
                }
            },
            notBeforeJoiningDate() {
                if(this.basicInfo.emp_join_date) {
                    return moment(this.basicInfo.emp_join_date, 'YYYY-MM-DD').add('180', 'days');
                }
            },
            fetchPayGradeList() {
                let emp_type_id=(typeof(this.basicInfo.emp_type_id))=='object'?this.basicInfo.emp_type_id['value']:this.basicInfo.emp_type_id;
                if(this.basicInfo.old_emp_type_id){
                    if(emp_type_id!=this.basicInfo.old_emp_type_id){
                        this.payGrades='';
                        this.gradeSteps='';
                        this.basicInfo.emp_class='';
                    }
                }
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/pay-grades/${emp_type_id}`).then(res => {
                    this.payGradeList = res.data;

                });
            },
            searchEmployeeById(id){
                if(!id) return;
                else if(this.id) {

                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/all-controlling-officer/${id}`).then(res => {
                        this.allEmployeeList = res.data;
                    });
                }
                else {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/controlling-officer/${id}?department=${this.basicInfo.dpt_department_id.value}`).then(res => {
                        this.employeeList = res.data;
                    });
                }

            },
            checkDeputation(){
                if(this.basicInfo.deputation_yn == 'Y'){
                    this.req_deputation_yn = '';
                    this.basicInfo.previous_workplace = '';
                    this.basicInfo.previous_designation = '';
                    this.basicInfo.previous_office_address = '';
                }else{
                    this.req_deputation_yn = 'requiredField';
                }
            },
            calculateLprDate() {
                this.basicInfo.emp_lpr_date = this.basicInfo.emp_dob && this.basicInfo.emp_quota_id.value ?
                    this.basicInfo.emp_quota_id.value == 2 ?
                    moment(this.basicInfo.emp_dob).add(61, 'year').format("DD-MM-YYYY"):
                    moment(this.basicInfo.emp_dob).add(59, 'year').format("DD-MM-YYYY"):
                    this.basicInfo.emp_lpr_date = ''
            },
            hasAuthenticationDocument()
            {
                return (this.basicInfo.emp_id && this.basicInfo.auth_document);
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
                    this.$validator.validate('auth_document', currObj.basicInfo.auth_document).then(function() {
                        reader.onload = (e) => {
                            if(!currObj.errors.has('auth_document')) {
                                currObj.basicInfo.auth_document = e.target.result;
                            }
                        }
                    }).catch(err => {
                        console.log('file error');
                    });
                    reader.readAsDataURL(input.files[0]);
                    this.basicInfo.auth_document_name = input.files[0].name;
                    this.basicInfo.auth_document_type = input.files[0].name.split('.').pop();
                }
            },
            getAge(dateOfBirth) {
                let duration = moment.duration(moment().diff(dateOfBirth));
                let years = duration.years();
                let months = duration.months();
                let days = duration.days();

                let textDuration = '';
                if(years > 0) {
                    textDuration = `${years} years `;
                }

                if(months > 0) {
                    textDuration += `${months} months `;
                }

                if(days > 0) {
                    textDuration += `${days} days`;
                }

                return textDuration;
            },
            uniqueEmployeeCode() {
                if(this.basicInfo.emp_code.trim()) {
                    let params = {
                        'emp_code': this.basicInfo.emp_code,
                        'emp_id': this.basicInfo.emp_id,
                    };
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos/unique-employee-code', {params}).then(result => {
                            this.unique_code_message = result.data.unique_message;
                    });
                }
            },

            divisionChange(id){
                    if(this.basicInfo.old_dpt_division_id){
                        if(id!=this.basicInfo.old_dpt_division_id){
                            this.departments = {
                                text:'',
                                value: ''
                            }
                            this.departmentList = []
                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/departments/${id}`).then(result => {
                        this.departmentList = result.data;
                    });
            },
            departmentChange(id, current = false){
                if(id) {
                    if(this.basicInfo.old_department_id){
                        if(id!=this.basicInfo.old_department_id){
                            this.sections= {
                                text: '',
                                value : ''
                            }
                            this.designations={
                                text: '',
                                value : ''
                            }
                        }
                        //add new
                        this.sectionList = [],
                            this.designationList = []

                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/sections/${id}`).then(result => {
                        this.sectionList = result.data;
                    });
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-department/${id}`).then(res => {
                        this.designationList = res.data.designations;
                    });
                   if(!current) this.departmentChange(id, true);

                }
            },
            payGradeChange(id){
                if(id) {
                    var grade_id=(typeof(id))=='string'?id:id['value'];
                    if(this.basicInfo.old_pay_grade_id){
                        if(grade_id!=this.basicInfo.old_pay_grade_id){
                            this.gradeSteps='';
                            this.basicInfo.emp_class='';
                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/pay-grades/${grade_id}`).then(result => {
                        this.basicInfo.emp_class = result.data.paygrade.emp_class;
                        this.gradeStepList = result.data.gradesteps
                        if(!this.id){
                            this.gradeSteps = result.data.gradesteps[1]
                        }
                    });
                }
            },

            bankChange(id){
                if(id){
                    var bank_id=(typeof(id))=='object'?id['value']:id;
                    if(this.basicInfo.old_bank_id){
                        if(bank_id!=this.basicInfo.old_bank_id){
                            this.branchs='';

                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/branches/${bank_id}`).then(result => {
                        this.branchList = result.data;
                        let that = this;
                        this.branchList.forEach(function(item) {

                        });

                    });

                }
            },


            validateGeneral: async function() {
                const general = Promise.all([
                    this.$validator.validate('emp_name', this.basicInfo.emp_name),
                    // this.$validator.validate('emp_photo', this.basicInfo.emp_photo),
                    this.$validator.validate('emp_father_name', this.basicInfo.emp_father_name),
                    this.$validator.validate('emp_mother_name', this.basicInfo.emp_mother_name),
                    this.$validator.validate('emp_dob', this.basicInfo.emp_dob),
                    this.$validator.validate('emp_gender_id', this.basicInfo.emp_gender_id),
                    this.$validator.validate('emp_maritial_status_id', this.basicInfo.emp_maritial_status_id.value),
                    this.$validator.validate('emp_nationality_id', this.basicInfo.emp_nationality_id.value),
                    this.$validator.validate('emp_religion_id', this.basicInfo.emp_religion_id),
                    this.$validator.validate('emp_tribal_yn', this.basicInfo.emp_tribal_yn),
                    this.$validator.validate('previous_workplace', this.basicInfo.previous_workplace),
                    this.$validator.validate('previous_designation', this.basicInfo.previous_designation),
                    this.$validator.validate('previous_office_address', this.basicInfo.previous_office_address),
                    this.$validator.validate('deputation_yn', this.basicInfo.deputation_yn),
                    this.$validator.validate('nid_no', this.basicInfo.nid_no),
                    this.$validator.validate('emp_blood_group_id', this.basicInfo.emp_blood_group_id),
                    this.$validator.validate('auth_doc_type_id', this.basicInfo.auth_doc_type_id),
                ]);

                const areValid = (await general).every(isValid => isValid);
                const uniqueCode = (this.unique_code_message=='');
                const clear = (this.unique_authentication_identity_message == '')
                return areValid && uniqueCode && clear;
            },
            permit: async function(){
                if (this.unique_authentication_identity_message == null){
                    return  true
                }
            },
            validatePosition: async function() {
                const position = Promise.all([
                    this.$validator.validate('dpt_division_id', this.basicInfo.dpt_division_id.value),
                    this.$validator.validate('dpt_department_id', this.basicInfo.dpt_department_id),
                    this.$validator.validate('current_department_id', this.basicInfo.current_department_id),
                    this.$validator.validate('designation_id', this.basicInfo.designation_id),
                    this.$validator.validate('emp_grade_id', this.basicInfo.emp_grade_id),
                    this.$validator.validate('grade_step_id', this.basicInfo.grade_step_id),
                    this.$validator.validate('emp_join_date', this.basicInfo.emp_join_date),
                    this.$validator.validate('reporting_officer_id', this.basicInfo.reporting_officer_id),
                    this.$validator.validate('emp_type_id', this.basicInfo.emp_type_id),
                    //this.$validator.validate('emp_status_id', this.basicInfo.emp_status_id),
                    this.$validator.validate('ot_category_id', this.basicInfo.ot_category_id),
                    this.$validator.validate('appointment_type_id', this.basicInfo.appointment_type_id),
                    this.$validator.validate('emp_quota_id', this.basicInfo.emp_quota_id.value),
                ]);
                const areValid = (await position).every(isValid => isValid);
                return areValid;

            },
            validateOthers: async function() {
                const others = Promise.all([
                    this.$validator.validate('emp_code', this.basicInfo.emp_code),
                    this.$validator.validate('bank_id', this.basicInfo.bank_id),
                    this.$validator.validate('branch_id', this.basicInfo.branch_id.value),
                    this.$validator.validate('emp_bank_acc_no', this.basicInfo.emp_bank_acc_no),
                    this.$validator.validate('on_pension_yn', this.basicInfo.on_pension_yn),
                    /*this.$validator.validate('biller_code', this.basicInfo.biller_code),*/
                    this.$validator.validate('bill_code', this.basicInfo.bill_code),
                    this.$validator.validate('allowance_yn', this.basicInfo.allowance_yn),
                   /* this.$validator.validate('approved_yn', this.basicInfo.approved_yn),*/
                    this.$validator.validate('emp_emergency_contact_mobile', this.basicInfo.emp_emergency_contact_mobile),
                    this.$validator.validate('location_id', this.basicInfo.location_id.value)
                ]);

                const areValid = (await others).every(isValid => isValid);
                const validLength = (this.basicInfo.emp_bank_acc_no.length  > 13 || this.basicInfo.emp_bank_acc_no.length < 15)
                // this.basicInfo.emp_bank_acc_no.length==15
                return areValid && validLength;
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
                return moment();
            },
            birthDateNotAfterYears() {
                return moment().subtract(18, 'year');
            },
            defaultBirthDate() {
                return moment().subtract(18, 'year');
            },

            notAfterYears() {
                if(this.basicInfo.emp_dob) {
                    return moment(this.basicInfo.emp_dob).add(67, 'year');
                } else {
                    return moment().add(67, 'year');
                }
            },
            formWidgetActiveAll(){
                let wizard = this.$refs.basicinfo;
                wizard.activateAll();
            },

            getPhoto(event) {
                let currObj = this;
                let input = event.target;
                let reader = new FileReader();
                if (input.files && input.files.length > 0) {
                    reader.onload = (e) => {
                        if(!currObj.errors.has('emp_photo')) {
                            currObj.basicInfo.emp_photo = e.target.result;
                        }
                    }
                };
                reader.readAsDataURL(input.files[0]);
                this.basicInfo.emp_photo_name = input.files[0].name;
                this.basicInfo.emp_photo_type = input.files[0].name.split('.').pop();
            },


            /*getPhoto(event) {
                let currObj = this;
                let input = event.target;
                let reader = new FileReader();
                if (input.files && input.files.length > 0) {
                    reader.onload = (e) => {
                        currObj.basicInfo.emp_photo = e.target.result;
                    }
                }
                reader.readAsDataURL(input.files[0]);
                this.basicInfo.emp_photo_name = input.files[0].name;
                this.basicInfo.emp_photo_type = input.files[0].name.split('.').pop();
            },*/
            fetchBasicInfo(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/${id}`).then(result => {
                    this.basicInfo = result.data;
                    this.basicInfo.approved_yn = result.data.approved_yn
                    this.academic_yn = result.data.academic_yn;
                    this.locations = this.basicInfo.location;
                    this.designations = result.data.designation;
                    this.payGrades = result.data.grade?result.data.grade: {text: '', value: ''}
                    this.joiningGrade = result.data.joining_grade ? result.data.joining_grade.text: ''
                    this.actualGrades = result.data.actual_grade ? result.data.actual_grade : {text: '', value: ''}
                    this.actualGrades.text = result.data.actual_grade != null ? 'Grade '+ result.data.actual_grade.emp_grade_id + ' ('+result.data.actual_grade.grade_range+')':''
                    this.payGrades.text = result.data.grade?'Grade '+result.data.grade.emp_grade_id+' ('+result.data.grade.grade_range+')':''
                    this.payGradeChange(result.data.emp_grade_id);
                    this.gradeSteps =result.data.employeeSelectedGradeStep.length >0 ? result.data.employeeSelectedGradeStep[0]:{text: '', value: ''};
                    this.gradeSteps.text =result.data.employeeSelectedGradeStep.length >0? 'Grade Step '+result.data.employeeSelectedGradeStep[0].grade_steps_id+' ('+result.data.employeeSelectedGradeStep[0].basic_amt+')':''
                    this.salutations.text=(!result.data.salutation_id)?'':result.data.salutation_id.salutation;
                    this.salutations.value=(!result.data.salutation_id)?'':result.data.salutation_id.salutation_id;
                    this.actualGrades.value=result.data.actual_grade.value; // new actualGrades
                    this.joiningGrades.value = result.data.joining_grade.value;
                    this.banks=result.data.employeeSelectedBank;
                    this.bankChange(result.data.bank_id);
                    this.branchs=result.data.employeeSelectedBankBranch;
                    this.bloodGroups=result.data.employeeSelectedBloodGroup;
                    this.maritalStatus=result.data.employeeSelectedMaritialStatus;
                    this.religions = result.data.emp_religion_id;
                    this.divisions = result.data.dpt_division;
                    this.basicInfo.old_dpt_division_id=result.data.dpt_division.dpt_division_id;
                    this.basicInfo.old_department_id=result.data.employeeSelectedDepartment.department_id;
                    this.basicInfo.old_emp_type_id=result.data.employeeSelectedType.emp_type_id;
                    this.basicInfo.old_pay_grade_id= result.data.grade ? result.data.grade.emp_grade_id: '';
                    this.basicInfo.old_bank_id=result.data.employeeSelectedBank.bank_id;
                    this.divisionChange(result.data.dpt_division_id);
                    this.departments = result.data.employeeSelectedDepartment;
                    this.current_departments = result.data.employeeSelectedCurrentDepartment;
                    this.departmentChange(result.data.dpt_department_id);
                    this.sections = result.data.section;
                    this.quota = result.data.employeeSelectedQuota;
                   // this.status.text = result.data.employeeSelectedJobStatus.text;
                    // this.status.value = result.data.employeeSelectedJobStatus.value;
                    this.status = {
                        text: result.data.employeeSelectedJobStatus ? result.data.employeeSelectedJobStatus.text: '',
                        value: result.data.employeeSelectedJobStatus ? result.data.employeeSelectedJobStatus.value: ''
                    }
                    this.nationality = result.data.employeeSelectedNationality;
                    this.otCategory = result.data.ot_category_id;
                    this.postType = {
                        text: result.data.employeeSelectedPostType ? result.data.employeeSelectedPostType.text: '',
                        value: result.data.employeeSelectedPostType ? result.data.employeeSelectedPostType.value: ''
                    }
                    this.billerCodes = result.data.employeeSelectedBillerCode[0];
                    this.emergencyRelationTypes = {
                        text:  result.data.employeeSelectedEmergencyRelationType? result.data.employeeSelectedEmergencyRelationType.text: '',
                        value:  result.data.employeeSelectedEmergencyRelationType? result.data.employeeSelectedEmergencyRelationType.value: ''
                    }
                    this.selectedMobileAllowance.text = result.data.selectedMobileAllowance?result.data.selectedMobileAllowance.text:null;
                    this.selectedMobileAllowance.value = result.data.selectedMobileAllowance?result.data.selectedMobileAllowance.value: null;
                    this.employeeTypes = result.data.employeeSelectedType;
                    this.appointmentTypes = result.data.employeeSelectedAppointmentType;
                    this.authenticationTypes = {
                        text: result.data.employeeSelectedAuthDocType ? result.data.employeeSelectedAuthDocType.text:'NATIONAL ID',
                        value: result.data.employeeSelectedAuthDocType ? result.data.employeeSelectedAuthDocType.value: 1,
                        auth_doc_type_id: result.data.employeeSelectedAuthDocType ? result.data.employeeSelectedAuthDocType.value: 1
                    };
                    this.basicInfo.nid_no = result.data.nid_no;
                    this.selectedEmployee = this.basicInfo.selectedEmployee;
                    this.basicInfo.emp_gender_id = (this.basicInfo.emp_gender_id == 0) ? '' : this.basicInfo.emp_gender_id;
                    this.basicInfo.emp_nationality_id = (this.basicInfo.emp_nationality_id == 0) ? '' : this.basicInfo.emp_nationality_id;
                    this.basicInfo.emp_grade_id = (this.basicInfo.emp_grade_id == 0) ? '' : this.basicInfo.emp_grade_id;
                    this.basicInfo.actual_grade_id = (this.basicInfo.actual_grade_id == 0) ? '' : this.basicInfo.actual_grade_id;
                    this.basicInfo.emp_type_id = (this.basicInfo.emp_type_id == 0) ? '' : this.basicInfo.emp_type_id;
                    this.basicInfo.grade_step_id = (this.basicInfo.grade_step_id == 0) ? '' : this.basicInfo.grade_step_id;
                    this.basicInfo.bank_id = (this.basicInfo.bank_id == 0) ? '' : this.basicInfo.bank_id;
                    this.basicInfo.branch_id = (this.basicInfo.branch_id == 0) ? '' : this.basicInfo.branch_id;
                    this.basicInfo.emp_bank_acc_no = (this.basicInfo.emp_bank_acc_no == 0) ? '' : this.basicInfo.emp_bank_acc_no;
                    this.actualGradeChange();

                });
            },


            //Charge Entry
            chargeEntryInfo(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/charge-entry/${id}`).then(result => {
                    this.chargeItems= (result.data.chargeEntry)?[result.data.chargeEntry]:[];
                })
            },

            allBasicInfo() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos').then(result => {
                    this.bankList = result.data.banks;

                    this.mobileAllowances = result.data.mobileAllowances;
                    this.billerCodeList = result.data.billerCodes;
                    this.actualGradeList = result.data.actualGrads;
                    this.joiningGradeList = result.data.joiningGrades;
                    this.bloodGroupList = result.data.bloodGroup;
                    this.dptDivisionList = result.data.dptDivision;
                    this.currentDepartmentList = result.data.department
                    this.empTypeList = result.data.empType;
                    this.locationList = result.data.location;
                    this.maritalStatusList = result.data.maritalStatus;
                    this.nationalityList = result.data.nationality;
                    this.postTypeList = result.data.postType;
                    this.quotaList = result.data.quota;
                    this.salutationList = result.data.salutation;
                    this.statusList = result.data.status;
                    this.religionList = result.data.religions;
                    this.otCategoryList = result.data.otCategories;
                    this.reportingOfficerList = result.data.employees;
                    this.genderList = result.data.genders;
                    this.appointmentTypeList = result.data.appointmentType;
                    this.relationList = result.data.relations;
                    this.auth_type_ids=result.data.auth_type_ids;
                    if(!this.id){
                        this.religions =result.data.religions[4];
                        this.nationality=result.data.nationality[1];
                        this.authenticationTypes=result.data.auth_type_ids[1];
                        this.status =result.data.status[6];
                        this.salutations= result.data.salutation[4];
                        this.bloodGroups=result.data.bloodGroup[5];
                        this.basicInfo.emp_gender_id=result.data.genders[1].value;
                        this.maritalStatus=result.data.maritalStatus[1];
                        this.basicInfo.post_type_id=result.data.postType[2];
                        this.otCategory=result.data.otCategories[1];
                        this.quota = result.data.quota[0];
                        this.status = result.data.status[8];
                        this.appointmentTypes=result.data.appointmentType[3];
                    }
                })

            },



            onSubmit(){
                let currObj = this;
                this.$v.$touch();
                this.$v.basicInfo.$touch();
                if(!this.$v.basicInfo.$invalid){
                    this.$validator.validateAll().then(() => {
                        if (!this.errors.any()) {
                                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/basic-infos", this.basicInfo).then(resp => {
                                    if (resp.data.o_status_code == 1) {
                                        currObj.basicInfo.emp_id = resp.data.id;
                                        this.fetchBasicInfo(resp.data.id);
                                        currObj.$notify({ group: 'pmis', text: resp.data.o_status_message, type:'success' });
                                        if(resp.data.url) {
                                            this.$router.push(resp.data.url);
                                            this.$router.go();
                                        }
                                    }else {
                                        currObj.$notify({ group: 'pmis', text: resp.data.o_status_message, type:'error' });
                                    }
                                }).catch(err => {
                                    console.log(err);
                                });


                        } else {
                            console.log('here', currObj.errors);
                        }
                    });
                }
            },
            onReset() {
                this.show = false;
                this.$nextTick(() => {
                    this.basicInfo.emp_grade_id = null;
                    this.basicInfo.actual_grade_id = null;
                    this.basicInfo.dpt_division_id = null;
                    this.basicInfo.dpt_department_id = null;
                    this.basicInfo.current_department_id = null;
                    this.basicInfo.section_id = null;
                    this.basicInfo.designation_id = null;
                    this.basicInfo.emp_type_id = null;
                    this.basicInfo.post_type_id = null;
                    this.basicInfo.ot_category_id = null;
                    this.basicInfo.location_id = null;
                    this.basicInfo.grade_step_id = null;
                    this.basicInfo.workplace_id = null;
                    this.basicInfo.bank_id = null;
                    this.basicInfo.branch_id = null;
                    this.basicInfo.emp_class = '';
                    this.basicInfo.emp_religion_id = null;
                    this.basicInfo.emp_quota_id = null;
                    this.basicInfo.emp_status_id = null;
                    this.basicInfo.emp_blood_group_id = null;
                    this.basicInfo.emp_nationality_id = null;
                    this.basicInfo.emp_maritial_status_id = null;
                    this.basicInfo.reporting_officer_id = null;
                    this.basicInfo.salutation_id = null;
                    this.basicInfo.appointment_type_id = null;
                    this.basicInfo.emp_emergency_relation_id = null;
                    this.basicInfo.salutation = null;
                    this.basicInfo.emp_gender_name = null;
                    this.basicInfo.salutation_bng = null;
                    this.basicInfo.emp_gender_name_bng = null;
                    this.basicInfo.emp_religion_name = null;
                    this.basicInfo.ot_category_name = null;
                    this.basicInfo.emp_religion_name_bng = null;
                    this.basicInfo.emp_photo = null;
                    this.basicInfo.emp_photo_name = '';
                    this.basicInfo.emp_photo_type = '';
                    this.basicInfo.tribal_yn = 'N';
                    this.basicInfo.emp_active_yn = 'Y';
                    this.basicInfo.emp_dob = null;
                    this.basicInfo.age = null;
                    this.basicInfo.nid_no = null;
                    this.basicInfo.auth_document = null;
                    this.basicInfo.auth_document_name = '';
                    this.basicInfo.auth_document_type = '';
                    this.basicInfo.gpf_yn = 'N';
                    // this.basicInfo.deceased_yn = 'N';
                    this.basicInfo.on_pension_yn = 'N';
                    this.basicInfo.hbl_yn = 'N';
                    this.basicInfo.allowance_yn = 'N';
                    this.basicInfo.approved_yn = 'N';
                    this.basicInfo.deputation_yn = 'N';
                    this.basicInfo.salary_process_type = 'A';
                    this.basicInfo.merit_position = null;
                    this.basicInfo.circular_no = null;
                    this.basicInfo.academic_yn = null;
                    this.basicInfo.emp_emergency_contact_name= null;
                    this.show = true
                })
            },
            ageCount(event) {
                const birthday = new Date(event);
                const today = new Date();
                var differenceInMilisecond = today.valueOf() - birthday.valueOf();
                var year_age = Math.floor(differenceInMilisecond / 31536000000);
                var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);
                var month_age = Math.floor(day_age / 30);
                day_age = day_age % 30;
                if (isNaN(year_age) || isNaN(month_age) || isNaN(day_age)) {
                    this.basicInfo.age = 0;
                } else {
                    this.basicInfo.age = year_age + " years " + month_age + " months " + day_age + " days ";
                }
            },


            designationChange(id){
                if (id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/by-designation/${id}`).then(resp => {
                        this.basicInfo.emp_class = resp.data.class
                        this.employeeTypes = resp.data.emp_type
                        this.payGrades = resp.data.grade
                        this.actualGrades = resp.data.grade
                        this.joiningGrades = resp.data.grade
                        // this.basicInfo.emp_code= resp.data.random_emp_code
                        this.payGradeChange(this.payGrades.value)
                        this.actualGradeChange(this.payGrades.value);
                        this.joiningGradeChange(this.payGrades.value);
                        this.getRandomEmpCode();

                    })
                }

            },

            getRandomEmpCode() {
               window.setTimeout(()=>{
                   if (!this.id) {
                       ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/by-designation/${this.basicInfo.dpt_department_id.value}/${this.basicInfo.designation_id}/${this.basicInfo.emp_type_id.value}/${this.basicInfo.deputation_yn}`).then(resp => {
                           if (resp.data.result)
                               this.basicInfo.emp_code = resp.data.result;
                       });
                   }
               }, 500);
            },

            actualGradeChange(){
                if(this.actualGrades.value) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/pay-grades/${this.actualGrades.value}`).then(response => {
                        this.emp_actual_class = response.data.paygrade.emp_class;
                    });
                }
            },
            joiningGradeChange(){
                if(this.joiningGrades.value) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/pay-grades/${this.actualGrades.value}`).then(response => {
                        this.emp_actual_class = response.data.paygrade.emp_class;
                    });
                }
            },
            onChangeBankAccount(){
                this.$v.$touch();
                this.$v.basicInfo.$touch();
                alert(this.$v.basicInfo.$invalid)
                return  this.$v.basicInfo.$invalid == false
            }

        }
    }
</script>
<style>
    .basicinfo .tabs .card-header {
        padding: 0px 35px;
    }
    .lowercase {text-transform: lowercase; }
    .uppercase { text-transform: uppercase; }
    .basicinfo .nav.nav-pills ~ .tab-content, .pills-stacked .tab-content {
        background-color: #FFF;
        box-shadow: 0px 0px 0px 0 rgba(0, 0, 0, 0);
        border-radius: .267rem;
    }

    .basicinfo .pills-stacked .tab-content {
        padding: 0;
        color: #475F7B;
        margin-top: -12px;
    }
    .basicinfo .profileImage{
        position: absolute;
        right: 30px;
        top: 147px;
        margin-top:10px;
    }
    .profileImage .card-body {
        padding:0px;
    }
    .basicinfo #profilepic{
        height: 180px !important;
        width: 100%;
    }
    .vue-form-wizard .wizard-tab-content {
        min-height: 100px;
        padding: 55px 20px 10px;
    }
    .uploadImage {
        display: none;
    }
    div.requiredField  label.d-block:after{
        content: '*';
        color: red;
    }
    @media (max-width: 576px) {
        .profileImage{
            position: inherit;
            right: 0;
            top: 0;
        }
    }

    .vue-form-wizard.md .wizard-icon-circle {
        width: 50px;
        height: 50px;
    }
    .vue-form-wizard.md .wizard-navigation .wizard-progress-with-circle {
        top: 31px;
    }
    .vue-form-wizard .wizard-header {
        padding: 0px;
    }
    .vue-form-wizard .wizard-tab-content {
        padding: 30px 20px 10px;
    }
    .basicinfo .profileImage {
        top: 103px;
    }

    .custom-select:disabled{
        background-color: #F2F4F4
    }

    .small-table {
        font-size: 12px; /* Adjust the font size as needed */
    }

</style>
