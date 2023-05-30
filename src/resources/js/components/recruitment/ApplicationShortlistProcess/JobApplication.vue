<template>
    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card title="Job Application">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <form-wizard title subtitle color="#394C62">
                                <!-- tab 1 content -->
                                <tab-content title="Basic Information" class="mb-3">
                                    <b-row>
                                        <b-col md="12">
                                            <b-row class="my-1">
                                                <b-col md="4">
                                                    <label>Do you currently work for CPA or any other Govt. organization?</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-radio-group
                                                        v-model="work"
                                                        :options="worklList"
                                                        name="radio-inline"
                                                        ></b-form-radio-group>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col>
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>First Name</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.fName" type="text" placeholder="First Name"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col>
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Middle Name</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.mName" type="text" placeholder="Middle Name"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col>
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Last Name</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.lName" type="text" placeholder="Last Name"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Father Name</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.fatherName" type="text" placeholder="Father Name"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Mother Name:</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.motherName" type="text" placeholder="Mother Name"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Maritial Status:</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-select v-model="form.maratialStatus" :options="maratialStatus"></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Spouse Name:</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.spouseName" type="text" placeholder="Spouse Name"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Date of Birth</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.dateOfBirth" type="text" placeholder="Date of Birth"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="4">
                                                    <label>Age on {{ dateOfBirth }}</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input v-model="form.ageOn" type="number" placeholder="Age"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>National ID:</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.spouseName" type="text" placeholder="National ID"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Mobile:</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.spouseName" type="text" placeholder="Mobile Number"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Email</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-input v-model="form.email" type="text" placeholder="Email"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Gender:</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-radio-group
                                                        v-model="gender"
                                                        :options="genderList"
                                                        name="radio-inline"
                                                        ></b-form-radio-group>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Religion:</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-select v-model="form.religion" :options="religion"></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col md="4">
                                            <b-row class="my-1">
                                                <b-col md="3">
                                                    <label>Quata:</label>
                                                </b-col>
                                                <b-col md="9">
                                                    <b-form-select v-model="form.quata" :options="quata"></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                </tab-content>
                                <!-- tab 1 content -->
                                <tab-content title="Address" class="mb-3">
                                    <!-- Address  -->
                                    <b-row>
                                        <b-col class="col-md-12">
                                            <fieldset class="border p-2">
                                                <legend class="w-auto" style="font-size:18px;">Parmanent Address</legend>
                                                <b-row>
                                                    <b-col md="3">
                                                        <b-form-group label="DIVISION" label-for="input-1">
                                                            <b-form-select id="input-1" v-model="form.parDivision" :options="division"></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="DISTRICT" label-for="input-1">
                                                            <b-form-select id="input-1" v-model="form.parDistrict" :options="district"></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="THANA/UPAZILA" label-for="input-1">
                                                            <b-form-select id="input-1" v-model="form.parThana" :options="thana"></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="POST OFFICE" label-for="input-1">
                                                            <b-form-select id="input-1" v-model="form.parPostOffice" :options="postOffice"></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <b-row>
                                                    <b-col md="2">
                                                        <b-form-group label="POST CODE" label-for="input-1">
                                                            <b-form-input id="postCode" v-model="form.parpPostCode" placeholder="Post Code"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="VILLAGE" label-for="parVillage">
                                                            <b-form-input id="parVillage" v-model="form.parVillage" placeholder="Village"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="SECTOR" label-for="input-1">
                                                            <b-form-input id="parSector" v-model="form.parSector" placeholder="Sector"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="BLOCK" label-for="parBlock">
                                                            <b-form-input id="parBlock" v-model="form.parBlock" placeholder="Block"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="ROAD NO" label-for="parRoadNo">
                                                            <b-form-input id="parRoadNo" v-model="form.parRoadNo" placeholder="Road No"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="HOUSE NO" label-for="parHouse">
                                                            <b-form-input id="parHouse" v-model="form.parHouse" placeholder="House No"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <b-row>
                                                    <b-col md="6">
                                                        <b-form-group label="REMARKS" label-for="remarks">
                                                            <b-form-input id="parremarks" v-model="form.parremarks" placeholder="Remarks"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                        <b-form-group label="ADDRESS LINE" label-for="parpAddress">
                                                            <b-form-input id="parpAddress" v-model="form.parpAddress" placeholder="Address Line"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                            </fieldset>
                                        </b-col>
                                    </b-row>

                                    <!-- Present Address  -->
                                    <b-row class="mt-2">
                                        <b-col class="col-md-12">
                                            <fieldset class="border p-2">
                                                <legend class="w-auto" style="font-size:18px;">Present Address</legend>
                                                <b-row>
                                                    <b-col md="3">
                                                        <b-form-group label="DIVISION" label-for="input-1">
                                                            <b-form-select id="input-1" v-model="form.parDivision" :options="division"></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="DISTRICT" label-for="input-1">
                                                            <b-form-select id="input-1" v-model="form.parDistrict" :options="district"></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="THANA/UPAZILA" label-for="input-1">
                                                            <b-form-select id="input-1" v-model="form.parThana" :options="thana"></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="POST OFFICE" label-for="input-1">
                                                            <b-form-select id="input-1" v-model="form.parPostOffice" :options="postOffice"></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <b-row>
                                                    <b-col md="2">
                                                        <b-form-group label="POST CODE" label-for="input-1">
                                                            <b-form-input id="postCode" v-model="form.parpPostCode" placeholder="Post Code"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="VILLAGE" label-for="parVillage">
                                                            <b-form-input id="parVillage" v-model="form.parVillage" placeholder="Village"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="SECTOR" label-for="input-1">
                                                            <b-form-input id="parSector" v-model="form.parSector" placeholder="Sector"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="BLOCK" label-for="parBlock">
                                                            <b-form-input id="parBlock" v-model="form.parBlock" placeholder="Block"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="ROAD NO" label-for="parRoadNo">
                                                            <b-form-input id="parRoadNo" v-model="form.parRoadNo" placeholder="Road No"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="2">
                                                        <b-form-group label="HOUSE NO" label-for="parHouse">
                                                            <b-form-input id="parHouse" v-model="form.parHouse" placeholder="House No"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <b-row>
                                                    <b-col md="6">
                                                        <b-form-group label="REMARKS" label-for="remarks">
                                                            <b-form-input id="parremarks" v-model="form.parremarks" placeholder="Remarks"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                        <b-form-group label="ADDRESS LINE" label-for="parpAddress">
                                                            <b-form-input id="parpAddress" v-model="form.parpAddress" placeholder="Address Line"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                            </fieldset>
                                        </b-col>
                                    </b-row>
                                </tab-content> 
                                <tab-content title="Eduction" class="mb-3">
                                    <b-row class="mt-2">
                                        <b-col>
                                            <fieldset class="border p-2">
                                                <legend class="w-auto" style="font-size:18px;">Eduction (From Latest)</legend>
                                                <b-table bordered hover :items="education" :fields="educationFields">
                                                         <template v-slot:cell(exam)="row">
                                                          <b-form-input id="parpAddress" v-model="form.exam" placeholder="B.sc(Hons)"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(subject)="row">
                                                              <b-form-input id="subject" v-model="form.subject" placeholder="Computer Science"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(examBody)="row">
                                                              <b-form-input id="examBody" v-model="form.examBody" placeholder="University Of Dhaka"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(passingYear)="row">
                                                              <b-form-input id="passingYear" v-model="form.passingYear" placeholder="2009"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(result)="row">
                                                              <b-form-input id="result" v-model="form.result" placeholder="3.55"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(attachment)="row">
                                                              <b-form-file id="attachment" v-model="form.attachment" placeholder="Attachment"></b-form-file>
                                                    </template>
                                                    <template v-slot:cell(action)="row">
                                                              <b-button size="sm"  class="mr-2"> Add </b-button>
                                                    </template>
                                                </b-table>
                                            </fieldset>
                                        </b-col>
                                    </b-row>
                                </tab-content>
                                <tab-content title="Job Experiance" class="mb-3">
                                    <b-row class="mt-2">
                                        <b-col>
                                            <fieldset class="border p-2">
                                                <legend class="w-auto" style="font-size:18px;">Job Experiance (From Latest)</legend>
                                                <b-table bordered hover :items="education" :fields="educationFields">
                                                         <template v-slot:cell(organization)="row">
                                                          <b-form-input id="organization" v-model="form.organization" placeholder="CNS Limited"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(position)="row">
                                                              <b-form-input id="subject" v-model="form.position" placeholder="Sr. Programmer"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(startDate)="row">
                                                              <b-form-input id="startDate" v-model="form.examBody" placeholder="02/02/2017"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(endDate)="row">
                                                              <b-form-input id="endDate" v-model="form.endDate" placeholder="02/02/2019"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(anyExperiance)="row">
                                                              <b-form-input id="result" v-model="form.result" placeholder="2 Years"></b-form-input>
                                                    </template>
                                                    <template v-slot:cell(attachment)="row">
                                                              <b-form-file id="attachment" v-model="form.attachment" placeholder="Attachment"></b-form-file>
                                                    </template>
                                                    <template v-slot:cell(action)="row">
                                                              <b-button size="sm"  class="mr-2"> Add </b-button>
                                                    </template>
                                                </b-table>
                                            </fieldset>
                                        </b-col>
                                    </b-row>
                                </tab-content>
                                <tab-content title="Bank Draft" class="mb-3">
                                    <b-row class="mt-2">
                                        <b-col>
                                            <fieldset class="border p-2">
                                                <legend class="w-auto" style="font-size:18px;">Bank Draft</legend>
                                                <b-row>
                                                    <b-col md="6">
                                                        <b-form-group label="BANK NAME" label-for="input-1">
                                                            <b-form-input id="bankName" v-model="form.parpPostCode" placeholder="Bank Name"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                        <b-form-group label="BRANCH" label-for="branch">
                                                            <b-form-select id="branch" v-model="form.branch" options:branch></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <b-row>
                                                    <b-col md="6">
                                                        <b-form-group label="BD BO" label-for="input-1">
                                                            <b-form-input id="bankName" v-model="form.parpPostCode" placeholder="BD No"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                        <b-form-group label="DATE" label-for="branch">
                                                            <b-form-input id="date" v-model="form.parpPostCode" placeholder="date"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                            </fieldset> 
                                        </b-col>
                                    </b-row>
                                </tab-content>
                                <tab-content title="Complete" class="mb-3">
                                    <b-row>
                                        <b-col>
                                            <h5> Declaration</h5> 

                                            <b-form-checkbox  id="checkbox-1"  v-model="status" name="checkbox-1" value="accepted" unchecked-value="not_accepted">  <p>I hereby affirm that I have the qualifications and experience to apply under the terms of the notice and that the information contained in this application is completely tru and correct.
                                                    If any information is lacking or falsified, the authority may take legal action, including cancellation of my application from at any time before or after the appointment examination.</p> </b-form-checkbox>
                                        </b-col>
                                    </b-row>

                                    <b-row align-h="between" class="mt-3">
                                        <b-col cols="2" class="text-left"><b-form-file id="attachment1" v-model="form.attachment1" placeholder="Attachment"></b-form-file></b-col>
                                        <b-col cols="2" class="text-left"><b-form-file id="attachment2" v-model="form.attachment2" placeholder="Attachment"></b-form-file></b-col>
                                    </b-row> 
                                </tab-content>
                            </form-wizard>
                        </b-form>

                    </b-card>
                </b-col>
            </b-row>

        </div>
    </div>


    <!-- END: Content-->

</template>

<script>
    import DatePicker from 'vue2-datepicker'
            import { FormWizard, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    export default {
        components: {
            FormWizard,
            DatePicker,
            TabContent
        },
        data() {
            return {
                dateOfBirth: '01/10/1993',
                form: {
                    incidentID: '001254',
                    description: '',
                    gender: 'male',
                    maratialStatus: null,
                    religion: null,
                    quata: null,
                    parDivision: null,
                    parDistrict: null,
                    parThana: null,
                    parPostOffice: null,
                    work: 'CPA',
                },
                genderList: [
                    {text: 'Male', value: 'male'},
                    {text: 'Female', value: 'female'},
                    {text: 'Others', value: 'others'}
                ],
                worklList: [
                    {text: 'CPA', value: 'CPA'},
                    {text: 'Other Govt. Organization', value: 'others'},
                    {text: 'NA', value: 'na'}
                ],
                maratialStatus: [
                    {text: 'Select One', value: null},
                    {text: 'Married', value: 'married'},
                    {text: 'Unmarried', value: 'Uunmarried'},
                ],
                religion: [
                    {text: 'Select One', value: null},
                    {text: 'Islam', value: 'Islam'},
                    {text: 'Others', value: 'others'}
                ],
                quata: [{text: 'Select One', value: null}, 'Freedom Fighter'],
                division: [{text: 'Select One', value: null}, 'Dhaka', 'Rajshahi'],
                district: [{text: 'Select One', value: null}, 'Dhaka', 'Lakshmipur'],
                thana: [{text: 'Select One', value: null}, 'Pallobi', 'Lakshmipur Sadar'],
                postOffice: [{text: 'Select One', value: null}, 'Mirpur', 'Lakshmipur Sadar'],
                show: true,
                educationFields: ['exam', 'subject', 'examBody', 'passingYear', 'result', 'attachment', 'action'],
                jobExperiance: ['organization', 'position', 'startDate', 'endDate', 'anyExperiance', 'attachment', 'action'],
                education: [
                    {exam: 'B.sc(Hons)', subject: 'Computer Science', examBody: 'University Of Dhaka', passingYear: '2009', result: '3.55'},
                ],
                jobExperiance: [
                    {organization: 'CNS Limited', position: 'Sr. Programmer', startDate: '01/02/2017', endDate: '01/02/2019', anyExperiance: '2 Years'},
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Online Recruitment"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Application Short List"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Job Application"});
            this.totalRows = this.items.length
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault()
                console.log(JSON.stringify(this.form))
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.incidentID = ''
                this.form.description = ''
                this.form.category = null
                this.form.location = null
                this.form.shipname = null
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal.title = ''
                this.infoModal.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        }

    }
</script>

<style scoped>

</style>
