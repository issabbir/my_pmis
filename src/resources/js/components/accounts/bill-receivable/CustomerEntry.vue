<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Customer Creation</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body">
                        <fieldset class="border p-2">
                            <legend class="w-auto" style="font-size:small">Customer Search</legend>
                            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                <b-form-input
                                    v-model="updateIndex"
                                    required
                                    id="input-update-index"
                                    type="text"
                                    :style="{'display':'none'}"
                                    ></b-form-input>
                                <b-row>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Customer Types</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="CustomerEntry.customerType"
                                                        :options="customerTypeList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Customer Code</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="CustomerEntry.customerCode"
                                                        :options="operatinUnitList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Customer Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="CustomerEntry.customerName"
                                                        required
                                                        placeholder="Customer Name"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Tax Registration Number</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="CustomerEntry.taxRegistrationNumber"
                                                        required
                                                        placeholder="Tax Registration Number"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Customer Category</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model=" CustomerEntry.customerCategory"
                                                        :options="customerCategoryList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Customer Class</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model=" CustomerEntry.customerClass"
                                                        :options="customerClassList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Account Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="CustomerEntry.poNumber"
                                                        required
                                                        placeholder="Account Name"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Account Description</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="CustomerEntry.poNumber"
                                                        required
                                                        placeholder="Account Description"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Country</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select v-model="CustomerEntry.country" :options="countryList"></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>City</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select v-model="CustomerEntry.city" :options="cityList"></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Address</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="CustomerEntry.poNumber"
                                                        required
                                                        placeholder="Address"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Status</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select v-model="CustomerEntry.status" :options="statusType"></b-form-select>
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
                                            v-on:click="isHidden = !isHidden"
                                            >Search</b-button>&nbsp;
                                        <b-button md="6" size="md" variant="dark mr-1" type="submit">Clear</b-button>&nbsp;
                                    </b-col>
                                     <b-col class="d-flex justify-content-end">
                                        <b-button
                                            md="6"
                                            size="md"
                                            variant="dark"
                                            type="reset"
                                            v-on:click="isHidden = !isHidden"
                                            >Create New</b-button>&nbsp;
                                    </b-col>
                                </b-row>
                            </b-form>
                        </fieldset>
                        <section id="basic-datatable" v-if="isHidden">
                            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                <b-form-input
                                    v-model="updateIndex"
                                    required
                                    id="input-update-index"
                                    type="text"
                                    :style="{'display':'none'}"
                                    ></b-form-input>

                                <fieldset class="border p-2">
                                    <legend class="w-auto" style="font-size:small">New Customer Entry</legend>
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Customer Name</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model="CustomerEntry.supplierName"
                                                            required
                                                            placeholder="Customer Name"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Allas</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model="CustomerEntry.supplierNo"
                                                            required
                                                            placeholder="Allas"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>License Valid Date</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <date-picker
                                                            v-model="CustomerEntry.LCValidDate"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD"
                                                            ></date-picker>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Tax Registration Number</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model="CustomerEntry.alternativeSupplier"
                                                            required
                                                            placeholder="Tax Registration Number"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Customer Category</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-select
                                                            v-model=" CustomerEntry.customerCategory"
                                                            :options="customerCategoryList"
                                                            ></b-form-select>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Customer Class</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-select
                                                            v-model=" CustomerEntry.supplierType"
                                                            :options="supplierTypeList"
                                                            ></b-form-select>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>License Number</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.taxRegistrationNumber"
                                                            required
                                                            placeholder="License Number"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <hr />
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Account Type</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-select
                                                            v-model=" CustomerEntry.accountType"
                                                            :options="accountTypeLIst"
                                                            ></b-form-select>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Account Name</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.accountName"
                                                            required
                                                            placeholder="Account Name"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Account Description</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.taxRegistrationNumber"
                                                            required
                                                            placeholder="Account Description"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Reference</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.taxRegistrationNumber"
                                                            required
                                                            placeholder="Reference"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Status</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-select
                                                            v-model=" CustomerEntry.accountStatus"
                                                            :options="accountStatusType"
                                                            ></b-form-select>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                                <fieldset class="border p-2">
                                    <legend class="w-auto" style="font-size:small">Customer Site(Primary)</legend>
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Country</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-select
                                                            v-model=" CustomerEntry.mailingCountry"
                                                            :options="countryList"
                                                            ></b-form-select>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>City</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-select v-model="CustomerEntry.city" :options="cityList"></b-form-select>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>State/Province</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.mailingstate"
                                                            required
                                                            placeholder="State/Province"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Postal Code</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.mailingCode"
                                                            required
                                                            placeholder="Postal Code"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Address Line 1</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.mailingaddressLine1"
                                                            required
                                                            placeholder="Address Line 1"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Address Line 2</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.mailingaddressLine2"
                                                            required
                                                            placeholder="Address Line 2"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Address Line 3</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.mailingaddressLine3"
                                                            required
                                                            placeholder="Address Line 3"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Cell Number</label>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-select
                                                            v-model="CustomerEntry.primaryCC"
                                                            :options="CCList"
                                                            ></b-form-select>
                                                    </b-col>
                                                    <b-col md="5">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.mailingCellNumber"
                                                            required
                                                            placeholder="Cell Number"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Phone</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.mailingPhone"
                                                            required
                                                            placeholder="Phone"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                                <fieldset class="border p-2">
                                    <legend class="w-auto" style="font-size:small">Bill To Location</legend>
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Bill To Location</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-radio
                                                            v-model="CustomerEntry.allowTaxVat"
                                                            value="Y"
                                                            unchecked-value="N"
                                                            >Billing Site Same As Primary Site</b-form-radio>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Receipt Terms</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input
                                                            v-model=" CustomerEntry.receiptTerms"
                                                            required
                                                            placeholder="Receipt Terms"
                                                            ></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                                <br />
                                <b-row>
                                    <b-col class="d-flex justify-content-end">
                                        <b-button md="6" size="md" variant="dark" type="submit">Save</b-button>
                                    </b-col>
                                </b-row>
                            </b-form>
                        </section>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Suppliers & Customers"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Customer Entry"});
        },
        data() {
            return {
                CustomerEntry: {},
                show: true,
                updateIndex: -1,
                submitBtn: "Save",
                paymentHold: [
                    {text: "All Invoice", value: "All Invoice"},
                    {text: "Unmatched Invoice", value: "Unmatched Invoice"},
                    {text: "Invalided Invoice", value: "Invalided Invoice"}
                ],
                paymentPurposeOptions: [
                    {text: "Purchasing", value: "Purchasing"},
                    {text: "Payment", value: "Payment"},
                    {text: "RFQ Only", value: "RFQ Only"}
                ],
                paymentMethodOptions: [
                    {text: "Bill Payble", value: "Bill Payble"},
                    {text: "Electronic", value: "Electronic"},
                    {text: "Cheque", value: "Cheque"}
                ],
                voucherCurencyList: [
                    {text: "BDT", value: "BDT"},
                    {text: "USD", value: "USD"}
                ],
                voucherMatchOptions: [
                    {text: "PO", value: "PO"},
                    {text: "Receipt", value: "Receipt"}
                ],
                voucherAmountLimitOptios: [{text: "Immediate", value: "Immediate"}],

                countryList: [{text: "Bangladesh", value: "1"},
                    {text: "China", value: "2"},
                    {text: "India", value: "3"},
                    {text: "Pakistan", value: "4"}, ],
                cityList: [{text: "Dhaka", value: "1"},
                    {text: "Chittagong", value: "2"},
                    {text: "Rajshahi", value: "1 "},
                    {text: "Hong Kong", value: "1 "},
                    {text: "Macau", value: "1 "},
                    {text: "Beijing", value: "1 "},
                ],
                CCList: [{text: "880", value: "880"},
                    {text: "86", value: "86"},
                    {text: "91", value: "91"}]
            
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

