<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Payment Overview</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-form-input v-model="updateIndex" required id="input-update-index" type="text"
                                          :style="{'display':'none'}"></b-form-input>
                            <b-row>
                                <b-col sm="6">
                                    <b-row class="my-1">
                                        <b-col sm="4">
                                            <label>Voucher Number</label>
                                        </b-col>
                                        <b-col sm="8">
                                            <b-form-select size="sm" v-model="paymnetOverview.searchVoucherNumber"
                                                           :options="voucherList"></b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col sm="6">
                                    <b-row class="my-1">
                                        <b-col lg="4" class="pb-2">
                                            <b-button sm="6" size="sm" variant="dark" type="Submit">Search</b-button>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>
                        </b-form>
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-form-input v-model="updateIndex" required id="input-update-index" type="text"
                                          :style="{'display':'none'}"></b-form-input>
                            <b-row class="my-1">
                                <b-col sm="6">
                                    <fieldset class="border p-1">
                                        <legend class="w-auto" style="font-size:small">Supplier</legend>
                                        <b-row class="my-1">
                                            <b-col sm="4">
                                                <label>Operating Unit</label>
                                            </b-col>
                                            <b-col sm="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.operatingUnit"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Voucher Section</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.voucherSection"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Voucher Number</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.voucherNumber"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Voucher Section</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.voucherSection"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Voucher Number</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.voucherNumber"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Voucher Section</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.voucherSection"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Voucher Number</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.voucherNumber"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Currency</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.currency"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Amount</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.amonut"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.date"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>cleared Amount</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.clearedAmt"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Cleared Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.clearedDate"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Void Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.voidDate"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Voucher Section</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.voucherSection"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Voucher Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.voucherDate"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>

                                    </fieldset>
                                </b-col>
                                <b-col md="6">
                                    <fieldset class="border p-1">
                                        <legend class="w-auto" style="font-size:small">Payee</legend>

                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Supplier Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.supplierName"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Supplier Code</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.supplierCode"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Tax Id</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.taxId"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Address</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.address"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </fieldset>
                                    <fieldset class="border p-1">
                                        <legend class="w-auto" style="font-size:small">Bank Details</legend>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Bank Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.bankName"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Account Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.accountName"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>

                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Branch Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.branchName"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>

                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Payment Document</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.paymentDocument"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row class="my-1">
                                            <b-col md="4">
                                                <label>Payment Method</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input size="sm" v-model="paymnetOverview.paymentMethod"
                                                              disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </fieldset>
                                </b-col>
                            </b-row>

                            <br/>
                            <b-table
                                striped
                                hover
                                show-empty
                                small
                                :items="voucherDetailsItem"
                                :current-page="currentPage"
                                :per-page="perPage"
                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                :fields="voucherDetailsFields"
                                responsive>
                            </b-table>
                        </b-form>
                    </div>
                </b-card-text>
                <hr/>
                <div class="invoice-subtotal pt-50">
                    <div class="row">
                        <div class="col-md-5 col-12"></div>
                        <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                    <span class="invoice-subtotal-title">Total  Amount:</span>
                                    <h6 class="invoice-subtotal-value mb-0">100000</h6>
                                </li>
                                <li class="list-group-item border-0 pb-0">
                                    <b-button
                                        variant="dark"
                                        class="btn btn-primary btn-block subtotal-preview-btn"
                                    >Exit
                                    </b-button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts Payble"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payment Overview"});
        },
        data() {
            return {
                paymnetOverview: {},
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                voucherDetailsFields: [{key: 'num', label: 'Line No', sortable: true, sortDirection: 'desc'},
                    {
                        key: 'voucherNo',
                        label: 'Voucher No',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    {
                        key: 'voucherDate',
                        label: 'Voucher Date',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    {key: 'accountingDate', label: 'Accounting Date'},
                    {
                        key: 'description',
                        label: 'Description',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    {key: 'Amt', label: 'Amount', sortable: true, sortDirection: 'desc', class: 'text-center'}],
                voucherDetailsItem: [
                    {
                        num: '1',
                        voucherNo: 'JV-0123',
                        voucherDate: '01/01/2019',
                        Amt: '100000',
                        accountingDate: '01/01/2019',
                        description: 'Software Paymnet'
                    }]

            }
        },

    }
</script>

