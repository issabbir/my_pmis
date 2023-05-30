<template>
    <div class="content-body">
        <div id="stacked-pill">
            <div class="col-md-12">
                <div class="card bg-transparent border">
                    <div class="card-content">
                        <div class="card-body pt-1">
                            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                <b-tabs card nav-wrapper-class="w-100" pills>

                                   <!---1ST TAB START-->
                                    <b-tab title="Medical Report" active>
                                        <b-card-text>
                                            <b-card title="Medical Report">
                                                <!---Row-1 Start-->
                                                <b-row>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            id="Height"
                                                            label="Height"
                                                            label-for="height">
                                                            <b-form-input id="name" v-model="basicInfo.height" placeholder="Height"  trim></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            id="Weight"
                                                            label="Weight"
                                                            label-for="weight">
                                                            <b-form-input id="Designation" v-model="basicInfo.weight" placeholder="Weight"  trim></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                     <b-col md="3">
                                                        <b-form-group
                                                            id="EyeSight"
                                                            label="Eye Sight"
                                                            label-for="EyeSight">
                                                            <b-form-input id="EyeSight" v-model="basicInfo.EyeSight" placeholder="Eye Sight"  trim></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            id="BloodGroup"
                                                            label="Blood Group"
                                                            label-for="BloodGroup">
                                                            <b-form-input id="BloodGroup" v-model="basicInfo.BloodGroup" placeholder="Blood Group"  trim></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <b-row>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            id="Pressure"
                                                            label="Pressure"
                                                            label-for="Pressure">
                                                            <b-form-input id="name" v-model="basicInfo.Pressure" placeholder="Pressure"  trim></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            id="XRayReport"
                                                            label="X-Ray Report"
                                                            label-for="XRayReport">
                                                            <b-form-input id="XRayReport" v-model="basicInfo.XRayReport" placeholder="X-Ray Report"  trim></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                     <b-col md="3">
                                                        <b-form-group
                                                            id="ECGReport"
                                                            label="ECG Report"
                                                            label-for="ECGReport">
                                                            <b-form-input id="ECGReport" v-model="basicInfo.ECGReport" placeholder="ECG Report"  trim></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            id="MedicalClassicfication"
                                                            label="Medical Classicfication"
                                                            label-for="MedicalClassicfication">
                                                            <b-form-input id="MedicalClassicfication" v-model="basicInfo.MedicalClassicfication" placeholder="Medical Classicfication"  trim></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <b-row>
                                                    <b-col md="12">
                                                        <b-form-group
                                                            label="Health Weakness"
                                                            label-for="HealthWeakness"
                                                        >  <b-form-textarea
                                                            v-model="basicInfo.HealthWeakness"
                                                            id="gpa"
                                                            size="sm"
                                                             rows="5"
                                                            placeholder="Health Weakness"
                                                        ></b-form-textarea>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <b-row >
                                                    <b-col  offset-sm="9" md="3">
                                                        <hr />
                                                        <p>Signature</p>
                                                        <p>Mohammad Hossain</p>
                                                        <p>Date: 11-11-2019</p>
                                                    </b-col>
                                                </b-row>

                                            </b-card>
                                        </b-card-text>
                                    </b-tab>
                                   <!---1ST TAB END--->

                                    <b-tab  title="Bio-data"><b-card-text>
                                        <b-card title="Bio-data">
                                            <!---Row-1 Start-->
                                            <b-row>
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
                                                        id="designation"
                                                        label="Designation"
                                                        label-for="Designation">
                                                        <b-form-input id="Designation" v-model="basicInfo.designation" placeholder="Designation"  trim></b-form-input>
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
                                                        id="fatherName"
                                                        label="Father's Name"
                                                        label-for="FatherName">
                                                        <b-form-input id="fatherName" v-model="basicInfo.fatherName" placeholder="Father's Name"  trim></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col md="3">
                                                    <b-form-group
                                                        label="Marital Status"
                                                        label-for="Marital"
                                                    >
                                                        <b-form-select v-model="basicInfo.marital" class="">
                                                            <option value="u" >Unmarried</option>
                                                            <option value="m" >Married</option>
                                                            <option value="d" >Divorce</option>
                                                            <option value="w" >Widow</option>
                                                        </b-form-select>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        id="NumberofcurrentChild"
                                                        label="Number of current Child"
                                                        label-for="empid">
                                                        <b-form-input id="empId" v-model="basicInfo.NumberofcurrentChild" placeholder="Current Salary"  trim></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="joining Date(In Cpa Service)"
                                                        label-for="joining Date"
                                                    >
                                                        <date-picker v-model="basicInfo.joiningDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-group
                                                        label="joining Date(In Current Designation )"
                                                        label-for="joining Date"
                                                    >
                                                        <date-picker v-model="basicInfo.joiningDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                                    </b-form-group>
                                                </b-col>


                                                    <b-col md="6" >
                                                        <b-form-group
                                                            id=" Current payScale"
                                                            label=" Current Pay Scale"
                                                            label-for="payscale">
                                                            <b-form-input id="payscale" v-model="basicInfo.payScale" placeholder="Pay Scale"  trim></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                        <b-form-group
                                                            id="currentSalary"
                                                            label="Current Salary"
                                                            label-for="empid">
                                                            <b-form-input id="empId" v-model="basicInfo.currentSalary" placeholder="Current Salary"  trim></b-form-input>
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
                                    <b-tab title="Personal Characteristics"><b-card-text>
                                        <b-card title="Personal Characteristics">
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
                                    <b-tab title="Performance of Work"><b-card-text>
                                        <b-card title="Performance of Work">
                                            <!---Row-1 Start-->
                                            <b-row>
                                                <b-col md="12">
                                                    <b-table border hover :items="anusakhor1" :fields="anusakhorfields">
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
                                    <b-tab title="Recommendation"><b-card-text>
                                        <b-card title="Recommendation">
                                            <b-col md="12" class="mt-2">
                                                <label for="EducationalQualification">Total Number</label>
                                                <b-table border hover :items="trainingList1" ></b-table>
                                            </b-col>
                                            <b-row >
                                                <b-col  offset-sm="9" md="3">
                                                    <hr />
                                                    <p>Signature</p>
                                                    <p>Mohammad Hossain</p>
                                                    <p>Date: 11-11-2019</p>
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
                    {  Type: 'PHP', Country: 'USA', Title: 'Laravel Training', Institute: 'Udmy', Duration: '24 Hours'  },
                ],
                trainingList1: [
                    {  Extraordinary: '95-100', Sogood: '85-94', Good: '61-84', Currentvalue: '41-60', Currentqualityislow: '40 and more'  },
                ],
                anusakhorfields: [
                    { key: 'Details', sortable: false },
                    { label: '4', key: 'A', sortable: false },
                    { label: '3', key: 'B', sortable: false },
                    { label: '2',key: 'C', sortable: false },
                    { label: '1',key: 'D', sortable: false },

                ],
                anusakhor: [
                    { isActive: true, Details: 'Disciplined', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Justice and Dimension', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Working Intelligence', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Communication Capability: Speaking', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Zeal and initiative', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Personality', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Collaboration', A: '', B: '', C: '', D: ''},
                    { isActive: true, Details: 'Punctuality', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Reliability', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Responsibility', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Eagerness', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Measures and operations command', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Aware  of Security ', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Conduct with the people', A: '', B: '', C: '', D: ''},

                ],
                anusakhor1: [
                    { isActive: true, Details: 'Professional knowledge', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: '.Quality of work', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: '.Amount of work performed', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Ability to oversee and manage', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Relationships with colleagues', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Skills in decision making', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'Ability to implement decisions', A: '', B: '', C: '', D: ''},
                    { isActive: true, Details: 'Interest and skills of training subordinates', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'The ability to express (written)', A: '', B: '', C: '', D: '' },
                    { isActive: true, Details: 'The ability to express (speaking) ', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Eagerness', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Measures and operations command', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Annual confidential report writing and signup activity ', A: '', B: '', C: '', D: ''  },
                    { isActive: true, Details: 'Conduct with the people', A: '', B: '', C: '', D: ''},

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
