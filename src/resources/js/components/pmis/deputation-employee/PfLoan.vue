<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked  pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0">
                        <b-card title="PF Loan">
                            <b-card-body class="border">
                                <b-form @submit="onSubmit" @reset="onReset">
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group
                                                label="PF ID"
                                                label-for="pf_id"
                                            >
                                                <b-form-input
                                                    id="gpf_id"
                                                    v-model="pfloan.gpf_id"
                                                    type="text"
                                                    disabled
                                                    placeholder="PF ID"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="PF Type"
                                                label-for="pf_type"
                                            >
                                                <b-form-input
                                                    id="pf_type"
                                                    v-model="pfloan.loan_name"
                                                    type="text"
                                                    disabled
                                                    placeholder="PF Type"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Current Basic"
                                                label-for="current_basic"
                                            >
                                                <b-form-input
                                                    id="medical_id"
                                                    v-model="pfloan.basic_amt"
                                                    type="text"
                                                    disabled
                                                    class="text-right"
                                                    placeholder="Current Basic"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Monthly Contribution"
                                                label-for="monthly_contribution"
                                            >
                                                <b-form-input
                                                    id="monthly_contribution"
                                                    v-model="pfloan.monthly_contribution"
                                                    type="text"
                                                    disabled
                                                    class="text-right"
                                                    placeholder="25% Monthly Contribution"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Total Loan Amount"
                                                label-for="total_loan_amount"
                                            >
                                                <b-form-input
                                                    id="total_loan_amount"
                                                    v-model="pfloan.application_amt"
                                                    type="text"
                                                    disabled
                                                    class="text-right"
                                                    placeholder="Total Loan Amount"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Monthly Deduction"
                                                label-for="monthly_deduction"
                                            >
                                                <b-form-input
                                                    id="monthly_deduction"
                                                    v-model="pfloan.monthly_deduction"
                                                    type="text"
                                                    disabled
                                                    class="text-right"
                                                    placeholder="Monthly Deduction"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Loan Outstanding"
                                                label-for="loan_outstanding"
                                            >
                                                <b-form-input
                                                    id="loan_outstanding"
                                                    v-model="pfloan.loan_outstanding"
                                                    type="text"
                                                    class="text-right"
                                                    disabled
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Loan Tenure (Month)"
                                                label-for="loan_tenure"
                                            >
                                                <b-form-input
                                                    id="loan_tenure"
                                                    v-model="pfloan.loan_tenure_month"
                                                    type="text"
                                                    disabled
                                                    placeholder="Loan Tenure(Month)"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Remain of Tenure (Month)"
                                                label-for="remain_of_tenure"
                                            >
                                                <b-form-input
                                                    id="remain_of_tenure"
                                                    v-model="pfloan.remain_of_tenure"
                                                    type="text"
                                                    disabled
                                                    placeholder="Remain of Tenure"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>

    import SideBar from "../partials/sidebar";
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        components: {  SideBar},
        props: ['id'],
        data() {
            return {
                pfloan: {
                    gpf_id: '',
                    loan_name: '',
                    basic_amt: '',
                    application_amt: '',
                    loan_outstanding: '',
                    loan_tenure_month: '',
                    monthly_contribution: '',
                    monthly_deduction: '',
                    remain_of_tenure: ''
                },
                show: true
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PF Loan"});
            this.loadData();
        },
        methods: {
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            loadData: function () {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/pf-loans/specific/${this.id}`).then(res => {
                        console.log(res.data.pf_loan_data);
                        this.pfloan = res.data.pf_loan_data;
                    });
                }
            },
            onSubmit() {

            },
            onReset(evt) {

            }
        }
    }
</script>
