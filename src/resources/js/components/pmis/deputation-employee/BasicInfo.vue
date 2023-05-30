<template>
    <div class="content-body">
        <b-card class="bg-transparent basicinfo">
            <b-card-body class="pills-stacked  pt-0">
                <b-row >
                    <b-col md="12" sm="12" class="pr-md-0">
                        <b-card>
                            <form-wizard @on-complete="onSubmit" title subtitle color="#394C62" shape="square" ref="basicinfo" :finish-button-text="id?'Update':'Submit'">
                                <tab-content title="General" icon="ti-user"  class="mb-1 mt-0" :before-change="validateGeneral">
                                    <b-card-text class="">
                                        <b-row>
                                            <b-col md="2" class="text-center profileImage">
                                                <b-card class="m-0" style="border: 1px solid #eff1f2;">
                                                    <b-card-text >
                                                        <img id="profilepic" :src="basicInfo.emp_photo ? basicInfo.emp_photo : '/images/avatar.png'"  class="img-fluid" alt="...">
                                                    </b-card-text>
                                                </b-card>
                                                <label style="width:100%" class="btn btn-primary"> Upload Photo
                                                    <input class="uploadImage"  type="file"  name="emp_photo" @change="getPhoto" accept="image/png,image/jpg,image/jpeg" v-validate.reject="'image|size:100'" />
                                                </label>
                                                <span :style="errorMessage">{{ errors.first('emp_photo') }}</span>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    id="empCode"
                                                    class="requiredField"
                                                    label="Employee Code"
                                                    label-for="empid">
                                                    <b-form-input id="empId"
                                                                  name="emp_code"
                                                                  v-model="basicInfo.emp_code"
                                                                  required
                                                                  :maxlength="6"
                                                                  trim v-validate="'required|max:6'"
                                                                  @input="uniqueEmployeeCode"
                                                                  @change="uniqueEmployeeCode"></b-form-input>
                                                    <span :style="errorMessage" v-if="unique_code_message">{{ unique_code_message }}</span>
                                                    <span :style="errorMessage">{{ errors.first('emp_code') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Full Name"
                                                    label-for="emp_name">
                                                    <b-form-input
                                                        id="emp_name"
                                                        required
                                                        v-model="basicInfo.emp_name"
                                                        type="text"
                                                        v-validate="'required'"
                                                        name="emp_name"
                                                        :maxlength="250"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('emp_name') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    class="requiredField"
                                                    label="Full Name Bangla"
                                                    label-for="emp_name_bng">
                                                    <b-form-input
                                                        id="emp_name_bng"
                                                        required
                                                        v-model="basicInfo.emp_name_bng"
                                                        type="text"
                                                        v-validate="'required'"
                                                        name="emp_name_bng"
                                                        :maxlength="250"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('emp_name_bng') }}</span>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Father Name"
                                                    label-for="emp_father_name"
                                                >
                                                    <b-form-input
                                                        id="emp_father_name"
                                                        v-model="basicInfo.emp_father_name"
                                                        type="text"
                                                        :maxlength="250"
                                                        name="emp_father_name"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('emp_father_name') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Father Name Bangla"
                                                    label-for="title"
                                                >
                                                    <b-form-input
                                                        id="emp_father_name_bangla"
                                                        v-model="basicInfo.emp_father_name_bng"
                                                        type="text"
                                                        :maxlength="3000"
                                                    ></b-form-input>

                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Mother Name"
                                                    label-for="emp_mother_name">
                                                    <b-form-input
                                                        id="emp_mother_name"
                                                        v-model="basicInfo.emp_mother_name"
                                                        type="text"
                                                        :maxlength="250"
                                                        name="emp_mother_name"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('emp_mother_name') }}</span>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Mother Name Bangla"
                                                    label-for="emp_mother_name_bng">
                                                    <b-form-input
                                                        id="emp_mother_name_bng"
                                                        v-model="basicInfo.emp_mother_name_bng"
                                                        type="text"
                                                        :maxlength="3000"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Blood Group"
                                                    label-for="emp_blood_group_id">
                                                    <v-select v-model="bloodGroups" :options="bloodGroupList"
                                                              name="emp_blood_group_id" id="emp_blood_group_id"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('emp_blood_group_id') }}</span>
                                                </b-form-group>

                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Date of Birth"
                                                    class="requiredField"
                                                    label-for="emp_dob">
                                                    <date-picker v-model="basicInfo.emp_dob"
                                                                 width="100%"
                                                                 input-class="form-control"
                                                                 type="date" lang="en" required v-validate="'required'"
                                                                 format="DD-MM-YYYY" :value-type="valueType" :editable="false" :default-value="defaultBirthDate()" :not-after="birthDateNotAfterYears()" name="emp_dob">
                                                    </date-picker>
                                                    <span :style="errorMessage">{{ errors.first('emp_dob') }}</span>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
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
                                                    label="Gender"
                                                    label-for="emp_gender_id">
                                                    <b-form-radio-group
                                                        v-model="selectedGender"
                                                        :options="genderList"
                                                        name="emp_gender_id"
                                                        @change="genderName($event)"
                                                    ></b-form-radio-group>
                                                    <span :style="errorMessage">{{ errors.first('emp_gender_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Marital Status"
                                                    label-for="emp_maritial_status_id">
                                                    <v-select
                                                        class="uppercase"
                                                        v-model="maritalStatus"
                                                        :options="maritalStatusList"
                                                        label="text"
                                                        id="emp_maritial_status_id"
                                                        name="emp_maritial_status_id">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('emp_maritial_status_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Nationality "
                                                    label-for="emp_nationality_id">
                                                    <v-select v-model="nationality" :options="nationalityList"
                                                              name="emp_nationality_id" id="emp_nationality_id" class="uppercase"
                                                              v-validate="'required'"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('emp_nationality_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Religion"
                                                    class="requiredField"
                                                    label-for="emp_religion_id">
                                                    <v-select v-model="religions" :options="religionList" required
                                                              name="emp_religion_id" id="emp_religion_id" v-validate="'required'"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('emp_religion_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Previous Workplace"
                                                    label-for="previous_workplace"
                                                >
                                                    <b-form-input
                                                        id="previous_workplace"
                                                        v-model="basicInfo.previous_workplace"
                                                        type="text"
                                                        :maxlength="500"
                                                        name="previous_workplace"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('previous_workplace') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Previous Workplace designation"
                                                    label-for="previous_designation"
                                                >
                                                    <b-form-input
                                                        id="previous_designation"
                                                        v-model="basicInfo.previous_designation"
                                                        type="text"
                                                        :maxlength="500"
                                                        name="previous_designation"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('previous_designation') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
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
                                                    <span :style="errorMessage">{{ errors.first('auth_doc_type_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="AUTHENTICATION ID" label-for="auth_no">
                                                    <b-form-input
                                                      v-model="basicInfo.auth_no"
                                                      id="auth_no"
                                                      name="auth_no"
                                                      @input="uniqueAuthenticationIdentity"
                                                      @change="uniqueAuthenticationIdentity"
                                                      v-validate="'required'"
                                                    ></b-form-input>
                                                    <span :style="errorMessage" v-if="unique_authentication_identity_message">{{ unique_authentication_identity_message }}</span>
                                                    <span v-if="errors.first('auth_no')" :style="errorMessage">This {{authenticationTypes.text.toLowerCase() }} is required.</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Authentication Document"
                                                    label-for="auth_document">
                                                    <div class="custom-file b-form-file">
                                                        <input type="file" class="custom-file-input" @change="getAuthIdDocument" aria-describedby="authentication-document-help-block" accept="application/msword,application/pdf,image/png,image/jpg,image/jpeg" v-validate.reject="'size:500'" name="auth_document" />
                                                        <b-form-text id="authentication-document-help-block">
                                                            Document must be PDF,DOCX,Image only. size doesn't exit 500KB.
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
                                                    label="Tribal"
                                                    label-for="Tribal">
                                                    <b-form-radio-group
                                                        v-model="basicInfo.tribal_yn"
                                                        id="tribal_yn"
                                                        :options="tribal_yn_options"
                                                        name="tribal_yn"
                                                    ></b-form-radio-group>
                                                </b-form-group>
                                                <span :style="errorMessage">{{ errors.first('tribal_yn') }}</span>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Active"
                                                    label-for="emp_active_yn">
                                                    <b-form-radio-group
                                                        v-model="basicInfo.emp_active_yn"
                                                        :options="emp_active_yn_options"
                                                        id="emp_active_yn"
                                                        name="emp_active_yn"
                                                    ></b-form-radio-group>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    </b-card-text>
                                </tab-content>
                                <tab-content title="Position" icon="ti-settings" class="mb-1 mt-0" :before-change="validatePosition">
                                    <b-card-text>
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Division"
                                                    class="requiredField"
                                                    label-for="dpt_division_id">
                                                    <v-select  v-model="divisions" :options="dptDivisionList"
                                                               name="dpt_division_id" id="dpt_division_id" required
                                                               label="text" class="uppercase" v-validate="'required'"
                                                               @input="divisionChange(divisions.value)"
                                                    >
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('dpt_division_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="DEPARTMENT"
                                                    class="requiredField"
                                                    label-for="dpt_department_id">
                                                    <v-select v-model="departments" :options="departmentList"
                                                              name="dpt_department_id" id="dpt_department_id" required
                                                              label="text" class="uppercase" v-validate="'required'"
                                                              @input="departmentChange(departments.value)"
                                                    >
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('dpt_department_id') }}</span>
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
                                                    label="DESIGNATION"
                                                    class="requiredField"
                                                    label-for="designation_id">
                                                    <v-select v-model="designations" :options="designationList" required
                                                              name="designation_id" id="designation_id" label="text"
                                                              class="uppercase" v-validate="'required'"
                                                    >
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('designation_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Employee type"
                                                    class="requiredField"
                                                    label-for="emp_type_id">
                                                    <v-select v-model="employeeTypes" :options="empTypeList" required
                                                              name="emp_type_id" id="emp_type_id" label="text" v-validate="'required'"
                                                              class="uppercase"
                                                    >
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('emp_type_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="PAY GRADE"
                                                    label-for="grade_id">
                                                    <v-select v-model="payGrades" :options="payGradeList"
                                                              @input="payGradeChange(payGrades.value)"
                                                              name="grade_id" id="grade_id" label="text"
                                                              class="uppercase"
                                                    >
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('grade_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                  label="PAY GRADE STEP"
                                                  label-for="grade_step_id">
                                                    <v-select v-model="gradeSteps" :options="gradeStepList"
                                                              name="grade_step_id" id="grade_step_id" label="text"
                                                              class="uppercase">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="CLASS"
                                                    label-for="emp_class">
                                                    <b-form-input
                                                        v-model="basicInfo.emp_class"
                                                        type="text"
                                                        readonly
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Joining Date"
                                                    class="requiredField"
                                                    label-for="emp_join_date">
                                                    <date-picker v-model="basicInfo.emp_join_date"
                                                                 width="100%"
                                                                 input-class="form-control"
                                                                 type="date" lang="en" required
                                                                 format="DD-MM-YYYY" :value-type="valueType" :editable="false"
                                                                 name="emp_join_date" v-validate="'required'">
                                                    </date-picker>
                                                    <span :style="errorMessage">{{ errors.first('emp_join_date') }}</span>
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
                                                    <span :style="errorMessage">{{ errors.first('emp_quota_id') }}</span>
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
                                                        name="emp_lpr_date"
                                                        readonly
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Status"
                                                    class="requiredField"
                                                    label-for="emp_status_id">
                                                    <b-form-input
                                                      id="emp_status_id"
                                                      v-model="basicInfo.emp_status_name"
                                                      type="text"
                                                      name="emp_status_id"
                                                      readonly
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Appointment Type"
                                                    label-for="appointment_type_id">
                                                    <v-select v-model="appointmentTypes" :options="appointmentTypeList"
                                                              name="appointment_type_id" id="appointment_type_id" class="uppercase"
                                                              label="text">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('appointment_type_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Active date"
                                                    label-for="emp_active_date">
                                                    <date-picker v-model="basicInfo.emp_active_date"
                                                                 width="100%"
                                                                 input-class="form-control"
                                                                 type="date" lang="en"
                                                                 format="DD-MM-YYYY" :value-type="valueType" :editable="false"></date-picker>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="PIN/ID NO"
                                                    class="requiredField"
                                                    label-for="pin_id_no">
                                                    <b-form-input
                                                        id="pin_id_no"
                                                        v-model="basicInfo.pin_id_no"
                                                        type="text"
                                                        required
                                                        v-validate="'required'"
                                                        :maxlength="50"
                                                        name="pin_id_no">
                                                    </b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('pin_id_no') }}</span>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    </b-card-text>
                                </tab-content>
                                <tab-content title="Others" icon="ti-check" class="mb-1 mt-0" :before-change="validateOthers">
                                    <b-card-text>
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="gpf"
                                                    label-for="gpf_yn">
                                                    <b-form-radio-group
                                                        v-model="basicInfo.gpf_yn"
                                                        :options="gpf_yn_options"
                                                        name="gpf_yn"
                                                    ></b-form-radio-group>
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
                                                        type="text"
                                                        :maxlength="20"
                                                        name="emp_pf_id"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Current Workplace"
                                                    label-for="location_id">
                                                    <v-select v-model="locations"
                                                              :options="locationList"
                                                              name="location_id"
                                                              label="text"
                                                              class="uppercase"
                                                    >
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"
                                                                   v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('location_id') }}</span>

                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Bank"
                                                    class="requiredField"
                                                    label-for="bank_id">
                                                    <v-select @input="bankChange(banks.value)" required
                                                              v-model="banks"
                                                              :options="bankList"
                                                              name="bank_id"
                                                              id="bank_id"
                                                              v-validate="'required'"
                                                              label="text"
                                                              class="uppercase"
                                                    >
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"
                                                                   v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('bank_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Branch"
                                                    class="requiredField"
                                                    label-for="branch_id">
                                                    <v-select v-model="branches"
                                                              :options="branchList"
                                                              name="branch_id"
                                                              id="branch_id"
                                                              label="text"
                                                              required
                                                              v-validate="'required'"
                                                              class="uppercase"
                                                    >
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"
                                                                   v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span :style="errorMessage">{{ errors.first('branch_id') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Bank Account No"
                                                    class="requiredField"
                                                    label-for="emp_bank_acc_no">
                                                    <b-form-input
                                                        id="emp_bank_acc_no"
                                                        v-model="basicInfo.emp_bank_acc_no"
                                                        type="text"
                                                        required
                                                        v-validate="'required'"
                                                        :maxlength="50"
                                                        name="emp_bank_acc_no">
                                                    </b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('emp_bank_acc_no') }}</span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Tin Number"
                                                    class="requiredField"
                                                    label-for="tin_id"
                                                >
                                                    <b-form-input
                                                        id="emp_tin_no"
                                                        required
                                                        v-validate="'required'"
                                                        v-model="basicInfo.emp_tin_no"
                                                        type="text"
                                                        :maxlength="15"
                                                        name="emp_tin_no"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('emp_tin_no') }}</span>
                                                </b-form-group>
                                            </b-col>
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
                                                        :maxlength="10"
                                                    ></b-form-input>
                                                    <span :style="errorMessage">{{ errors.first('bill_code') }}</span>
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
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <!---Row-7 End-->

                                        </b-row>

                                    </b-card-text>
                                </tab-content>
                                <tab-content title="Preview" icon="ti-eye" class="mb-1 mt-0">
                                    <b-card-text>
                                        <EmployeePreview
                                          :employee="basicInfo"
                                          :division="divisions"
                                          :department="departments"
                                          :designation="designations"
                                          :section="sections"
                                          :bank="banks"
                                          :branch="branches"
                                          :location="locations"
                                          :appointment_type="appointmentTypes"
                                          :pay-grade="payGrades"
                                          :grade-step="gradeSteps"
                                          :employee_type="employeeTypes"
                                          :authentication_type="authenticationTypes"
                                          :religion="religions"
                                          :nationality="nationality"
                                          :marital_status="maritalStatus"
                                          :blood_group="bloodGroups"
                                        ></EmployeePreview>
                                    </b-card-text>
                                </tab-content>
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
    import SideBar from "../partials/deputationSidebar";
    import ApiRepository from "../../../Repository/ApiRepository";
    import { FormWizard, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    import EmployeePreview from "./EmployeePreview";

    //import employee from '../../../json/json'; //data edit
    export default {
        components: {DatePicker, SideBar, FormWizard, TabContent, vSelect, EmployeePreview},
        props: ['id'],
        data() {
            return {
                selectedGender: {text: '', value: null},
                renderEmployeePreview:false,
                hideWizard: false,
                authName: '',
                unique_authentication_identity_message:'',
                otCategoryValidationRule: '',
                selectedEmployee: {'option_name':'','emp_id':'', 'emp_name':''},
                designations: {grade:'',designation_id:'',designation:'',text:'',value:''},
                locations: {text:'',value:''},
                payGrades: {text:'',value:''},
                gradeSteps: {text:'',value:''},
                salutations: {text:'',value:''},
                bloodGroups: {text:'',value:''},
                maritalStatus: {text:'',value:''},
                religions: {text:'',value:'','religion_bng':''},
                divisions: {text:'',value:''},
                departments: {text:'',value:''},
                sections: {text:'',value:''},
                quota: {text:'',value:''},
                status: {text:'',value:''},
                nationality: {text:'',value:''},
                otCategory: {text:'',value:''},
                postType: {text:'',value:''},
                billerCodes: {text:'',value:''},
                employeeTypes: {text:'',value:''},
                appointmentTypes: {text:'',value:''},
                emergencyRelationTypes: {text:'',value:''},
                authenticationTypes: {text:'',value:''},
                banks:{text:'',value:''},
                branches:{text:'',value:''},
                employeeList: [],
                unique_code_message: '',
                req_deputation_yn:'',
                authIdValidationRule: '',
                errorMessage: {color: 'red'},
                valueType: this.dateFormatter(),
                basicInfo: {
                    emp_active_date: '',
                    designation_name:'',
                    grade_id: null,
                    grade_name: null,
                    grade_step_id: null,
                    grade_step_name: null,
                    dpt_division_id: null,
                    dpt_division_name: null,
                    dpt_department_id: null,
                    dpt_department_name: null,
                    pin_id_no: null,
                    section_id: null,
                    section_name: null,
                    designation_id: null,
                    emp_type_id: null,
                    emp_type_name: null,
                    location_id: null,
                    location_name: null,
                    workplace_id: null,
                    bank_id: null,
                    bank_name: null,
                    branch_id: null,
                    branch_name: null,
                    emp_class: '',
                    emp_religion_id: '',
                    emp_quota_id: null,
                    emp_status_id: null,
                    emp_status_name: null,
                    emp_blood_group_id: null,
                    emp_blood_group_name: null,
                    emp_nationality_id: 1,
                    emp_nationality_name: 'Bangladeshi',
                    emp_maritial_status_id: null,
                    emp_maritial_status_name: null,
                    reporting_officer: null,
                    appointment_type_id: null,
                    appointment_type_name: null,
                    salutation: null,
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
                    auth_no: '',
                    auth_document: null,
                    auth_document_name: '',
                    auth_document_type: '',
                    auth_doc_type_name: '',
                    auth_doc_type_id: '',
                    emp_active_yn: 'Y',
                    emp_dob: null,
                    age: null,
                    old_dpt_division_id:'',
                    old_department_id:'',
                    old_section_id:'',
                    old_designation_id:'',
                    old_emp_type_id:'',
                    old_pay_grade_id:'',
                    old_bank_id:'',
                    emp_gender_id: '',
                    emp_gender_name: null
                },
                billerCodeList: [],
                bankList: [],
                bloodGroupList: [],
                branchList: [],
                departmentList: [],
                designationList: [],
                dptDivisionList: [],
                empTypeList: [],
                locationList: [],
                maritalStatusList: [],
                nationalityList: [],
                payGradeList: [],
                postTypeList: [],
                quotaList: [],
                salutationList: [],
                sectionList: [],
                gradeStepList: [],
                religionList: [],
                otCategoryList: [],
                reportingOfficerList: [],
                genderList: [],
                appointmentTypeList: [],
                relationList: [],
                classList: [
                    {text: 'Select Class', value: 'null'},
                    {text: 'Class 1', value: 'Class 1'},
                    {text: 'Class 2', value: 'Class 2'},
                    {text: 'Class 3', value: 'Class 3'},
                    {text: 'Class 4', value: 'Class 4'}
                ],
                selected: 'first',
                tax_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                gpf_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                emp_active_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                tribal_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                auth_type_ids: [{value: '', text: 'Select Authentication type'}],
                show: true,
                selectedIndex: 0
            }
        },
        mounted() {
            this.allBasicInfo();
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Deputation Employee"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Basic info"});
            this.formWidgetActiveAll();
            if (this.id > 0) {
                this.basicInfo.emp_id = this.id;
                this.fetchBasicInfo(this.id);
            }
        },
        watch: {
            '$route': function(value, oldvalue){
                this.$router.go(value.fullPath);
            },
            selectedGender(val, oldVal){
                if(val){
                    this.basicInfo.emp_gender_id = val
                    this.genderList.forEach(a=>{
                        if(a.value == val){
                            this.basicInfo.emp_gender_name = a.text
                        }
                    })
                }
            },
            designations:function(val,oldVal) {
                if(val.value !== null) {
                    this.basicInfo.designation_id = val.value;
                    this.basicInfo.designation_name = val.text;
                } else {
                    this.basicInfo.designation_id = '';
                }
            },
            locations:function(val,oldVal) {
                if(val.value !== null) {
                    this.basicInfo.location_id = val.value;
                    this.basicInfo.location_name = val.text;
                } else {
                    this.basicInfo.location_id = '';
                    this.basicInfo.location_name = '';
                }
            },
            payGrades: function (val, oldVal) {
                if (val.value !== null) {
                    this.basicInfo.grade_id = val.value;
                    this.basicInfo.grade_name = val.text;
                } else {
                    this.basicInfo.grade_id ='';
                    this.basicInfo.grade_name ='';
                }
            },
            gradeSteps: function (val, oldVal) {
                if (val.value !== null) {
                    this.basicInfo.grade_step_id = val.value;
                    this.basicInfo.grade_step_name = val.text;
                } else {
                    this.basicInfo.grade_step_id ='';
                    this.basicInfo.grade_step_name ='';
                }
            },
            bloodGroups:function (val, oldVal) {
                if (val.value !== null) {
                    this.basicInfo.emp_blood_group_id = val.value;
                    this.basicInfo.emp_blood_group_name = val.text
                } else {
                    this.basicInfo.emp_blood_group_id ='';
                    this.basicInfo.emp_blood_group_name = ''
                }
            },
            maritalStatus:function (val, oldVal) {
                if (val.value !== null) {
                    this.basicInfo.emp_maritial_status_id = val.value;
                    this.basicInfo.emp_maritial_status_name = val.text;
                } else {
                    this.basicInfo.emp_maritial_status_id ='';
                    this.basicInfo.emp_maritial_status_name ='';
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
                if (val.value !== null) {
                    this.basicInfo.appointment_type_id = val.value;
                    this.basicInfo.appointment_type_name = val.text;
                } else {
                    this.basicInfo.appointment_type_id ='';
                    this.basicInfo.appointment_type_name ='';
                }
            },
            divisions: function(val, oldVal){
                if (val.value !== null) {
                    this.basicInfo.dpt_division_id = val.value;
                    this.basicInfo.dpt_division_name = val.text;
                } else {
                    this.basicInfo.dpt_division_id ='';
                    this.basicInfo.dpt_division_name ='';
                }
            },
            departments: function(val, oldVal){
                if (val.value !== null) {
                    this.basicInfo.dpt_department_id = val.value;
                    this.basicInfo.dpt_department_name = val.text;
                } else {
                    this.basicInfo.dpt_department_id ='';
                    this.basicInfo.dpt_department_name ='';
                }
            },
            sections: function(val, oldVal){
                if (val.value !== null) {
                    this.basicInfo.section_id = val.value;
                    this.basicInfo.section_name = val.text;
                } else {
                    this.basicInfo.section_id ='';
                    this.basicInfo.section_name ='';
                }
            },
            quota: function(val, oldVal){
                if (val.value !== null) {
                    this.basicInfo.emp_quota_id = val.value;
                } else {
                    this.basicInfo.emp_quota_id ='';
                }
            },
            status: function(val, oldVal){
                if (val.value !== null) {
                    this.basicInfo.emp_status_id = val.value;
                    this.basicInfo.emp_status_name = val.text;
                } else {
                    this.basicInfo.emp_status_id ='';
                    this.basicInfo.emp_status_name ='';
                }
            },
            authenticationTypes :function(val, oldVal){
                if (val.value !== null) {
                    this.basicInfo.auth_doc_type_id = val.value;
                    this.basicInfo.auth_doc_type_name = val.text;
                } else {
                    this.basicInfo.auth_doc_type_id ='';
                    this.basicInfo.auth_doc_type_name ='';
                }
            },
            employeeTypes: function(val, oldVal){
                if (val.value !== null) {
                    this.basicInfo.emp_type_id = val.value;
                    this.basicInfo.emp_type_name = val.text;
                } else {
                    this.basicInfo.emp_type_id ='';
                    this.basicInfo.emp_type_name ='';
                }
            },
            nationality: function(val, oldVal){
                if (val.value !== null) {
                    this.basicInfo.emp_nationality_id = val.value;
                    this.basicInfo.emp_nationality_name = val.text;
                } else {
                    this.basicInfo.emp_nationality_id ='';
                    this.basicInfo.emp_nationality_name ='';
                }
            },
            banks:function (val, oldVal) {
                if (val.value !== null) {
                    this.basicInfo.bank_id = val.value;
                    this.basicInfo.bank_name = val.text;
                } else {
                    this.basicInfo.bank_id ='';
                    this.basicInfo.bank_name ='';
                }
            },
            branches:function (val, oldVal) {
                if (val.value !== null) {
                    this.basicInfo.branch_id = val.value;
                    this.basicInfo.branch_name = val.text;
                } else {
                    this.basicInfo.branch_id ='';
                    this.basicInfo.branch_name ='';
                }
            },
            "basicInfo.emp_type_id": function(val, oldVal) {
                if(val){
                    this.fetchPayGradeList();
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
                    return this.basicInfo.auth_doc_type_id == row.auth_doc_type_id
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
            onChangeAuthType(){
                this.basicInfo.auth_no = "";
                this.unique_authentication_identity_message = ''
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            uniqueAuthenticationIdentity(){
                let params = {
                    'auth_id': this.basicInfo.auth_no,
                    'auth_type': this.basicInfo.auth_doc_type_id
                };
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/deputation-employee/basic-infos/check-valid-nid/`, {params}).then(result => {
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
                let emp_type_id=(typeof(this.basicInfo.emp_type_id))=='object'?this.basicInfo.emp_type_id[value]:this.basicInfo.emp_type_id;
                if(this.basicInfo.old_emp_type_id){
                    if(emp_type_id!=this.basicInfo.old_emp_type_id){
                        this.payGrades = {text: '', value: ''};
                        this.gradeSteps = {text: '', value: ''};
                        this.basicInfo.emp_class='';
                    }
                }
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/deputation-employee/basic-infos/pay-grades/${emp_type_id}`).then(res => {
                    this.payGradeList = res.data;

                });
            },
            searchEmployeeById(id){
                if(id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/deputation-employee/basic-infos/employee-information/${id}`).then(res => {
                        this.employeeList = res.data;
                    });
                }
            },
             calculateLprDate() {
                 if(this.basicInfo.emp_dob) {
                     let selectedQuota = this.quotaList.find(row => {
                         return row.value == this.basicInfo.emp_quota_id;
                     });

                     if(selectedQuota) {
                         let quotaName = selectedQuota.text;
                         if(quotaName) {
                             quotaName = quotaName.toLowerCase();
                             if(quotaName == 'freedom fighter') {
                                 this.basicInfo.emp_lpr_date = moment(this.basicInfo.emp_dob).add(62, 'year').format("DD-MM-YYYY");
                             } else {
                                 this.basicInfo.emp_lpr_date = moment(this.basicInfo.emp_dob).add(60, 'year').format("DD-MM-YYYY");
                             }
                         } else {
                             this.basicInfo.emp_lpr_date = moment(this.basicInfo.emp_dob).add(60, 'year').format("DD-MM-YYYY");
                         }
                     } else {
                         this.basicInfo.emp_lpr_date = moment(this.basicInfo.emp_dob).add(60, 'year').format("DD-MM-YYYY");
                     }
                 } else {
                     this.basicInfo.emp_lpr_date = '';
                 }
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
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/deputation-employee/basic-infos/unique-employee-code', {params},{},false).then(result => {
                        this.unique_code_message = result.data.unique_message;
                    });
                }
            },
            divisionChange(id){
                if(id){
                    if(id!=this.basicInfo.dpt_division_id){
                        this.departments={text: '', value: ''}
                        this.sections={text: '', value: ''}
                    }
                    if(this.basicInfo.old_dpt_division_id){
                        if(id!=this.basicInfo.old_dpt_division_id){
                            this.departments={text: '', value: ''}
                            this.sections={text: '', value: ''}
                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/departments/${id}`).then(result => {
                        this.departmentList = result.data;
                    });
                }
            },
            departmentChange(id){
                if(id) {
                    if(id!=this.basicInfo.dpt_department_id){
                        this.sections={text: '', value: ''}
                        this.designations={text: '', value: '', designation_id: ''}
                    }
                    if(this.basicInfo.old_department_id){
                        if(id!=this.basicInfo.old_department_id){
                            this.sections={text: '', value: ''}
                            this.designations={text: '', value: '', designation_id: ''}
                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/sections/${id}`).then(result => {
                        this.sectionList = result.data;
                    });
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-department/${id}`).then(res => {
                        this.designationList = res.data.designations;

                    });
                }
            },
            payGradeChange(id){
                if(id) {
                    if(this.basicInfo.old_pay_grade_id){
                        if(id!=this.basicInfo.old_pay_grade_id){
                            this.gradeSteps = {text: '', value: ''};
                            this.basicInfo.emp_class='';
                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/pay-grades/${id}`).then(result => {
                        if(result.data.paygrade){
                            this.basicInfo.emp_class = result.data.paygrade.emp_class;

                        }
                        this.gradeStepList = result.data.gradesteps
                        if(!this.id){
                            this.gradeSteps = result.data.gradesteps[1]
                        }
                    });
                }
            },
            bankChange(id){
                if(id){
                    if(id!=this.basicInfo.bank_id){
                        this.branches= {text: '', value: ''};
                    }
                    if(this.basicInfo.old_bank_id){
                        if(id!=this.basicInfo.old_bank_id){
                            this.branches= {text: '', value: ''}
                        }
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/branches/${id}`).then(result => {
                        this.branchList = result.data;
                    });
                }
            },
            validateGeneral: async function() {
                const general = Promise.all([
                    this.$validator.validate('emp_code', this.basicInfo.emp_code),
                    this.$validator.validate('emp_name', this.basicInfo.emp_name),
                    this.$validator.validate('emp_name_bng', this.basicInfo.emp_name_bng),
                    this.$validator.validate('emp_dob', this.basicInfo.emp_dob),
                    this.$validator.validate('emp_religion_id', this.basicInfo.emp_religion_id),
                    this.$validator.validate('auth_no', this.basicInfo.auth_no),
                ]);

                const areValid = (await general).every(isValid => isValid);
                const uniqueCode = (this.unique_code_message=='');

                return areValid && uniqueCode;
            },
            validatePosition: async function() {
                const position = Promise.all([
                    this.$validator.validate('dpt_division_id', this.basicInfo.dpt_division_id),
                    this.$validator.validate('dpt_department_id', this.basicInfo.dpt_department_id),
                    this.$validator.validate('pin_id_no', this.basicInfo.pin_id_no),
                    this.$validator.validate('designation_id', this.basicInfo.designation_id),
                    /*this.$validator.validate('grade_step_id', this.basicInfo.grade_step_id),*/
                    this.$validator.validate('emp_join_date', this.basicInfo.emp_join_date),
                    this.$validator.validate('emp_type_id', this.basicInfo.emp_type_id),
                ]);
                const areValid = (await position).every(isValid => isValid);
                return areValid;

            },
            validateOthers: async function() {
                const others = Promise.all([
                    this.$validator.validate('bank_id', this.basicInfo.bank_id),
                    this.$validator.validate('branch_id', this.basicInfo.branch_id),
                    this.$validator.validate('emp_bank_acc_no', this.basicInfo.emp_bank_acc_no),
                    this.$validator.validate('emp_tin_no', this.basicInfo.emp_tin_no),
                    this.$validator.validate('bill_code', this.basicInfo.bill_code),
                ]);

                const areValid = (await others).every(isValid => isValid);

                return areValid;
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
                if (input.files && input.files[0]) {
                    this.$validator.validate('emp_photo', currObj.basicInfo.emp_photo).then(function() {
                        reader.onload = (e) => {
                            if(!currObj.errors.has('emp_photo')) {
                                currObj.basicInfo.emp_photo = e.target.result;
                            }
                        }
                    }).catch(err => {
                        console.log('image error');
                    });
                };
                reader.readAsDataURL(input.files[0]);
                this.basicInfo.emp_photo_name = input.files[0].name;
                this.basicInfo.emp_photo_type = input.files[0].name.split('.').pop();
            },
            fetchBasicInfo(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/deputation-employee/basic-infos/${id}`).then(result => {
                    this.basicInfo = result.data;
                    this.locations = this.basicInfo.location ? this.basicInfo.location: {text: '', value: ''};
                    this.designations = result.data.designation;

                    if(result.data.grade!=null){
                        this.payGrades = result.data.grade;
                        this.payGrades.text ='Grade '+result.data.grade.emp_grade_id+' ('+result.data.grade.grade_range+')';
                        this.payGradeChange(result.data.grade_id);
                        this.basicInfo.old_pay_grade_id=result.data.grade_id;
                        this.basicInfo.grade_id = (this.basicInfo.grade_id == 0) ? '' : this.basicInfo.grade_id;

                        this.gradeSteps = result.data.employeeSelectedGradeStep.length >0 ? result.data.employeeSelectedGradeStep[0]:{text: '', value: ''};
                        this.gradeSteps.text =result.data.employeeSelectedGradeStep.length >0? 'Grade Step '+result.data.employeeSelectedGradeStep[0].grade_steps_id+' ('+result.data.employeeSelectedGradeStep[0].basic_amt+')':''
                    }
                    this.banks=result.data.employeeSelectedBank;
                    this.bankChange(result.data.bank_id);
                    this.branches=result.data.employeeSelectedBankBranch;
                    this.bloodGroups=result.data.employeeSelectedBloodGroup;
                    this.maritalStatus=result.data.employeeSelectedMaritialStatus;
                    this.religions = result.data.emp_religion_id;
                    this.divisions = result.data.dpt_division;
                    this.basicInfo.old_dpt_division_id=result.data.dpt_division.dpt_division_id;
                    this.basicInfo.old_department_id=result.data.employeeSelectedDepartment.department_id;
                    if(result.data.emp_type_id!=null){
                        //this.basicInfo.old_emp_type_id=result.data.employeeSelectedType.emp_type_id;
                        this.basicInfo.old_emp_type_id=result.data.emp_type_id;
                        this.basicInfo.emp_type_id = (this.basicInfo.emp_type_id == 0) ? '' : this.basicInfo.emp_type_id;
                    }


                    this.basicInfo.old_bank_id=result.data.employeeSelectedBank.bank_id;
                    this.divisionChange(result.data.dpt_division_id);
                    this.departments = result.data.employeeSelectedDepartment;
                    this.departmentChange(result.data.dpt_department_id);
                    this.sections = result.data.section ? result.data.section: {text: '', value: ''};
                    this.quota = result.data.employeeSelectedQuota;
                    this.basicInfo.emp_status_name = result.data.employeeSelectedJobStatus.text;
                    this.basicInfo.emp_status_id = result.data.employeeSelectedJobStatus.value;
                    this.nationality = result.data.employeeSelectedNationality;
                    this.postType = result.data.employeeSelectedPostType;
                    this.billerCodes = result.data.employeeSelectedBillerCode[0];
                    this.emergencyRelationTypes = result.data.employeeSelectedEmergencyRelationType;
                    this.employeeTypes = result.data.employeeSelectedType;
                    this.appointmentTypes = result.data.employeeSelectedAppointmentType;
                    this.authenticationTypes = result.data.employeeSelectedAuthDocType;
                    this.basicInfo.auth_no = result.data.auth_no;
                    this.selectedEmployee = this.basicInfo.selectedEmployee;
                    this.selectedGender = result.data.emp_gender_id.value
                    this.basicInfo.emp_nationality_id = (this.basicInfo.emp_nationality_id == 0) ? '' : this.basicInfo.emp_nationality_id;
                    if(result.data.emp_pf_id!=''){
                        this.basicInfo.gpf_yn = 'Y';
                    }else {
                        this.basicInfo.gpf_yn = 'N';
                    }
                    this.basicInfo.grade_step_id = (this.basicInfo.grade_step_id == 0) ? '' : this.basicInfo.grade_step_id;
                    this.basicInfo.bank_id = (this.basicInfo.bank_id == 0) ? '' : this.basicInfo.bank_id;
                    this.basicInfo.branch_id = (this.basicInfo.branch_id == 0) ? '' : this.basicInfo.branch_id;
                    this.basicInfo.emp_bank_acc_no = (this.basicInfo.emp_bank_acc_no == 0) ? '' : this.basicInfo.emp_bank_acc_no;
                    this.basicInfo.emp_tin_no = (this.basicInfo.emp_tin_no == 0) ? '' : this.basicInfo.emp_tin_no;

                });
            },
            allBasicInfo() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/deputation-employee/basic-infos').then(result => {
                    this.genderList = []
                    result.data.genders.forEach(a=>{
                        this.genderList.push({text: a.text, value: a.value.value})
                    });
                    this.bankList = result.data.banks;
                    this.billerCodeList = result.data.billerCodes;
                    this.bloodGroupList = result.data.bloodGroup;
                    this.dptDivisionList = result.data.dptDivision;
                    this.empTypeList = result.data.empType;
                    this.locationList = result.data.location;
                    this.maritalStatusList = result.data.maritalStatus;
                    this.nationalityList = result.data.nationality;
                    this.postTypeList = result.data.postType;
                    this.quotaList = result.data.quota;
                    this.salutationList = result.data.salutation;
                    this.religionList = result.data.religions;
                    this.otCategoryList = result.data.otCategories;
                    this.reportingOfficerList = result.data.employees;


                    this.appointmentTypeList = result.data.appointmentType;
                    this.relationList = result.data.relations;
                    this.auth_type_ids=result.data.auth_type_ids;
                    this.religions =result.data.religions[4];
                    this.nationality=result.data.nationality[1];
                    this.authenticationTypes=result.data.auth_type_ids[1];
                    this.basicInfo.emp_status_name = 'Deputation'
                    this.basicInfo.emp_status_id = 13
                    this.salutations= result.data.salutation[4];
                    this.bloodGroups=result.data.bloodGroup[5];
                    this.maritalStatus=result.data.maritalStatus[1];
                    this.quota=result.data.quota[8];
                    this.otCategory=result.data.otCategories[1];
                    this.appointmentTypes=result.data.appointmentType[2];
                })
            },
            onSubmit(){
                let currObj = this;
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/deputation-employee/basic-infos", this.basicInfo).then(resp => {
                            if (resp.data.o_status_code == 1) {
                                currObj.basicInfo.emp_id = resp.data.id;
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
            },
            onReset() {
                // Reset our form values
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.basicInfo.grade_id = null;
                    this.basicInfo.dpt_division_id = null;
                    this.basicInfo.dpt_department_id = null;
                    this.basicInfo.pin_id_no = null;
                    this.basicInfo.section_id = null;
                    this.basicInfo.designation_id = null;
                    this.basicInfo.emp_type_id = null;
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
                    this.basicInfo.appointment_type_id = null;
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
                    this.basicInfo.auth_no = null;
                    this.basicInfo.auth_document = null;
                    this.basicInfo.gpf_yn = 'N';
                    this.basicInfo.auth_document_name = '';
                    this.basicInfo.auth_document_type = '';
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
            genderName(){

            },
            otCategoryName(){

            },
            religionName(){

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
</style>
