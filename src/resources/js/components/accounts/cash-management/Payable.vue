OPERATING<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Paymnet Details</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                            <b-card-body>
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
                                    responsive >
                                     <template v-slot:cell(operating)="row">
                                              <b-form-select v-model="operatingUnit" :options="operatingUnitList"></b-form-select>
                                    </template>
                                    <template v-slot:cell(invoiceType)="row">
                                              <b-form-select v-model="invoiceType" :options="invoiceTypeList"></b-form-select>
                                    </template>
                                    <template v-slot:cell(partyName)="row">
                                              <b-form-input v-model="partyName"></b-form-input>
                                    </template>
                                    <template v-slot:cell(bankName)="row">

                                              <b-form-select v-model="bankName" :options="bankNameList"></b-form-select>
                                    </template>
                                    <template v-slot:cell(branch)="row">

                                              <b-form-select v-model="branch" :options="branchList"></b-form-select>
                                    </template>
                                    <template v-slot:cell(paymentMode)="row">
                                              <b-form-select v-model="paymentMode" :options="paymentModeList"></b-form-select>
                                    </template>
                                    <template v-slot:cell(payment)="row">
                                              <b-form-input v-model="payment"></b-form-input>
                                    </template>
                                    <template v-slot:cell(cheque)="row">
                                              <b-form-input v-model="cheque"></b-form-input>
                                    </template>
                                    <template v-slot:cell(currentFuction)="row">
                                              <b-form-select v-model="currency" :options="currencyList"></b-form-select>
                                    </template>
                                    <template v-slot:cell(rate)="row">
                                              <b-form-input v-model="rate"></b-form-input>
                                    </template>

                                </b-table>
                                <br/>
                                <br/>
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
                                    <template v-slot:cell(num)="row">

                                          <b-form-input v-model="num"></b-form-input>
                                    </template>
                                    <template v-slot:cell(voucher_no)="row">
                                              <b-form-input v-model="voucherNo"></b-form-input>
                                    </template>
                                    <template v-slot:cell(payment_date)="row">
                                              <date-picker
                                            v-model="form.paymentDate"
                                            input-class="form-control"
                                            type="date"
                                            lang="en"
                                            format="YYYY-MM-DD"></date-picker>
                                    </template>
                                    <template v-slot:cell(gl_date)="row">
                                              <date-picker
                                            v-model="form.glDate"
                                            input-class="form-control"
                                            type="date"
                                            lang="en"
                                            format="YYYY-MM-DD"></date-picker>
                                    </template>
                                    <template v-slot:cell(amt)="row">
                                              <b-form-input v-model="paymentAmt"></b-form-input>
                                    </template>
                                </b-table>
                                <b-row>
                                    <b-col class="mt-2 d-flex justify-content-end">
                                        <b-button md="6"  size="md" variant="dark" type="submit" >Save</b-button>&nbsp;
                                        <b-button md="6"  size="md" variant="dark" type="submit" >Create Accounting</b-button>&nbsp;
                                        <b-button md="6"  size="md" variant="dark" type="submit" >View Accounting</b-button>&nbsp;
                                        <b-button md="6"  size="md" variant="dark" href="/accounts/#/payment-overview" type="submit" >Payment Overview</b-button>&nbsp;
                                    </b-col>
                                </b-row>
                            </b-card-body>

                        </b-form>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts Payable"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payment"});
        },
        data() {
            return {
                voucherDate: new Date(),
                accountingDate: new Date(),
                form: {
                },
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                invoiceFields: [{key: 'num', label: 'Line No', sortable: true, sortDirection: 'desc'},
                    {key: 'operating', label: 'Operating Unit', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'invoiceType', label: 'Payment Type', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'partyName', label: 'Party Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'bankName', label: 'Bank Name'},
                    {key: 'branch', label: 'Branch', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'paymentMode', label: 'Payment Mode', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'payment', label: 'Payment', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'cheque', label: 'Cheque', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'currentFuction', label: 'Currency List', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'rate', label: 'Rate', sortable: true, sortDirection: 'desc', class: 'text-center'}],
                invoiceItems: [
                    {num: '', operating: '', invoiceType: '', partyName: '', bankName: '',
                        branch: '', paymentMode: '', payment: '', cheque: '', currentFuction: '',
                        rate: ''},
                ],
                distributionFields: [{key: 'num', label: 'Line No', sortable: true, sortDirection: 'desc'},
                    {key: 'voucher_no', label: 'Voucher No', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'payment_date', label: 'Payment Date', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'gl_date', label: 'Gl Date', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'amt', label: 'Payment Amount', sortable: true, sortDirection: 'desc', class: 'text-center'}],
                distributionItems: [
                    {num: '', voucher_no: '', payment_date: '', gl_date: '', amt: ''},
                ],
                taxCalculationFields: [{key: 'line', label: 'Line', sortable: true, sortDirection: 'desc'},
                    {key: 'description', label: 'Description', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'rate', label: 'Rate', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'amt', label: 'Tax/Vat Amount', sortable: true, sortDirection: 'desc', class: 'text-center'}],
                taxCalculationItems: [
                    {line: '1', description: 'Vat', rate: '10000', amt: '10'},
                    {line: '2', description: 'Tax', rate: '15', amt: '15'},
                    {line: '3', description: 'AIT', rate: '00', amt: ''},
                    {line: 'Total', description: '00', rate: '.00', amt: '25'}],
                operatinUnitList: [
                    {value: null, text: 'Please select'},
                ],
                supplerList: [
                    {value: null, text: 'Please select'},
                ],
                invoicGroupList: [
                    {value: null, text: 'Please select'},
                ],
                currencyList: [
                    {value: null, text: 'BDT'},
                    {value: null, text: 'Dollar'}
                ],
                invoicTypeList: [
                    {value: null, text: 'Please select'}
                ],
                invoieRegList: [
                    {value: null, text: 'Please select'}
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
                invoiceType: [1],
                invoiceTypeList: [
                    {value: 1, text: 'Item'},
                    {value: 2, text: 'Service'}],

                accountHeadList: [
                    {value: 1, text: 'Fixed Asset'},
                    {value: 2, text: 'Cash'},
                    {value: 2, text: 'Revenue'}
                ],
                voucherTypeList: [
                    {value: 1, text: 'Standart'},
                    {value: 2, text: 'Pre-Payment'}
                ],
                bankNameList: [
                    {value: 1, text: 'Sonali bank'},
                    {value: 2, text: 'Agrani bank'}
                ],
                branchList: [
                    {value: 1, text: 'Agrabad Corp. Br.'},
                    {value: 2, text: 'Amin Court Corp. Br.'}
                ],
                paymentModeList: [
                    {value: 1, text: 'Cash'},
                    {value: 2, text: 'Bank'}
                ],
                currency: 1,
                currencyList: [
                    {value: 1, text: 'BDT'},
                    {value: 2, text: 'USD'}
                ],
                operatingUnitList:[ {value: 1, text: 'Chittagong Port Authority'},
                    {value: '2', text: 'Pangaon ICT'} ]

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

