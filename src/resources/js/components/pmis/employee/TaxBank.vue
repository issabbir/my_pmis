
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

                            <b-card title="Tax Bank">
                                <b-row>
                                    <b-col md="1">
                                        <b-form-group
                                            label="GRADE"
                                            label-for="GRADE"
                                        >
                                            <div>
                                                <span class="info">A</span>
                                            </div>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="1">
                                        <b-form-group
                                            label="PAY SCALE"
                                            label-for="pay_scale"
                                        >
                                            <div>
                                                <span class="info">5th</span>
                                            </div>

                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col  md="4">
                                        <b-form-group
                                            label="BANK NAME"
                                            label-for="bank_name"
                                        >
                                            <b-form-select
                                                v-model="taxBank.bank"
                                                :options="e_bank"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col  md="4">
                                        <b-form-group
                                            label="BANK BRANCH"
                                            label-for="bank_branch"
                                        >
                                            <b-form-input
                                                id="bank_branch"
                                                v-model="taxBank.bankBranch"
                                                type="text"
                                                required
                                                placeholder="Bank Branch"

                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col  md="4">
                                        <b-form-group
                                            label="ACCOUNT NO"
                                            label-for="account_no"
                                        >
                                            <b-form-input
                                                id="account_no"
                                                v-model="taxBank.accountNo"
                                                type="text"
                                                required
                                                placeholder="Account No"

                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col  md="12">
                                        <b-form-group
                                            label="TAX PAYABLE"
                                            label-for="tax_payable"
                                        >
                                            <b-form-radio-group
                                                v-model="taxBank.taxPayable"
                                                :options="e_tax_payable"
                                                plain
                                                name="plain-inline"
                                            >
                                            </b-form-radio-group>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row v-if="taxBank.taxPayable" >
                                    <b-col md="3">
                                        <b-form-group
                                            label="Tin No"
                                            label-for="tin_no"
                                        >
                                            <b-form-input
                                                id="tin_no"
                                                v-model="taxBank.tinNo"
                                                type="text"
                                                required
                                                placeholder="Tin No"
                                            ></b-form-input>

                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="TAX PAYERS ADDRESS"
                                            label-for="tax_payers_address"
                                        >
                                            <b-form-select
                                                v-model="taxBank.taxPayersAddress"
                                                :options="e_tax_payers_address"
                                                class=""
                                                value-field="value"
                                                text-field="text"
                                                disabled-field="notEnabled"
                                            ></b-form-select>

                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="TAX PAYERS CONTACT NO"
                                            label-for="tax_payers_contact_no"
                                        >
                                            <b-form-input
                                                id="tax_payers_contact_no"
                                                v-model="taxBank.taxPayersContactNo"
                                                type="text"
                                                required
                                                placeholder="Tax payers contact No"
                                            ></b-form-input>

                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3">
                                        <b-form-group
                                            label="TAX PAYERS EMAIL ID"
                                            label-for="tax_payer_email_id"
                                        >
                                            <b-form-input
                                                id="tax_payer_email_id"
                                                v-model="taxBank.taxPayerEmailId"
                                                type="text"
                                                required
                                                placeholder="Tax Payer Email ID"
                                            ></b-form-input>

                                        </b-form-group>
                                    </b-col>
                                </b-row>
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

    import DatePicker from 'vue2-datepicker'
    import Header from "../../../layouts/pmis/partials/Header";
    import SideBar from "../partials/sidebar";

    export default {
        components: {Header, DatePicker,SideBar },
        props: ['id'],
        data() {
            return {
                taxBank: {
                    taxPayable:  false,
                    tinNo:  '',
                    taxPayersAddress:  '',
                    taxPayersContactNo:  '',
                    taxPayerEmailId:  '',
                 },

                 e_tax_payable: [
                    { value: true, text: 'Yes', },
                    { value: false, text: 'No',},
                ],
                tax_payers_address: 'A',
                e_tax_payers_address: [
                    { value: 'A', text: 'A' },
                    { value: 'B', text: 'Option B' },
                    { value: 'D', text: 'Option C', notEnabled: true },
                    { value: { d: 1 }, text: 'Option D' }
                ],
                bank:'Agrani Bank Limited',
                e_bank: [
                    { value: 'Agrani Bank Limited', text: 'Agrani Bank Limited' },
                    { value: 'Bank Asia Limited', text: 'Bank Asia Limited' }
                ],
                text: '',
                show: true,
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Tax Bank"});
         },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                console.log(JSON.parse(JSON.stringify(this.taxBank)))
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.taxBank.tinNo = '';
                this.taxBank.taxPayersAddress='';
                this.taxBank.taxPayersContactNo='';
                this.taxBank.taxPayerEmailId='';
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
