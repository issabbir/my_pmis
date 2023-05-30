<template>
    <div class="content-body">
        <div id="stacked-pill">
            <div class="col-md-12">
                <div class="card bg-transparent border">
                    <div class="card-content">
                        <div class="card-body pt-1">
                             <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-tabs card nav-wrapper-class="w-25" pills>
                                <b-tab active title="Part 1"><b-card-text>
                                            <b-card title="Part 1">
                                                <!---Row-1 Start-->
                                                <b-row>
                                                    <b-col md="3">
                                                            <b-form-group
                                                                id="reportType"
                                                                label="Confidential Report Type"
                                                                label-for="reportType">
                                                                <b-form-select v-model="basicInfo.reportType" >
                                                                    <option value="0" >Select Report Type</option>
                                                                    <option value="01" >Yearly</option>
                                                                    <option value="02" >Special</option>
                                                                </b-form-select>
                                                             </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                            <b-form-group
                                                                label="To Date"
                                                                label-for="jobentry"
                                                            >
                                                             <b-input-group class="mb-2">
                                                                <date-picker v-model="basicInfo.toDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                                                              </b-input-group>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                label="From Date"
                                                                label-for="jobentry"
                                                            >
                                                             <b-input-group class="mb-2">
                                                                <date-picker v-model="basicInfo.fromDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                                                              </b-input-group>
                                                            </b-form-group>
                                                        </b-col>
                                                </b-row>

                                                    <b-row>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                id="employee_id"
                                                                label="Employee Id"
                                                                label-for="name">
                                                                <b-form-input id="employee_id" v-model="basicInfo.name" placeholder="ID"  trim></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                id="name"
                                                                label="Name"
                                                                label-for="name">
                                                                <b-form-input id="name" v-model="basicInfo.name" placeholder="Name"  trim></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                id="fatherName"
                                                                label="Father's Name"
                                                                label-for="FatherName">
                                                                <b-form-input id="fatherName" v-model="basicInfo.fatherName" placeholder="Father's Name"  trim></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                id="designation"
                                                                label="Designation"
                                                                label-for="Designation">
                                                                <b-form-input id="Designation" v-model="basicInfo.designation" placeholder="Designation"  trim></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                id="division"
                                                                label="Division"
                                                                label-for="division">
                                                                <b-form-input id="division" v-model="basicInfo.division" placeholder="Division"  trim></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                         <b-col md="3">
                                                            <b-form-group
                                                                label="Date of Birth"
                                                                label-for="section"
                                                            >
                                                                <date-picker v-model="basicInfo.dob" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                id="currentSalary"
                                                                label="Current Salary"
                                                                label-for="empid">
                                                                <b-form-input id="empId" v-model="basicInfo.currentSalary" placeholder="Current Salary"  trim></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                id="payScale"
                                                                label="Pay Scale"
                                                                label-for="payscale">
                                                                <b-form-input id="payscale" v-model="basicInfo.payScale" placeholder="Pay Scale"  trim></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                label="joining Date"
                                                                label-for="joining Date"
                                                            >
                                                                <date-picker v-model="basicInfo.joiningDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                label="Job Entry"
                                                                label-for="jobentry"
                                                            >
                                                                <b-form-radio-group
                                                                    v-model="basicInfo.jobentry"
                                                                    :options="options"
                                                                    name="radio-inline"
                                                                ></b-form-radio-group>
                                                            </b-form-group>
                                                        </b-col>

                                                         <b-col md="3">
                                                              <b-form-group
                                                                label="If Division Exam Qualified"
                                                                label-for="jobentry"
                                                            >
                                                             <b-input-group class="mb-2">
                                                                <b-input-group-prepend is-text>
                                                                  <input type="checkbox" aria-label="Checkbox for following text input">
                                                                </b-input-group-prepend>
                                                                <date-picker v-model="basicInfo.jobentryDate" width="88%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD" placeholder="Exam Date"></date-picker>
                                                              </b-input-group>
                                                            </b-form-group>
                                                         </b-col>

                                                        <b-col md="3">
                                                            <b-form-group
                                                                id="joingDate"
                                                                label="Joining Date of Current Position"
                                                                label-for="joingDate">
                                                                <date-picker v-model="basicInfo.joingDate" width="88%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                                                            </b-form-group>
                                                        </b-col>

                                                        <b-col md="12" class="mb-2">
                                                            <label for="EducationalQualification">Educational Qualification</label>
                                                            <b-table border hover :items="educational" :fields="fields"></b-table>
                                                        </b-col>
                                                        <b-col md="12">
                                                            <label for="EducationalQualification">Language Proficiency</label>
                                                            <b-table border hover :items="languageProficiency" ></b-table>
                                                        </b-col>
                                                        <b-col md="12" class="mt-2">
                                                            <label for="EducationalQualification">Training</label>
                                                            <b-table border hover :items="trainingList" ></b-table>
                                                        </b-col>
                                                        <b-col md="12" class="mt-2">
                                                            <label for="ExpirationDate">Employee Expiration Date</label>
                                                         <b-row>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                label="To Date"
                                                                label-for="jobentry"
                                                            >
                                                             <b-input-group class="mb-2">
                                                                <date-picker v-model="basicInfo.jobentryDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                                                              </b-input-group>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group
                                                                label="From Date"
                                                                label-for="jobentry"
                                                            >
                                                             <b-input-group class="mb-2">
                                                                <date-picker v-model="basicInfo.jobentryDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                                                              </b-input-group>
                                                            </b-form-group>
                                                        </b-col>
                                                    </b-row>
                                                        </b-col>
                                                    </b-row>
                                            </b-card>

                                </b-card-text></b-tab>
                                <b-tab title="Part 2"><b-card-text>
                                    <b-card title="Part 2">
                                                <!---Row-1 Start-->
                                                    <b-row>
                                                         <b-col md="12">
                                                                <b-table border hover :items="anusakhor" :fields="anusakhorfields">
                                                                    <template v-slot:cell(a)="row">
                                                                        <input type="radio" name="a">
                                                                   </template>
                                                                     <template v-slot:cell(b)="row">
                                                                        <input type="radio" name="a">
                                                                   </template>
                                                                     <template v-slot:cell(c)="row">
                                                                        <input type="radio" name="a">
                                                                   </template>
                                                                     <template v-slot:cell(d)="row">
                                                                        <input type="radio" name="a">
                                                                   </template>
                                                                </b-table>
                                                         </b-col>
                                                    </b-row>
                                            </b-card>
                                </b-card-text></b-tab>
                                <b-tab title="Part 3"><b-card-text>
                                     <b-card title="Part 3">
                                                <!---Row-1 Start-->
                                                    <b-row>
                                                         <b-col md="12" class="mb-2">
                                                             <b-row>
                                                                 <b-col md="3">
                                                                     <label for="overallAssessment"> OVERALL ASSESSMENT </label>
                                                                 </b-col>
                                                                  <b-col md="9">
                                                                    <b-form-radio-group
                                                                        v-model="basicInfo.overallAssessment"
                                                                        :options="overallAssessment"
                                                                        name="radio-inline"
                                                                    ></b-form-radio-group>
                                                                  </b-col>
                                                              </b-row>
                                                          </b-col>
                                                        <b-col md="12">
                                                            <b-row>
                                                                 <b-col md="3">
                                                                     <label for="promotionalDeserving"> PROMOTIONAL DESERVING </label>
                                                                 </b-col>
                                                                  <b-col md="9">
                                                                    <b-form-radio-group
                                                                        v-model="basicInfo.promotionalDeserving"
                                                                        :options="promotionalDeserving"
                                                                        name="radio-inline"
                                                                    ></b-form-radio-group>
                                                                  </b-col>
                                                              </b-row>
                                                        </b-col>
                                                        <b-col md="12" class="mt-3">
                                                        <b-row>
                                                            <b-col md="9">

                                                            </b-col>
                                                            <b-col md="3">
                                                                <p>Assist By Mohammad Hossain</p>
                                                                <p>Date: 11-11-2019</p>
                                                             </b-col>
                                                        </b-row>
                                                            <hr />
                                                      </b-col>
                                                        <b-col md="12" class="mb-2">
                                                             <b-row>
                                                                 <b-col md="2">
                                                                     <label for="overallAssessment"> Counter-signer's Remarks </label>
                                                                 </b-col>
                                                                  <b-col md="3">
                                                                     <b-form-textarea
                                                                          id="textarea"
                                                                          v-model="text"
                                                                          placeholder="Enter something..."
                                                                          rows="3"
                                                                          max-rows="6"
                                                                        ></b-form-textarea>
                                                                  </b-col>
                                                              </b-row>
                                                            <b-row class="mt-2">
                                                                 <b-col md="3">
                                                                     <label for="overallAssessment"> I suppose that Instruction officer's Assessment is</label>
                                                                 </b-col>
                                                                  <b-col md="6">
                                                                     <b-form-radio-group
                                                                        v-model="basicInfo.instructionOfficer"
                                                                        :options="instructionOfficer"
                                                                        name="radio-inline"
                                                                    ></b-form-radio-group>
                                                                  </b-col>
                                                              </b-row>
                                                          </b-col>
                                                         <b-col md="12" class="mt-3">
                                                        <b-row>
                                                            <b-col md="9">

                                                            </b-col>
                                                            <b-col md="3">
                                                                 <p>Name: Arafat Hossain</p>
                                                                <p>Date: 11-11-2019</p>
                                                             </b-col>
                                                        </b-row>
                                                      </b-col>
                                                    </b-row>
                                            </b-card>
                                </b-card-text></b-tab>
                            </b-tabs>
                                 <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                     <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Save</b-button>
                                    <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">Cancel</b-button>
                                 </div>
                             </b-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import DatePicker from 'vue2-datepicker';
    import SideBar from "../partials/sidebar";
    import Repo from  "../../../Repository/ApiRepository";

    //import employee from '../../../json/json'; //data edit
    // json.forEach(x => { console.log(x.emp_id, x.lastname); });

    export default {
        components: { DatePicker, SideBar},
        props: ['id'],
        data() {
            return {
                basicInfo:{},
                employeeTitleList: [
                  { text: 'MR.', value: 'MR.' },
                  { text: 'MRS.', value: 'MRS.' }
                ],
                selected: 'first',
                options: [
                    { text: 'Permanent', value: 'permanent' },
                    { text: 'Temporary', value: 'temporary' },
                 ],
                overallAssessment: [
                    { text: 'Very Good', value: 'very_good' },
                    { text: 'Good', value: 'good' },
                    { text: 'Good Enough', value: 'good_enough' },
                    { text: 'Not Satisfied', value: 'not_Satisfied' },
                 ],
                promotionalDeserving: [
                    { text: 'Excellent', value: '1' },
                    { text: 'Capable', value: '2' },
                    { text: 'Recently Got Promotion', value: '3' },
                    { text: 'Not Capable Yet', value: '4' },
                 ],
                instructionOfficer: [
                    { text: 'Excellent', value: '1' },
                    { text: 'Logically Best', value: '2' },
                    { text: 'Extreme Harsh', value: '3' },
                    { text: 'Humble', value: '4' },
                    { text: 'Biased', value: '4' },
                 ],
                foods: [{text: 'Select One', value: null}, 'Carrots', 'Beans', 'Tomatoes', 'Corn'],
                fields: [
                  {
                    key: 'Exam',
                    sortable: false
                  },
                  {
                    key: 'Subject',
                    sortable: false
                  },
                  {
                    key: 'PassingYear',
                    label: 'Passing Year',
                    sortable: false,
                    },
                  {
                    key: 'Result',
                    label: 'Result',
                    sortable: false,
                    },
                  {
                    key: 'Attachment',
                    label: 'Attachment',
                    sortable: false,
                    }
                ],
                educational: [
                  { isActive: true, Exam: 'B.sc(Hons)', Subject: 'Computer Science', PassingYear: '2009', Result: '4.8', Attachment: 'pdf' },
                   ],
                languageProficiency: [
                        {  Language: 'Bangla', Exam: '', Grade: 'A', Strength: 'Strong' },
                        {  Language: 'English', Exam: 'IELTS', Grade: 'A', Strength: 'Strong' },
                   ],
                trainingList: [
                        {  Type: 'PHP', Country: 'USA', Title: 'Laravel Training', Institute: 'Udmy', Duration: '24 Hours', CompletionDate: '31-02-2019' },
                     ],
                anusakhorfields: [
                  { key: 'Details', sortable: false },
                  { label: 'Very Good', key: 'A', sortable: false },
                  { label: 'Good', key: 'B', sortable: false },
                  { label: 'Good Enough',key: 'C', sortable: false },
                  { label: 'Not Satisfied',key: 'D', sortable: false },
                  { label: 'Remarks', key: 'remarks', sortable: false },
                ],
                anusakhor: [
                  { isActive: true, Details: 'Logical & Emotional Capability', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Working Intelligence', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Communication Capability: Writing', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Communication Capability: Speaking', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Initiative', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Work Quality & Quantity', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Assistance & Skill', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Eagerness & Industrious', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: '08', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'General Responsibility', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Financial Responsibility', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Honesty and Goodwill', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Character & Personality', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Health', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Punctuality', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: 'Disciplined', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: '14', A: '', B: '', C: '', D: '', remarks: '' },
                  { isActive: true, Details: '15', A: '', B: '', C: '', D: '', remarks: '' },
                   ],
                show: true
            }
        },
        mounted() {
            Repo.callApi(Repo.GET_COMMAND, "/pmis/employee/basic-info").then(res => {
                let i = {};
                let id = this.$route.params.id;
                res.forEach(function(item) {
                    if (item.empId == id)
                        i = item;
                });
                this.basicInfo = i;
            });
            console.log(this.basicInfo);
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Basic info"});
        },
        methods: {
            onSubmit(evt) {
                let id = this.$route.params.id;
                let pimaryKey = "";
                let pimaryValue = "";
                if (id) {
                    pimaryKey = "empId";
                    pimaryValue = id;
                }
                evt.preventDefault();
                Repo.callApi(Repo.POST_COMMAND, "/pmis/employee/basic-info", this.basicInfo, pimaryKey, pimaryValue).then(res => {
                    console.log(res.data);
                });
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.form.email = '';
                this.form.name = '';
                this.form.food = null;
                this.form.checked = [];
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            }
        }
    }
</script>

<style>
    .card-header{
        padding: 0 37px;
    }
</style>
