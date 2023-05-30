<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card no-body>
                <div class="ml-1 mt-2">
                    <h4 class="card-title">Cash Clear</h4>
                </div>

                <b-row >
                    <b-col class="ml-1 p-1">

                        <b-form-group label="">
                            <b-form-checkbox-group
                                v-model="abcd"
                                :options="abc"
                                plain
                                ></b-form-checkbox-group>
                        </b-form-group>

                    </b-col >
                </b-row>
                <b-tabs card>

                    <b-tab no-body title="Bank">
                        <b-row>
                            <b-col>
                                <b-card class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"></h4>
                                    </div>
                                    <b-card-text class="card-content">
                                        <div class="card-body mb-2">
                                            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                                <b-row>
                                                    <b-col>
                                                        <b-row>
                                                            <b-col lg="6">
                                                                <b-row>
                                                                    <b-col lg="4">
                                                                        <label>Account Number</label>
                                                                    </b-col>
                                                                    <b-col lg="8" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.employee_id"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Account Number"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="4">
                                                                        <label>Account Name</label>
                                                                    </b-col>
                                                                    <b-col lg="8" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.employee_id"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Account Name"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>
                                                                <b-row>
                                                                    <b-col lg="4">
                                                                        <label>Bank Name</label>
                                                                    </b-col>
                                                                    <div class="col-md-8 form-group">
                                                                        <b-form-input
                                                                            v-model="form.employee_id"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Bank Name"
                                                                            ></b-form-input>
                                                                    </div>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="4">
                                                                        <label>Branch Name</label>
                                                                    </b-col>
                                                                    <div class="col-md-8 form-group">
                                                                        <b-form-input
                                                                            v-model="form.employee_id"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Branch Name"
                                                                            ></b-form-input>
                                                                    </div>
                                                                </b-row>
                                                                <b-row>
                                                                    <b-col lg="4">
                                                                        <label>Country Code</label>
                                                                    </b-col>
                                                                    <div class="col-md-8 form-group">
                                                                        <b-form-input
                                                                            v-model="form.employee_id"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Country Code"
                                                                            ></b-form-input>
                                                                    </div>
                                                                </b-row>
                                                            </b-col>
                                                            <b-row>
                                                                <b-col>
                                                                    <b-tabs card>
                                                                        <b-tab title="Transaction" active>
                                                                            <b-col >
                                                                                <b-table striped hover show-empty :items="items" :current-page="1" :per-page="10" :filter="filter" :sort-by.sync="sortBy"
                                                                                         :sort-desc.sync="sortDesc" :sort-direction="sortDirection" :fields="fields" responsive="sm">
                                                                                         <template v-slot:cell(select)="row">
                                                                                          <b-form-checkbox id="status" v-model="status"  value="accepted"> </b-form-checkbox>
                                                                                    </template>
                                                                                    <template v-slot:cell(action)="row">
                                                                                              <a  href="#" class="btn btn btn-dark btn-sm"> View CV </a>
                                                                                    </template>
                                                                                </b-table>
                                                                                <b-row class="">
                                                                                    <b-col>
                                                                                        <label>Total Count</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            value="4"
                                                                                            placeholder="Total Count"
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                    <b-col>
                                                                                        <label>Total Amount Cleared</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            placeholder="Account Number"
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                    <b-col>
                                                                                        <label>Maturity Date</label>
                                                                                        <date-picker v-model="form.datetime" width="100%"
                                                                                                     input-class="form-control" type="date" lang="en"
                                                                                                     format="YYYY-MM-DD">
                                                                                        </date-picker>
                                                                                    </b-col>
                                                                                    <b-col >
                                                                                        <label>Status</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            placeholder=""
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                </b-row>

                                                                                <b-row>
                                                                                    <b-col class=" mt-1 d-flex justify-content-end ">
                                                                                        <b-button type="button" class="btn btn-dark shadow mr-1 mb-1">Default Date </b-button> &nbsp;
                                                                                        <b-button type="button" class="btn btn-dark shadow  mb-1 mr-1">Clear Transaction</b-button> &nbsp;
                                                                                    </b-col>
                                                                                </b-row>
                                                                            </b-col>
                                                                        </b-tab>
                                                                        <b-tab title="Exchange">
                                                                            <b-col >
                                                                                <b-table striped hover show-empty :items="items" :current-page="1" :per-page="10" :filter="filter" :sort-by.sync="sortBy"
                                                                                         :sort-desc.sync="sortDesc" :sort-direction="sortDirection" :fields="fields" responsive="sm">
                                                                                         <template v-slot:cell(select)="row">
                                                                                          <b-form-checkbox id="status" v-model="status"  value="accepted"> </b-form-checkbox>
                                                                                    </template>
                                                                                    <template v-slot:cell(action)="row">
                                                                                              <a  href="#" class="btn btn btn-dark btn-sm"> View CV </a>
                                                                                    </template>
                                                                                </b-table>
                                                                                <b-row class="">
                                                                                    <b-col>
                                                                                        <label>Total Count</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            value="4"
                                                                                            placeholder="Total Count"
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                    <b-col>
                                                                                        <label>Total Amount Cleared</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            placeholder="Account Number"
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                    <b-col>
                                                                                        <label>Maturity Date</label>
                                                                                        <date-picker v-model="form.datetime" width="100%"
                                                                                                     input-class="form-control" type="date" lang="en"
                                                                                                     format="YYYY-MM-DD">
                                                                                        </date-picker>
                                                                                    </b-col>
                                                                                    <b-col >
                                                                                        <label>Status</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            placeholder=""
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                </b-row>

                                                                                <b-row>
                                                                                    <b-col class=" mt-1 d-flex justify-content-end ">
                                                                                        <b-button type="button" class="btn btn-dark shadow mr-1 mb-1">Default Date </b-button> &nbsp;
                                                                                        <b-button type="button" class="btn btn-dark shadow  mb-1 mr-1">Clear Transaction</b-button> &nbsp;
                                                                                    </b-col>
                                                                                </b-row>
                                                                            </b-col>
                                                                        </b-tab>
                                                                        <b-tab title="Reference">
                                                                            <b-col >
                                                                                <b-table striped hover show-empty :items="items" :current-page="1" :per-page="10" :filter="filter" :sort-by.sync="sortBy"
                                                                                         :sort-desc.sync="sortDesc" :sort-direction="sortDirection" :fields="fields" responsive="sm">
                                                                                         <template v-slot:cell(select)="row">
                                                                                          <b-form-checkbox id="status" v-model="status"  value="accepted"> </b-form-checkbox>
                                                                                    </template>
                                                                                    <template v-slot:cell(action)="row">
                                                                                              <a  href="#" class="btn btn btn-dark btn-sm"> View CV </a>
                                                                                    </template>
                                                                                </b-table>
                                                                                <b-row class="">
                                                                                    <b-col>
                                                                                        <label>Total Count</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            value="4"
                                                                                            placeholder="Total Count"
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                    <b-col>
                                                                                        <label>Total Amount Cleared</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            placeholder="Account Number"
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                    <b-col>
                                                                                        <label>Maturity Date</label>
                                                                                        <date-picker v-model="form.datetime" width="100%"
                                                                                                     input-class="form-control" type="date" lang="en"
                                                                                                     format="YYYY-MM-DD">
                                                                                        </date-picker>
                                                                                    </b-col>
                                                                                    <b-col >
                                                                                        <label>Status</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            placeholder=""
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                </b-row>

                                                                                <b-row>
                                                                                    <b-col class=" mt-1 d-flex justify-content-end ">
                                                                                        <b-button type="button" class="btn btn-dark shadow mr-1 mb-1">Default Date </b-button> &nbsp;
                                                                                        <b-button type="button" class="btn btn-dark shadow  mb-1 mr-1">Clear Transaction</b-button> &nbsp;
                                                                                    </b-col>
                                                                                </b-row>
                                                                            </b-col>
                                                                        </b-tab>
                                                                        <b-tab title="Organization">
                                                                            <b-col >
                                                                                <b-table striped hover show-empty :items="items" :current-page="1" :per-page="10" :filter="filter" :sort-by.sync="sortBy"
                                                                                         :sort-desc.sync="sortDesc" :sort-direction="sortDirection" :fields="fields" responsive="sm">
                                                                                         <template v-slot:cell(select)="row">
                                                                                          <b-form-checkbox id="status" v-model="status"  value="accepted"> </b-form-checkbox>
                                                                                    </template>
                                                                                    <template v-slot:cell(action)="row">
                                                                                              <a  href="#" class="btn btn btn-dark btn-sm"> View CV </a>
                                                                                    </template>
                                                                                </b-table>
                                                                                <b-row class="">
                                                                                    <b-col>
                                                                                        <label>Total Count</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            value="4"
                                                                                            placeholder="Total Count"
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                    <b-col>
                                                                                        <label>Total Amount Cleared</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            placeholder="Account Number"
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                    <b-col>
                                                                                        <label>Maturity Date</label>
                                                                                        <date-picker v-model="form.datetime" width="100%"
                                                                                                     input-class="form-control" type="date" lang="en"
                                                                                                     format="YYYY-MM-DD">
                                                                                        </date-picker>
                                                                                    </b-col>
                                                                                    <b-col >
                                                                                        <label>Status</label>
                                                                                        <b-form-input
                                                                                            v-model="form.employee_id"
                                                                                            required
                                                                                            id="input-id"
                                                                                            type="text"
                                                                                            placeholder=""
                                                                                            ></b-form-input>
                                                                                    </b-col>
                                                                                </b-row>

                                                                                <b-row>
                                                                                    <b-col class=" mt-1 d-flex justify-content-end ">
                                                                                        <b-button type="button" class="btn btn-dark shadow mr-1 mb-1">Default Date </b-button> &nbsp;
                                                                                        <b-button type="button" class="btn btn-dark shadow  mb-1 mr-1">Clear Transaction</b-button> &nbsp;
                                                                                    </b-col>
                                                                                </b-row>
                                                                            </b-col>
                                                                        </b-tab>
                                                                    </b-tabs>

                                                                </b-col>
                                                            </b-row>

                                                        </b-row>

                                                    </b-col>
                                                </b-row>
                                            </b-form>
                                        </div>
                                    </b-card-text>
                                </b-card>
                            </b-col>
                        </b-row>
                    </b-tab>

                    <b-tab no-body title="Transaction">
                        <b-row>
                            <b-col class="ml-2 mr-2 p-1">

                                <b-table striped hover show-empty :items="items" :current-page="1" :per-page="10" :filter="filter" :sort-by.sync="sortBy"
                                         :sort-desc.sync="sortDesc" :sort-direction="sortDirection" :fields="fields" responsive="sm">
                                         <template v-slot:cell(select)="row">
                                          <b-form-checkbox id="status" v-model="status"  value="accepted"> </b-form-checkbox>
                                    </template>
                                    <template v-slot:cell(action)="row">
                                              <a  href="#" class="btn btn btn-dark btn-sm"> View CV </a>
                                    </template>
                                </b-table>

                            </b-col>
                        </b-row>
                        <b-row class="ml-2 mr-2 p-1">
                            <b-col>
                                <label>Total Count</label>
                                <b-form-input
                                    v-model="form.employee_id"
                                    required
                                    id="input-id"
                                    type="text"
                                    value="4"
                                    placeholder="Total Count"
                                    ></b-form-input>
                            </b-col>
                            <b-col>
                                <label>Total Amount Cleared</label>
                                <b-form-input
                                    v-model="form.employee_id"
                                    required
                                    id="input-id"
                                    type="text"
                                    placeholder="Account Number"
                                    ></b-form-input>
                            </b-col>
                            <b-col>
                                <label>Maturity Date</label>
                                <date-picker v-model="form.datetime" width="100%"
                                             input-class="form-control" type="date" lang="en"
                                             format="YYYY-MM-DD">
                                </date-picker>
                            </b-col>
                            <b-col >
                                <label>Status</label>
                                <b-form-input
                                    v-model="form.employee_id"
                                    required
                                    id="input-id"
                                    type="text"
                                    placeholder=""
                                    ></b-form-input>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end ">
                                <b-button type="button" class="btn btn-dark shadow mr-1 mb-1">Default Date </b-button> &nbsp;
                                <b-button type="button" class="btn btn-dark shadow  mb-1 mr-1">Clear Transaction</b-button> &nbsp;
                            </b-col>
                        </b-row>
                    </b-tab>

                    <b-tab no-body title="Agent">

                    </b-tab>

                    <b-tab no-body title="Receipt">
                    </b-tab>
                    <b-tab no-body title="Ordering">
                    </b-tab>
                    <b-tab title="Journal">

                    </b-tab>
                </b-tabs>
            </b-card>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Cash Clear"});
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
                    abcd: null,
                    shift: null
                },
                show: true,
                updateIndex: -1,
                submitBtn: "Save",

                examCenter: [
                    {key: 'SL', label: 'SL', sortable: true},
                    {key: 'BillNo', label: 'Bill No', sortable: true},
                    {key: 'BillDate', label: 'Bill Date', sortable: true},
                    {key: 'NameofVessle', label: 'Name of Vessle', sortable: true},
                    {key: 'NaturalAccounts', label: 'Natural Accounts', sortable: true},
                    {key: 'BillAmount', label: 'Bill Amount', sortable: true},
                    {key: 'Remarks', label: 'Remarks', sortable: true},
                    "Action"
                ],
                education: [
                    {
                        SL: "",
                        BillNo: "",
                        BillDate: "",
                        NameofVessle: "",
                        NaturalAccounts: "",
                        BillAmount: "",
                        Remarks: "",
                        Action: ""
                    }
                ],

                abc: [

                    {text: " Capital Expenditure", value: "Capital Expenditure"},
                    {text: "Revenue Expenditure ", value: "Revenue Expenditure"},
                    {text: "Bill Receivables ", value: "Bill Receivables"},
                    {text: " Miscellabeous", value: "Miscellabeous"},
                    {text: "Cash Flow ", value: "Cash Flow"}
                ],
                fields: ['select',
                    {key: 'Type', sortable: true},
                    {key: 'Number', sortable: true},
                    {key: 'Currency', sortable: true},
                    {key: 'OrgAmount', sortable: true},
                    {key: 'AccAmount', sortable: true},
                    {key: 'AmountCleared', sortable: true},
                    {key: 'ClearedDate', sortable: true},
                    {key: 'ValueDate', sortable: true},
                    {key: 'GLDate', sortable: true},
                    {key: 'Date', sortable: true}
                ],
                items: [
                    {isActive: true, Type: 'Receipt', Number: '123', Currency: 'BDT', OrgAmount: '3000.00', AccAmount: '3000.00', AmountCleared: '200.00', ClearedDate: '10/12/2019', ValueDate: '10/12/2019', GLDate: '10/12/2019', Date: '20/12/2019'},
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
