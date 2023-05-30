<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked  pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-card title="Service">
                                <!--Row Start-1-->
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="PAY SCALE"
                                            label-for="pay_scale"
                                        >
                                            <b-form-select
                                                v-model="service.payscale"
                                                :options="e_payscale"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <!--Row End-1-->
                                <!--Row Start-2-->
                                <b-row>
                                    <b-col md="3">
                                        <b-form-group
                                            label="REPORTING OFFICER (EIN)"
                                            label-for="EIN"
                                        >
                                            <b-form-select
                                                v-model="service.ein"
                                                :options="e_ein"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="NAME"
                                            label-for="Emp_name"
                                        >
                                            <b-form-input
                                                id="emp_name"
                                                v-model="service.empName"
                                                type="text"
                                                required
                                                placeholder="Employee Name"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="DEPARTMENT"
                                            label-for="department"
                                        >
                                            <b-form-input
                                                id="department"
                                                v-model="service.department"
                                                type="text"
                                                required
                                                placeholder="Department"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="DESIGNATION"
                                            label-for="designation"
                                        >
                                            <b-form-input
                                                id="designation"
                                                v-model="service.designation"
                                                type="text"
                                                required
                                                placeholder="Designation"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <!--Row End-2-->
                                <!--Row Start-3-->
                                <b-row>
                                    <b-col md="3">
                                        <b-form-group
                                            label="JOINING DATE"
                                            label-for="date"

                                        >
                                            <date-picker v-model="service.joinDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="DATE OF CONFIRMATION"
                                            label-for="section"
                                        >
                                            <date-picker v-model="service.confirmationDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="DATE OF PRL"
                                            label-for="prl_date"
                                        >
                                            <date-picker v-model="service.prlDate" width="100%" input-class="form-control" disabled="" type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="WORK PLACE"
                                            label-for="work_place"
                                        >
                                            <b-form-select
                                                v-model="service.workPlace"
                                                :options="e_workplace"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <!--Row End-3-->
                                <!--Row Start-4--->
                                <b-row>
                                    <b-col md="3">
                                        <b-form-group
                                            label="PROFESSION TYPE"
                                            label-for="profession_type"
                                        >
                                            <b-form-select
                                                v-model="service.professionType"
                                                :options="e_professionType"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="APPOINT TYPE"
                                            label-for="appoint_type"
                                        >
                                            <b-form-select
                                                v-model="service.appointType"
                                                :options="e_appointType"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="ALLOW / DED"
                                            label-for="allow_ded"
                                        >
                                            <b-form-radio-group
                                                v-model="service.allowDed"
                                                :options="e_allow_ded"
                                                plain
                                                name="plain-inline"
                                            >
                                            </b-form-radio-group>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="BILL NO"
                                            label-for="bill_no"
                                        >
                                            <b-form-input
                                                id="boll_no"
                                                v-model="service.billNo"
                                                type="text"
                                                required
                                                placeholder="Bill No"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <!--Row End-4-->
                                <!--Row Start-5-->
                                <b-row>
                                    <b-col md="3">
                                        <b-form-group
                                            label="STATUS"
                                            label-for="status"
                                        >
                                            <b-form-select
                                                v-model="service.status"
                                                :options="e_status"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="POST TYPE"
                                            label-for="post_type"
                                        >
                                            <b-form-select
                                                v-model="service.postType"
                                                :options="e_postType"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="GRADE BY POST"
                                            label-for="grade_by_post"
                                        >
                                            <b-form-input
                                                id="grade_by_post"
                                                v-model="service.gradeByPost"
                                                type="text"
                                                required
                                                placeholder="Grade By Post"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3">
                                        <b-form-group
                                            label="REPORTING GROUP"
                                            label-for="reportingGroup"
                                        >
                                            <b-form-select
                                                v-model="service.reportingGroup"
                                                :options="e_reportingGroup"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <!--Row End-5-->
                                <!--Row Start-6-->
                                <b-row>
                                    <b-col md="3">
                                        <b-form-group
                                            label="OT STATUS"
                                            label-for="ot_status"
                                        >
                                            <b-form-select
                                                v-model="service.otStatus"
                                                :options="e_ot_status"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="OT CATEGORY"
                                            label-for="ot_category"
                                        >
                                            <b-form-select
                                                v-model="service.otCatagory"
                                                :options="e_ot_catagory"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="MEDICAL BOOK ID"
                                            label-for="medical_book_id"
                                        >
                                            <b-form-input
                                                id="medical_book_id"
                                                v-model="service.medicalBookId"
                                                type="text"
                                                required
                                                placeholder="Medical Book Id"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="PROBATION PERIOD"
                                            label-for="probation_period"
                                        >
                                            <b-form-input
                                                id="probation_period"
                                                v-model="service.probationPeriod"
                                                type="text"
                                                required
                                                placeholder="Probation Period"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <!--Row End-6-->
                                <!--Row Start-7-->
                                <b-row>
                                    <b-col md="3">
                                        <b-form-group
                                            label="PREVIOUS WORK PLACE"
                                            label-for="previous_work_place"
                                        >
                                            <b-form-input
                                                id="medical_book_id"
                                                v-model="service.previousWorkPlace"
                                                type="text"
                                                required
                                                placeholder="Previous Work Place"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="PREVIOUS DESIGNATION"
                                            label-for="previous_designation"
                                        >
                                            <b-form-input
                                                id="previous_designation"
                                                v-model="service.previousDesignation"
                                                type="text"
                                                required
                                                placeholder="Previous Designation"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="OFFICE ADDRESS"
                                            label-for="office_address"
                                        >
                                            <b-form-input
                                                id="office_address"
                                                v-model="service.officeAddress"
                                                type="text"
                                                required
                                                placeholder="Office Address"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <!--Row End-7-->
                                <!--Row Start-8-->
                                <b-row>
                                    <b-col md="4">
                                        <b-form-group
                                            label="WRITTEN TEST RESULT"
                                            label-for="written_test_result"
                                        >
                                            <b-form-input
                                                id="written_test_result"
                                                v-model="service.writtenTestResult"
                                                type="text"
                                                required
                                                placeholder="Written Test Result"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group
                                            label="VIVA RESULT"
                                            label-for="viva_result"
                                        >
                                            <b-form-input
                                                id="viva_result"
                                                v-model="service.vivaResult"
                                                type="text"
                                                required
                                                placeholder="Viva Result"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group
                                            label="RECRUITMENT TEST RESULT"
                                            label-for="recruitment_test_result"
                                        >
                                            <b-form-input
                                                id="recruitment_test_result"
                                                v-model="service.recruitmentTestResult"
                                                type="text"
                                                required
                                                placeholder="Recruitment Test Result"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <!--Row End-8-->
                                <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                    <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Save</b-button>
                                    <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">Cancel</b-button>
                                </div>

                            </b-card>

                        </b-form>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
      import Header from "../../../layouts/pmis/partials/Header";
    import SideBar from "../partials/sidebar";

    export default {
        components: {Header, DatePicker,SideBar },
        props: ['id'],
        data() {
            return {
                service: {
                    paygarde:'',
                    payscale:'',
                    ein:'',
                    empName:'',
                    department:'',
                    designation:'',
                    joinDate:'',
                    confirmationDate:new Date(),
                    prlDate:new Date(),
                    workPlace:'',
                    classType:null,
                    professionType:null,
                    appointType:null,
                    allowDed:'',
                    status:'',
                    postType:'',
                    gradeByPost:'',
                    reportingGroup:'',
                    bankname:'',
                    bankBranch:'',
                    accountNo:'',
                    billNo:'',
                    otStatus:'',
                    otCatagory:'',
                    medicalBookId:'',
                    officeOrderNo:'',
                    probationPeriod:'',
                    deputation:'',
                    previousWorkPlace:'',
                    previousDesignation:'',
                    officeAddress:'',
                    writtenTestResult:'',
                    vivaResult:'',
                    recruitmentTestResult:'',
                 },

                allow_ded: 'No',
                e_allow_ded: [
                    { value: true, text: 'Yes', },
                    { value: false, text: 'No',},

                ],
                deputation: false,
                e_deputation: [
                    { value: true, text: 'Yes', },
                    { value: false, text: 'No',},

                ],
               /* paygarde: '01',
                e_paygrade: [
                    { value: '01', text: '01' },
                    { value: '02', text: '02' },
                    { value: '03', text: '03', },
                    { value: '04' ,text: '04' },
                    { value: '05' ,text: '05' }
                ],*/
                ein:'012',
                e_ein: [
                    { value: '012', text: '012' },
                    { value: '012', text: '013' },
                    { value: '012', text: '014' }
                ],
                payscale: '78000',
                e_payscale: [
                    { value: '78000', text: '78000' },
                    { value: '50000', text: '50000' },
                    { value: '60000', text: '60000' }
                ],
                workplace: 'Chittagong',
                e_workplace: [
                    { value: 'Chittagong', text: 'Chittagong' },
                    { value: 'Dhaka', text: 'Dhaka' }

                ],
                professionType: 'Accounts',
                e_professionType: [
                    { value: 'Accounts', text: 'Accounts' },
                    { value: 'Marine Engr', text: 'Marine Engr' },
                    { value: 'Engr. Electrical', text: 'Engr. Electrical' },
                    { value: 'Non-Diploma', text: 'Non-Diploma' }
                ],
              appointType: 'Permanent',
                e_appointType: [
                    { value: 'Permanent', text: 'Permanent' },
                    { value: 'Contractual', text: 'Contractual' }
                ],

                status: 'One',
                e_status: [
                    { value: 'One', text: 'One' },
                    { value: 'Two', text: 'Two' }
                ],
                postType: 'Ministerial',
                e_postType: [
                    { value: 'Ministerial', text: 'Ministerial' },
                    { value: 'Operational', text: 'Operational' }
                ],
                reportingGroup: 'Permanent',
                e_reportingGroup: [
                    { value: 'Permanent', text: 'Permanent' },
                    { value: 'Contractual', text: 'Contractual' }
                ],

               /* bank:'Agrani Bank Limited',
                e_bank: [
                    { value: 'Agrani Bank Limited', text: 'Agrani Bank Limited' },
                    { value: 'Bank Asia Limited', text: 'Bank Asia Limited' }
                ],*/
                ot_status:'Yes',
                e_ot_status: [
                    { value: 'Yes', text: 'Yes' },
                    { value: 'No', text: 'No' }
                ],
                ot_catagory: 'Cat-01',
                e_ot_catagory: [
                    { value: 'Cat-01', text: 'Cat-01' },
                    { value: 'Cat-02', text: 'Cat-02' }
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Service"});
         },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                console.log(JSON.parse(JSON.stringify(this.service)))
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.form.email = '';
                this.form.name = '';
                this.form.medical_book_id='';
                this.form.office_order_no='';
                this.form.probation_period= '';
                this.form.previous_work_place='';
                this.form.previous_designation='';
                this.form.office_address='';
                this.form.written_test_result='';
                this.form.viva_result='';
                this.form.recruitment_test_result='';
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

