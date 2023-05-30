<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Bank Account Transfer</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body">
                        <fieldset class="border p-2">
                            <legend class="w-auto" style="font-size:small">Bank Account Search</legend>
                            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                <b-form-input
                                    v-model="updateIndex"
                                    required
                                    id="input-update-index"
                                    type="text"
                                    :style="{'display':'none'}"
                                    ></b-form-input>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bank Account Number</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.bankAccountNumber"
                                                        :options="bankAccountNumberList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bank Account Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.bankAccountName"
                                                        :options="BankAccountNameList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bank Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.bankName"
                                                        :options="bankNameList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Account Types</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.accountType"
                                                        :options="accountTypeList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Date From</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <date-picker
                                                        v-model="bankTransfer.fromDate"
                                                        width="100%"
                                                        input-class="form-control"
                                                        type="date"
                                                        lang="en"
                                                        format="YYYY-MM-DD"
                                                        ></date-picker>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Date To</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <date-picker
                                                        v-model="bankTransfer.toDate"
                                                        width="100%"
                                                        input-class="form-control"
                                                        type="date"
                                                        lang="en"
                                                        format="YYYY-MM-DD"
                                                        ></date-picker>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Status</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.status"
                                                        :options="statusList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col class="d-flex justify-content-start">
                                        <b-button
                                            md="6"
                                            size="md"
                                            variant="dark mr-1"
                                            type="submit"
                                            >Search</b-button>&nbsp;
                                        <b-button md="6" size="md" variant="dark mr-1" type="submit">Clear</b-button>&nbsp;
                                    </b-col>
                                    <b-col class="d-flex justify-content-end">
                                        <b-button
                                            md="6"
                                            size="md"
                                            variant="dark"
                                            type="submit"
                                            v-on:click="isHiddenn = !isHiddenn"
                                            >Create New</b-button>&nbsp;
                                    </b-col>
                                </b-row>
                            </b-form>
                        </fieldset>
                        <!--section id="basic-datatable" v-if="isHiddenn"-->
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-form-input
                                v-model="updateIndex"
                                required
                                id="input-update-index"
                                type="text"
                                :style="{'display':'none'}"
                                ></b-form-input>

                            <fieldset class="border p-2">
                                <legend class="w-auto" style="font-size:small">Transaction Information</legend>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Transfer Date</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <date-picker
                                                        v-model="bankTransfer.transferDate"
                                                        width="100%"
                                                        input-class="form-control"
                                                        type="date"
                                                        lang="en"
                                                        format="YYYY-MM-DD"
                                                        ></date-picker>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Transfer Amount</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="bankTransfer.transferAmt"
                                                        required
                                                        placeholder="Transfer Amount"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Event No</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="bankTransfer.eventNo"
                                                        required
                                                        placeholder="Event No"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Currency</label>
                                                </b-col>
                                                <b-col md="8">
                                                   <b-form-select
                                                        v-model="bankTransfer.currency"
                                                        :options="currencyList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </fieldset>
                            <fieldset class="border p-2">
                                <legend class="w-auto" style="font-size:small">Transfer Bank Related Information</legend>
                                <b-row>
                                    <b-col md="6">
                                        <p class="font-weight-normal">Source Bank Account</p>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bank Account Number</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="bankTransfer.srcBankAcountNumber"
                                                        required
                                                        placeholder="Bank Account Number"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bank Account Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="bankTransfer.srcBankAccountName"
                                                        required
                                                        placeholder="Bank Account Name"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bank Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.srcBankName"
                                                        :options="bankNameList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Branch Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.srcBranchName"
                                                        :options="bankBranchList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Account Types</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.srcaccountType"
                                                        :options="accountTypeList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <p class="font-weight-normal">Destination Bank Account</p>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bank Account Number</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="bankTransfer.destBankAccountNumber"
                                                        required
                                                        placeholder="Bank Account Number"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bank Account Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="bankTransfer.destBankAccountName"
                                                        required
                                                        placeholder="Bank Account Name"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bank Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.destBankName"
                                                        :options="bankNameList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Branch Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.destBankBranchName"
                                                        :options="bankBranchList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Account Types</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="bankTransfer.destAccountType"
                                                        :options="accountTypeList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="2">
                                        <label>Transfer Reason</label>
                                    </b-col>
                                    <b-col md="10">
                                        <b-form-input
                                            v-model="bankTransfer.transferReason"
                                            required
                                            placeholder="Transfer Reason"
                                            ></b-form-input>
                                    </b-col>
                                </b-row>
                            </fieldset>
                            <br />
                            <b-row>
                                <b-col class="d-flex justify-content-end">
                                    <b-button md="6" size="md" variant="dark" type="submit">Approved & Forward</b-button>&nbsp;
                                    <b-button md="6" size="md" variant="dark" type="submit">Save</b-button>
                                </b-col>
                            </b-row>
                        </b-form>
                        <!--/section-->
                    </div>
                </b-card-text>
            </b-card>
        </div>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    export default {
        components: {DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Cash Management"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Bank Transfer"});
        },
        data() {
            return {
                bankTransfer: {},
                show: true,
                updateIndex: -1,
                submitBtn: "Save",
                accountTypeList: [{text: "Current Account", value: "CA"},
                    {text: "STD Account", value: "STDA"}],
                bankBranchList: [{text: "Agrabad", value: "01"},
                    {text: "GEC", value: "02"},{text: "Bandor", value: "03"}],
                bankNameList:[{text: "NRBC Global Bank", value: "01"},
                    {text: "Dutch Bangla Bank", value: "02"},{text: "Agrani Bank", value: "03"}],
                currencyList:[{text: "USD", value: "01"},
                    {text: "BDT", value: "02"}],
                statusList:[{text: "Active", value: "01"},
                    {text: "Inactive", value: "02"}],
                bankAccountNumberList:[{text: "10001-001-123654", value: "10001-001-123654"},
                    {text: "10001-001-123655", value: "10001-001-123655"}],
                BankAccountNameList:[{text: "CPA Salary", value: "001"},
                    {text: "CPA Supplier Payment", value: "002"}]
            };
        },

        methods: {
            onSubmit(evt) {
            },
            onReset(evt) {
                evt.preventDefault();
                this.employee_id = "";
                this.department_name = "";
                this.designation = "";
                this.division_name = null;
                this.financial_code = null;
                this.shift = null;
                this.updateIndex = -1;
                this.submitBtn = "Save";
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(i, code) {
                this.submitBtn = "Update";
                this.updateIndex = i;
                let data = this.tableData.items[i];
                console.log(data);
                this.form.employee_id = data.employee_id;
                this.form.department_name = data.department_name;
                this.form.designation = data.designation;
                this.form.division_name = data.division_name;
                this.form.financial_code = data.financial_code;
                this.form.shift = data.shift;
                console.log(this.form);
            },
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }
        }
    };
</script>

