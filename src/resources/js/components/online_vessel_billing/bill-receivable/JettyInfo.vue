<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Jetty Information</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                            <!--<fieldset class="border p-2">-->
                            <!--<legend class="w-auto"> Administrative Department Setup</legend>-->
                            <b-row>
                                <b-col md="8">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="2">
                                                <label>Registration/ROT No</label>
                                            </b-col>
                                            <b-col md="10">
                                                <b-form-select v-model="form.registationno":options="registationnoList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Registration Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.registrationDate" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Agent Type</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.agentType" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Vessel Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.vesselName" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>M Vessel Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.mVesselName" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Status</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.status" value="Incomplete" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Entry Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.entryDate" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Master Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.masterName" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Vessel Types</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.vesselTypes" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>GRT</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.grt" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Deck Cargo</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.deckcargo" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Exchange Rate($)</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.exchangeRate"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Last Port</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.lastPort" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Next Port</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.nxtPort" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <br/>
                            <br/>
                            <b-row>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Jetty Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.jettyName"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Water Barge</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.waterBarge"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Water Main</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.waterMain"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Water Main Cancel</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.waterMainCancel"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Number Of Crane</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.numberOfCrane"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>No Of Derrick</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.noOfDerrick"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <!--fieldset class="border p-2">
                                        <legend class="w-auto font-size-small">Bill Processing</legend>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bill No</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input v-model="form.billNo" disabled></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Bill Date</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input v-model="form.billDate" disabled></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Exchange Rate</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input v-model="form.exchangeRate" disabled></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>Outer Date</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input v-model="form.outerDate" disabled></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </fieldset-->
                                </b-col>
                                <b-col md="8">
                                    <fieldset class="border p-2">
                                        <legend class="w-auto font-size-small">Import</legend>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="2">
                                                    <label>Loaded</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="20'">
                                                        <b-form-input v-model="form.imploaded20"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="20' OT">
                                                        <b-form-input v-model="form.imploaded20ot"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="40">
                                                        <b-form-input v-model="form.imploaded40"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="40'OT">
                                                        <b-form-input v-model="form.imploaded40ot"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="2">
                                                    <label>Empty</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="20'">
                                                        <b-form-input v-model="form.impEmpty20"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="20' OT">
                                                        <b-form-input v-model="form.impEmpty20ot"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="40">
                                                        <b-form-input v-model="form.impEmpty40"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="40'OT">
                                                        <b-form-input v-model="form.impEmpty40ot"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </fieldset>
                                    <fieldset class="border p-2">
                                        <legend class="w-auto font-size-small">Export</legend>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="2">
                                                    <label>Loaded</label>
                                                </b-col>
                                                <b-col lg="2" sm="4">
                                                    <b-form-group
                                                        label="20'">
                                                        <b-form-input v-model="form.exploaded20"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col lg="2" sm="4">
                                                    <b-form-group
                                                        label="20' OT">
                                                        <b-form-input v-model="form.exploaded20ot"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="40">
                                                        <b-form-input v-model="form.exploaded40"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="40'OT">
                                                        <b-form-input v-model="form.exploaded40ot"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="2">
                                                    <label>Empty</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="20'">
                                                        <b-form-input v-model="form.expEmpty20"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="20' OT">
                                                        <b-form-input v-model="form.expEmpty20ot"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="40">
                                                        <b-form-input v-model="form.expEmpty40"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                        label="40'OT">
                                                        <b-form-input v-model="form.expEmpty40ot"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </fieldset>
                                </b-col>
                            </b-row>

                            <b-row class="mt-3">

                                <b-col class="d-flex justify-content-end ">
                                    <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Save</b-button> &nbsp;
                                    <b-button type="submit" class="btn btn-dark shadow  mb-1">Process & Approved</b-button> &nbsp;
                                </b-col>
                            </b-row>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Receivable"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Vessel Service"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Jetty Service"});
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
                invoiceFields: [{key: 'num', label: 'Number', sortable: true, sortDirection: 'desc'},
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
                    {key: 'taskNumber', label: 'Task Number', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'select'],
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
                    {key: 'amt', label: 'Tax/Vat Amount', sortable: true, sortDirection: 'desc', class: 'text-center'}],
                taxCalculationItems: [
                    {line: '1', description: 'Vat', rate: '10000', amt: '10'},
                    {line: '2', description: 'Tax', rate: '15', amt: '15'},
                    {line: '3', description: 'AIT', rate: '00', amt: ''},
                    {line: 'Total', description: '00', rate: '.00', amt: '25'}],
                operatinUnitList: [
                    {value: 1, text: 'CPA'},
                    {value: '2', text: 'Pangaon ICT'}],
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
                selected: [1],
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
                voucherStatusList: [
                    {value: 1, text: 'Incomplete'},
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

