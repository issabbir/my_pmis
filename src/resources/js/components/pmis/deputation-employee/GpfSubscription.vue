<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked  pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0">
                        <b-card title="GPF Summary">
                            <b-card-body class="border">
                                <b-row>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="GPF ID"
                                            label-for="gpf_id"
                                        >
                                            <b-form-input v-model="listItems.gpf_id" readonly id="gpf_id"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="Pay Scale"
                                            label-for="pay_scale"
                                        >
                                            <b-form-input v-model="listItems.pay_scale" readonly id="pay_scale" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="Basic"
                                            label-for="basic_amt"
                                        >
                                            <b-form-input v-model="listItems.basic_amt" readonly id="basic_amt" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="GPF Opening"
                                            label-for="opening"
                                        >
                                            <b-form-input v-model="listItems.opening" readonly id="opening" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="GPF Subscription"
                                            label-for="GPF-Subscription"
                                        >
                                            <b-form-input v-model="listItems.gpf_subscription" readonly id="GPF-Subscription" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="GPF Interest"
                                            label-for="gpf_interest"
                                        >
                                            <b-form-input v-model="listItems.gpf_interest" readonly id="gpf_interest" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="Loan Amount"
                                            label-for="loan"
                                        >
                                            <b-form-input v-model="listItems.loan" readonly id="loan" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="Loan Repay Amount"
                                            label-for="loan_repay"
                                        >
                                            <b-form-input v-model="listItems.loan_repay_amount" readonly id="loan_repay" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="PF Balance"
                                            label-for="pf_balance"
                                        >
                                            <b-form-input v-model="listItems.pf_balance" readonly id="pf_balance" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="Total Installment"
                                            label-for="installment_number"
                                        >
                                            <b-form-input v-model="listItems.total_installment" readonly id="installment_number" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="Total Paid Installment"
                                            label-for="paid_installment"
                                        >
                                            <b-form-input v-model="listItems.total_paid_installment" readonly id="paid_installment" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6" xl="4" >
                                        <b-form-group
                                            label-cols-sm="4"
                                            label-cols-lg="4"
                                            label="Loan Balance"
                                            label-for="loan_balance"
                                        >
                                            <b-form-input v-model="listItems.loan_balance" readonly id="loan_balance" class="text-right"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker'
    import SideBar from "../partials/sidebar";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        props: ['id'],
        components: {DatePicker, SideBar, Datatable},
        data() {
            return {
                listItems:{
                    opening:'',
                    gpf_subscription: '',
                    gpf_interest: '',
                    loan: '',
                    loan_repay_amount: '',
                    pf_balance: '',
                    total_installment: '',
                    total_paid_installment: '',
                    loan_balance: '',
                    gpf_id:'',
                    basic_amt:'',
                    pay_scale:''
                },

            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "GPF Subscription"});
            this.loadData(this.id);
        },
        watch: {
        },
        methods: {
            loadData(empId){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/gpf-subscription/${empId}`).then(result => {
                    this.listItems = result.data.gpf_summary_data;
                }).catch(err=>{
                    console.log(err)
                })
            }
        }
    }
</script>
