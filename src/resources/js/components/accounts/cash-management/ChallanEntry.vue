<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Challan/Pay Order Entry</h4>
                            <div class="mt-2 d-flex justify-content-end">
                                <b-button
                                    lg="6"
                                    size="md"
                                    variant="dark"
                                    type="submit"
                                    href="/accounts/#/challan-entry-search"
                                    >
                                    <i class="bx bx-search cursor-pointer"></i> Search
                                </b-button>
                            </div>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input
                                        v-model="updateIndex"
                                        required
                                        id="input-update-index"
                                        type="text"
                                        :style="{'display':'none'}"
                                        ></b-form-input>

                                    <b-row>
                                        <b-col>
                                            <b-row>
                                                <b-col lg="6">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Challan No</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.ChallanNo"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Challan No"
                                                                ></b-form-input>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Party Code</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <multiselect
                                                                v-model="form.PartyCode"
                                                                :options="partycodelist"
                                                                :custom-label="nameWithLang"
                                                                placeholder="Select one"
                                                                label="text"
                                                                track-by="name"
                                                                ></multiselect>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>PO/contract No</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <b-form-input
                                                                v-model="form.PONo"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Optional"
                                                                ></b-form-input>
                                                        </div>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Challan Amount</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <b-form-input
                                                                v-model="form.ChallanAmount"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Challan Amount"
                                                                ></b-form-input>
                                                        </div>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Approval Status</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <multiselect
                                                                v-model="form.ApprovalStatus"
                                                                :options="approvalstatus"
                                                                :custom-label="nameWithLang"
                                                                placeholder="Select one"
                                                                label="text"
                                                                track-by="name"
                                                                ></multiselect>
                                                        </div>
                                                    </b-row>
                                                </b-col>
                                                <b-col lg="6">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Challan Date</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <date-picker
                                                                v-model="form.ChallanDate"
                                                                width="100%"
                                                                input-class="form-control"
                                                                type="date"
                                                                lang="en"
                                                                format="YYYY-MM-DD"
                                                                ></date-picker>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Party Name</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <multiselect
                                                                v-model="form.PartyName"
                                                                :options="partynamelist"
                                                                :custom-label="nameWithLang"
                                                                placeholder="Select one"
                                                                label="text"
                                                                track-by="name"
                                                                ></multiselect>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>PO/contract Date</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <date-picker
                                                                v-model="form.PODate"
                                                                width="100%"
                                                                input-class="form-control"
                                                                type="date"
                                                                lang="en"
                                                                format="YYYY-MM-DD"
                                                                ></date-picker>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Bank Name</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <multiselect
                                                                v-model="form.BankName"
                                                                :options="bankNameList"
                                                                :custom-label="nameWithLang"
                                                                placeholder="Select one"
                                                                label="text"
                                                                track-by="name"
                                                                ></multiselect>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Branch Name</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <multiselect
                                                                v-model="form.BranchName"
                                                                :options="bankbrNameList"
                                                                :custom-label="nameWithLang"
                                                                placeholder="Select one"
                                                                label="text"
                                                                track-by="name"
                                                                ></multiselect>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Remarks</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <b-form-input
                                                                v-model="form.remarks"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Remarks"
                                                            ></b-form-input>
                                                        </div>
                                                    </b-row>

                                                    <b-row class="mt-2 d-flex justify-content-end">
                                                        <b-button lg="6" size="md" variant="dark" type="submit">Process</b-button>
                                                    </b-row>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-content">
                            <b-card-text class="card-body">
                                <div class="table-responsive">
                                    <b-table
                                        bordered
                                        striped
                                        hover
                                        show-empty
                                        small
                                        :items="fieldItems"
                                        :current-page="currentPage"
                                        er-page="perPage"
                                        :filter="filter"
                                        ort-by.sync="sortBy"
                                        ort-desc.sync="sortDesc"
                                        ort-direction="sortDirection"
                                        :fields="tableFields"
                                        responsive
                                    >
                                        <template v-slot:cell(SL)="row">
                                            <b-form-input id="tableFields" v-model="form.SL" placeholder="SL"></b-form-input>
                                        </template>
                                        <template v-slot:cell(DateinService)="row">
                                            <date-picker
                                                v-model="form.datetimein"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                format="YYYY-MM-DD"
                                            ></date-picker>
                                        </template>
                                        <template v-slot:cell(LifeYear)="row">
                                            <b-form-input
                                                id="tableFields"
                                                v-model="form.Number"
                                                placeholder="Life Year"
                                            ></b-form-input>
                                        </template>
                                        <template v-slot:cell(Month)="row">
                                            <b-form-input id="tableFields" v-model="form.Number" placeholder="Month"></b-form-input>
                                        </template>
                                        <template v-slot:cell(Cost)="row">
                                            <b-form-input id="tableFields" v-model="form.Number" placeholder="Cost"></b-form-input>
                                        </template>
                                        <template v-slot:cell(ExpanceAmount)="row">
                                            <b-form-input
                                                id="tableFields"
                                                v-model="form.Number"
                                                placeholder="Expance Amount"
                                            ></b-form-input>
                                        </template>
                                        <template v-slot:cell(Quantity)="row">
                                            <b-form-input id="tableFields" v-model="form.Number" placeholder="Quantity"></b-form-input>
                                        </template>
                                        <template v-slot:cell(Remarks)="row">
                                            <b-form-input id="tableFields" v-model="form.Number" placeholder="Remarks"></b-form-input>
                                        </template>
                                        <template v-slot:cell(action)="row">
                                            <b-button size="sm" class="mr-2">Add</b-button>
                                        </template>
                                    </b-table>


                                </div>
                            </b-card-text>
                            <b-card-text class="card-body">
                                <div class="table-responsive">
                                    <b-table
                                        bordered
                                        striped
                                        hover
                                        show-empty
                                        small
                                        :items="tableData.items"
                                        :current-page="currentPage"
                                        er-page="perPage"
                                        :filter="filter"
                                        ort-by.sync="sortBy"
                                        ort-desc.sync="sortDesc"
                                        ort-direction="sortDirection"
                                        :fields="tableData.fields"
                                        responsive
                                        ></b-table>

                                </div>
                            </b-card-text>

                            <hr />
                            <div class="invoice-subtotal pt-50">
                                <div class="row">
                                    <div class="col-md-5 col-12"></div>
                                    <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                                <span class="invoice-subtotal-title">Total Bill Amount:</span>
                                                <h6 class="invoice-subtotal-value mb-0">10027056</h6>
                                            </li>
                                            <li class="list-group-item border-0 pb-0">
                                            <b-button
                                                variant="dark"
                                                class="btn btn-primary btn-block subtotal-preview-btn"
                                                >Save & Print</b-button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </b-card>
                </b-col>


            </b-row>
        </div>
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import DatePicker from "vue2-datepicker";

    export default {
        components: {
            Multiselect,
            DatePicker
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Cash Management"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Challan Entry"});
        },
        data() {
            return {
                form: {
                    employee_id: "",
                    department_name: "",
                    designation: "",
                    bankname: null,
                    bankbr: null,
                    accname: null,
                    accno: null,
                    financial_code: null,
                    remarks:null,
                    shift: null
                },
                show: true,
                updateIndex: -1,
                submitBtn: "Save",

                tableData: {
                    fields: [
                        {key: "SL", label: "SL"},
                        {key: "BillNo", label: "Bill No"},
                        {key: "BillDate", label: "Bill Date"},
                        {key: "NameofVessle", label: "Name of Vessle"},
                        {key: "NaturalAccounts", label: "Natural Accounts"},
                        {key: "BillAmount", label: "Bill Amount"},
                        {key: "Remarks", label: "Remarks"}
                    ],
                    items: [
                        {
                            SL: "1",
                            BillNo: "FV-0001",
                            BillDate: "29-Aug-2019",
                            NameofVessle: "LOUSIONA MA",
                            NaturalAccounts: "128/2929",
                            BillAmount: "10027056",
                            Remarks: "-"
                        }
                    ]
                },
                tableData: {
                    fields: [
                        { key: "SL", label: "SL", sortable: true },
                        { key: "DateinService", label: "Date in Service", sortable: true },
                        { key: "LifeYear", label: "Life Year", sortable: true },
                        { key: "Month", label: "Month", sortable: true },
                        { key: "Cost", label: "Cost", sortable: true },
                        { key: "ExpenseAccount", label: "Expense Account", sortable: true },
                        { key: "Quantity", label: "Quantity", sortable: true },
                        { key: "Remarks", label: "Remarks", sortable: true },
                        "Action"
                    ],
                    items: [
                        {
                            SL: 1,
                            DateinService: "1-Jan-2019",
                            LifeYear: 4,
                            Month: "29-Aug-2019",
                            Cost: 5000,
                            ExpenseAccount: "222.49448(LOV)",
                            Quantity: 1,
                            Remarks: "-"
                        }
                    ]
                },

                tableFields: [
                    { key: "DateinService", label: "Date in Service", sortable: true },
                    { key: "LifeYear", label: "Life Year", sortable: true },
                    { key: "Month", label: "Month", sortable: true },
                    { key: "Cost", label: "Cost", sortable: true },
                    { key: "ExpanceAmount", label: "Expance Amount", sortable: true },
                    { key: "Quantity", label: "Quantity", sortable: true },
                    { key: "Remarks", label: "Remarks", sortable: true },
                    "Action"
                ],
                fieldItems: [
                    {
                        SL: "",
                        DateinService: "",
                        LifeYear: "",
                        Month: "",
                        Cost: "",
                        ExpanceAmount: "",
                        Quantity: "",
                        Remarks: "",
                        Action: ""
                    }
                ],
                accnolist: [
                    {value: null, text: "Please select"},
                    {value: "011091003", text: "011091003"},
                    {value: "011091004", text: "011091004"},
                    {value: "011091005", text: "011091005"},
                    {value: "011091006", text: "011091006"}
                ],
                partycodelist: [
                    {value: null, text: "Please select"},
                    {value: "011091003", text: "011091003"},
                    {value: "011091004", text: "011091004"},
                    {value: "011091005", text: "011091005"},
                    {value: "011091006", text: "011091006"}
                ],
                partynamelist: [
                    {value: null, text: "Please select"},
                    {value: "ABC Company", text: "ABC Company"},
                    {value: "XYZ Pvt. Ltd.", text: "XYZ Pvt. Ltd."}
                ],
                approvalstatus: [
                    {value: null, text: "Please select"},
                    {value: "Approved", text: "Approved"},
                    {value: "Not Approved", text: "Not Approved"}
                ],
                bankNameList: [
                    {value: null, text: "Please select"},
                    {value: "NRBC Bank", text: "NRBC Bank"},
                    {value: "Pubali Bank", text: "Pubali Bank"},
                    {value: "Standered Chartered Bank", text: "Standered Chartered Bank"},
                    {value: "United Commarcial Bank", text: "United Commarcial Bank"},
                    {value: "Eastern Bank", text: "Eastern Bank"}
                ],
                bankbrNameList: [
                    {value: null, text: "Please select"},
                    {value: "Agrabad", text: "Agrabad"},
                    {value: "Sadar", text: "Sadar"},
                    {value: "Port", text: "Port"}
                ],
                financial_code_options: [
                    {value: null, text: "Please select"},
                    {value: 97040, text: "97040"},
                    {value: 97041, text: "97041"},
                    {value: 97042, text: "97042"},
                    {value: 97043, text: "97043"},
                    {value: 97044, text: "97044"},
                    {value: 97045, text: "97045"},
                    {value: 97046, text: "97046"},
                    {value: 90720, text: "90720"},
                    {value: 90631, text: "90631"},
                    {value: 90730, text: "90730"},
                    {value: 90810, text: "90810"},
                    {value: 90490, text: "90490"}
                ],
                shift_options: [
                    {value: null, text: "Please select"},
                    {value: "1", text: "1"},
                    {value: "2", text: "2"},
                    {value: "3", text: "3"},
                    {value: "4", text: "4"},
                    {value: "5", text: "5"},
                    {value: "6", text: "6"},
                    {value: "7", text: "7"}
                ]
            };
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (this.updateIndex > -1) {
                    //update
                    this.tableData.items[
                            this.updateIndex
                    ].employee_id = this.form.employee_id;
                    this.tableData.items[
                            this.updateIndex
                    ].department_name = this.form.department_name;
                    this.tableData.items[
                            this.updateIndex
                    ].designation = this.form.designation;
                    this.tableData.items[
                            this.updateIndex
                    ].division_name = this.form.division_name;
                    this.tableData.items[
                            this.updateIndex
                    ].financial_code = this.form.financial_code;
                    this.tableData.items[this.updateIndex].shift = this.form.shift;
                } else {
                    //new data add
                    this.tableData.items.push({
                        employee_id: this.form.employee_id,
                        department_name: this.form.department_name,
                        designation: this.form.designation,
                        division_name: this.form.division_name,
                        financial_code: this.form.financial_code,
                        shift: this.form.shift
                    });
                }
                this.onReset(evt);
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
