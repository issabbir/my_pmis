<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Supplier Creation</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body">
                        <fieldset class="border p-2">
                            <legend class="w-auto" style="font-size:small">Supplier Search</legend>
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
                                                    <label>Supplier Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="supplierEntry.searchSupplierName"
                                                        :options="supplierList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Supplier Number</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.searchSupplierNo"
                                                        required
                                                        placeholder="Supplier Number"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Tax Registration Number</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="supplierEntry.searchTaxRegistrationNumber"
                                                        :options="taxRegistrationNoList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Employee Number</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.empNumber"
                                                        required
                                                        placeholder="Employee Number"
                                                        ></b-form-input>
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
                                <legend class="w-auto" style="font-size:small">New Supplier Entry</legend>
                                <b-row>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Supplier Name</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.supplierName"
                                                        required
                                                        placeholder="Supplier Name"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Supplier Number</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.supplierNo"
                                                        required
                                                        placeholder="Supplier Number"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Alternative Supplier</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.alternativeSupplier"
                                                        required
                                                        placeholder="Alternative Supplier"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Inactive Date</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <date-picker
                                                        v-model="supplierEntry.incativeDate"
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
                                                    <label>Supplier Type</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="supplierEntry.supplierType"
                                                        :options="supplierTypeList"
                                                        ></b-form-select>
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
                                                        v-model="supplierEntry.taxRegistrationNumber"
                                                        required
                                                        placeholder="Tax Registration Number"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Employee Number</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.employeeNumber1"
                                                        required
                                                        placeholder="Employee Number"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Hold For Payment</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-checkbox-group
                                                        v-model="supplierEntry.holdForPaymnet"
                                                        :options="paymentHold"
                                                        stacked
                                                        ></b-form-checkbox-group>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Tax & Vat</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-checkbox
                                                        v-model="supplierEntry.allowTaxVat"
                                                        value="Y"
                                                        unchecked-value="N"
                                                        >Allow Withholding Tax</b-form-checkbox>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Attachment</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-file v-model="supplierEntry.attachmnet" :state="Boolean(file)"></b-form-file>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </fieldset>
                            <fieldset class="border p-2">
                                <legend class="w-auto" style="font-size:small">Address</legend>
                                <p class="font-weight-normal">Mailing Address</p>
                                <b-row>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Country</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="supplierEntry.mailingCountry"
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
                                                    <b-form-select
                                                        v-model="supplierEntry.mailingCity"
                                                        :options="cityList"
                                                        ></b-form-select>
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
                                                        v-model="supplierEntry.mailingstate"
                                                        required
                                                        placeholder="State/Province"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Postal Code</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.mailingCode"
                                                        required
                                                        placeholder="Postal Code"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Address Line 1</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.mailingaddressLine1"
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
                                                        v-model="supplierEntry.mailingaddressLine2"
                                                        required
                                                        placeholder="Address Line 2"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Address Line 3</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.mailingaddressLine3"
                                                        required
                                                        placeholder="Address Line 3"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Cell Number</label>
                                                </b-col>
                                                 <b-col md="3">
                                                    <b-form-select
                                                        v-model="supplierEntry.mailingCellNumberCC"
                                                        :options="CCList"
                                                        ></b-form-select>
                                                </b-col>
                                                <b-col md="5">
                                                    <b-form-input
                                                        v-model="supplierEntry.mailingCellNumber"
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
                                                        v-model="supplierEntry.mailingPhone"
                                                        required
                                                        placeholder="Phone"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Email</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.email"
                                                        required
                                                        placeholder="Email"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <hr />
                                <p class="font-weight-normal">Permanent Address</p>
                                <b-row>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Country</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="supplierEntry.permanentCountry"
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
                                                    <b-form-select
                                                        v-model="supplierEntry.permanentCity"
                                                        :options="cityList"
                                                        ></b-form-select>
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
                                                        v-model="supplierEntry.permanentstate"
                                                        required
                                                        placeholder="State/Province"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Postal Code</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.permanentCode"
                                                        required
                                                        placeholder="Postal Code"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Address Line 1</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.permanentaddressLine1"
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
                                                        v-model="supplierEntry.permanentaddressLine2"
                                                        required
                                                        placeholder="Address Line 2"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Address Line 3</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.permanentaddressLine3"
                                                        required
                                                        placeholder="Address Line 3"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Cell Number</label>
                                                </b-col>
                                                <b-col md="3">
                                                    <b-form-select
                                                        v-model="supplierEntry.permanentCellNumberCC"
                                                        :options="CCList"
                                                        ></b-form-select>
                                                </b-col>
                                                <b-col md="5">
                                                    <b-form-input
                                                        v-model="supplierEntry.permanentCellNumber"
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
                                                        v-model="supplierEntry.permanentPhone"
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
                                <legend class="w-auto" style="font-size:small">Bills & Payment Method</legend>
                                <b-row>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Voucher Currency</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="supplierEntry.voucherCurency"
                                                        :options="voucherCurencyList"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Voucher Amount Limit</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        v-model="supplierEntry.voucherAmtLimit"
                                                        required
                                                        placeholder="Voucher Amount Limit"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Voucher Match Option</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="supplierEntry.voucherMatchOption"
                                                        :options="voucherMatchOptions"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Voucher Amount Limit</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-select
                                                        v-model="supplierEntry.voucherAmountLimit"
                                                        :options="voucherAmountLimitOptios"
                                                        ></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Payment Purpose</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-checkbox-group
                                                        v-model="supplierEntry.paymentPurpose"
                                                        :options="paymentPurposeOptions"
                                                        stacked
                                                        ></b-form-checkbox-group>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Paymnet Method</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-checkbox-group
                                                        v-model="supplierEntry.paymentMethod"
                                                        :options="paymentMethodOptions"
                                                        stacked
                                                        ></b-form-checkbox-group>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </fieldset>
                            <br />
                            <b-row>
                                <b-col class="d-flex justify-content-end">
                                    <b-button md="6" size="md" variant="dark" type="submit">Save</b-button>&nbsp;
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
    this.$store.commit("setBreadcrumb", {link: "#", label: "Suppliers & Customers"});
    this.$store.commit("setBreadcrumb", {link: "#", label: "Supplier Entry"});
    },
            data() {
    return {
    supplierEntry: {},
            show: true,
            updateIndex: - 1,
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
            supplierList: [{text: "", value: ""}],
            taxRegistrationNoList: [{text: "", value: ""}],
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
            CCList:[{text: "880", value: "880"},
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

