<template>
    <div class="content-body">
        <div id="stacked-pill">
            <div class="col-md-12">
                <div class="card bg-transparent border">
                    <div class="card-content">
                        <div class="card-body pt-1">
                            <div class="pills-stacked">
                                <div class="">

                                    <div class="col-md-12 col-sm-12 border-right pr-md-0">

                                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">

                                            <b-card>
                                                 <b-row>
                                <b-col md="12">
                                     <h4 class="card-title">Employee Report Book</h4>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Empoyee ID"
                                        label-for="Empoyee ID"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.empId"
                                            type="text"
                                            required
                                            placeholder="Empoyee ID"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Employee Name"
                                        label-for="Employee Name"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.empName"
                                            type="text"
                                            required
                                            placeholder="Name"
                                            disabled
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Educational Qualification"
                                        label-for="Designation"
                                    >
                                        <b-form-select v-model="form.edu_qualific_id"
                                                       :options="qualificationList"></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Race"
                                        label-for="Race"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.race"
                                            type="text"
                                            required
                                            placeholder="Race"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Residence"
                                        label-for="Residence"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.residence_id"
                                            type="text"
                                            required
                                            placeholder="Residence"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Father's Name"
                                        label-for="Father's Name"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.father_name"
                                            type="text"
                                            required
                                            placeholder="Father's Name"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="12">
                                    <b-form-group
                                        label="Address"
                                        label-for="Address"
                                    >
                                        <b-textarea md="6" rows="3">
                                            <b-form-input v-model="form.address"></b-form-input>
                                        </b-textarea>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Date of Birth"
                                        label-for="Date of Birth"

                                    >
                                        <date-picker v-model="form.date_of_birth" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Height"
                                        label-for="Height"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.height"
                                            type="text"
                                            required
                                            placeholder="Height"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Personal Marks"
                                        label-for="Personal Marks"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.personal_marks"
                                            type="text"
                                            required
                                            placeholder="Personal Marks"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-row>
                                <b-col class="mt-2 d-flex justify-content-end">
                                    <a md="6" size="md" variant="dark" class="btn btn-dark btn-md" target="_blank" href="/pmis/acr/report">Print</a>&nbsp;
                                    <b-button md="6" size="md" variant="dark" type="submit">Submit</b-button>&nbsp;
                                    <b-button md="6" size="md" class="btn-outline-dark" type="reset">Cancel</b-button>
                                </b-col>
                            </b-row>

                                            </b-card>


                                        </b-form>
                                        <b-row>
                                            <b-col>
                                                <b-card title="Employee Inner Sheet">
                                                    <template>
                                                        <div class="content-wrapper">
                                                            <div class="content-body reportBook">
                                                                <Datatable v-bind:fields="fields" v-bind:items="items" >
                                                                    <template v-slot:actions="{rows}" >
                                                                        <router-link :to='"/employee/basic-info/"+rows.item.ID' class="text-primary"><i class="bx bx-edit cursor-pointer"></i></router-link>
                                                                        <router-link :to='"/employee/basic-info/del/"+rows.item.ID' class="text-primary"><i class="bx bx-show cursor-pointer"></i></router-link>
                                                                    </template>
                                                                </Datatable>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </b-card>
                                            </b-col>

                                        </b-row>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../../layouts/common/datatable';
    import Repo from '../..//../Repository/ApiRepository';
    export default {
        components: { DatePicker, Datatable },
        data() {
            return {
                form:{

                },
                employeeSearch: {
                    department: 'Adminsitration',
                    payGrade: 'Grade-1',
                    jobStatus: 'Active',                },
                selected: 'first',
                options: [
                    { text: 'Male', value: '' },
                    { text: 'Female', value: 'second' },
                    { text: 'Other', value: 'third' }
                ],
                 e_department: [
                    { value: 'Administration', text: 'Administration' },
                    { value: 'Finance', text: 'Finance' },
                    { value: 'IT', text: 'IT' }
                ],
                 e_job_status: [
                    { value: 'Active', text: 'Active' },
                    { value: 'Inactive', text: 'Inactive' }

                ],
                fields: [
                    {label: 'Name Of Appointment', key: 'NameOfAppointment', sortable: true},
                    {label: 'Whether Substantive Or Officiating And Whether Permanent Or Temporary', key: 'WhetherSubstantiveOrOfficiatingAndWhetherPermanentOrTemporary', sortable: true},
                    {label: 'In Officiating Here State Substantive Appointment', key: 'InOfficiatingHereStateSubstantiveAppointment', sortable: true},
                    {label: 'Pay In Substantive Appointment', key: 'PayInSubstantiveAppointment', sortable: true},
                    {label: 'Additional Pay For Officiating', key: 'AdditionalPayForOfficiating', sortable: true},
                    {label: 'Other Emoluments Following Under The Term Pay', key: 'OtherEmolumentsFollowingUnderTheTermPay', sortable: true},
                    {label: 'Date Of Appointment', key: 'DateOfAppointment', sortable: true},
                    {label: 'Signature Of Officer', key: 'SignatureOfOfficer', sortable: true},
                    {label: 'Signature And Designation Of Head Of The Office Or Other Attesting Officer In Attesting Of Columns 1 To 8', key: 'SignatureAndDesignationOfHeadOfTheOfficeOrOtherAttestingOfficerInAttestingOfColumns1To8', sortable: true},
                    {label: 'Date Of Termination Of Appointment', key: 'DateOfTerminationOfAppointment', sortable: true},
                    {label: 'Reason Of Termination (Such As Promotion Transfer Dismissal Etc.)', key: 'ReasonOfTerminationSuchAsPromotionTransferDismissalEtc', sortable: true},
                    {label: 'Signature Of Head Of The Officer Or Other Attesting Officer', key: 'SignatureOfHeadOfTheOfficerOrOtherAttestingOfficer', sortable: true},
                    {label: 'Leave Taken Nature And Duration Of', key: 'LeaveTakenNatureAndDurationOf', sortable: true},
                    {label: 'Signature Of Head Of The Office Or Other Attesting Officer', key: 'SignatureOfHeadOfTheOfficeOrOtherAttestingOfficer', sortable: true},
                    {label: 'Reference To Any Recorded Punishment Of Censure, Or Reward Or Praise Of The Officer', key: 'ReferenceToAnyRecordedPunishmentOfCensureOrRewardOrPraiseOfTheOfficer', sortable: true},

                ],

                items: [
                    {
                        NameOfAppointment: '1',
                        WhetherSubstantiveOrOfficiatingAndWhetherPermanentOrTemporary: '2',
                        InOfficiatingHereStateSubstantiveAppointment: '3',
                        PayInSubstantiveAppointment: '4',
                        AdditionalPayForOfficiating: '5',
                        OtherEmolumentsFollowingUnderTheTermPay: '6',
                        DateOfAppointment: '7',
                        SignatureOfOfficer: '8',
                        SignatureAndDesignationOfHeadOfTheOfficeOrOtherAttestingOfficerInAttestingOfColumns1To8: '8',
                        DateOfTerminationOfAppointment: '9',
                        ReasonOfTerminationSuchAsPromotionTransferDismissalEtc: '10',
                        SignatureOfHeadOfTheOfficerOrOtherAttestingOfficer: '11',
                        LeaveTakenNatureAndDurationOf: '12',
                        SignatureOfHeadOfTheOfficeOrOtherAttestingOfficer: '13',
                        ReferenceToAnyRecordedPunishmentOfCensureOrRewardOrPraiseOfTheOfficer: '14',
                    },
                  ],
                text: '',
                foods: [{text: 'Select One', value: null}, 'Carrots', 'Beans', 'Tomatoes', 'Corn'],
                show: true,
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Search"});
         },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                let arr = [];
                Repo.callApi(Repo.GET_COMMAND, "/pmis/employee/basic-info").then(res => {
                    res.forEach(function(item) {
                        let i ={
                                ID: item.empId,
                                EmployeeName: item.fname+" "+item.mname+ " "+item.lname,
                                Designation: item.designation,
                                Department: item.department,
                                Mobile: item.mobile,
                                Email: item.email};
                        arr.push(i);
                    });
                    this.items = arr;
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
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            }
        }
    }
</script>

<style>
    .reportBook table th{
        text-transform: capitalize;
    }
</style>
