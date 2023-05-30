<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Payable Invoice Entry Form</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body">
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-dropdown id="dropdown-1" text="Invoice Action" class="m-md-1">
                                    <b-dropdown-item >Match Invoice</b-dropdown-item>
                                    <b-dropdown-item>Apply & UnApply Advance</b-dropdown-item>
                                    <b-dropdown-item>Delete Invoice</b-dropdown-item>
                                    <b-dropdown-item href="/accounts/#/payable">Pay In Full</b-dropdown-item>
                                    <b-dropdown-item>Approval</b-dropdown-item>
                                    <b-dropdown-item>Validate</b-dropdown-item>
                                    <b-dropdown-item>View Accounting</b-dropdown-item>
                                </b-dropdown>
                            </b-col>
                        </b-row>
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                            <!--<fieldset class="border p-2">-->
                            <!--<legend class="w-auto"> Administrative Department Setup</legend>-->

                            <b-row>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>OPERATING UNIT</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="form.operatinUnit"  :options="operatinUnitList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>PO NUMBER</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.poNumber" required placeholder="PO Number"></b-form-input>
                                            </b-col>
                                        </b-row>

                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>SUPPLIER NAME</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="form.supplierName" :options="supplerList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>SUPPLIER CODE</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.supplerCode"  placeholder="Supper Code"></b-form-input>
                                            </b-col>

                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label> SUPPLIER SITE</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.supplerSite"  placeholder="Supper Site"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>VOUCHER GROUP</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="form.invoiceGroup" :options="invoicGroupList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Voucher Status</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="voucherStatus" :options="voucherStatusList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>VOUCHER NUMBER</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.invoiceNumber" required  placeholder="Invoice Number"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>AMOUNT</label>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-select v-model="currency" :options="currencyList"></b-form-select>
                                            </b-col>
                                            <b-col md="5">
                                                <b-form-input v-model="form.billAmount" required  placeholder="Amount"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>VOUCHER TYPE</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="voucherType" :options="voucherTypeList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>VOUCHER REGISTER</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="form.invoicType" :options="invoieRegList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>VOUCHER SECTION</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="form.invoiceSection" :options="invoiceSectionList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>VOUCHER DATE</label>
                                            </b-col>
                                            <b-col md="8">
                                                <date-picker
                                                    v-model="voucherDate"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="YYYY-MM-DD" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>BUDGET HEAD</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="form.budgethead" :options="budgetHeadList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>PAYMENT</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="form.payment" :options="paymentList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>TERMS DATE</label>
                                            </b-col>
                                            <b-col md="8">
                                                <date-picker
                                                    v-model="form.termsDate"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="YYYY-MM-DD" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>REQUESTER</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="form.requster" :options="requestEmp"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Particulars</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.particulars"  placeholder="Particulars"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Attachment</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-file
                                                    v-model="attachment"
                                                    :state="Boolean(file)"></b-form-file>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col class="d-flex justify-content-end">
                                    <b-button md="6"  size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                </b-col>
                            </b-row>
                            <!--</fieldset>-->
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Payable Invoice Entry</h4>
                </div>
                <b-card-text class="card-content">
                    <b-card-body>
                        <b-tabs>
                            <b-tab title="Invoice LIne" active>
                                <b-table
                                    striped
                                    hover
                                    show-empty
                                    small
                                    :items="invoiceItems"
                                    :current-page="currentPage"
                                    :per-page="perPage"
                                    :filter="filter"
                                    :sort-by.sync="sortBy"
                                    :sort-desc.sync="sortDesc"
                                    :sort-direction="sortDirection"
                                    :fields="invoiceFields"
                                    responsive>
                                    <template v-slot:cell(type)="row">

                                          <b-form-select v-model="paymnetType" :options="invoiceTypeList"></b-form-select>
                                    </template>
                                    <template v-slot:cell(amount)="row">
                                              <b-form-input v-model="amount"></b-form-input>
                                    </template>
                                    <template v-slot:cell(accountCombination)="row">
                                              <b-form-select v-model="accountHead" :options="accountHeadList"></b-form-select>
                                    </template>
                                    <template v-slot:cell(accountingDate)="row">
                                              <date-picker
                                            v-model="form.termsDate"
                                            input-class="form-control"
                                            type="date"
                                            lang="en"
                                            format="YYYY-MM-DD"></date-picker>
                                    </template>
                                    <template v-slot:cell(poNumber)="row">
                                              <b-form-input v-model="poNumber"></b-form-input>
                                    </template>
                                    <template v-slot:cell(lineNo)="row">
                                              <b-form-input v-model="lineNo"></b-form-input>
                                    </template>
                                    <template v-slot:cell(poQty)="row">
                                              <b-form-input v-model="poQty"></b-form-input>
                                    </template>
                                    <template v-slot:cell(taxClassification)="row">
                                              <b-form-input v-model="taxClassification"></b-form-input>
                                    </template>
                                    <template v-slot:cell(trackAsAsset)="row">
                                              <b-form-input v-model="trackAsAsset"></b-form-input>
                                    </template>
                                    <template v-slot:cell(projectNumber)="row">
                                              <b-form-input v-model="projectNumber"></b-form-input>
                                    </template>
                                    <template v-slot:cell(taskNumber)="row">
                                              <b-form-input v-model="taskNumber"></b-form-input>
                                    </template>
                                    <template v-slot:cell(select)="row">
                                              <b-form-checkbox id="status" v-model="status"  value="accepted"> </b-form-checkbox>
                                    </template>
                                </b-table>
                                <b-row>
                                    <b-col class="mt-2 d-flex justify-content-start">
                                        <b-button md="6"  size="md" variant="success" type="submit" >Add</b-button>&nbsp;
                                    </b-col>
                                </b-row>
                            </b-tab>
                            <b-tab title="Distribution Line">
                                <b-card-text>
                                    <b-table
                                        striped
                                        hover
                                        show-empty
                                        small
                                        :items="distributionItems"
                                        :current-page="currentPage"
                                        :per-page="perPage"
                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        :fields="distributionFields"
                                        responsive >
                                        <template v-slot:cell(type)="row">

                                              <b-form-select v-model="type" :options=" invoiceTypeList"></b-form-select>
                                        </template>
                                        <template v-slot:cell(account)="row">
                                                  <b-form-select v-model="account" :options="accountHeadList"></b-form-select>
                                        </template>
                                        <template v-slot:cell(descOfAccount)="row">
                                                  <b-form-input v-model="descOfAccount"></b-form-input>
                                        </template>
                                        <template v-slot:cell(descOfAccount)="row">
                                                  <b-form-input v-model="projectNumber"></b-form-input>
                                        </template>
                                        <template v-slot:cell(amt)="row">
                                                  <b-form-input v-model="amt"></b-form-input>
                                        </template>
                                    </b-table>
                                </b-card-text>
                            </b-tab>
                        </b-tabs>
                    </b-card-body>
                </b-card-text>
            </b-card>
            <b-card class="card" style="max-width: 1000px;">
                <div class="card-header">
                    <h4 class="card-title">Tax Calculation</h4>
                </div>
                <b-card-text class="card-content">
                    <b-card-body>
                        <b-card-text class="h-25 d-inline-block" style="width:800px; /*background-color: rgba(0,0,255,.1)*/">
                            <b-table
                                striped
                                hover
                                show-empty
                                small
                                :items="taxCalculationItems"
                                :current-page="currentPage"
                                :per-page="perPage"
                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                :fields="taxCalculationFields"
                                responsive >
                        </b-table>
                    </b-card-text>
                </b-card-body>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts Payable"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payment Voucher"});
        },
        data() {
            return {
                voucherDate: new Date(),
                accountingDate: new Date(),
                form: {
                    employee_id: '',
                    department_name: '',
                    designation: '',
                    division_name: null,
                    financial_code: null,
                    shift: null
                },
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                invoiceFields: ['select',{key: 'num', label: 'Number', sortable: true, sortDirection: 'desc'},
                    {key: 'type', label: 'Type', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'amount', label: 'Amount', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'accountCombination', label: 'Account Combination', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'accountingDate', label: 'Accounting Date'},
                    {key: 'poNumber', label: 'PO Number', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'lineNo', label: 'Line No', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'poQty', label: 'PO Qty', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'taxClassification', label: 'Tax Classification', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'trackAsAsset', label: 'Track As Asset', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'projectNumber', label: 'Project Number', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'taskNumber', label: 'Task Number', sortable: true, sortDirection: 'desc', class: 'text-center'}],
                invoiceItems: [
                    {num: '', type: '', amount: '', accountCombination: '', accountingDate: '',
                        poNumber: '', lineNo: '', poQty: '', taxClassification: '', trackAsAsset: '',
                        projectNumber: '', taskNumber: ''},
                ],
                distributionFields: [{key: 'num', label: 'Number', sortable: true, sortDirection: 'desc'},
                    {key: 'type', label: 'Type', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'account', label: 'Account', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'descOfAccount', label: 'Description of Account', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'amt', label: 'Amount', sortable: true, sortDirection: 'desc', class: 'text-center'}],
                distributionItems: [
                    {num: '1', type: 'Item', account: '10000.00', descOfAccount: 'Material/Department', amt: ''},
                ],
                taxCalculationFields: [{key: 'line', label: 'Line', sortable: true, sortDirection: 'desc'},
                    {key: 'description', label: 'Description', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'rate', label: 'Rate', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'amt', label: 'Tax/Vat Amount', sortable: true, sortDirection: 'desc', class: 'text-center'}, 'rate'],
                taxCalculationItems: [
                    {line: '1', description: 'Vat', rate: '10000', amt: '10'},
                    {line: '2', description: 'Tax', rate: '15', amt: '15'},
                    {line: '3', description: 'AIT', rate: '00', amt: ''},
                    {line: 'Total', description: '00', rate: '.00', amt: '25'}],
                operatinUnitList: [
                    {value: 1, text: 'Chittagong Port Authority'},
                    {value: '2', text: 'Pangaon ICT'}],
                supplerList: [
                    {value: 1, text: 'Computer Network Systems Limited'}, {value: 2, text: 'Saif Power Limited'}
                ],
                invoicGroupList: [
                    {value: null, text: 'Please select'},
                ],
                currency: 1,
                currencyList: [
                    {value: 1, text: 'BDT'},
                    {value: 2, text: 'USD'}
                ],
                invoicTypeList: [
                    {value: null, text: 'Please select'}
                ],
                invoieRegList: [
                    {value: 1, text: 'Bill revenue'}, {value: 2, text: 'Capital expenditure'}
                ],
                invoiceSectionList: [
                    {value: null, text: 'Please select'}
                ],
                budgetHeadList: [
                    {value: 1, text: 'Inventory spare parts'},
                    {value: 2, text: 'Capital expenditure'},
                    {value: 3, text: 'Revenue expenditure'}
                ],
                paymentList: [
                    {value: 1, text: 'Immediate'}
                ],
                requestEmp: [
                    {value: 1, text: 'waker'}
                ],
               type:[1],
                invoiceTypeList: [
                    {value: 1, text: 'Item'},
                    {value: 2, text: 'Service'}],

                accountHeadList: [
                    {value: 1, text: '100.4241.000'},
                    {value: 2, text: '100.4242.000'},
                    {value: 2, text: '100.4243.000'}
                ],
                voucherType: 1,
                voucherTypeList: [
                    {value: 1, text: 'Standard'},
                    {value: 2, text: 'Pre-Payment'}
                ],
                voucherStatus: 1,
                voucherStatusList: [
                    {value: 1, text: 'Incomplete'},
                    {value: 2, text: 'Approved'}
                ]

            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (this.updateIndex > -1) { //update
                    this.tableData.items[this.updateIndex].employee_id = this.form.employee_id;
                    this.tableData.items[this.updateIndex].department_name = this.form.department_name;
                    this.tableData.items[this.updateIndex].designation = this.form.designation;
                    this.tableData.items[this.updateIndex].division_name = this.form.division_name;
                    this.tableData.items[this.updateIndex].financial_code = this.form.financial_code;
                    this.tableData.items[this.updateIndex].shift = this.form.shift;
                } else { //new data add
                    this.tableData.items.push({
                        employee_id: this.form.employee_id,
                        department_name: this.form.department_name,
                        designation: this.form.designation,
                        division_name: this.form.division_name,
                        financial_code: this.form.financial_code,
                        shift: this.form.shift,
                    });
                }
                this.onReset(evt);
            },
            onReset(evt) {
                evt.preventDefault();
                this.employee_id = '';
                this.department_name = '';
                this.designation = '';
                this.division_name = null;
                this.financial_code = null;
                this.shift = null;
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(i, code) {
                this.submitBtn = 'Update';
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
    }
</script>

