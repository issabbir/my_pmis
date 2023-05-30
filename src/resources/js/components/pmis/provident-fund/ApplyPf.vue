<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">PF Applications</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Empoyee Code"
                                        label-for="Empoyee Code"
                                    >
                                        <b-form-input
                                            name="emp_id"
                                            hidden
                                            v-model="pfOpening.emp_id"></b-form-input>
                                        <b-form-input
                                            id="emp_code"
                                            v-model="emp_code"
                                            type="text"
                                            required
                                            placeholder="Empoyee code"
                                           :disabled="validated"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Employee Name"
                                        label-for="Employee Name"
                                    >
                                        <b-form-input
                                            id="empName"
                                            v-model="empName"
                                            type="text"
                                            required
                                            placeholder="Employee Name"
                                            disabled
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Department"
                                        label-for="Department"
                                    >
                                        <b-form-input
                                            id="department"
                                            v-model="department"
                                            type="text"
                                            required
                                            placeholder="Department"
                                            disabled
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Section"
                                        label-for="Section"
                                    >
                                        <b-form-input
                                            id="section"
                                            v-model="section"
                                            type="text"
                                            required
                                            placeholder="Section"
                                            disabled
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Designation"
                                        label-for="Designation"
                                    >
                                        <b-form-input
                                            id="designation"
                                            v-model="designation"
                                            type="text"
                                            required
                                            placeholder="Designation"
                                            disabled
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Basic"
                                        label-for="Basic"
                                    >
                                        <b-form-input
                                            id="basic"
                                            v-model="basic"
                                            type="text"
                                            required
                                            placeholder="Basic"
                                            disabled
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="CPF/GPF No"
                                        label-for="CPF-GPF No"
                                    >
                                        <b-form-input
                                            id="cpf_gpf_no"
                                            :disabled="hasgpfId!==null||gpfStatus=='N'"
                                            v-model="pfOpening.cpf_gpf_no"
                                            type="text"
                                            required
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Current PF(%)"
                                        label-for="Current PF"
                                    >
                                        <b-form-input
                                            id="curr_pf"
                                            disabled
                                            v-model="pfOpening.curr_pf"
                                            type="number"
                                            placeholder="Current PF"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="2">
                                    <b-form-group
                                        label="New PF(%)"
                                        label-for="New PF"
                                    >
                                        <b-form-input
                                            id="new_pf"
                                            v-model="pfOpening.new_pf"
                                            type="number"
                                            required
                                            placeholder="New PF"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="2">
                                    <b-form-group
                                        label="Amount"
                                        label-for="showCalculationAmt"
                                    >
                                        <b-form-input
                                            id="showCalculationAmt"
                                            v-model="showCalculationAmt"
                                            type="text"
                                            disabled
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Status"
                                        label-for="status"
                                    >
                                        <b-form-select :disabled="hasPermission('PF_APPLICATION_APPROVAL')==false"
                                                       v-model="pfOpening.status" required
                                                       :options="pfStatus"></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>

                                <b-col class="mt-2 d-flex justify-content-end">
                                    <b-button md="6" size="md" variant="dark mr=1" type="submit">Submit</b-button>&nbsp;
                                    <b-button md="6" size="md" @click="exitPfApplication"
                                              class="btn-outline-dark" type="reset">Exit
                                    </b-button>
                                </b-col>
                            </b-row>
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>
        </div>


    </div>
</template>

<script>
    import Vue from 'vue';
    import DatePicker from "vue2-datepicker";
    import moment from 'moment';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker, Vue},
        props: ['id'],
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PF Opening"});
            this.loadData();


        },
        data() {
            return {
                validated : false,
                effectDate: new Date(),
                pfOpening: {},
                pfStatus: [{text: 'Approved', value: 'Y'}, {text: 'Not Approved', value: 'N'}],
                emp_code: '',
                emp_id: '',
                empName: '',
                department: '',
                departmentId: '',
                designation: '',
                section: '',
                basic: '',
                gpfStatus: '',
                hasgpfId: '',
                show: true,

            }
        },
        computed: {
            showCalculationAmt: function () {
                let basicAmt = this.basic;
                let newPercentage = 0;
                newPercentage = this.pfOpening.new_pf;
                let showCalculationAmt = 0;
                showCalculationAmt = basicAmt * newPercentage / 100;
                if (showCalculationAmt)
                    return showCalculationAmt;
            },

        },
        methods: {
            loadData: function () {
                // let that = this;
                // let permission = this.hasPermission("CAN_OT_ACTUAL_DEPT_HEAD");
                // this.fields.forEach(function (i) {
                //     if (i.key == "action4") {
                //         if (permission)
                //             that.permittedFields.push(i);
                //     }  else {
                //         that.permittedFields.push(i);
                //     }
                // });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/pf-opening/${this.id}`).then(res => {
                    if (res.data.pfOpeningEmployeeInfo[0] && (res.data.pfOpeningEmployeeInfo[0] !== undefined)) {
                        this.emp_code = res.data.pfOpeningEmployeeInfo[0].emp_code;
                        this.pfOpening.emp_id = res.data.pfOpeningEmployeeInfo[0].emp_id;
                        this.empName = res.data.pfOpeningEmployeeInfo[0].emp_name;
                        this.department = res.data.pfOpeningEmployeeInfo[0].department_name;
                        this.designation = res.data.pfOpeningEmployeeInfo[0].designation;
                        this.section = res.data.pfOpeningEmployeeInfo[0].dpt_section;
                        this.basic = res.data.pfOpeningEmployeeInfo[0].basic_amt;
                        this.pfOpening.curr_pf = res.data.pfOpeningEmployeeInfo[0].gpf_pct;
                        this.pfOpening.cpf_gpf_no = res.data.pfOpeningEmployeeInfo[0].gpf_id;
                        this.gpfStatus = res.data.pfOpeningEmployeeInfo[0].gpf_status;
                        this.hasgpfId = res.data.pfOpeningEmployeeInfo[0].gpf_id;
                        this.pfOpening.status = res.data.pfOpeningEmployeeInfo[0].gpf_status;
                        this.departmentId = res.data.pfOpeningEmployeeInfo[0].dpt_department_id;
                        this.validated=true;
                    }

                });
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            onSubmit() {
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/providentFund/pf-store ', this.pfOpening).then(res => {
                    if (res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.$router.push({
                            path: '/search-pf-employee', query: {
                                department: res.data.dpt_department_id
                            }
                        });
                    } else {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });

            },
            exitPfApplication() {
                let department = this.departmentId;
                this.$router.push({path: '/search-pf-employee', query: {department: department}})
            },

        }
    }
</script>

