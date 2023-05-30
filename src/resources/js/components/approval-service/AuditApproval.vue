<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Audit Approval</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-row>
                                <b-col>
                                    <b-form-group
                                            label="Pension no."
                                            label-for="pension_no"
                                    >

                                        <b-form-input
                                                id="retirement_allowance_decreases"
                                                v-model="auditApproval.pension_no"
                                                placeholder="Retirement allowance decreases"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            label="Date"
                                            label-for="date"
                                    >

                                        <date-picker
                                                v-model="auditApproval.date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                format="YYYY-MM-DD"></date-picker>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="5">
                                    <b-form-group
                                            label="In ex. for the first half of the total retirmnt. allowance wholesale gratuity (BDT)"
                                            label-for="wholesale_gratuity"
                                    >

                                        <b-form-input
                                                id="wholesale_gratuity"
                                                v-model="auditApproval.wholesale_gratuity"
                                                placeholder="Wholesale gratuity"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                            label="Net monthly retirmnt. amt to the second half (BDT)"
                                            label-for="net_monthly_retirement_amounts_second half"
                                    >

                                        <b-form-input
                                                id="retirement_allowance_decreases"
                                                v-model="auditApproval.net_monthly_retirement_amounts_second"
                                                placeholder="Net monthly retirement amounts to the second half (BDT)"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                            label="Wholesale gratuity for the second half (BDT)"
                                            label-for="wholesale_gratuity_secound_half"
                                    >
                                        <b-form-input
                                                id="wholesale_gratuity_secound_half"
                                                v-model="auditApproval.wholesale_gratuity_secound_half"
                                                placeholder="Wholesale gratuity for the second half (BDT)"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                            label="Bank Branch"
                                            label-for="bank_branch"
                                    >

                                        <b-form-input
                                                id="bank_branch"
                                                v-model="auditApproval.bank_branch"
                                                placeholder="Bank Branch"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            label="Bank Address"
                                            label-for="bank_address"
                                    >
                                        <b-form-textarea
                                                id="bank_address"
                                                v-model="auditApproval.bank_address"
                                                placeholder="Bank Address"
                                                rows="3"
                                                max-rows="6"
                                        ></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group label="Account Type" label-for="account_type">
                                        <b-form-select v-model="auditApproval.accountType" class="">
                                            <option value="2">Current Account</option>
                                            <option value="1">Savings Account</option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Account No" label-for="account_no">
                                        <b-form-input
                                                id="account_no"
                                                v-model="auditApproval.accountNo"
                                                type="text"
                                                required
                                                placeholder="Account no"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            label="PPO no"
                                            label-for="ppo_no"
                                    >

                                        <b-form-input
                                                id="ppo_no"
                                                v-model="auditApproval.ppo_no"
                                                placeholder="PPO no"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            label="PPO Date"
                                            label-for="ppo_date"
                                    >

                                        <date-picker
                                                v-model="auditApproval.ppo_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                format="YYYY-MM-DD"></date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            label="Approval Date"
                                            label-for="approval_date"
                                    >

                                        <date-picker
                                                v-model="auditApproval.approval_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                format="YYYY-MM-DD"></date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            label="Approved by"
                                            label-for="approved_by"
                                    >

                                        <b-form-input
                                                id="approved_by"
                                                v-model="auditApproval.approved_by"
                                                placeholder="Approved by"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                    <b-button type="submit" id="basic_sub_btn"
                                              class="btn btn-dark shadow mr-1 mb-1">Submit
                                    </b-button>
                                    <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">
                                        Cancel
                                    </b-button>
                                </div>
                            </b-row>
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>
            <!-- Zero configuration table -->
            <section id="basic-datatable">
                <b-row >
                    <b-col >
                        <b-card class="card">
                            <div class="card-content">
                                <b-card-text class="card-body">
                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" >
                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item.holiday_id)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                        </template>
                                    </Datatable>
                                </b-card-text>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </section>
            <!--/ Zero configuration table -->
        </div>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import Repo from '../../Repository/ApiRepository';

    export default {
        components: {DatePicker, Datatable},
        props: ['id'],
        data() {
            return {
                auditApproval: {},
                employeeTitleList: [
                    {text: 'MR.', value: 'MR.'},
                    {text: 'MRS.', value: 'MRS.'}
                ],
                options: [
                    {text: 'Male', value: ''},
                    {text: 'Female', value: 'second'},
                    {text: 'Other', value: 'third'}
                ],

                tableData: {
                    fields: [{key:'id', label: 'ID', sortable:true}, {key:'name', label: 'Name', sortable:true}, {key:'last_designation', label: 'Last designation', sortable:true}, {key:'last_department', label: 'Last department', sortable:true}, 'Action'],
                    items:[
                        {
                            id: 1,
                            name: 'Mrs. Anita Prova Chowdhury',
                            last_designation: 'Metron',
                            last_department: 'Medical department',
                        }
                    ]
                },
                show: true
            }
        },
        mounted() {
            /*Repo.callApi(Repo.GET_COMMAND, "/pmis/employee/basic-info").then(res => {
                let i = {};
                let id = this.$route.params.id;
                res.forEach(function(item) {
                    if (item.empId == id)
                        i = item;
                });
                this.prlApplication = i;
            });*/
            console.log(this.auditApproval);
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval Service"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Audit Approval"});
        },
        methods: {
            onSubmit(evt) {
                let id = this.$route.params.id;
                let pimaryKey = "";
                let pimaryValue = ""
                if (id) {
                    pimaryKey = "empId";
                    pimaryValue = id;
                }
                evt.preventDefault();
                /*Repo.callApi(Repo.POST_COMMAND, "/pmis/employee/basic-info", this.prlApplication, pimaryKey, pimaryValue).then(res => {
                    console.log(res.data);
                });*/
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